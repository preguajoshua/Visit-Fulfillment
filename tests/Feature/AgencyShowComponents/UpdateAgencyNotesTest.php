<?php

namespace Tests\Feature\AgencyShowComponents;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\DataWarehouse\AgencyNote;
use App\Models\DataWarehouse\Facility;
use App\Http\Livewire\UpdateAgencyNotes;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateAgencyNoteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The agency under test.
     *
     * @var  \App\Models\DataWarehouse\Facility
     */
    protected $agency;

    /**
     * Run before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->agency = Facility::factory()
            ->create();

        $this->actingAs(User::factory()->create());
    }

     /** @test  */
    function can_add_agency_notes()
    {
        $this->agency->note()->save(
            AgencyNote::factory()->create()
        );

        Livewire::test(UpdateAgencyNotes::class, ['agency' => $this->agency])
            ->set('note.Note', 'Lorem ipsum dolor sit amet')
            ->call('saveNote');

        $this->assertTrue($this->agency->note()->where('Note', 'Lorem ipsum dolor sit amet')->exists());
    }
}
