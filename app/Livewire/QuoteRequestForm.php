<?php

namespace App\Livewire;

use App\Models\City;
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
    public string $vehicle_year      = '';
    public string $vehicle_make      = '';
    public array  $make_suggestions  = [];
    public ?int   $selected_make_id  = null;
    public string $vehicle_model     = '';
    public array  $model_suggestions = [];

    // Origin
    public string $origin_country_id      = '';
    public string $origin_province_id     = '';
    public string $origin_city_input      = '';
    public ?int   $origin_city_id         = null;
    public array  $origin_city_suggestions = [];

    // Destination
    public string $destination_country_id      = '';
    public string $destination_province_id     = '';
    public string $destination_city_input      = '';
    public ?int   $destination_city_id         = null;
    public array  $destination_city_suggestions = [];

    // Date
    public string $date_type      = 'pickup';
    public string $preferred_date = '';

    public bool   $submitted     = false;
    public string $quote_number  = '';

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
        $this->origin_province_id      = '';
        $this->origin_city_input       = '';
        $this->origin_city_id          = null;
        $this->origin_city_suggestions = [];
    }

    public function updatedDestinationCountryId(): void
    {
        $this->destination_province_id      = '';
        $this->destination_city_input       = '';
        $this->destination_city_id          = null;
        $this->destination_city_suggestions = [];
    }

    public function updatedOriginProvinceId(): void
    {
        $this->origin_city_input = '';
        $this->origin_city_id    = null;

        $this->origin_city_suggestions = $this->origin_province_id
            ? City::where('is_active', true)
                ->where('province_id', $this->origin_province_id)
                ->orderBy('name')
                ->limit(50)
                ->get(['id', 'name'])
                ->toArray()
            : [];
    }

    public function updatedDestinationProvinceId(): void
    {
        $this->destination_city_input = '';
        $this->destination_city_id    = null;

        $this->destination_city_suggestions = $this->destination_province_id
            ? City::where('is_active', true)
                ->where('province_id', $this->destination_province_id)
                ->orderBy('name')
                ->limit(50)
                ->get(['id', 'name'])
                ->toArray()
            : [];
    }

    // ── Origin City Autocomplete ───────────────────────────────────────

    public function updatedOriginCityInput(): void
    {
        $this->origin_city_id = null;

        if (! $this->origin_province_id) {
            $this->origin_city_suggestions = [];
            return;
        }

        $search = trim($this->origin_city_input);

        $query = City::where('is_active', true)->where('province_id', $this->origin_province_id);

        if ($search !== '') {
            $query->where('name', 'like', $search . '%');
        }

        $this->origin_city_suggestions = $query->orderBy('name')->limit($search !== '' ? 8 : 50)->get(['id', 'name'])->toArray();
    }

    public function selectOriginCity(int $id, string $name): void
    {
        $this->origin_city_input       = $name;
        $this->origin_city_id          = $id;
        $this->origin_city_suggestions = [];
    }

    public function clearOriginCitySuggestions(): void
    {
        $this->origin_city_suggestions = [];
    }

    // ── Destination City Autocomplete ──────────────────────────────────

    public function updatedDestinationCityInput(): void
    {
        $this->destination_city_id = null;

        if (! $this->destination_province_id) {
            $this->destination_city_suggestions = [];
            return;
        }

        $search = trim($this->destination_city_input);

        $query = City::where('is_active', true)->where('province_id', $this->destination_province_id);

        if ($search !== '') {
            $query->where('name', 'like', $search . '%');
        }

        $this->destination_city_suggestions = $query->orderBy('name')->limit($search !== '' ? 8 : 50)->get(['id', 'name'])->toArray();
    }

    public function selectDestinationCity(int $id, string $name): void
    {
        $this->destination_city_input       = $name;
        $this->destination_city_id          = $id;
        $this->destination_city_suggestions = [];
    }

    public function clearDestinationCitySuggestions(): void
    {
        $this->destination_city_suggestions = [];
    }

    // ── Validation & Submit ────────────────────────────────────────────

    protected function rules(): array
    {
        return [
            'first_name'              => ['required', 'string', 'max:100'],
            'last_name'               => ['required', 'string', 'max:100'],
            'email'                   => ['nullable', 'email', 'max:255'],
            'phone'                   => ['nullable', 'string', 'max:20'],
            'vehicle_year'            => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . (date('Y') + 2)],
            'vehicle_make'            => ['required', 'string', 'max:100'],
            'vehicle_model'           => ['required', 'string', 'max:100'],
            'origin_country_id'       => ['required', 'exists:countries,id'],
            'origin_province_id'      => ['required', 'exists:provinces,id'],
            'origin_city_input'       => ['required', 'string', 'max:100'],
            'destination_country_id'  => ['required', 'exists:countries,id'],
            'destination_province_id' => ['required', 'exists:provinces,id'],
            'destination_city_input'  => ['required', 'string', 'max:100'],
            'preferred_date'          => ['required', 'date', 'after_or_equal:today'],
        ];
    }

    public function submit(): void
    {
        $this->validate($this->rules());

        if (empty($this->email) && empty($this->phone)) {
            $this->addError('email', 'Please provide at least an email address or phone number.');
            return;
        }

        $this->quote_number = QuoteRequest::generateQuoteNumber();

        QuoteRequest::create([
            'first_name'                 => $this->first_name,
            'last_name'                  => $this->last_name,
            'email'                      => $this->email ?: null,
            'phone'                      => $this->phone ?: null,
            'origin_country_id'          => $this->origin_country_id,
            'origin_province_id'         => $this->origin_province_id,
            'origin_city_id'             => $this->origin_city_id,
            'origin_city_custom'         => $this->origin_city_input,
            'destination_country_id'     => $this->destination_country_id,
            'destination_province_id'    => $this->destination_province_id,
            'destination_city_id'        => $this->destination_city_id,
            'destination_city_custom'    => $this->destination_city_input,
            'preferred_date'             => $this->preferred_date,
            'date_type'                  => $this->date_type,
            'quote_number'               => $this->quote_number,
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
