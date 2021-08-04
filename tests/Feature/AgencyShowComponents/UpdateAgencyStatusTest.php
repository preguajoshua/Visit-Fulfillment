<?php

namespace Tests\Feature\AgencyShowComponents;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\DataWarehouse\AgencyNote;
use App\Models\DataWarehouse\Facility;
use App\Http\Livewire\UpdateAgencyStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateAgencyStatusTest extends TestCase
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
    function the_agency_status_are_disabled_by_default()
    {
        $this->agency->note()->save(
            AgencyNote::factory()->create()
        );

        Livewire::test(UpdateAgencyStatus::class, ['agency' => $this->agency]);
        
        $status = $this->agency->note()
            ->where('IsDnc', false)
            ->where('IsPaused', false);
        
        $this->assertTrue($status->exists());
    }

    /** @test  */
    function can_reset_agency_status()
    {
        $this->agency->note()->save(
            AgencyNote::factory()->make([
                'IsDnc' => true,
                'IsPaused' => true,
            ])
        );
        $this->assertTrue($this->agency->note()
            ->where('IsDnc', true)
            ->where('IsPaused', true)
            ->exists()
        );

        Livewire::test(UpdateAgencyStatus::class, ['agency' => $this->agency])
            ->call('clearBadges');

        $this->assertTrue($this->agency->note()
            ->where('IsDnc', false)
            ->where('IsPaused', false)
            ->exists()
        );
    }

    /** @test  */
    function can_set_agency_status_to_do_not_contact()
    {
        $this->agency->note()->save(
            AgencyNote::factory()->create()
        );

        Livewire::test(UpdateAgencyStatus::class, ['agency' => $this->agency])
            ->set('note.IsDnc', true);

        $this->assertTrue($this->agency->note()->where('IsDnc', true)->exists());
    }

    /** @test  */
    function can_set_agency_status_to_is_paused()
    {
        $this->agency->note()->save(
            AgencyNote::factory()->create()
        );

        Livewire::test(UpdateAgencyStatus::class, ['agency' => $this->agency])
            ->set('note.IsPaused', true);

        $this->assertTrue($this->agency->note()->where('IsPaused', true)->exists());
    }

}
