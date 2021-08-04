<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\DataWarehouse\VisitNote;

class UpdateVisitNote extends Component
{
    public VisitNote $note;

    protected $rules = [
        'note.isUnderstaffed' => 'between:0,1',
        'note.isLowvisitrate' => 'between:0,1',
        'note.isRescheduleremove' => 'between:0,1',
        'note.isAttemptedFulfillment' => 'between:0,1',
        'note.Note' => 'string',
    ];

    public function mount($jobId)
    {
        $this->note = VisitNote::firstOrCreate(
            ['JobID' => $jobId],
            ['id' => (string) Str::uuid()]
        );
    }

    public function save()
    {
        $this->validate();

        $this->note->save();
    }

    public function render()
    {
        return view('livewire.update-visit-note');
    }
}
