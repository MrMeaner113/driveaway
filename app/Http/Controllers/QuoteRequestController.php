<?php

namespace App\Http\Controllers;

use App\Models\AddOnService;
use App\Models\City;
use App\Models\Country;
use App\Models\Province;
use App\Models\QuoteRequest;
use App\Models\VehicleMake;
use App\Models\VehicleModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class QuoteRequestController extends Controller
{
    public function create(): View
    {
        $countries      = Country::where('is_active', true)->orderBy('name')->get();
        $addOnServices  = AddOnService::active()->get();
        $vehicleMakes   = VehicleMake::where('is_active', true)->orderBy('name')->get(['id', 'name']);
        $defaultCountry = Country::where('is_default', true)->first() ?? $countries->first();

        $provinces = $defaultCountry
            ? Province::where('country_id', $defaultCountry->id)
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name'])
            : collect();

        return view('quote-request', compact(
            'countries',
            'addOnServices',
            'vehicleMakes',
            'defaultCountry',
            'provinces',
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name'             => ['required', 'string', 'max:100'],
            'last_name'              => ['required', 'string', 'max:100'],
            'email'                  => ['nullable', 'email', 'max:255', 'required_without:phone'],
            'phone'                  => ['nullable', 'string', 'max:20', 'required_without:email'],

            // Origin — at least one of _id or _custom must be present per field
            'origin_country_id'        => ['required', 'exists:countries,id'],
            'origin_province_id'       => ['nullable', 'exists:provinces,id'],
            'origin_province_custom'   => ['nullable', 'string', 'max:150', 'required_without:origin_province_id'],
            'origin_city_id'           => ['nullable', 'exists:cities,id'],
            'origin_city_custom'       => ['nullable', 'string', 'max:150', 'required_without:origin_city_id'],

            // Destination — same pattern
            'destination_country_id'      => ['required', 'exists:countries,id'],
            'destination_province_id'     => ['nullable', 'exists:provinces,id'],
            'destination_province_custom' => ['nullable', 'string', 'max:150', 'required_without:destination_province_id'],
            'destination_city_id'         => ['nullable', 'exists:cities,id'],
            'destination_city_custom'     => ['nullable', 'string', 'max:150', 'required_without:destination_city_id'],

            'preferred_date'           => ['nullable', 'date', 'after:today'],
            'date_type'                => ['nullable', 'string', 'in:pickup,delivery'],
            'notes'                    => ['nullable', 'string', 'max:2000'],
            'add_on_services'          => ['nullable', 'array'],
            'add_on_services.*'        => ['exists:add_on_services,id'],

            'vehicles'                          => ['required', 'array', 'min:1'],
            'vehicles.*.vehicle_year'           => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 2)],
            'vehicles.*.vehicle_make_id'        => ['nullable', 'exists:vehicle_makes,id'],
            'vehicles.*.vehicle_make_custom'    => ['nullable', 'string', 'max:100', 'required_without:vehicles.*.vehicle_make_id'],
            'vehicles.*.vehicle_model_id'       => ['nullable', 'exists:vehicle_models,id'],
            'vehicles.*.vehicle_model_custom'   => ['nullable', 'string', 'max:100', 'required_without:vehicles.*.vehicle_model_id'],
        ]);

        $quoteNumber = QuoteRequest::generateQuoteNumber();

        DB::transaction(function () use ($validated, $quoteNumber) {
            $originProvinceId   = $validated['origin_province_id'] ?? null;
            $originCityId       = $validated['origin_city_id'] ?? null;
            $destProvinceId     = $validated['destination_province_id'] ?? null;
            $destCityId         = $validated['destination_city_id'] ?? null;

            $quoteRequest = QuoteRequest::create([
                'first_name'              => $validated['first_name'],
                'last_name'               => $validated['last_name'],
                'email'                   => $validated['email'] ?? null,
                'phone'                   => $validated['phone'] ?? null,
                'origin_country_id'       => $validated['origin_country_id'],
                'origin_province_id'      => $originProvinceId,
                'origin_province_custom'  => $originProvinceId ? null : ($validated['origin_province_custom'] ?? null),
                'origin_city_id'          => $originCityId,
                'origin_city_custom'      => $originCityId ? null : ($validated['origin_city_custom'] ?? null),
                'destination_country_id'  => $validated['destination_country_id'],
                'destination_province_id' => $destProvinceId,
                'destination_province_custom' => $destProvinceId ? null : ($validated['destination_province_custom'] ?? null),
                'destination_city_id'     => $destCityId,
                'destination_city_custom' => $destCityId ? null : ($validated['destination_city_custom'] ?? null),
                'preferred_date'          => $validated['preferred_date'] ?? null,
                'date_type'               => $validated['date_type'] ?? 'pickup',
                'quote_number'            => $quoteNumber,
                'notes'                   => $validated['notes'] ?? null,
                'status'                  => 'new',
            ]);

            foreach ($validated['vehicles'] as $v) {
                $makeId  = $v['vehicle_make_id'] ?? null;
                $modelId = $v['vehicle_model_id'] ?? null;

                $quoteRequest->vehicles()->create([
                    'vehicle_year'         => $v['vehicle_year'],
                    'vehicle_make_id'      => $makeId,
                    'vehicle_make_custom'  => $makeId  ? null : ($v['vehicle_make_custom'] ?? null),
                    'vehicle_model_id'     => $modelId,
                    'vehicle_model_custom' => $modelId ? null : ($v['vehicle_model_custom'] ?? null),
                ]);
            }

            if (! empty($validated['add_on_services'])) {
                $quoteRequest->addOnServices()->attach($validated['add_on_services']);
            }
        });

        return redirect()->route('quote-request.confirmation')->with('quote_number', $quoteNumber);
    }

    public function provinces(Country $country): JsonResponse
    {
        $provinces = Province::where('country_id', $country->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($provinces);
    }

    public function cities(Province $province): JsonResponse
    {
        $cities = City::where('province_id', $province->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($cities);
    }

    public function vehicleModels(Request $request): JsonResponse
    {
        $makeId   = $request->query('make_id');
        $makeName = $request->query('make', '');

        $vehicleMake = $makeId
            ? VehicleMake::where('id', $makeId)->where('is_active', true)->first()
            : VehicleMake::where('name', $makeName)->where('is_active', true)->first();

        if (! $vehicleMake) {
            return response()->json([]);
        }

        $models = VehicleModel::where('vehicle_make_id', $vehicleMake->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($models);
    }
}
