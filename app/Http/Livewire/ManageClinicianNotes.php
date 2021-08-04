<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\DataWarehouse\Professional;
use App\Models\DataWarehouse\ProfessionalNote;

class ManageClinicianNotes extends Component
{
    public Professional $clinician;
    public ProfessionalNote $note;

    public $rules = [
        'note.IsDnc' => 'between:0,1',
        'note.IsPaused' => 'between:0,1',
        'note.IsTechIssue' => 'between:0,1',
        'note.isStarResponder' => 'between:0,1',
        'note.isAxxessian' => 'between:0,1',
        'note.Note' => 'string',
        'note.Rating' => 'integer',
    ];

    public function mount(Professional $clinician)
    {
        $this->clinician = $clinician;

        $this->note = ProfessionalNote::firstOrCreate(
            ['ProfessionalId' => $this->clinician->Id],
            ['id' => (string) Str::uuid()]
        );
    }

    public function clearBadges()
    {
        $this->note->update([
            'IsDnc' => 0,
            'IsPaused' => 0,
            'IsTechIssue' => 0,
            'isStarResponder' => 0,
            'isAxxessian' => 0,
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

    public function updatedNoteIsTechIssue()
    {
        $this->validateAndSave();
    }

    public function updatedNoteIsStarResponder()
    {
        $this->validateAndSave();
    }

    public function updatedNoteIsAxxessian()
    {
        $this->validateAndSave();
    }

    public function saveNote()
    {
        $this->validateAndSave();
    }

    public function saveRating()
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
        return view('livewire.manage-clinician-notes');
    }
}
