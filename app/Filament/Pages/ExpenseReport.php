<?php

namespace App\Filament\Pages;

use App\Models\Driver;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\FuelExpense;
use App\Models\Vehicle;
use App\Models\WorkOrder;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ExpenseReport extends Page
{
    protected string $view = 'filament.pages.expense-report';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    public static function getNavigationGroup(): string|\UnitEnum|null { return 'Finance'; }

    protected static ?int $navigationSort = 10;

    protected static ?string $title = 'Expense Report';

    // ── Filter properties ────────────────────────────────────────────────────

    public ?string $date_from    = null;
    public ?string $date_until   = null;
    public ?int    $work_order_id = null;
    public ?int    $driver_id    = null;
    public ?int    $vehicle_id   = null;
    public ?int    $expense_category_id = null;

    // ── Lifecycle ────────────────────────────────────────────────────────────

    public function mount(): void
    {
        $this->date_from  = Carbon::now()->startOfMonth()->toDateString();
        $this->date_until = Carbon::now()->endOfMonth()->toDateString();
    }

    // ── Authorization ────────────────────────────────────────────────────────

    public static function canAccess(): bool
    {
        return auth()->check() && (
            auth()->user()->hasRole('super_admin') ||
            auth()->user()->hasRole('office_staff')
        );
    }

    // ── Filter select options ─────────────────────────────────────────────────

    public function getWorkOrderOptions(): array
    {
        return WorkOrder::orderBy('work_order_number')
            ->pluck('work_order_number', 'id')
            ->toArray();
    }

    public function getDriverOptions(): array
    {
        return Driver::with('user')
            ->get()
            ->mapWithKeys(fn ($d) => [$d->id => $d->user?->name ?? "Driver #{$d->id}"])
            ->toArray();
    }

    public function getVehicleOptions(): array
    {
        return Vehicle::with(['make', 'model'])
            ->get()
            ->mapWithKeys(fn ($v) => [$v->id => trim("{$v->year} {$v->make?->name} {$v->model?->name}")])
            ->toArray();
    }

    public function getCategoryOptions(): array
    {
        return ExpenseCategory::orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }

    // ── Query helpers ────────────────────────────────────────────────────────

    private function expenseQuery()
    {
        return Expense::query()
            ->when($this->date_from,  fn ($q) => $q->whereDate('expense_date', '>=', $this->date_from))
            ->when($this->date_until, fn ($q) => $q->whereDate('expense_date', '<=', $this->date_until))
            ->when($this->work_order_id,       fn ($q) => $q->where('work_order_id', $this->work_order_id))
            ->when($this->driver_id,           fn ($q) => $q->where('driver_id', $this->driver_id))
            ->when($this->vehicle_id,          fn ($q) => $q->where('vehicle_id', $this->vehicle_id))
            ->when($this->expense_category_id, fn ($q) => $q->where('expense_category_id', $this->expense_category_id));
    }

    private function fuelQuery()
    {
        return FuelExpense::query()
            ->when($this->date_from,    fn ($q) => $q->whereDate('fuel_date', '>=', $this->date_from))
            ->when($this->date_until,   fn ($q) => $q->whereDate('fuel_date', '<=', $this->date_until))
            ->when($this->work_order_id, fn ($q) => $q->where('work_order_id', $this->work_order_id))
            ->when($this->driver_id,    fn ($q) => $q->where('driver_id', $this->driver_id))
            ->when($this->vehicle_id,   fn ($q) => $q->where('vehicle_id', $this->vehicle_id));
    }

    // ── Summary stats ────────────────────────────────────────────────────────

    public function getTotalExpenses(): int
    {
        return (int) $this->expenseQuery()->sum('amount');
    }

    public function getTotalFuel(): int
    {
        return (int) $this->fuelQuery()->sum('total_cost');
    }

    public function getCombinedTotal(): int
    {
        return $this->getTotalExpenses() + $this->getTotalFuel();
    }

    public function getJobsWithExpensesCount(): int
    {
        $expenseWorkOrders = $this->expenseQuery()->distinct()->pluck('work_order_id');
        $fuelWorkOrders    = $this->fuelQuery()->distinct()->pluck('work_order_id');

        return $expenseWorkOrders->merge($fuelWorkOrders)->unique()->count();
    }

    // ── Breakdown tables ──────────────────────────────────────────────────────

    public function getCategoryBreakdown(): \Illuminate\Support\Collection
    {
        return $this->expenseQuery()
            ->select('expense_category_id', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
            ->groupBy('expense_category_id')
            ->with('category')
            ->get()
            ->map(fn ($row) => [
                'category' => $row->category?->name ?? 'Unknown',
                'count'    => $row->count,
                'total'    => (int) $row->total,
            ])
            ->sortByDesc('total')
            ->values();
    }

    public function getWorkOrderBreakdown(): \Illuminate\Support\Collection
    {
        $expensesByWo = $this->expenseQuery()
            ->select('work_order_id', DB::raw('SUM(amount) as expenses_total'))
            ->groupBy('work_order_id')
            ->pluck('expenses_total', 'work_order_id');

        $fuelByWo = $this->fuelQuery()
            ->select('work_order_id', DB::raw('SUM(total_cost) as fuel_total'))
            ->groupBy('work_order_id')
            ->pluck('fuel_total', 'work_order_id');

        $allWorkOrderIds = $expensesByWo->keys()->merge($fuelByWo->keys())->unique();

        $workOrders = WorkOrder::whereIn('id', $allWorkOrderIds)
            ->pluck('work_order_number', 'id');

        return $allWorkOrderIds->map(function ($id) use ($expensesByWo, $fuelByWo, $workOrders) {
            $expenses = (int) ($expensesByWo[$id] ?? 0);
            $fuel     = (int) ($fuelByWo[$id] ?? 0);

            return [
                'work_order_number' => $workOrders[$id] ?? "WO #{$id}",
                'expenses'          => $expenses,
                'fuel'              => $fuel,
                'total'             => $expenses + $fuel,
            ];
        })
            ->sortByDesc('total')
            ->values();
    }

    // ── Formatting helpers ────────────────────────────────────────────────────

    public function formatDollars(int $cents): string
    {
        return '$' . number_format($cents / 100, 2);
    }
}
