<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Support\Str;
use App\Http\Livewire\Visits;
use Illuminate\Support\Carbon;
use App\View\Components\VisitCard;
use Illuminate\Support\Facades\Http;
use App\Services\AxxessCareApiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Factories\Fakes\AxxessCareApiFactory;

class VisitIndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user.
     *
     * @var  \App\Models\User
     */
    protected $user;

    /**
     * The default visits filters.
     *
     * @var  array
     */
    protected $filters;

    /**
     * Run before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->filters = [
            'jobType' => null,
            'discipline' => null,
            'radius' => 20,
            'dateRange' => null,
            'orderBy' => 'Visit Date',
            'page' => 1,
        ];
    }

    /** @test  */
    public function the_visits_page_correctly_displays_when_passed_no_visits()
    {
        $visits = [];
        Http::fake(['*' => Http::response(['items' => $visits, 'total' => 0], 200)]);

        $response = $this->actingAs($this->user)->get('/visits');

        $response
            ->assertStatus(200)
            ->assertSeeText('Displaying 0 visits');
    }

    /** @test  */
    public function the_visits_page_shows_the_correct_number_of_visits()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1),
            AxxessCareApiFactory::visits($id = 2),
            AxxessCareApiFactory::visits($id = 3),
        ];
        Http::fake(['*' => Http::response(['items' => $visits, 'total' => 3] , 200)]);

        $response = $this->actingAs($this->user)->get('/visits');

        $response
            ->assertStatus(200)
            ->assertSeeText('Displaying 3 visits');
    }

    /** @test  */
    public function the_visit_card_details_can_be_seen()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'jobtype' => 'External',
                'Discipline' => 'Nursing',
                'Discipline Task' => 'Skilled Nurse Visit',
                'Speciality' => 'Assessment and Training',
                'Posting Agency' => 'Acme Home Health Care',
                'JobAddress' => '101 Main Street, Dallas, TX 75080',
                'DistancefromClinician' => '1.23',
                'Visit Date' => '12-31-2020',
                'PostingDate' => now()->subMonths(3)->format('m-d-Y'),
            ]),
        ];
        Http::fake(['*' => Http::response(['items' => $visits, 'total' => 1], 200)]);

        $response = $this->actingAs($this->user)->get('/visits');

        $response
            ->assertStatus(200)
            ->assertSeeText('External Job')
            ->assertSeeText('Nursing')
            ->assertSeeText('Skilled Nurse Visit - Assessment and Training')
            ->assertSeeText('Acme Home Health Care')
            ->assertSeeText('101 Main Street, Dallas, TX 75080')
            ->assertSeeText('1.23 miles from clinician')
            ->assertSeeText('Dec 31, 2020')
            ->assertSeeText('Posted 3 months ago');
    }


    // Rates

    /** @test  */
    public function the_rates_for_nursing_visits_can_be_displayed()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
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
                'CustomRateOASISRN' => '99',
                'CustomRateOASISPT' => '99',
                'OasisRnCost' => '99',
                'OasisPtCost' => '99',
            ]),
        ];
        Http::fake(['*' => Http::response(['items' => $visits, 'total' => 1], 200)]);

        $response = $this->actingAs($this->user)->get('/visits');

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
    public function the_rates_for_pt_visits_can_be_displayed()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'Discipline' => 'PT',
                'Discipline Task' => 'PTA Visit',
                'VisitRatePT' => '11',
                'VisitRatePTA' => '22',
                'CustomRatePT' => '33',
                'CustomRatePTA' => '44',
                'Visit Rate RN' => '99',
                'Visit Rate LVN' => '99',
                'Custom Rate RN' => '99',
                'Custom Rate LVN' => '99',
                'CustomRateOASISRN' => '99',
                'CustomRateOASISPT' => '99',
                'OasisRnCost' => '99',
                'OasisPtCost' => '99',
            ]),
        ];
        Http::fake(['*' => Http::response(['items' => $visits, 'total' => 1], 200)]);

        $response = $this->actingAs($this->user)->get('/visits');

        $response
            ->assertStatus(200)
            ->assertSee('PTA Visit')
            ->assertSeeText('11')
            ->assertSeeText('22')
            ->assertSeeText('33')
            ->assertSeeText('44')
            ->assertDontSeeText('99');
    }

    /** @test  */
    public function the_rates_for_nursing_oasis_visits_can_be_displayed()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'Discipline' => 'Nursing',
                'Discipline Task' => 'OASIS Discharge',
                'OasisRnCost' => '11',
                'CustomRateOASISRN' => '22',
                'VisitRatePT' => '99',
                'VisitRatePTA' => '99',
                'CustomRatePT' => '99',
                'CustomRatePTA' => '99',
                'Visit Rate RN' => '99',
                'Visit Rate LVN' => '99',
                'Custom Rate RN' => '99',
                'Custom Rate LVN' => '99',
                'CustomRateOASISPT' => '99',
                'OasisPtCost' => '99',
            ]),
        ];
        Http::fake(['*' => Http::response(['items' => $visits, 'total' => 1], 200)]);

        $response = $this->actingAs($this->user)->get('/visits');

        $response
            ->assertStatus(200)
            ->assertSeeText('OASIS Discharge')
            ->assertSeeText('11')
            ->assertSeeText('22')
            ->assertDontSeeText('99');
    }

    /** @test  */
    public function the_rates_for_pt_oasis_visits_can_be_displayed()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'Discipline' => 'PT',
                'Discipline Task' => 'Non-OASIS Discharge',
                'OasisPtCost' => '11',
                'CustomRateOASISPT' => '22',
                'VisitRatePT' => '99',
                'VisitRatePTA' => '99',
                'CustomRatePT' => '99',
                'CustomRatePTA' => '99',
                'Visit Rate RN' => '99',
                'Visit Rate LVN' => '99',
                'Custom Rate RN' => '99',
                'Custom Rate LVN' => '99',
                'CustomRateOASISRN' => '99',
                'OasisRnCost' => '99',
            ]),
        ];
        Http::fake(['*' => Http::response(['items' => $visits, 'total' => 1], 200)]);

        $response = $this->actingAs($this->user)->get('/visits');

        $response
            ->assertStatus(200)
            ->assertSeeText('Non-OASIS Discharge')
            ->assertSeeText('11')
            ->assertSeeText('22')
            ->assertDontSeeText('99');
    }

    /** @test  */
    public function the_rates_for_non_nursing_and_non_pt_visits_can_not_be_displayed()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'Discipline' => 'ST',
                'Discipline Task' => 'Skilled Nurse Visit',
                'VisitRatePT' => '99',
                'VisitRatePTA' => '99',
                'CustomRatePT' => '99',
                'CustomRatePTA' => '99',
                'Visit Rate RN' => '99',
                'Visit Rate LVN' => '99',
                'Custom Rate RN' => '99',
                'Custom Rate LVN' => '99',
                'CustomRateOASISRN' => '99',
                'CustomRateOASISPT' => '99',
                'OasisRnCost' => '99',
                'OasisPtCost' => '99',
            ]),
        ];
        Http::fake(['*' => Http::response(['items' => $visits, 'total' => 1], 200)]);

        $response = $this->actingAs($this->user)->get('/visits');

        $response
            ->assertStatus(200)
            ->assertSeeText('Skilled Nurse Visit')
            ->assertDontSeeText('99');
    }


    // Filtering

    /** @test  */
    public function the_visit_page_contains_the_visits_livewire_component()
    {
        $this->actingAs($this->user)->get('/visits')
            ->assertStatus(200)
            ->assertSeeLivewire('visits');
    }

    /** @test  */
    public function visit_cards_are_rendered_in_yellow_when_the_professional_count_is_low()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'Posting Agency' => 'Acme Home Health Care',
                'pcount' => VisitCard::LOW_PROFESSIONAL_THRESHOLD - 1,
            ]),
        ];
        Http::fake(['*' => Http::response(['items' => $visits, 'total' => 1], 200)]);

        $response = $this->actingAs($this->user)->get('/visits');

        Livewire::test(Visits::class)
            ->assertSee('Acme Home Health Care')
            ->assertViewHas('visits', function ($visits) {
                $visitCardComponent = new VisitCard($visits->first());

                return
                    Str::contains($visitCardComponent->bgColor(), 'yellow') &&
                    Str::contains($visitCardComponent->ratesBgColor(), 'yellow');
            });
    }

    /** @test  */
    public function visit_cards_are_not_rendered_in_yellow_when_the_professional_count_is_not_low()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'Posting Agency' => 'Acme Home Health Care',
                'pcount' => VisitCard::LOW_PROFESSIONAL_THRESHOLD + 1,
            ]),
        ];
        Http::fake(['*' => Http::response(['items' => $visits, 'total' => 1], 200)]);

        $response = $this->actingAs($this->user)->get('/visits');

        Livewire::test(Visits::class)
            ->assertSee('Acme Home Health Care')
            ->assertViewHas('visits', function ($visits) {
                $visitCardComponent = new VisitCard($visits->first());

                return
                    ! Str::contains($visitCardComponent->bgColor(), 'yellow') &&
                    ! Str::contains($visitCardComponent->ratesBgColor(), 'yellow');
            });
    }


    // Filter: Job type

    /** @test  */
    public function the_visit_cards_can_be_filtered_down_to_internal_jobs()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'jobtype' => 'Internal',
                'Posting Agency' => 'Acme Home Health Care One',
            ]),
            AxxessCareApiFactory::visits($id = 2, [
                'jobtype' => 'Internal',
                'Posting Agency' => 'Acme Home Health Care Two',
            ]),
            AxxessCareApiFactory::visits($id = 3, [
                'jobtype' => 'External',
                'Posting Agency' => 'Acme Home Health Care Three',
            ]),
            AxxessCareApiFactory::visits($id = 4, [
                'jobtype' => 'External',
                'Posting Agency' => 'Acme Home Health Care Four',
            ]),
        ];
        Http::fake(function ($request) use ($visits) {
            $filteredVisits = collect($visits)
                ->when($request->data()['jobType'], function ($collection, $jobtype) {
                    return $collection->where('jobtype', $jobtype);
                });
            return Http::response(['items' => $filteredVisits, 'total' => 4], 200);
        });
        $this->filters['jobType'] = 'Internal';

        Livewire::test(Visits::class, ['filters' => $this->filters])
            ->assertSeeText('Acme Home Health Care One')
            ->assertSeeText('Acme Home Health Care Two')
            ->assertDontSeeText('Acme Home Health Care Three')
            ->assertDontSeeText('Acme Home Health Care Four');
    }

    /** @test  */
    public function the_visit_cards_can_be_filtered_down_to_external_jobs()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'jobtype' => 'Internal',
                'Posting Agency' => 'Acme Home Health Care One',
            ]),
            AxxessCareApiFactory::visits($id = 2, [
                'jobtype' => 'Internal',
                'Posting Agency' => 'Acme Home Health Care Two',
            ]),
            AxxessCareApiFactory::visits($id = 3, [
                'jobtype' => 'External',
                'Posting Agency' => 'Acme Home Health Care Three',
            ]),
            AxxessCareApiFactory::visits($id = 4, [
                'jobtype' => 'External',
                'Posting Agency' => 'Acme Home Health Care Four',
            ]),
        ];
        Http::fake(function ($request) use ($visits) {
            $filteredVisits = collect($visits)
                ->when($request->data()['jobType'], function ($collection, $jobtype) {
                    return $collection->where('jobtype', $jobtype);
                });
            return Http::response(['items' => $filteredVisits, 'total' => 4], 200);
        });
        $this->filters['jobType'] = 'External';

        Livewire::test(Visits::class, ['filters' => $this->filters])
            ->assertDontSeeText('Acme Home Health Care One')
            ->assertDontSeeText('Acme Home Health Care Two')
            ->assertSeeText('Acme Home Health Care Three')
            ->assertSeeText('Acme Home Health Care Four');
    }

    /** @test  */
    public function when_no_job_type_filtering_is_applied_all_job_types_are_shown()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'jobtype' => 'Internal',
                'Posting Agency' => 'Acme Home Health Care One',
            ]),
            AxxessCareApiFactory::visits($id = 2, [
                'jobtype' => 'Internal',
                'Posting Agency' => 'Acme Home Health Care Two',
            ]),
            AxxessCareApiFactory::visits($id = 3, [
                'jobtype' => 'External',
                'Posting Agency' => 'Acme Home Health Care Three',
            ]),
            AxxessCareApiFactory::visits($id = 4, [
                'jobtype' => 'External',
                'Posting Agency' => 'Acme Home Health Care Four',
            ]),
        ];
        Http::fake(function ($request) use ($visits) {
            $filteredVisits = collect($visits)
                ->when($request->data()['jobType'], function ($collection, $jobtype) {
                    return $collection->where('jobtype', $jobtype);
                });
            return Http::response(['items' => $filteredVisits, 'total' => 4], 200);
        });
        $this->filters['jobType'] = null;

        Livewire::test(Visits::class, ['filters' => $this->filters])
            ->assertSeeText('Acme Home Health Care One')
            ->assertSeeText('Acme Home Health Care Two')
            ->assertSeeText('Acme Home Health Care Three')
            ->assertSeeText('Acme Home Health Care Four');
    }


    // Filter: Discipline

    /** @test  */
    public function the_visit_cards_can_be_filtered_down_to_the_nursing_discipline()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'Discipline' => 'Nursing',
                'Posting Agency' => 'Acme Home Health Care One',
            ]),
            AxxessCareApiFactory::visits($id = 2, [
                'Discipline' => 'PT',
                'Posting Agency' => 'Acme Home Health Care Two',
            ]),
            AxxessCareApiFactory::visits($id = 3, [
                'Discipline' => 'OT',
                'Posting Agency' => 'Acme Home Health Care Three',
            ]),
        ];
        Http::fake(function ($request) use ($visits) {
            $filteredVisits = collect($visits)
                ->when($request->data()['discipline'], function ($collection, $discipline){
                    return $collection->where('Discipline', $discipline);
                });
            return Http::response(['items' => $filteredVisits, 'total' => 3], 200);
        });
        $this->filters['discipline'] = 'Nursing';

        Livewire::test(Visits::class, ['filters' => $this->filters])
            ->assertSeeText('Displaying 1 visit')
            ->assertSeeText('Acme Home Health Care One')
            ->assertDontSeeText('Acme Home Health Care Two')
            ->assertDontSeeText('Acme Home Health Care Three');
    }

    /** @test  */
    public function the_visit_cards_can_be_filtered_down_to_the_pt_discipline()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'Discipline' => 'PT',
                'Posting Agency' => 'Acme Home Health Care One',
            ]),
            AxxessCareApiFactory::visits($id = 2, [
                'Discipline' => 'PT',
                'Posting Agency' => 'Acme Home Health Care Two',
            ]),
            AxxessCareApiFactory::visits($id = 3, [
                'Discipline' => 'Nursing',
                'Posting Agency' => 'Acme Home Health Care Three',
            ]),
        ];
        Http::fake(function ($request) use ($visits) {
            $filteredVisits = collect($visits)
                ->when($request->data()['discipline'], function ($collection, $discipline){
                    return $collection->where('Discipline', $discipline);
                });
            return Http::response(['items' => $filteredVisits, 'total' => 3], 200);
        });
        $this->filters['discipline'] = 'PT';

        Livewire::test(Visits::class, ['filters' => $this->filters])
            ->assertSeeText('Displaying 2 visit')
            ->assertSeeText('Acme Home Health Care One')
            ->assertSeeText('Acme Home Health Care Two')
            ->assertDontSeeText('Acme Home Health Care Three');
    }

    /** @test  */
    public function when_no_discipline_filtering_is_applied_all_disciplines_are_shown()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'Discipline' => 'Nursing',
                'Posting Agency' => 'Acme Home Health Care One',
            ]),
            AxxessCareApiFactory::visits($id = 2, [
                'Discipline' => 'PT',
                'Posting Agency' => 'Acme Home Health Care Two',
            ]),
            AxxessCareApiFactory::visits($id = 3, [
                'Discipline' => 'ST',
                'Posting Agency' => 'Acme Home Health Care Three',
            ]),
            AxxessCareApiFactory::visits($id = 4, [
                'Discipline' => 'OT',
                'Posting Agency' => 'Acme Home Health Care Four',
            ]),
        ];
        Http::fake(function ($request) use ($visits) {
            $filteredVisits = collect($visits)
                ->when($request->data()['discipline'], function ($collection, $discipline){
                    return $collection->where('Discipline', $discipline);
                });
            return Http::response(['items' => $filteredVisits, 'total' => 4], 200);
        });
        $this->filters['discipline'] = null;

        Livewire::test(Visits::class, ['filters' => $this->filters])
            ->assertSeeText('Displaying 4 visit')
            ->assertSeeText('Acme Home Health Care One')
            ->assertSeeText('Acme Home Health Care Two')
            ->assertSeeText('Acme Home Health Care Three')
            ->assertSeeText('Acme Home Health Care Four');
    }


    // Filter: Visit distance

    /** @test  */
    public function the_visit_cards_can_be_filtered_down_by_their_distance_to_clinician()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'Posting Agency' => 'Acme Home Health Care One',
                'DistancefromClinician' => 10,
            ]),
            AxxessCareApiFactory::visits($id = 2, [
                'Posting Agency' => 'Acme Home Health Care Two',
                'DistancefromClinician' => 20,
            ]),
            AxxessCareApiFactory::visits($id = 3, [
                'Posting Agency' => 'Acme Home Health Care Three',
                'DistancefromClinician' => 30,
            ]),
        ];
        Http::fake(function ($request) use ($visits) {
            $filteredVisits = collect($visits)
                ->when($request->data()['radius'], function ($collection, $radius) {
                    return $collection->whereBetween('DistancefromClinician', [0, $radius]);
                });
            return Http::response(['items' => $filteredVisits, 'total' => 3], 200);
        });
        $this->filters['radius'] = 15;

        Livewire::test(Visits::class, ['filters' => $this->filters])
            ->assertSeeText('Displaying 1 visit')
            ->assertSeeText('Acme Home Health Care One')
            ->assertDontSeeText('Acme Home Health Care Two')
            ->assertDontSeeText('Acme Home Health Care Three');
    }


    // Filter: Visit date range

    /** @test  */
    public function only_visits_prior_to_the_date_range_are_shown()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'Posting Agency' => 'Acme Home Health Care One',
                'Visit Date' => Carbon::parse('first day of January 2021')->format('m-d-Y'),
                'PostingDate' => Carbon::parse('January 1, 2022')->format('m-d-Y'),
            ]),
            AxxessCareApiFactory::visits($id = 2, [
                'Posting Agency' => 'Acme Home Health Care Two',
                'Visit Date' => Carbon::parse('first day of February 2021')->format('m-d-Y'),
                'PostingDate' => Carbon::parse('January 1, 2022')->format('m-d-Y'),
            ]),
            AxxessCareApiFactory::visits($id = 3, [
                'Posting Agency' => 'Acme Home Health Care Three',
                'Visit Date' => Carbon::parse('first day of March 2021')->format('m-d-Y'),
                'PostingDate' => Carbon::parse('January 1, 2022')->format('m-d-Y'),
            ]),
        ];
        Http::fake(function ($request) use ($visits) {
            $filteredVisits = collect($visits)
                ->when($request->data()['dateRange'], function ($collection, $endDate) {
                    $endDate = Carbon::parse($endDate)->format('m-d-Y');
                    return $collection->where('Visit Date', '<=', $endDate);
                });
            return Http::response(['items' => $filteredVisits, 'total' => 3], 200);
        });
        $this->filters['dateRange'] = Carbon::parse('14 February 2021')->format('Y-m-d');

        Livewire::test(Visits::class, ['filters' => $this->filters])
            ->assertSeeText('Acme Home Health Care One')
            ->assertSeeText('Acme Home Health Care Two')
            ->assertDontSeeText('Acme Home Health Care Three');
    }


    // Sorting

    /** @test  */
    public function the_visits_can_be_ordered_by_visit_date()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'Posting Agency' => 'Acme Home Health Care One',
                'Visit Date' => Carbon::parse('first day of March 2021')->format('m-d-Y'),
                'PostingDate' => Carbon::parse('December 2, 2020')->format('m-d-Y'),
            ]),
            AxxessCareApiFactory::visits($id = 2, [
                'Posting Agency' => 'Acme Home Health Care Two',
                'Visit Date' => Carbon::parse('first day of February 2021')->format('m-d-Y'),
                'PostingDate' => Carbon::parse('December 3, 2020')->format('m-d-Y'),
            ]),
            AxxessCareApiFactory::visits($id = 3, [
                'Posting Agency' => 'Acme Home Health Care Three',
                'Visit Date' => Carbon::parse('first day of January 2021')->format('m-d-Y'),
                'PostingDate' => Carbon::parse('December 1, 2020')->format('m-d-Y'),
            ]),
        ];
        Http::fake(function ($request) use ($visits) {
            $filteredVisits = collect($visits)->sortBy($request->data()['orderBy']);
            return Http::response(['items' => $filteredVisits, 'total' => 3], 200);
        });
        $this->filters['orderBy'] = 'Visit Date';

        Livewire::test(Visits::class, ['filters' => $this->filters])
            ->assertSeeInOrder([
                'Acme Home Health Care Three',
                'Acme Home Health Care Two',
                'Acme Home Health Care One',
            ]);
    }

    /** @test  */
    public function the_visits_can_be_ordered_by_posting_date()
    {
        $visits = [
            AxxessCareApiFactory::visits($id = 1, [
                'Posting Agency' => 'Acme Home Health Care One',
                'Visit Date' => Carbon::parse('first day of March 2021')->format('m-d-Y'),
                'PostingDate' => Carbon::parse('December 2, 2020')->format('m-d-Y'),
            ]),
            AxxessCareApiFactory::visits($id = 2, [
                'Posting Agency' => 'Acme Home Health Care Two',
                'Visit Date' => Carbon::parse('first day of February 2021')->format('m-d-Y'),
                'PostingDate' => Carbon::parse('December 3, 2020')->format('m-d-Y'),
            ]),
            AxxessCareApiFactory::visits($id = 3, [
                'Posting Agency' => 'Acme Home Health Care Three',
                'Visit Date' => Carbon::parse('first day of January 2021')->format('m-d-Y'),
                'PostingDate' => Carbon::parse('December 1, 2020')->format('m-d-Y'),
            ]),
        ];
        Http::fake(function ($request) use ($visits) {
            $filteredVisits = collect($visits)->sortBy($request->data()['orderBy']);
            return Http::response(['items' => $filteredVisits, 'total' => 3], 200);
        });
        $this->filters['orderBy'] = 'PostingDate';

        Livewire::test(Visits::class, ['filters' => $this->filters])
            ->assertSeeInOrder([
                'Acme Home Health Care Three',
                'Acme Home Health Care One',
                'Acme Home Health Care Two',
            ]);
    }

    /** @test  */
    public function the_pagination_can_navigate_to_other_page()
    {
        $this->assertEquals(24, AxxessCareApiService::PER_PAGE, 'Unexpected number of visits per page');
        $visits = [
            // Page 1
            AxxessCareApiFactory::visits($id = 1, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 2, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 3, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 4, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 5, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 6, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 7, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 8, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 9, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 10, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 11, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 12, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 13, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 14, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 15, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 16, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 17, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 18, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 19, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 20, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 21, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 22, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 23, ['Posting Agency' => 'Acme Home Health Care']),
            AxxessCareApiFactory::visits($id = 24, ['Posting Agency' => 'Acme Home Health Care']),
            // Page 2
            AxxessCareApiFactory::visits($id = 25, ['Posting Agency' => 'Nexcare Health Services Inc']),
        ];
        Http::fake(function ($request) use ($visits) {
            $paginatedVisits = collect($visits)->forPage($request->data()['page'], AxxessCareApiService::PER_PAGE)->toArray();
            return Http::response(['items' => $paginatedVisits, 'total' => 25], 200);
        });

        Livewire::withQueryParams(['page' => 1])
            ->test(Visits::class)
            ->assertSeeText('Acme Home Health Care')
            ->assertDontSeeText('Nexcare Health Services Inc');
        Livewire::withQueryParams(['page' => 2])
            ->test(Visits::class)
            ->assertSeeText('Nexcare Health Services Inc')
            ->assertDontSeeText('Acme Home Health Care');
    }
}
