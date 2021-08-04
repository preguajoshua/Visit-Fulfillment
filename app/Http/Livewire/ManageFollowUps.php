<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\DataWarehouse\FollowUp;
use App\Models\DataWarehouse\Professional;

class ManageFollowUps extends Component
{
    public Professional $clinician;
    public FollowUp $followUp;

    public $rules = [
        'followUp.FollowUpDetail' => 'required',
        'followUp.FollowUpDate' => 'required',
    ];

    protected $validationAttributes = [
        'followUp.FollowUpDetail' => 'follow-up details',
        'followUp.FollowUpDate' => 'follow-up date',
    ];

    public function mount(Professional $clinician)
    {
        $this->clinician = $clinician;

        $this->followUp = new FollowUp;
    }

    public function save()
    {
        $this->validate();

        $this->followUp->ID = (string) Str::uuid();
        $this->followUp->UserId = auth()->user()->id;
        $this->followUp->Type = 1;

        $this->clinician->followUps()->save($this->followUp);

        $this->followUp = new FollowUp;
    }

    public function delete(FollowUp $followUp)
    {
        $followUp->deprecate();

        $this->followUp = new FollowUp;
    }

    public function render()
    {
        return view('livewire.manage-follow-ups', [
            'followUps' => $this->clinician->followUps()->active()->orderbyDesc('Created')->get(),
        ]);
    }
}
