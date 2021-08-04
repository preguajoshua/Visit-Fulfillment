<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\DataWarehouse\Facility;
use App\Models\DataWarehouse\AgencyNote;

class UpdateAgencyStatus extends Component
{
    public Facility $agency;
    public AgencyNote $note;

    public $rules = [
        'note.IsDnc' => 'between:0,1',
        'note.IsPaused' => 'between:0,1',
    ];

    public function mount(Facility $agency) 
    {
        $this->agency = $agency;
        $this->note = AgencyNote::firstOrCreate(
            ['FacilityID' => $this->agency->Id],
            ['Id' => (string) Str::uuid()]
        );
    }

    public function clearBadges()
    {
        $this->note->update([
            'IsDnc' => 0,
            'IsPaused' => 0,
        ]);
    }

    public function updatedNoteIsDnc()
    {
        $this->validateAndSave();
    }

    public function updatedNoteIsPaused()
    {
        $this->validateAndSave();
    }

    private function validateAndSave()
    {
        $this->validate();
        $this->note->save();
    }
    
    public function render()
    {
        return view('livewire.update-agency-status');
    }
}
