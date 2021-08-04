<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\DataWarehouse\Log;
use App\Models\DataWarehouse\Facility;

class ManageAgencyLogs extends Component
{
    public Facility $agency;
    public Log $log;
    
    public $rules = [
        'log.Log' => 'required',
    ];

    public function mount(Facility $agency)
    {
        $this->agency = $agency;
        $this->log = new Log;
    }
    
    public function save()
    {
        $this->validate();

        $this->log->Id = (string) Str::uuid();
        $this->log->UserId = auth()->user()->id;

        $this->agency->logs()->save($this->log);

        $this->log = new Log;
    }

    public function delete(Log $log)
    {
        $log->deprecate();

        $this->log = new Log;
    }

    public function render()
    {
        return view('livewire.manage-agency-logs', [
            'logs' => $this->agency->logs()->active()->orderbyDesc('Created')->get(),
        ]);
    }
}
