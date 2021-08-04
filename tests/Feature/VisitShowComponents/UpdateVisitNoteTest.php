<?php

namespace Tests\Feature\VisitShowComponents;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\UpdateVisitNote;
use App\Models\DataWarehouse\VisitNote;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateVisitNoteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Run before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());

        $this->note = VisitNote::factory()->create(['JobID' => '00000000-0000-0000-0000-000000000001']);
    }

    /** @test  */
    function the_understaffed_flag_can_be_set()
    {
        Livewire::test(UpdateVisitNote::class, ['jobId' => $this->note->JobID])
            ->set('note.Note', 'foobar')
            ->set('note.isUnderstaffed', true)
            ->call('save');
        
        $this->assertTrue(VisitNote::where('isUnderstaffed', true)->exists());
    }

    /** @test  */
    function the_low_visit_rate_flag_can_be_set()
    {
        Livewire::test(UpdateVisitNote::class, ['jobId' => $this->note->JobID])
            ->set('note.Note', 'foobar')
            ->set('note.isLowvisitrate', true)
            ->call('save');

        $this->assertTrue(VisitNote::where('isLowvisitrate', true)->exists());
    }

    /** @test  */
    function the_reschedule_flag_can_be_set()
    {
        Livewire::test(UpdateVisitNote::class, ['jobId' => $this->note->JobID])
            ->set('note.Note', 'foobar')
            ->set('note.isRescheduleremove', true)
            ->call('save');

        $this->assertTrue(VisitNote::where('isRescheduleremove', true)->exists());
    }

    /** @test  */
    function the_attempted_fulfillment_flag_can_be_set()
    {
        Livewire::test(UpdateVisitNote::class, ['jobId' => $this->note->JobID])
            ->set('note.Note', 'foobar')
            ->set('note.isAttemptedFulfillment', true)
            ->call('save');

        $this->assertTrue(VisitNote::where('isAttemptedFulfillment', true)->exists());
    }

    /** @test  */
    function the_note_text_can_be_updated()
    {
        Livewire::test(UpdateVisitNote::class, ['jobId' => $this->note->JobID])
            ->set('note.Note', 'foobar')
            ->call('save');

        $this->assertTrue(VisitNote::whereNote('foobar')->exists());
    }

    /** @test  */
    function a_new_note_record_is_created_when_it_does_not_already_exist()
    {
        $this->assertDatabaseMissing('axxesscare_visitnotes', ['JobID' => '00000000-0000-0000-0000-000000000002']);

        Livewire::test(UpdateVisitNote::class, ['jobId' => '00000000-0000-0000-0000-000000000002'])
            ->set('note.Note', 'foobar')
            ->call('save');

        $this->assertDatabaseHas('axxesscare_visitnotes', ['JobID' => '00000000-0000-0000-0000-000000000002']);
        $this->assertTrue(VisitNote::whereNote('foobar')->exists());
    }
}
