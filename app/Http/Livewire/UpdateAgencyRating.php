<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\DataWarehouse\Facility;
use App\Models\DataWarehouse\AgencyNote;

class UpdateAgencyRating extends Component
{
    public Facility $agency;
    public AgencyNote $note;

    public $rules = [
        'note.Note' => '',
        'note.Rating' => 'between:0,10'
    ];

    public function mount(Facility $agency) 
    {
        $this->agency = $agency;
        $this->note = AgencyNote::firstOrCreate(
            ['FacilityID' => $this->agency->Id],
            ['Id' => (string) Str::uuid()]
        );
    }

    public function saveRating()
    {
        $this->validate();
        $this->note->save();
    }

    public function render()
    {
        return view('livewire.update-agency-rating');
    }
}
