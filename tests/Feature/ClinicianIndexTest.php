<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Clinicians;
use App\Models\DataWarehouse\Identity;
use App\Models\DataWarehouse\Professional;
use App\Models\DataWarehouse\ProfessionalNote;
use App\Models\DataWarehouse\ProfessionalRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ClinicianIndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user.
     *
     * @var  \App\Models\User
     */
    protected $user;

    /**
     * Default filters.
     *
     * @var  array
     */
    protected $filters;

    /**
     * Default sort order.
     *
     * @var  array
     */
    protected $orderBy;

    /**
     * Run before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->filters = [
            'starResponder' => null,
            'technicalIssue' => null,
            'paused' => null,
            'doNotContact' => null,
            'rating' => null,
        ];

        $this->orderBy = 'name';
    }

    /** @test  */
    public function a_clinician_can_be_viewed_on_the_clinicians_page()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create([
                'FirstName' => 'John',
                'LastName' => 'Doe',
            ]);

        $response = $this->actingAs($this->user)->get('/clinicians');

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe');
    }

    /** @test  */
    public function a_clinicians_related_data_can_be_viewed_on_the_clinicians_page()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState()->state(['PhoneNumber' => '5551112222']))
            ->has(ProfessionalNote::factory()->nonAxxessian()->state(['LastContacted' => '2020-12-31 23:59:59']), 'note')
            ->has(ProfessionalRole::factory()->rn(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);

        $response = $this->actingAs($this->user)->get('/clinicians');

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertSeeText('555-111-2222')
            ->assertSeeText('RN')
            ->assertSeeText('2020-12-31 23:59:59')
            ->assertSeeText('Approved');
    }

    /** @test  */
    public function clinician_page_displays_expected_number_of_clinicians_per_page()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->count(Clinicians::PER_PAGE + 1)
            ->create();

        Livewire::withQueryParams(['page' => 1])
            ->test(Clinicians::class)
            ->assertSet('clinicians', function ($paginatedData) {
                return $paginatedData->count() === Clinicians::PER_PAGE;
            });
        Livewire::withQueryParams(['page' => 2])
            ->test(Clinicians::class)
            ->assertSet('clinicians', function ($paginatedData) {
                return $paginatedData->count() === 1;
            });
    }

    /** @test  */
    public function the_correct_clinicians_are_shown_on_the_correct_pages()
    {
        $this->assertEquals(Clinicians::PER_PAGE, 12, 'Test expects PER_PAGE to be 12.');
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->count(Clinicians::PER_PAGE + 1)
            ->state(new Sequence(
                // Page 1
                ['FirstName' => 'Ann', 'LastName' => 'Bee'],
                ['FirstName' => 'Ann', 'LastName' => 'Bee'],
                ['FirstName' => 'Ann', 'LastName' => 'Bee'],
                ['FirstName' => 'Ann', 'LastName' => 'Bee'],
                ['FirstName' => 'Ann', 'LastName' => 'Bee'],
                ['FirstName' => 'Ann', 'LastName' => 'Bee'],
                ['FirstName' => 'Ann', 'LastName' => 'Bee'],
                ['FirstName' => 'Ann', 'LastName' => 'Bee'],
                ['FirstName' => 'Ann', 'LastName' => 'Bee'],
                ['FirstName' => 'Ann', 'LastName' => 'Bee'],
                ['FirstName' => 'Ann', 'LastName' => 'Bee'],
                ['FirstName' => 'Ann', 'LastName' => 'Bee'],
                // Page 2
                ['FirstName' => 'Yak', 'LastName' => 'Zak'],
            ))
            ->create();
        $this->orderBy = 'name';

        Livewire::withQueryParams(['page' => 1])
            ->test(Clinicians::class, ['filters' => $this->filters])
            ->assertSeeText('Ann Bee')
            ->assertDontSeeText('Yak Zak');
        Livewire::withQueryParams(['page' => 2])
            ->test(Clinicians::class, ['filters' => $this->filters])
            ->assertSeeText('Yak Zak')
            ->assertDontSeeText('Ann Bee');
    }

    /** @test  */
    public function the_clinicians_page_indicates_when_there_is_no_last_contacted_date()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian()->state(['LastContacted' => null]), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);

        $response = $this->actingAs($this->user)->get('/clinicians');

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertSeeText('Never');
    }

    /** @test  */
    public function the_clinicians_page_does_not_display_axxessian_clinicians()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->state(['isAxxessian' => 1]), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->state(['isAxxessian' => 0]), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'Jane', 'LastName' => 'Doe']);
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->state(['isAxxessian' => null]), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'Jill', 'LastName' => 'Doe']);

        $response = $this->actingAs($this->user)->get('/clinicians');

        $response
            ->assertSuccessful()
            ->assertDontSeeText('John Doe')
            ->assertSeeText('Jane Doe')
            ->assertSeeText('Jill Doe');
    }

    /** @test  */
    public function the_clinicians_page_does_not_display_clinicians_from_non_participating_us_states()
    {
        Professional::factory()
            ->has(Identity::factory()->nonParticipatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'Jane', 'LastName' => 'Doe']);

        $response = $this->actingAs($this->user)->get('/clinicians');

        $response
            ->assertSuccessful()
            ->assertDontSeeText('John Doe')
            ->assertSeeText('Jane Doe');
    }

    /** @test  */
    public function the_clinician_page_does_not_display_clinicians_with_invalid_statuses()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->undefinedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'Jane', 'LastName' => 'Doe']);

        $response = $this->actingAs($this->user)->get('/clinicians');

        $response
            ->assertSuccessful()
            ->assertDontSeeText('John Doe')
            ->assertSeeText('Jane Doe');
    }

    /** @test  */
    public function the_clinicians_name_is_sent_to_the_clinicians_view()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);

        Livewire::test(Clinicians::class)
            ->assertViewIs('livewire.clinicians')
            ->assertSet('clinicians', function ($paginatedData) {
                $firstClinician = $paginatedData->offsetGet(0);

                return
                    $firstClinician->FirstName === 'John' &&
                    $firstClinician->LastName === 'Doe';
            });
    }


    // Rating Filters

    /**
     * All possible rating descriptions.
     *
     * @return  array
     */
    public function ratingsProvider()
    {
        return [
            ['good'],
            ['neutral'],
            ['poor'],
        ];
    }

    /**
     * @test
     * @dataProvider ratingsProvider
     */
    public function the_clinicians_good_rating_is_sent_to_the_clinicians_view($rating)
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian()->rating($rating), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);

        Livewire::test(Clinicians::class)
            ->assertViewIs('livewire.clinicians')
            ->assertSeeHtml('<title>' . ucfirst($rating) . '</title>')
            ->assertSet('clinicians', function ($paginatedData) use ($rating) {
                $firstClinician = $paginatedData->offsetGet(0);

                return
                    $firstClinician->FirstName === 'John' &&
                    $firstClinician->LastName === 'Doe' &&
                    $firstClinician->note->ratingDescription === $rating;
            });
    }


    // Notes Filters

    /** @test  */
    public function can_filter_clinicians_star_responders_status()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian()->starResponder(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'Jane', 'LastName' => 'Doe']);
        $this->filters['starResponder'] = 1;

        Livewire::test(Clinicians::class, ['filters' => $this->filters])
            ->assertViewIs('livewire.clinicians')
            ->assertSet('clinicians', function ($paginatedData) {
                $firstClinician = $paginatedData->offsetGet(0);

                return
                    $paginatedData->count() === 1 &&
                    $firstClinician->FirstName === 'John' &&
                    $firstClinician->LastName === 'Doe' &&
                    $firstClinician->note->starResponder === true;
            });
    }

    /** @test  */
    public function can_filter_clinicians_technical_issues_status()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian()->techIssue(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'Jane', 'LastName' => 'Doe']);
        $this->filters['technicalIssue'] = 1;

        Livewire::test(Clinicians::class, ['filters' => $this->filters])
            ->assertViewIs('livewire.clinicians')
            ->assertSet('clinicians', function ($paginatedData) {
                $firstClinician = $paginatedData->offsetGet(0);

                return
                    $paginatedData->count() === 1 &&
                    $firstClinician->FirstName === 'John' &&
                    $firstClinician->LastName === 'Doe' &&
                    $firstClinician->note->techIssue === true;
            });
    }

    /** @test  */
    public function can_filter_clinicians_paused_status()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian()->paused(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'Jane', 'LastName' => 'Doe']);
        $this->filters['paused'] = 1;

        Livewire::test(Clinicians::class, ['filters' => $this->filters])
            ->assertViewIs('livewire.clinicians')
            ->assertSet('clinicians', function ($paginatedData) {
                $firstClinician = $paginatedData->offsetGet(0);

                return
                    $paginatedData->count() === 1 &&
                    $firstClinician->FirstName === 'John' &&
                    $firstClinician->LastName === 'Doe' &&
                    $firstClinician->note->Paused === true;
            });
    }

    /** @test  */
    public function can_filter_clinicians_do_not_contact_status()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian()->doNotContact(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'Jane', 'LastName' => 'Doe']);
        $this->filters['doNotContact'] = 1;

        Livewire::test(Clinicians::class, ['filters' => $this->filters])
            ->assertViewIs('livewire.clinicians')
            ->assertSet('clinicians', function ($paginatedData) {
                $firstClinician = $paginatedData->offsetGet(0);

                return
                    $paginatedData->count() === 1 &&
                    $firstClinician->FirstName === 'John' &&
                    $firstClinician->LastName === 'Doe' &&
                    $firstClinician->note->Dnc === true;
            });
    }

    /** @test  */
    public function can_reset_notes_filter()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian()->starResponder()->techIssue()->paused()->doNotContact(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'Jane', 'LastName' => 'Doe']);
        $this->filters['starResponder'] = 1;
        $this->filters['technicalIssue'] = 1;
        $this->filters['paused'] = 1;
        $this->filters['doNotContact'] = 1;

        Livewire::test(Clinicians::class, ['filters' => $this->filters])
            ->assertViewIs('livewire.clinicians')
            ->assertSet('clinicians', function ($paginatedData) {
                $firstClinician = $paginatedData->offsetGet(0);

                return
                    $paginatedData->count() === 1 &&
                    $firstClinician->FirstName === 'John' &&
                    $firstClinician->LastName === 'Doe';
            })
            ->call('clearBadges')
            ->assertSet('clinicians', function ($paginatedData) {
                return $paginatedData->count() === 2;
            });
    }

    /** @test  */
    public function can_reset_all_filters()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian()->paused()->rating('poor'), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'Jane', 'LastName' => 'Doe']);
        $this->filters['paused'] = 1;
        $this->filters['rating'] = 'poor';

        Livewire::test(Clinicians::class, ['filters' => $this->filters])
            ->assertViewIs('livewire.clinicians')
            ->assertSet('clinicians', function ($paginatedData) {
                $firstClinician = $paginatedData->offsetGet(0);

                return
                    $paginatedData->count() === 1 &&
                    $firstClinician->FirstName === 'John' &&
                    $firstClinician->LastName === 'Doe';
            })
            ->call('resetFilters')
            ->assertSet('clinicians', function ($paginatedData) {
                return $paginatedData->count() === 2;
            });
    }

    /** @test  */
    public function multiple_filters_are_addative()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian()->starResponder()->doNotContact(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian()->doNotContact(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'Jane', 'LastName' => 'Doe']);
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'Jill', 'LastName' => 'Doe']);
        $this->filters['starResponder'] = 1;
        $this->filters['doNotContact'] = 1;

        Livewire::test(Clinicians::class, ['filters' => $this->filters])
            ->assertViewIs('livewire.clinicians')
            ->assertSet('clinicians', function ($paginatedData) {
                $firstClinician = $paginatedData->offsetGet(0);

                return
                    $paginatedData->count() === 1 &&
                    $firstClinician->FirstName === 'John' &&
                    $firstClinician->LastName === 'Doe';
            });
    }


    // Sorting

    /** @test  */
    public function clinicians_can_be_sorted_by_name()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->count(2)
            ->state(new Sequence(
                ['FirstName' => 'Yak', 'LastName' => 'Zak'],
                ['FirstName' => 'Ann', 'LastName' => 'Bee'],
            ))
            ->create();
        $this->orderBy = 'name';

        Livewire::test(Clinicians::class, ['orderBy' => $this->orderBy])
            ->assertSeeInOrder([
                'Ann Bee',
                'Yak Zak',
            ]);
    }

    /** @test  */
    public function clinicians_can_be_sorted_by_last_contacted_date()
    {
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian()->state(['LastContacted' => '2020-01-01 23:59:59']), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);
        Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian()->state(['LastContacted' => '2020-12-31 23:59:59']), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create(['FirstName' => 'Jane', 'LastName' => 'Doe']);
        $this->orderBy = 'lastContacted';

        Livewire::test(Clinicians::class, ['orderBy' => $this->orderBy])
            ->assertSet('clinicians', function ($paginatedData) {
                $firstClinician = $paginatedData->offsetGet(0);
                $secondClinician = $paginatedData->offsetGet(1);

                return
                    $firstClinician->FirstName === 'Jane' &&
                    $firstClinician->LastName === 'Doe' &&

                    $secondClinician->FirstName === 'John' &&
                    $secondClinician->LastName === 'Doe';
            })
            ->assertSeeInOrder(['Jane Doe', 'John Doe']);
    }

    /** @test  */
    public function clicking_on_a_clinicians_summary_can_redirect_to_the_clinicians_details_page()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory()->participatingState())
            ->has(ProfessionalNote::factory()->nonAxxessian(), 'note')
            ->has(ProfessionalRole::factory(), 'roles')
            ->approvedStatus()
            ->create();

        Livewire::test(Clinicians::class)
            ->call('clinicianDetails', $clinician->Id)
            ->assertRedirect("clinicians/{$clinician->Id}");
    }
}
