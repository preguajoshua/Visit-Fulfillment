<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\DataWarehouse\FollowUp;
use App\Models\DataWarehouse\Facility;

class AgencyScheduleFollowup extends Component
{
    public Facility $agency;
    public FollowUp $followUp;

    public $rules = [
        'followUp.FollowUpDate' => 'required',
        'followUp.FollowUpDetail' => 'required',
    ];

    public function mount(Facility $agency)
    {
        $this->agency = $agency;
        $this->followUp = new FollowUp;
    }

    public function save()
    {
        $this->validate();

        $this->followUp->ID = (string) Str::uuid();
        $this->followUp->UserId = auth()->user()->id;
        $this->followUp->Type = 1;

        $this->agency->followUps()->save($this->followUp);

        $this->followUp = new FollowUp;
    }

    public function delete(FollowUp $followUp)
    {
        $followUp->deprecate();

        $this->followUp = new FollowUp;
    }

    public function render()
    {
        return view('livewire.agency-schedule-followup', [
            'followUps' => $this->agency->followUps()->active()->orderbyDesc('Created')->get(),
        ]);
    }
}
