<?php

namespace App\Services;

use App\Events\QuoteAccepted;
use App\Models\Contact;
use App\Models\ContactStatus;
use App\Models\ContactType;
use App\Models\DistanceUnit;
use App\Models\Quote;
use App\Models\QuoteRequest;
use App\Models\QuoteStatus;
use App\Models\RateType;
use App\Models\WorkOrder;
use App\Models\WorkOrderStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuotePromotionService
{
    /**
     * Promote a quote request into a Contact, Quote, and WorkOrder.
     * Only callable on non-terminal requests.
     */
    public function promote(QuoteRequest $quoteRequest): void
    {
        if ($quoteRequest->isTerminal()) {
            throw new \LogicException(
                "Cannot promote a terminal quote request (status: {$quoteRequest->status})."
            );
        }

        DB::transaction(function () use ($quoteRequest) {
            $contact   = $this->createContact($quoteRequest);
            $quote     = $this->createQuote($quoteRequest, $contact);
            $workOrder = $this->createWorkOrder($quoteRequest, $quote);

            $quoteRequest->update([
                'status'      => 'accepted',
                'accepted_at' => now(),
            ]);

            QuoteAccepted::dispatch($quoteRequest, $contact, $quote, $workOrder);
        });
    }

    private function createContact(QuoteRequest $quoteRequest): Contact
    {
        $contactType   = ContactType::first();
        $contactStatus = ContactStatus::first();

        return Contact::create([
            'first_name'        => $quoteRequest->first_name,
            'last_name'         => $quoteRequest->last_name,
            'email'             => $quoteRequest->email,
            'phone'             => $quoteRequest->phone,
            'contact_type_id'   => $contactType->id,
            'contact_status_id' => $contactStatus->id,
            'is_active'         => true,
        ]);
    }

    private function createQuote(QuoteRequest $quoteRequest, Contact $contact): Quote
    {
        $acceptedStatus = QuoteStatus::where('name', 'Accepted')->firstOrFail();
        $rateType       = RateType::first();
        $distanceUnit   = DistanceUnit::first();

        // Use resolved FK IDs when available; fall back to null so the Quote
        // still saves even when a city/province is unresolved custom text.
        // The _display accessors are used for readable notes rather than FK fields.
        return Quote::create([
            'quote_number'            => 'Q-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
            'contact_id'              => $contact->id,
            'quote_status_id'         => $acceptedStatus->id,
            'origin_city_id'          => $quoteRequest->origin_city_id,
            'origin_province_id'      => $quoteRequest->origin_province_id,
            'destination_city_id'     => $quoteRequest->destination_city_id,
            'destination_province_id' => $quoteRequest->destination_province_id,
            'rate_type_id'            => $rateType->id,
            'distance_unit_id'        => $distanceUnit->id,
            'notes'                   => $this->buildNotes($quoteRequest),
            'created_by'              => auth()->id(),
        ]);
    }

    private function createWorkOrder(QuoteRequest $quoteRequest, Quote $quote): WorkOrder
    {
        $status       = WorkOrderStatus::first();
        $rateType     = RateType::first();
        $distanceUnit = DistanceUnit::first();

        return WorkOrder::create([
            'work_order_number'       => 'WO-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
            'quote_id'                => $quote->id,
            'work_order_status_id'    => $status->id,
            'origin_city_id'          => $quoteRequest->origin_city_id,
            'origin_province_id'      => $quoteRequest->origin_province_id,
            'destination_city_id'     => $quoteRequest->destination_city_id,
            'destination_province_id' => $quoteRequest->destination_province_id,
            'scheduled_pickup'        => $quoteRequest->preferred_date ?? now()->toDateString(),
            'rate_type_id'            => $rateType->id,
            'distance_unit_id'        => $distanceUnit->id,
            'notes'                   => $this->buildNotes($quoteRequest),
            'created_by'              => auth()->id(),
        ]);
    }

    /**
     * Build a readable notes string that always includes human-readable city/province
     * labels (using _display accessors) regardless of whether the FK is resolved.
     * If the request has any unresolved fields, a warning line is prepended so staff
     * know to revisit the record after resolution.
     */
    private function buildNotes(QuoteRequest $quoteRequest): ?string
    {
        $parts = [];

        if ($quoteRequest->hasUnresolvedFields()) {
            $parts[] = '[Note: This request contained unverified cities or vehicles at the time of promotion. '
                . 'Review and resolve the original quote request.]';
        }

        $parts[] = sprintf(
            'Route: %s, %s → %s, %s',
            $quoteRequest->origin_city_display,
            $quoteRequest->origin_province_display,
            $quoteRequest->destination_city_display,
            $quoteRequest->destination_province_display,
        );

        foreach ($quoteRequest->vehicles as $vehicle) {
            $parts[] = sprintf(
                'Vehicle: %s %s %s',
                $vehicle->vehicle_year,
                $vehicle->vehicle_make_display,
                $vehicle->vehicle_model_display,
            );
        }

        if (filled($quoteRequest->notes)) {
            $parts[] = $quoteRequest->notes;
        }

        return implode("\n", $parts) ?: null;
    }
}
