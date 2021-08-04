<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use App\Services\AxxessCareApiService;

class Visits extends Component
{
    use WithPagination;

    public $tomorrow;

    public $filters = [
        'jobType' => null,
        'discipline' => null,
        'radius' => 20,
        'dateRange' => null,
        'orderBy' => 'Visit Date',
        'page' => 1,
    ];

    public function mount()
    {
        $this->tomorrow = today()->addDay()->format('Y-m-d');
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function updatingFilters()
    {
        $this->resetPage();
    }

    public function render(AxxessCareApiService $axxessCareApiService)
    {
        $this->filters['page'] = Paginator::resolveCurrentPage() ?: 1;

        return view('livewire.visits', [
            'visits' => $axxessCareApiService->visits($this->filters)
        ]);
    }
}
