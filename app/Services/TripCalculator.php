<?php

namespace App\Services;

class TripCalculator
{
    /**
     * @param array<string, mixed> $state
     */
    public function __construct(
        protected array $state = []
    ) {}

    public static function make(array $state): self
    {
        return new self($state);
    }

    public function getFuelCostCents(): int
    {
        $distance = (float) ($this->state['distance_km'] ?? 0);
        $economy = (float) ($this->state['fuel_economy_per_100km'] ?? 10);
        $price = (int) ($this->state['avg_fuel_price_cents'] ?? 150);

        return (int) round(($distance / 100) * $economy * $price);
    }

    public function getTotalCents(): int
    {
        // Simple example: Fuel + any other logic you want to add
        $subtotal = $this->getFuelCostCents();
        
        // Ontario HST logic
        $taxRate = (float) ($this->state['tax_rate'] ?? 0.1300);
        return (int) round($subtotal * (1 + $taxRate));
    }
}