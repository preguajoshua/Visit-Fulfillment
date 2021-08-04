<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\DataWarehouse\Job;
use App\Models\DataWarehouse\Facility;
use App\Models\DataWarehouse\PayRate;
use App\Models\DataWarehouse\JobApplication;
use App\Models\DataWarehouse\CustomJobRate;
use App\Models\DataWarehouse\AgencyLocation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgencyShowTest extends TestCase
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
    public function the_basic_details_of_agency_can_be_displayed()
    {
        $Id = '00000000-0000-0000-0000-000000000001';
        $facility = Facility::factory()
            ->has(AgencyLocation::factory([
                'AgencyId' => $Id,
                'Name' => 'Acme Home Health',
                'AddressLine1' => 'FM-45',
                'AddressLine2' => 'Richland Springs',
                'AddressCity' =>  'TX',
                'AddressStateCode' => '76871',
                'AddressZipCode' => '',
                'AddressZipCodeFour' => '89889-6930',
                'PhoneWork' => '661-425-7788',
            ]), 'location')
            ->has(Job::factory([
                'FacilityId' => $Id,
                'Created' => '11-11-2020',
            ]))
            ->has(Job::factory([
                'FacilityId' => $Id,
                'Created' => '11-12-2020',
            ]))
            ->create(['Id' => $Id, 'Name' => 'Acme Home Health']);

        $response = $this->actingAs($this->user)->get("/agency/{$Id}");
        
        $response
            ->assertSuccessful()
            //Job Completed
            ->assertViewHas('agency', function ($agency) {
                return ($agency->jobs->count() === 2);
            })
            //First Job Completed
            ->assertViewHas('agency', function($agency){
                return $agency->jobs()->oldest('Created')->first()->Created === 'November 11, 2020';
            })
            //Last Job Completed
            ->assertViewHas('agency', function($agency){
                return $agency->jobs()->latest('Created')->first()->Created === 'December 11, 2020';
            })
            ->assertSeeText('661-425-7788')
            ->assertSeeText('FM-45 Richland Springs TX 76871');
    }


    // Clinicians jobs

    /** @test  */
    public function a_message_shows_no_related_jobs_for_this_agency()
    {
        $Id = '00000000-0000-0000-0000-000000000001';
        $facility = Facility::factory()
            ->has(AgencyLocation::factory([
                'AgencyId' => $Id,
                'Name' => 'Acme Home Health',
                'AddressLine1' => 'FM-45',
                'AddressLine2' => 'Richland Springs',
                'AddressCity' =>  'TX',
                'AddressStateCode' => '76871',
                'AddressZipCode' => '',
                'AddressZipCodeFour' => '89889-6930',
                'PhoneWork' => '661-425-7788',
            ]), 'location')
            ->create(['Id' => $Id, 'Name' => 'Acme Home Health']);

        $response = $this->actingAs($this->user)->get("/agency/{$Id}");
        
        $response
            ->assertSuccessful()
            ->assertSeeText('Acme Home Health')
            ->assertSeeText('Found 0 related jobs');
    }

    /** @test  */
    public function displays_number_of_related_jobs_for_this_agency()
    {
        $Id = '00000000-0000-0000-0000-000000000001';
        $facility = Facility::factory()
            ->has(Job::factory([
                'Status' => 9,
            ])->count(10))
            ->create(['Id' => $Id, 'Name' => 'Acme Home Health']);

        $response = $this->actingAs($this->user)->get("/agency/{$facility->Id}");
        
        $response
            ->assertSuccessful()
            ->assertSeeText('Acme Home Health')
            ->assertSeeText('Found 10 related jobs');
    }


    /** @test  */
    public function displays_all_detials_in_jobs_detail()
    {
        $facilityId = '00000000-0000-0000-0000-000000000001';
        $facility = Facility::factory()
            ->has(
                Job::factory([
                    'DisciplineTask' => 'Skilled Nurse Visit',
                    'Specialty' => 'Bladder Instillation (Flushing)',
                    'VisitDate' => '2019-02-13 00:00:00',
                    'Address1' => '2008 SLEEPYHOLLOW RD',
                    'City' => 'SLEEPY HOLLOW',
                    'State' => 'IL',
                    'Zipcode' => '60118',
                    'Status' => 9,
                ])->count(1)
                ->has(JobApplication::factory()->count(5), 'applications')
                ->has(CustomJobRate::factory([
                    'Role' => 0,
                    'Rate' => 11,
                ]), 'customjobrates')
                ->has(CustomJobRate::factory([
                    'Role' => 1,
                    'Rate' => 22,
                ]), 'customjobrates')
            )
            ->has(PayRate::factory()->state([
                'RnCost' => 33,
                'LvnLpnCost' => 44,
            ]), 'payrates')
            ->create(['Name' => 'Acme Home Health']);
        
        $response = $this->actingAs($this->user)->get("/agency/{$facility->Id}");

        $response
            ->assertSuccessful()
            ->assertViewHas('jobs', function($jobs){
                return 
                    $jobs->count() === 1 && //count the total related jobs
                    $jobs[0]->applicantCount === 5 && //count the all applicants in visits
                    $jobs[0]->visitRateRn === 33.0 &&  //displays the RN visit pay rate
                    $jobs[0]->visitRateLvn === 44.0 && //displays the LVN visit pay rate
                    $jobs[0]->customRateRn === 11.0 && //displays the Custom RN visit pay rate
                    $jobs[0]->customRateLvn === 22.0 && //displays the Custom LVN visit pay rate
                    $jobs[0]->jobStatus === "Returned"; // Displays job status description
            })
            ->assertSeeText('2008 SLEEPYHOLLOW RD, SLEEPY HOLLOW, IL, 60118')
            ->assertSeeText('Acme Home Health');
    }
}
