<?php

namespace App\Events;

use App\Models\Contact;
use App\Models\Quote;
use App\Models\QuoteRequest;
use App\Models\WorkOrder;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuoteAccepted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly QuoteRequest $quoteRequest,
        public readonly Contact $contact,
        public readonly Quote $quote,
        public readonly WorkOrder $workOrder,
    ) {}
}
