<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\DataWarehouse\Job;
use Illuminate\Support\Facades\Http;
use App\Models\DataWarehouse\Identity;
use App\Models\DataWarehouse\Professional;
use App\Models\DataWarehouse\JobApplication;
use App\Models\DataWarehouse\ProfessionalNote;
use App\Models\DataWarehouse\ProfessionalRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Factories\Fakes\AxxessCareApiFactory;

class ClinicianShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user.
     *
     * @var  \App\Models\User
     */
    protected $user;

    /**
     * Run before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test  */
    public function a_clinician_can_be_shown()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory(), 'note')
            ->create([
                'FirstName' => 'John',
                'LastName' => 'Doe',
            ]);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe');
    }

    /** @test  */
    public function a_clinicians_details_can_be_shown()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory()->state([
                'AddressLine1' => '101 Main Street',
                'AddressLine2' => 'Flat 1a',
                'City' => 'Dallas',
                'StateCode' => 'TX',
                'ZipCode' => '75000',
                'phonenumber' => '5551231234',
            ]))
            ->has(ProfessionalNote::factory(), 'note')
            ->has(ProfessionalRole::factory()->rn(), 'roles')
            ->create([
                'FirstName' => 'John',
                'LastName' => 'Doe',
            ]);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertSeeText('RN')
            ->assertSeeText('101 Main Street')
            ->assertSeeText('Flat 1a')
            ->assertSeeText('Dallas')
            ->assertSeeText('TX')
            ->assertSeeText('75000')
            ->assertSeeText('555-123-1234');
    }

    /** @test  */
    public function technical_issues_are_indiciated()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory()->techIssue(), 'note')
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertViewHas('clinician', function ($clinician) {
                return $clinician->note->IsTechIssue == true;
            });
    }

    /** @test  */
    public function axxessians_are_indiciated()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory()->axxessian(), 'note')
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertViewHas('clinician', function ($clinician) {
                return $clinician->note->Axxessian == true;
            });
    }

    /** @test  */
    public function the_number_of_job_applications_can_be_shown()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory(), 'note')
            ->has(JobApplication::factory()->count(11), 'applications')
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertSeeText('11');
    }

    /** @test  */
    public function the_number_of_jobs_completed_can_be_shown()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory(), 'note')
            ->has(Job::factory()->count(22)->statusCompleted(), 'jobs')
            ->has(Job::factory()->count(5)->statusUncompleted(), 'jobs')
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertSeeText('22');
    }

    /** @test  */
    public function the_date_of_the_last_completed_job_can_be_shown()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory(), 'note')
            ->has(Job::factory()->count(22)->state(['Created' => '2020-01-31']), 'jobs')
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);
        foreach (range(1, 25) as $n) {
            $clinician->jobs()->save(
                Job::factory()->make(['Created' => Carbon::parse('2020-01-01')->addDays($n)->format('Y-m-d H:i:s')])
            );
        }
        $clinician->jobs()->save(
            Job::factory()->make(['Created' => '2020-12-31 00:00:00'])
        );

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertViewHas('lastJobCompleted', function ($lastJobCompleted) {
                return ($lastJobCompleted === 'December 31, 2020');
            });
    }

    /** @test  */
    public function the_date_of_the_first_completed_job_can_be_shown()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory(), 'note')
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);
        foreach (range(1, 25) as $n) {
            $clinician->jobs()->save(
                Job::factory()->make(['Created' => Carbon::parse('2020-12-31')->subDays($n)->format('Y-m-d H:i:s')])
            );
        }
        $clinician->jobs()->save(
            Job::factory()->make(['Created' => '2020-01-31 00:00:00'])
        );

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertViewHas('firstJobCompleted', function ($firstJobCompleted) {
                return ($firstJobCompleted === 'January 31, 2020');
            });
    }

    /** @test  */
    public function the_date_that_the_profile_was_started_can_be_shown()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory(), 'note')
            ->create(['FirstName' => 'John', 'LastName' => 'Doe', 'Created' => '2020-12-15']);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertSeeText('December 15, 2020');
    }

    /** @test  */
    public function the_date_that_the_clinician_was_last_contacted_can_be_shown()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory()->state(['LastContacted' => '2020-01-01 23:59:59']), 'note')
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertSeeText('January 01, 2020');
    }

    /** @test  */
    public function the_clinicians_paused_status_can_be_shown()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory()->state(['IsPaused' => 1]), 'note')
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertViewIs('clinicians.show')
            ->assertViewHasAll([
                'clinician.FirstName' => 'John',
                'clinician.LastName' => 'Doe',
                'clinician.note.IsPaused' => true,
            ]);
    }

    /** @test  */
    public function the_clinicians_do_not_contact_status_can_be_shown()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory()->state(['IsDnc' => 1]), 'note')
            ->create(['FirstName' => 'John', 'LastName' => 'Doe']);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertStatus(200)
            ->assertViewIs('clinicians.show')
            ->assertViewHasAll([
                'clinician.FirstName' => 'John',
                'clinician.LastName' => 'Doe',
                'clinician.note.IsDnc' => true,
            ]);
    }


    // Clinicians jobs

    /** @test  */
    public function a_message_is_shown_to_indicate_that_a_clinician_has_no_jobs()
    {
        $jobs = [];
        $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory(), 'note')
            ->create([
                'Id' => '00000000-0000-0000-000000000001',
                'FirstName' => 'John',
                'LastName' => 'Doe'
            ]);
        Http::fake(["*/clinicians/{$clinician->Id}/jobs" => Http::response($jobs, 200),]);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertSeeText('Displaying 0 jobs');
    }

    /** @test  */
    public function a_message_is_shown_to_indicate_that_a_clinician_has_some_jobs()
    {
       $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory(), 'note')
            ->create(['Id' => '00000000-0000-0000-000000000001', 'FirstName' => 'John', 'LastName' => 'Doe']);
        Http::fake(["*/clinicians/{$clinician->Id}/jobs" => Http::response($jobs = [
            AxxessCareApiFactory::jobs($id = 1),
            AxxessCareApiFactory::jobs($id = 2),
            AxxessCareApiFactory::jobs($id = 3),
        ], 200)]);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");
        
        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertSeeText('Displaying 3 jobs');
    }

    /** @test  */
    public function a_clinicians_job_card_details_can_be_shown()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory(), 'note')
            ->create(['Id' => '00000000-0000-0000-000000000001', 'FirstName' => 'John', 'LastName' => 'Doe']);
        Http::fake(["*/clinicians/{$clinician->Id}/jobs" => Http::response($jobs = [
            AxxessCareApiFactory::jobs($id = 1, [
                'JobAddress' => '101 Main Street, Dallas, TX 75080',
                'Discipline Task' => 'Skilled Nurse Visit',
                'Speciality' => 'Assessment and Training',
                'jobstatus' => 'Posted',
                'applicantcount' => '1',
                'Visit Date' => '12-31-2020',
                'Distance from Clinician' => '1.23',
                'PostingAgency' => 'Acme Home Health Care',
            ]),
        ], 200)]);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertSeeText('101 Main Street, Dallas, TX 75080')
            ->assertSeeText('Skilled Nurse Visit')
            ->assertSeeText('Assessment and Training')
            ->assertSeeText('Status: Posted')
            ->assertSeeText('Applicants: 1')
            ->assertSeeText('Dec 31, 2020')
            ->assertSeeText('1.23 miles')
            ->assertSeeText('Acme Home Health Care');
    }

    /** @test  */
    public function a_clinicians_job_card_rates_for_nursing_visits_can_be_shown()
    {
        $clinician = Professional::factory()
        ->has(Identity::factory())
        ->has(ProfessionalNote::factory(), 'note')
        ->create(['Id' => '00000000-0000-0000-000000000001', 'FirstName' => 'John', 'LastName' => 'Doe']);
        Http::fake(["*/clinicians/{$clinician->Id}/jobs" => Http::response($jobs = [
            AxxessCareApiFactory::jobs($id = 1, [
                'Discipline' => 'Nursing',
                'Discipline Task' => 'Skilled Nurse Visit',
                'Visit Rate RN' => '11',
                'Visit Rate LVN' => '22',
                'Custom Rate RN' => '33',
                'Custom Rate LVN' => '44',
                'VisitRatePT' => '99',
                'VisitRatePTA' => '99',
                'CustomRatePT' => '99',
                'CustomRatePTA' => '99',
            ]),
        ], 200)]);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertSeeText('Skilled Nurse Visit')
            ->assertSeeText('$11')
            ->assertSeeText('$22')
            ->assertSeeText('$33')
            ->assertSeeText('$44')
            ->assertDontSeeText('$99');
    }

    /** @test  */
    public function a_clinicians_job_card_rates_for_pt_visits_can_be_shown()
    {
        $clinician = Professional::factory()
            ->has(Identity::factory())
            ->has(ProfessionalNote::factory(), 'note')
            ->create(['Id' => '00000000-0000-0000-000000000001', 'FirstName' => 'John', 'LastName' => 'Doe']);
        Http::fake(["*/clinicians/{$clinician->Id}/jobs" => Http::response($jobs = [
            AxxessCareApiFactory::jobs($id = 1, [
                'Discipline' => 'PT',
                'Discipline Task' => 'Skilled Nurse Visit',
                'Visit Rate RN' => '99',
                'Visit Rate LVN' => '99',
                'Custom Rate RN' => '99',
                'Custom Rate LVN' => '99',
                'VisitRatePT' => '11',
                'VisitRatePTA' => '22',
                'CustomRatePT' => '33',
                'CustomRatePTA' => '44',
            ]),
        ], 200)]);

        $response = $this->actingAs($this->user)->get("/clinicians/{$clinician->Id}");

        $response
            ->assertSuccessful()
            ->assertSeeText('John Doe')
            ->assertSeeText('Skilled Nurse Visit')
            ->assertSeeText('$11')
            ->assertSeeText('$22')
            ->assertSeeText('$33')
            ->assertSeeText('$44')
            ->assertDontSeeText('$99');
    }
}
