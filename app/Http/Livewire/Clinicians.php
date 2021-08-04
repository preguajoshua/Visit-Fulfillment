<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\DataWarehouse\Identity;
use Illuminate\Database\Eloquent\Builder;
use App\Models\DataWarehouse\Professional;
use App\Models\DataWarehouse\ProfessionalNote;

class Clinicians extends Component
{
    use WithPagination;

    const PER_PAGE = 12;

    public $filters = [
        'starResponder' => null,
        'technicalIssue' => null,
        'paused' => null,
        'doNotContact' => null,
        'rating' => null,
    ];

    public $orderBy = 'name';

    public function resetFilters()
    {
        $this->reset(['filters', 'orderBy']);
    }

    public function clearBadges()
    {
        $this->filters['starResponder'] = null;
        $this->filters['technicalIssue'] = null;
        $this->filters['paused'] = null;
        $this->filters['doNotContact'] = null;
    }

    public function clinicianDetails(Professional $clinician)
    {
        return redirect()->route('clinicians.show', [$clinician]);
    }

    public function getCliniciansProperty()
    {
        $professional = (new Professional)->getTable();

        return Professional::qualifyColumns()
            ->leftJoinRelationship('identity')
            ->leftJoinRelationship('note')
            // Wheres
            ->validStatus()
            ->identityParticipatingState()
            ->noteNonAxxessian()
            // Filters
            ->filterNoteAttributes($this->filters)
            ->groupBy("{$professional}.Id")
            ->select([
                "{$professional}.Id",
                "{$professional}.FirstName",
                "{$professional}.LastName",
                "{$professional}.Status",
            ])
            ->with([
                'identity:Id,EntityId,PhoneNumber',
                'note:id,ProfessionalID,LastContacted,IsDnc,IsPaused,IsTechIssue,isStarResponder,Rating',
                'roles:Id,ProfessionalId,Role'
            ])
            ->orderClinicianResults($this->orderBy)
            ->paginate(self::PER_PAGE);
    }

    public function render()
    {
        return view('livewire.clinicians');
    }
}
