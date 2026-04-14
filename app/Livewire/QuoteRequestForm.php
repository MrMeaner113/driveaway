<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\Province;
use App\Models\QuoteRequest;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Livewire\Component;

class QuoteRequestForm extends Component
{
    // Contact
    public string $first_name = '';
    public string $last_name  = '';
    public string $email      = '';
    public string $phone      = '';

    // Vehicle
    public string $vehicle_year   = '';
    public string $vehicle_make   = '';
    public array  $make_suggestions = [];
    public ?int   $selected_make_id = null;
    public string $vehicle_model  = '';
    public array  $model_suggestions = [];

    // Origin
    public string $origin_country_id   = '';
    public string $origin_province_id  = '';
    public string $origin_city         = '';

    // Destination
    public string $destination_country_id  = '';
    public string $destination_province_id = '';
    public string $destination_city        = '';

    // Date
    public string $requested_date = '';
    public bool   $submitted      = false;

    public function mount(): void
    {
        $default = Country::where('is_default', true)->first();
        if ($default) {
            $this->origin_country_id      = (string) $default->id;
            $this->destination_country_id = (string) $default->id;
        }
    }

    // ── Vehicle Make Autocomplete ──────────────────────────────────────

    public function updatedVehicleMake(): void
    {
        // Reset dependent fields whenever the make changes
        $this->selected_make_id  = null;
        $this->vehicle_model     = '';
        $this->model_suggestions = [];

        $search = trim($this->vehicle_make);
        if ($search === '') {
            $this->make_suggestions = [];
            return;
        }

        $this->make_suggestions = VehicleMake::where('is_active', true)
            ->where('name', 'like', $search . '%')
            ->orderBy('name')
            ->limit(8)
            ->get(['id', 'name'])
            ->toArray();
    }

    public function selectMake(int $id, string $name): void
    {
        $this->vehicle_make      = $name;
        $this->make_suggestions  = [];
        $this->selected_make_id  = $id;
        $this->vehicle_model     = '';
        $this->model_suggestions = [];
    }

    public function clearMakeSuggestions(): void
    {
        $this->make_suggestions = [];
    }

    // ── Vehicle Model Autocomplete ─────────────────────────────────────

    public function updatedVehicleModel(): void
    {
        $search = trim($this->vehicle_model);
        if ($search === '') {
            $this->model_suggestions = [];
            return;
        }

        $query = VehicleModel::where('is_active', true)
            ->where('name', 'like', $search . '%')
            ->orderBy('name')
            ->limit(8);

        if ($this->selected_make_id) {
            $query->where('vehicle_make_id', $this->selected_make_id);
        }

        $this->model_suggestions = $query->get(['id', 'name'])->toArray();
    }

    public function selectModel(int $id, string $name): void
    {
        $this->vehicle_model     = $name;
        $this->model_suggestions = [];
    }

    public function clearModelSuggestions(): void
    {
        $this->model_suggestions = [];
    }

    // ── Location Cascades ──────────────────────────────────────────────

    public function updatedOriginCountryId(): void
    {
        $this->origin_province_id = '';
    }

    public function updatedDestinationCountryId(): void
    {
        $this->destination_province_id = '';
    }

    // ── Validation & Submit ────────────────────────────────────────────

    protected function rules(): array
    {
        return [
            'first_name'               => ['required', 'string', 'max:100'],
            'last_name'                => ['required', 'string', 'max:100'],
            'email'                    => ['nullable', 'email', 'max:255'],
            'phone'                    => ['nullable', 'string', 'max:20'],
            'vehicle_year'             => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . (date('Y') + 2)],
            'vehicle_make'             => ['required', 'string', 'max:100'],
            'vehicle_model'            => ['required', 'string', 'max:100'],
            'origin_country_id'        => ['required', 'exists:countries,id'],
            'origin_province_id'       => ['required', 'exists:provinces,id'],
            'origin_city'              => ['required', 'string', 'max:100'],
            'destination_country_id'   => ['required', 'exists:countries,id'],
            'destination_province_id'  => ['required', 'exists:provinces,id'],
            'destination_city'         => ['required', 'string', 'max:100'],
            'requested_date'           => ['required', 'date', 'after_or_equal:today'],
        ];
    }

    public function submit(): void
    {
        $this->validate($this->rules());

        if (empty($this->email) && empty($this->phone)) {
            $this->addError('email', 'Please provide at least an email address or phone number.');
            return;
        }

        QuoteRequest::create([
            'first_name'              => $this->first_name,
            'last_name'               => $this->last_name,
            'email'                   => $this->email ?: null,
            'phone'                   => $this->phone ?: null,
            'vehicle_year'            => $this->vehicle_year,
            'vehicle_make'            => $this->vehicle_make,
            'vehicle_model'           => $this->vehicle_model,
            'origin_city'             => $this->origin_city,
            'origin_province_id'      => $this->origin_province_id,
            'destination_city'        => $this->destination_city,
            'destination_province_id' => $this->destination_province_id,
            'requested_date'          => $this->requested_date,
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        $countries = Country::where('is_active', true)
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get();

        $originProvinces = $this->origin_country_id
            ? Province::where('country_id', $this->origin_country_id)
                ->where('is_active', true)
                ->orderBy('name')
                ->get()
            : collect();

        $destinationProvinces = $this->destination_country_id
            ? Province::where('country_id', $this->destination_country_id)
                ->where('is_active', true)
                ->orderBy('name')
                ->get()
            : collect();

        return view('livewire.quote-request-form', compact('countries', 'originProvinces', 'destinationProvinces'));
    }
}
