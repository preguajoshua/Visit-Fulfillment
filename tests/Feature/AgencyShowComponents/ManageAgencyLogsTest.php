<?php

namespace Tests\Feature\AgencyShowComponents;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\DataWarehouse\Log;
use App\Models\DataWarehouse\Facility;
use App\Http\Livewire\ManageAgencyLogs;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ManageAgencyLogsTest extends TestCase
{
    use RefreshDatabase;

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
    function the_agency_log_can_be_shown()
    {
        Log::factory()->create([
            'EntityId' => $this->agency->Id,
            'Log' => 'Lorem ipsum dolor sit amet',
        ]);

        Livewire::test(ManageAgencyLogs::class, ['agency' => $this->agency])
            ->assertSee('Lorem ipsum dolor sit amet');
    }

    /** @test  */
    function the_agency_logs_can_be_shown_in_order()
    {
        Log::factory()
            ->count(3)
            ->state(new Sequence(
                ['EntityId' => $this->agency->Id, 'Log' => 'This is the first log message.', 'Created' => '2020-12-29 23:59:59'],
                ['EntityId' => $this->agency->Id, 'Log' => 'This is the second log message.', 'Created' => '2020-12-30 23:59:59'],
                ['EntityId' => $this->agency->Id, 'Log' => 'This is the third log message.', 'Created' => '2020-12-31 23:59:59'],
            ))
            ->create();
        
            Livewire::test(ManageAgencyLogs::class, ['agency' => $this->agency])
            ->assertSeeTextInOrder([
                'This is the third log message.',
                'This is the second log message.',
                'This is the first log message.',
            ]);
    }

    /** @test  */
    function the_time_of_the_agency_log_can_be_shown()
    {
        Log::factory()->create([
            'EntityId' => $this->agency->Id,
            'Log' => 'Lorem ipsum dolor sit amet',
            'Created' => '2020-12-31 23:59:59',
        ]);

        Livewire::test(ManageAgencyLogs::class, ['agency' => $this->agency])
            ->assertSee('Lorem ipsum dolor sit amet')
            ->assertSee('December 31, 2020 11:59 PM');
    }

    /** @test  */
    public function the_agency_log_record_can_be_created()
    {
        $log = Livewire::test(ManageAgencyLogs::class, ['agency' => $this->agency])
            ->set('log.Log', 'Lorem ipsum dolor sit amet')
            ->call('save');

        $this->assertTrue(Log::where('Log', 'Lorem ipsum dolor sit amet')->exists());
    }

    /** @test  */
    public function the_agency_log_record_can_be_deleted()
    {
        $log1 = Log::factory()->create([
            'EntityId' => $this->agency->Id,
            'Log' => 'This is the first log message.',
        ]);
        $log2 = Log::factory()->create([
            'EntityId' => $this->agency->Id,
            'Log' => 'This is the second log message.',
        ]);
        $log3 = Log::factory()->create([
            'EntityId' => $this->agency->Id,
            'Log' => 'This is the third log message.',
        ]);
        $this->assertEquals(3, Log::where('EntityId', $this->agency->Id)->where('isDeprecated', 0)->count());

        Livewire::test(ManageAgencyLogs::class, ['agency' => $this->agency])
            ->call('delete', $log2->Id);

        $this->assertEquals(2, Log::where('EntityId', $this->agency->Id)->where('isDeprecated', 0)->count());
        $this->assertTrue(Log::where('Id', $log1->Id)->where('isDeprecated', 0)->exists());
        $this->assertFalse(Log::where('Id', $log2->Id)->where('isDeprecated', 0)->exists());
        $this->assertTrue(Log::where('Id', $log3->Id)->where('isDeprecated', 0)->exists());
    }
}
