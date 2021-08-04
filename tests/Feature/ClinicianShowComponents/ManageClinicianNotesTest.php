<?php

namespace Tests\Feature\ClinicianShowComponents;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\DataWarehouse\Professional;
use App\Http\Livewire\ManageClinicianNotes;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\DataWarehouse\ProfessionalNote;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageClinicianNotesTest extends TestCase
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
    function clinician_notes_are_disabled_by_default()
    {
        $this->professional->note()->save(
            ProfessionalNote::factory()->create()
        );

        Livewire::test(ManageClinicianNotes::class, ['clinician' => $this->professional]);
        
        $note = $this->professional->note()
            ->where('IsDnc', false)
            ->where('IsPaused', false)
            ->where('isTechissue', false)
            ->where('isStarResponder', null)
            ->where('isAxxessian', false);
        
        $this->assertTrue($note->exists());
    }

    /** @test  */
    function can_reset_clinician_notes()
    {
        $this->professional->note()->save(
            ProfessionalNote::factory()->make([
                'IsDnc' => true,
                'IsPaused' => true,
                'isTechIssue' => true,
                'isStarResponder' => true,
                'isAxxessian' => true,
            ])
        );
        $this->assertTrue($this->professional->note()
            ->where('IsDnc', true)
            ->where('IsPaused', true)
            ->where('isTechIssue', true)
            ->where('isStarResponder', true)
            ->where('isAxxessian', true)
            ->exists()
        );

        Livewire::test(ManageClinicianNotes::class, ['clinician' => $this->professional])
            ->call('clearBadges');

        $this->assertTrue($this->professional->note()
            ->where('IsDnc', false)
            ->where('IsPaused', false)
            ->where('isTechIssue', false)
            ->where('isStarResponder', false)
            ->where('isAxxessian', false)
            ->exists()
        );
    }

    /** @test  */
    function can_set_clinician_to_do_not_contact()
    {
        $this->professional->note()->save(
            ProfessionalNote::factory()->create()
        );

        Livewire::test(ManageClinicianNotes::class, ['clinician' => $this->professional])
            ->set('note.IsDnc', true);

        $this->assertTrue($this->professional->note()->where('IsDnc', true)->exists());
    }

    /** @test  */
    function can_set_clinician_to_paused()
    {
        $this->professional->note()->save(
            ProfessionalNote::factory()->create()
        );

        Livewire::test(ManageClinicianNotes::class, ['clinician' => $this->professional])
            ->set('note.IsPaused', true);

        $this->assertTrue($this->professional->note()->where('IsPaused', true)->exists());
    }

    /** @test  */
    function can_set_clinician_to_technical_issue()
    {
        $this->professional->note()->save(
            ProfessionalNote::factory()->create()
        );

        Livewire::test(ManageClinicianNotes::class, ['clinician' => $this->professional])
            ->set('note.IsTechIssue', true);

        $this->assertTrue($this->professional->note()->where('isTechissue', true)->exists());
    }

    /** @test  */
    function can_set_clinician_to_star_responder()
    {
        $this->professional->note()->save(
            ProfessionalNote::factory()->create()
        );

        Livewire::test(ManageClinicianNotes::class, ['clinician' => $this->professional])
            ->set('note.isStarResponder', true);

        $this->assertTrue($this->professional->note()->where('isStarResponder', true)->exists());
    }

    /** @test  */
    function can_set_clinician_to_an_axxessian()
    {
        $this->professional->note()->save(
            ProfessionalNote::factory()->create()
        );
        Livewire::test(ManageClinicianNotes::class, ['clinician' => $this->professional])
            ->set('note.isAxxessian', true);

        $this->assertTrue($this->professional->note()->where('isAxxessian', true)->exists());
    }

    /** @test  */
    function can_add_clinician_notes()
    {
        $this->professional->note()->save(
            ProfessionalNote::factory()->create()
        );

        Livewire::test(ManageClinicianNotes::class, ['clinician' => $this->professional])
            ->set('note.Note', 'Lorem ipsum dolor sit amet')
            ->call('saveNote');

        $this->assertTrue($this->professional->note()->where('Note', 'Lorem ipsum dolor sit amet')->exists());
    }

    /** @test  */
    function can_edit_clinician_notes()
    {
        $this->professional->note()->save(
            ProfessionalNote::factory()->make(['Note' => 'Original Note'])
        );
        $this->assertTrue($this->professional->note()->where('Note', 'Original Note')->exists());

        Livewire::test(ManageClinicianNotes::class, ['clinician' => $this->professional])
            ->set('note.Note', 'Lorem ipsum dolor sit amet')
            ->call('saveNote');

        $this->assertFalse($this->professional->note()->where('Note', 'Original Note')->exists());
        $this->assertTrue($this->professional->note()->where('Note', 'Lorem ipsum dolor sit amet')->exists());
    }

    /** @test  */
    public function the_clinicians_rating_can_be_set()
    {
        $this->professional->note()->save(
            ProfessionalNote::factory()->create()
        );
        Livewire::test(ManageClinicianNotes::class, ['clinician' => $this->professional])
            ->set('note.Rating', 5)
            ->call('saveRating');

        $this->assertTrue($this->professional->note()->where('Rating', 5)->exists());
    }

    /** @test  */
    public function the_clinicians_rating_can_be_updated()
    {
        $this->professional->note()->save(
            ProfessionalNote::factory()->make(['Rating' => 3])
        );
        $this->assertTrue($this->professional->note()->where('Rating', 3)->exists());

        Livewire::test(ManageClinicianNotes::class, ['clinician' => $this->professional])
            ->set('note.Rating', 5)
            ->call('saveRating');

        $this->assertFalse($this->professional->note()->where('Rating', 3)->exists());
        $this->assertTrue($this->professional->note()->where('Rating', 5)->exists());
    }
}
