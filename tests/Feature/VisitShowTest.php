<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\DataWarehouse\VisitNote;
use App\Models\DataWarehouse\Professional;
use App\Models\DataWarehouse\ProfessionalNote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Factories\Fakes\AxxessCareApiFactory;

class VisitShowTest extends TestCase
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

        // For AxxessCareApiController::randomClinicians()
        Professional::factory()->count(100)->create();
    }

    /** @test  */
    public function the_details_of_single_visits_can_be_displayed_by_id()
    {
        $visit1 = AxxessCareApiFactory::visit(['AgencyName' => 'Acme One Home Health Care']);
        $visit2 = AxxessCareApiFactory::visit(['AgencyName' => 'Acme Two Home Health Care']);
        $visit4 = AxxessCareApiFactory::visit(['AgencyName' => 'Acme Four Home Health Care']);
        Http::fake([
            '*/visits/00000000-0000-0000-0000-000000000001' => Http::response($visit1, 200),
            '*/visits/00000000-0000-0000-0000-000000000002' => Http::response($visit2, 200),
            '*/visits/00000000-0000-0000-0000-000000000004' => Http::response($visit4, 200),
            '*' => Http::response([], 200),
        ]);

        $response1 = $this->actingAs($this->user)->get('/visits/00000000-0000-0000-0000-000000000001');
        $response2 = $this->actingAs($this->user)->get('/visits/00000000-0000-0000-0000-000000000002');
        $response4 = $this->actingAs($this->user)->get('/visits/00000000-0000-0000-0000-000000000004');

        $response1->assertStatus(200)->assertSeeText('Acme One Home Health Care');
        $response2->assertStatus(200)->assertSeeText('Acme Two Home Health Care');
        $response4->assertStatus(200)->assertSeeText('Acme Four Home Health Care');
    }

    /** @test  */
    public function the_basic_details_of_a_visit_can_be_displayed()
    {
        $visit = AxxessCareApiFactory::visit([
            'jobcomments' => 'These are the special instructions.',
            'jobdescription' => 'These are the visit details.',
            'jobtype' => 'External',
            'JobAddress' => '101 Main Street, Dallas, TX 75080',
            'DisciplineTask' => 'Skilled Nurse Visit',
            'Specialty' => 'Assessment and Training',
            'AgencyName' => 'Acme Home Health Care',
            'VisitDate' => '12-31-2020',
        ]);
        Http::fake([
            '*/visits/00000000-0000-0000-0000-000000000001' => Http::response($visit, 200),
            '*' => Http::response([], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/visits/00000000-0000-0000-0000-000000000001');

        $response
            ->assertStatus(200)
            ->assertSeeText('These are the special instructions.')
            ->assertSeeText('These are the visit details.')
            ->assertSeeText('External Job')
            ->assertSeeText('101 Main Street, Dallas, TX 75080')
            ->assertSeeText('Skilled Nurse Visit')
            ->assertSeeText('Assessment and Training')
            ->assertSeeText('Acme Home Health Care')
            ->assertViewHas('visit', function($visit){
                return $visit->visitDate == Carbon::createFromFormat('m-d-Y', '12-31-2020');
            });
    }


    // Rates

    /** @test  */
    public function the_details_of_nursing_visit_rates_can_be_displayed()
    {
        $visit = AxxessCareApiFactory::visit([
            'Discipline' => 'Nursing',
            'DisciplineTask' => 'Skilled Nurse Visit',
            'VisitRateRN' => '11',
            'VisitRateLVN' => '22',
            'CustomRateRN' => '33',
            'CustomRateLVN' => '44',
            'VisitRatePT' => '99',
            'VisitRatePTA' => '99',
            'CustomRatePT' => '99',
            'CustomRatePTA' => '99',
            'OasisRnCost' => '99',
            'OasisPtCost' => '99',
            'CustomRateOASISRN' => '99',
            'CustomRateOASISPT' => '99',
        ]);
        Http::fake([
            '*/visits/00000000-0000-0000-0000-000000000001' => Http::response($visit, 200),
            '*' => Http::response([], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/visits/00000000-0000-0000-0000-000000000001');

        $response
            ->assertStatus(200)
            ->assertSeeText('Skilled Nurse Visit')
            ->assertSeeText('11')
            ->assertSeeText('22')
            ->assertSeeText('33')
            ->assertSeeText('44')
            ->assertDontSeeText('99');
    }

    /** @test  */
    public function the_details_of_pt_visit_rates_can_be_displayed()
    {
        $visit = AxxessCareApiFactory::visit([
            'Discipline' => 'PT',
            'DisciplineTask' => 'Skilled Nurse Visit',
            'VisitRateRN' => '99',
            'VisitRateLVN' => '99',
            'CustomRateRN' => '99',
            'CustomRateLVN' => '99',
            'VisitRatePT' => '11',
            'VisitRatePTA' => '22',
            'CustomRatePT' => '33',
            'CustomRatePTA' => '44',
            'OasisRnCost' => '99',
            'OasisPtCost' => '99',
            'CustomRateOASISRN' => '99',
            'CustomRateOASISPT' => '99',
        ]);
        Http::fake([
            '*/visits/00000000-0000-0000-0000-000000000001' => Http::response($visit, 200),
            '*' => Http::response([], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/visits/00000000-0000-0000-0000-000000000001');

        $response
            ->assertStatus(200)
            ->assertSeeText('Skilled Nurse Visit')
            ->assertSeeText('11')
            ->assertSeeText('22')
            ->assertSeeText('33')
            ->assertSeeText('44')
            ->assertDontSeeText('99');
    }

    /** @test  */
    public function the_details_of_nursing_oasis_visit_rates_can_be_displayed()
    {
        VisitNote::factory()
            ->create(['JobID' => '00000000-0000-0000-0000-000000000001']);
        ProfessionalNote::factory()
            ->create(['ProfessionalID' => '00000000-0000-0000-0000-000000000010']);
        $visit = AxxessCareApiFactory::visit([
            'Discipline' => 'Nursing',
            'DisciplineTask' => 'OASIS-D Transfer',
            'VisitRateRN' => '99',
            'VisitRateLVN' => '99',
            'CustomRateRN' => '99',
            'CustomRateLVN' => '99',
            'VisitRatePT' => '99',
            'VisitRatePTA' => '99',
            'CustomRatePT' => '99',
            'CustomRatePTA' => '99',
            'OasisRnCost' => '11',
            'OasisPtCost' => '99',
            'CustomRateOASISRN' => '22',
            'CustomRateOASISPT' => '99',
        ]);
        Http::fake([
            '*/visits/00000000-0000-0000-0000-000000000001' => Http::response($visit, 200),
            '*' => Http::response([], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/visits/00000000-0000-0000-0000-000000000001');

        $response
            ->assertStatus(200)
            ->assertSeeText('OASIS-D Transfer')
            ->assertSeeText('11')
            ->assertSeeText('22')
            ->assertDontSeeText('99');
    }

    /** @test  */
    public function the_details_of_pt_oasis_visit_rates_can_be_displayed()
    {
        VisitNote::factory()
            ->create(['JobID' => '00000000-0000-0000-0000-000000000001']);
        ProfessionalNote::factory()
            ->create(['ProfessionalID' => '00000000-0000-0000-0000-000000000010']);
        $visit = AxxessCareApiFactory::visit([
            'Discipline' => 'PT',
            'DisciplineTask' => 'OASIS-D Transfer',
            'VisitRateRN' => '99',
            'VisitRateLVN' => '99',
            'CustomRateRN' => '99',
            'CustomRateLVN' => '99',
            'VisitRatePT' => '99',
            'VisitRatePTA' => '99',
            'CustomRatePT' => '99',
            'CustomRatePTA' => '99',
            'OasisRnCost' => '99',
            'OasisPtCost' => '11',
            'CustomRateOASISRN' => '99',
            'CustomRateOASISPT' => '22',
        ]);
        Http::fake([
            '*/visits/00000000-0000-0000-0000-000000000001' => Http::response($visit, 200),
            '*' => Http::response([], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/visits/00000000-0000-0000-0000-000000000001');

        $response
            ->assertStatus(200)
            ->assertSeeText('OASIS-D Transfer')
            ->assertSeeText('11')
            ->assertSeeText('22')
            ->assertDontSeeText('99');
    }


    // Job clinicians

    /** @test  */
    public function the_visits_clinicians_are_shown()
    {
        Professional::factory()->create(['Id' => '00000000-0000-0000-0000-000000000001']);
        Http::fake([
            '*/visits/00000000-0000-0000-0000-000000000001' => Http::response(
                AxxessCareApiFactory::visit(['AgencyName' => 'Acme Home Health Care']), 200
            ),
            '*/visits/00000000-0000-0000-0000-000000000001/clinicians' => Http::response($clinicians = [
                AxxessCareApiFactory::clinicians(1, ['ClinicianName' => 'John Doe']),
                AxxessCareApiFactory::clinicians(1, ['ClinicianName' => 'Jane Doe']),
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/visits/00000000-0000-0000-0000-000000000001');

        $response
            ->assertStatus(200)
            ->assertSeeText('Acme Home Health Care')
            ->assertSeeText('John Doe')
            ->assertSeeText('Jane Doe');
    }

    /** @test  */
    public function the_visits_clinicians_full_details_are_shown()
    {
        Professional::factory()
            ->has(ProfessionalNote::factory()->state([
                'LastContacted' => now()->subMonths(3)->format('Y-m-d'),
                'isStarResponder' => false,
                'isTechIssue' => false,
            ]), 'note')
            ->create(['Id' => '00000000-0000-0000-0000-000000000001']);
        $clinicians = [
            AxxessCareApiFactory::clinicians(1, [
                'ClinicianName' => 'John Doe',
                'Clinician Phone#' => '555-123-1234',
                'Role' => 'RN',
                'AppliedJobsCount' => 10,
                'CompletedJobsCount' => 20,
                'DistancefromClinician' => 1.23,
            ]),
        ];
        Http::fake([
            '*/visits/00000000-0000-0000-0000-000000000001' => Http::response(AxxessCareApiFactory::visit(['AgencyName' => 'Acme Home Health Care']), 200),
            '*/visits/00000000-0000-0000-0000-000000000001/clinicians' => Http::response($clinicians, 200),
        ]);

        $response = $this->actingAs($this->user)->get('/visits/00000000-0000-0000-0000-000000000001');

        $response
            ->assertStatus(200)
            ->assertSeeText('Acme Home Health Care')
            ->assertSeeText('John Doe')
            ->assertSeeText('555-123-1234')
            ->assertSeeText('RN')
            ->assertSeeText('10')
            ->assertSeeText('20')
            ->assertSeeText('1.23')
            ->assertSeeText('3 months ago')
            ->assertViewHas('clinicians', function ($clinicians) {
                $firstClinician = $clinicians[0];

                return $firstClinician->note->starResponder == false && $firstClinician->note->technicalIssue == false;
            });
    }

    /** @test  */
    public function when_set_the_star_responder_icon_is_shown()
    {
        Professional::factory()
            ->has(ProfessionalNote::factory()->state(['isStarResponder' => true]), 'note')
            ->create(['Id' => '00000000-0000-0000-0000-000000000001']);
        Http::fake([
            '*/visits/00000000-0000-0000-0000-000000000001' => Http::response(
                AxxessCareApiFactory::visit(['AgencyName' => 'Acme Home Health Care']), 200
            ),
            '*/visits/00000000-0000-0000-0000-000000000001/clinicians' => Http::response($clinicians = [
                AxxessCareApiFactory::clinicians(1, ['ClinicianName' => 'John Doe']),
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/visits/00000000-0000-0000-0000-000000000001');

        $response
            ->assertStatus(200)
            ->assertSeeText('Acme Home Health Care')
            ->assertSeeText('John Doe')
            ->assertViewHas('clinicians', function ($clinicians) {
                $firstClinician = $clinicians[0];

                return $firstClinician->note->isStarResponder == true;
            });
    }

    /** @test  */
    public function when_set_the_technical_issue_icon_is_shown()
    {
        Professional::factory()
            ->has(ProfessionalNote::factory()->state(['isTechIssue' => true]), 'note')
            ->create(['Id' => '00000000-0000-0000-0000-000000000001']);
        Http::fake([
            '*/visits/00000000-0000-0000-0000-000000000001' => Http::response(
                AxxessCareApiFactory::visit(['AgencyName' => 'Acme Home Health Care']), 200
            ),
            '*/visits/00000000-0000-0000-0000-000000000001/clinicians' => Http::response($clinicians = [
                AxxessCareApiFactory::clinicians(1, ['ClinicianName' => 'John Doe']),
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/visits/00000000-0000-0000-0000-000000000001');

        $response
            ->assertStatus(200)
            ->assertSeeText('Acme Home Health Care')
            ->assertSeeText('John Doe')
            ->assertViewHas('clinicians', function ($clinicians) {
                $firstClinician = $clinicians[0];

                return $firstClinician->note->IsTechIssue == true;
            });
    }

    /** @test  */
    public function the_client_can_be_set_to_paused()
    {
        Professional::factory()
            ->has(ProfessionalNote::factory()->state(['IsPaused' => true]), 'note')
            ->create(['Id' => '00000000-0000-0000-0000-000000000001']);
        Http::fake([
            '*/visits/00000000-0000-0000-0000-000000000001' => Http::response(
                AxxessCareApiFactory::visit(['AgencyName' => 'Acme Home Health Care']), 200
            ),
            '*/visits/00000000-0000-0000-0000-000000000001/clinicians' => Http::response($clinicians = [
                AxxessCareApiFactory::clinicians(1, ['ClinicianName' => 'John Doe']),
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/visits/00000000-0000-0000-0000-000000000001');

        $response
            ->assertStatus(200)
            ->assertSeeText('Acme Home Health Care')
            ->assertSeeText('John Doe')
            ->assertViewHas('clinicians', function ($clinicians) {
                $firstClinician = $clinicians[0];

                return $firstClinician->note->IsPaused == true;
            });
    }

    /** @test  */
    public function the_client_can_be_set_to_do_not_contact()
    {
        Professional::factory()
            ->has(ProfessionalNote::factory()->state(['IsDnc' => true]), 'note')
            ->create(['Id' => '00000000-0000-0000-0000-000000000001']);
        Http::fake([
            '*/visits/00000000-0000-0000-0000-000000000001' => Http::response(
                AxxessCareApiFactory::visit(['AgencyName' => 'Acme Home Health Care']), 200
            ),
            '*/visits/00000000-0000-0000-0000-000000000001/clinicians' => Http::response($clinicians = [
                AxxessCareApiFactory::clinicians(1, ['ClinicianName' => 'John Doe']),
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/visits/00000000-0000-0000-0000-000000000001');

        $response
            ->assertStatus(200)
            ->assertSeeText('Acme Home Health Care')
            ->assertSeeText('John Doe')
            ->assertViewHas('clinicians', function ($clinicians) {
                $firstClinician = $clinicians[0];

                return $firstClinician->note->IsDnc == true;
            });
    }
}
