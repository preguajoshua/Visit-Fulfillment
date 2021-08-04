<?php

namespace Tests\Feature\AgencyShowComponents;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\DataWarehouse\AgencyNote;
use App\Models\DataWarehouse\Facility;
use App\Http\Livewire\UpdateAgencyRating;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateAgencyRatingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The agency under test.
     *
     * @var  \App\Models\DataWarehouse\Professional
     */
    protected $agency;

    /**
     * Run before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->agency = Facility::factory()->create();

        $this->actingAs(User::factory()->create());
    }

    /** @test  */
    public function the_agency_rating_can_be_updated()
    {
        $this->agency->note()->save(
            AgencyNote::factory()->make(['Rating' => 3])
        );
        $this->assertTrue($this->agency->note()->where('Rating', 3)->exists());

        Livewire::test(UpdateAgencyRating::class, ['agency' => $this->agency])
            ->set('note.Rating', 5)
            ->call('saveRating');

        $this->assertTrue($this->agency->note()->where('Rating', 5)->exists());
        $this->assertFalse($this->agency->note()->where('Rating', 3)->exists());
    }
}
