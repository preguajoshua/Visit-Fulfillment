<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\DataWarehouse\Log;
use App\Models\DataWarehouse\Professional;

class ManageClinicianLogs extends Component
{
    public Professional $clinician;
    public Log $log;
    
    public $rules = [
        'log.Log' => 'required',
    ];

    protected $validationAttributes = [
        'log.Log' => 'log details',
    ];

    public function mount(Professional $clinician)
    {
        $this->clinician = $clinician;

        $this->log = new Log;
    }
    
    public function save()
    {
        $this->validate();

        $this->log->Id = (string) Str::uuid();
        $this->log->UserId = auth()->user()->id;

        $this->clinician->logs()->save($this->log);

        $this->log = new Log;
    }

    public function delete(Log $log)
    {
        $log->deprecate();

        $this->log = new Log;
    }

    public function render()
    {
        return view('livewire.manage-clinician-logs', [
            'logs' => $this->clinician->logs()->active()->orderbyDesc('Created')->get(),
        ]);
    }
}
