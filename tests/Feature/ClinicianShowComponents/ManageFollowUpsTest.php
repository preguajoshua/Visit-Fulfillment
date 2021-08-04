<?php

namespace Tests\Feature\ClinicianShowComponents;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\ManageFollowUps;
use App\Models\DataWarehouse\FollowUp;
use App\Models\DataWarehouse\Professional;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ManageFollowUpsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The professional under test.
     *
     * @var  \App\Models\DataWarehouse\Professional
     */
    protected $professional;

    /**
     * Run before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->professional = Professional::factory()->create();

        $this->actingAs(User::factory()->create());
    }

    /** @test  */
    public function a_follow_up_can_be_created()
    {
        Livewire::test(ManageFollowUps::class, ['clinician' => $this->professional])
            ->set('followUp.FollowUpDetail', 'Lorem ipsum dolor sit amet')
            ->set('followUp.FollowUpDate', '2020-12-31 23:59:59')
            ->call('save');

        $this->assertTrue(
            FollowUp::query()
                ->where('FollowUpDetail', 'Lorem ipsum dolor sit amet')
                ->where('FollowUpDate', '2020-12-31 23:59:59')
                ->exists()
        );
    }

    /** @test  */
    public function some_detail_must_be_provided()
    {
        Livewire::test(ManageFollowUps::class, ['clinician' => $this->professional])
            ->set('followUp.FollowUpDate', '2020-12-31 23:59:59')
            ->call('save')
            ->assertHasErrors(['followUp.FollowUpDetail']);
    }

    /** @test  */
    public function a_date_must_be_provided()
    {
        Livewire::test(ManageFollowUps::class, ['clinician' => $this->professional])
            ->set('followUp.FollowUpDetail', 'Lorem ipsum dolor sit amet')
            ->call('save')
            ->assertHasErrors(['followUp.FollowUpDate']);
    }

    /** @test  */
    function multiple_follow_ups_can_be_shown_in_order()
    {
        FollowUp::factory()
            ->count(3)
            ->state(new Sequence(
                ['EntityId' => $this->professional->Id, 'FollowUpDetail' => 'This is the first follow-up.', 'FollowUpDate' => '2021-12-30 06:26:49', 'Created' => '2020-12-29 23:59:59'],
                ['EntityId' => $this->professional->Id, 'FollowUpDetail' => 'This is the second follow-up.', 'FollowUpDate' => '2021-12-31 06:26:49', 'Created' => '2020-12-30 23:59:59'],
                ['EntityId' => $this->professional->Id, 'FollowUpDetail' => 'This is the third follow-up.', 'FollowUpDate' => '2022-01-01 06:26:49', 'Created' => '2020-12-31 23:59:59'],
            ))
            ->create();
        
        Livewire::test(ManageFollowUps::class, ['clinician' => $this->professional])
            ->assertSeeTextInOrder([
                'This is the third follow-up.',
                'This is the second follow-up.',
                'This is the first follow-up.',
            ]);
    }

    /** @test  */
    public function a_follow_up_can_be_deleted()
    {
        $followUp1 = FollowUp::factory()->create([
            'EntityId' => $this->professional->Id,
            'FollowUpDetail' => 'This is the first follow-up.',
            'FollowUpDate' => '2021-12-29 06:26:49',
        ]);
        $followUp2 = FollowUp::factory()->create([
            'EntityId' => $this->professional->Id,
            'FollowUpDetail' => 'This is the second follow-up.',
            'FollowUpDate' => '2021-12-30 06:26:49',
        ]);
        $followUp3 = FollowUp::factory()->create([
            'EntityId' => $this->professional->Id,
            'FollowUpDetail' => 'This is the third follow-up.',
            'FollowUpDate' => '2021-12-31 06:26:49',
        ]);
        $this->assertEquals(3, FollowUp::where('EntityId', $this->professional->Id)->where('isDeprecated', 0)->count());

        Livewire::test(ManageFollowUps::class, ['clinician' => $this->professional])
            ->call('delete', $followUp2->ID);

        $this->assertEquals(2, FollowUp::where('EntityId', $this->professional->Id)->where('isDeprecated', 0)->count());
        $this->assertTrue(FollowUp::where('ID', $followUp1->ID)->where('isDeprecated', 0)->exists());
        $this->assertFalse(FollowUp::where('ID', $followUp2->ID)->where('isDeprecated', 0)->exists());
        $this->assertTrue(FollowUp::where('ID', $followUp3->ID)->where('isDeprecated', 0)->exists());
    }
}
