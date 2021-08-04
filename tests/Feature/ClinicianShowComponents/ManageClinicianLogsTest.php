<?php

namespace Tests\Feature\ClinicianShowComponents;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\DataWarehouse\Log;
use App\Http\Livewire\ManageClinicianLogs;
use App\Models\DataWarehouse\Professional;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ManageClinicianLogsTest extends TestCase
{
    use RefreshDatabase;

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
    function a_clinician_log_can_be_shown()
    {
        Log::factory()->create([
            'EntityId' => $this->professional->Id,
            'Log' => 'Lorem ipsum dolor sit amet',
        ]);

        Livewire::test(ManageClinicianLogs::class, ['clinician' => $this->professional])
            ->assertSee('Lorem ipsum dolor sit amet');
    }

    /** @test  */
    function multiple_clinician_logs_can_be_shown_in_order()
    {
        Log::factory()
            ->count(3)
            ->state(new Sequence(
                ['EntityId' => $this->professional->Id, 'Log' => 'This is the first log message.', 'Created' => '2020-12-29 23:59:59'],
                ['EntityId' => $this->professional->Id, 'Log' => 'This is the second log message.', 'Created' => '2020-12-30 23:59:59'],
                ['EntityId' => $this->professional->Id, 'Log' => 'This is the third log message.', 'Created' => '2020-12-31 23:59:59'],
            ))
            ->create();
        
        Livewire::test(ManageClinicianLogs::class, ['clinician' => $this->professional])
            ->assertSeeTextInOrder([
                'This is the third log message.',
                'This is the second log message.',
                'This is the first log message.',
            ]);
    }

    /** @test  */
    function the_time_of_the_log_can_be_shown()
    {
        Log::factory()->create([
            'EntityId' => $this->professional->Id,
            'Log' => 'Lorem ipsum dolor sit amet',
            'Created' => '2020-12-31 23:59:59',
        ]);

        Livewire::test(ManageClinicianLogs::class, ['clinician' => $this->professional])
            ->assertSee('Lorem ipsum dolor sit amet')
            ->assertSee('December 31, 2020 11:59 PM');
    }

    /** @test  */
    public function a_log_record_can_be_created()
    {
        $log = Livewire::test(ManageClinicianLogs::class, ['clinician' => $this->professional])
            ->set('log.Log', 'Lorem ipsum dolor sit amet')
            ->call('save');

        $this->assertTrue(Log::where('Log', 'Lorem ipsum dolor sit amet')->exists());
    }

    /** @test  */
    public function a_log_record_can_be_deleted()
    {
        $log1 = Log::factory()->create([
            'EntityId' => $this->professional->Id,
            'Log' => 'This is the first log message.',
        ]);
        $log2 = Log::factory()->create([
            'EntityId' => $this->professional->Id,
            'Log' => 'This is the second log message.',
        ]);
        $log3 = Log::factory()->create([
            'EntityId' => $this->professional->Id,
            'Log' => 'This is the third log message.',
        ]);
        $this->assertEquals(3, Log::where('EntityId', $this->professional->Id)->where('isDeprecated', 0)->count());

        Livewire::test(ManageClinicianLogs::class, ['clinician' => $this->professional])
            ->call('delete', $log2->Id);

        $this->assertEquals(2, Log::where('EntityId', $this->professional->Id)->where('isDeprecated', 0)->count());
        $this->assertTrue(Log::where('Id', $log1->Id)->where('isDeprecated', 0)->exists());
        $this->assertFalse(Log::where('Id', $log2->Id)->where('isDeprecated', 0)->exists());
        $this->assertTrue(Log::where('Id', $log3->Id)->where('isDeprecated', 0)->exists());
    }
}
