<?php

namespace App\Http\Controllers\Fakes;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\DataWarehouse\Professional;
use Database\Factories\Fakes\AxxessCareApiFactory;

class AxxessCareApiController extends Controller
{
    /**
     * Number of visits to generate.
     *
     * @var  integer
     */
    const VISIT_COUNT = 100;

    /**
     * Number of visits per page.
     *
     * @var  integer
     */
    const PER_PAGE = 20;

    /**
     * Fake Dataset.
     */
    const DISCIPLINES = ['Nursing' => 45, 'PT' => 45, 'OT' => 5, 'ST' => 5];
    const JOB_TYPES = ['Internal', 'External'];
    const DISCIPLINE_TASKS = ['OASIS-D1 Resumption of Care', 'SN Management & Evaluation Visit', 'Skilled Nurse Visit', 'OASIS-D1 Start of Care', 'Skilled Nurse/Home Infusion/SD', 'HHA Supervisory Visit', 'Skilled Nurse Visit PM', 'OASIS-D1 Discharge', 'PTA Visit', 'Skilled Nurse Visit AM', 'SN Wound Care Visit', 'LVN/LPN Visit', 'OASIS-D1 Recertification', 'PT Discharge', '60 Day Summary/Case Conference', 'SN D/C Planning Visit', 'Non-OASIS Recertification', 'PT Visit', 'SN w/ Aide Supervision Visit', 'LVN/LPN Supervisory Visit', 'SN Teaching/Training Visit'];
    const SPECIALITYS = ['CHF Management', '5-day/2-day Discharge Notice', 'w/ Supervisory Visit-LVN', 'Discontinue PICC', 'Home Infusion Pump', 'Diabetic Management', 'Gastric Tube Care', 'Bladder Instillation (Flushing)', 'PICC/CVC Dressing and Cap Changes', 'Assessment and Training', 'Pain Management', 'Wound Vac', 'Hypertension Management', 'Insulin Administration', 'Lab Collection', 'Wound Care', 'Post Orthopedic Surgery', 'Bed Mobility', 'Fall Prevention', 'Catheter Care', 'Foley Catheter Insertion', 'Urinary Catheter Care/Training', 'Discharge (DC)', 'Insertion/Removal Urinary Catheter'];
    const AGENCY_NAMES = ['Human Touch Home Health Inc', 'Illinois Professional Home Health', 'OPTIMUM HEALTH CARE SERVICES, INC OF ILLINOIS', 'EXHH HOME HEALTH, INC.', 'Healthquest Homecare LLC', 'Town and Country Home Care & Rehab', 'PIVOT POINT HOMECARE SERVICES', 'A BLESSING HAND HOME HEALTH LLC', 'BUCKEYE HOME HEALTH CARE INC', 'Symmetrix home Health Care Inc', 'HOME HEALTH UNLIMITED INC', 'Nexcare Health Services Inc.', 'Elite Medical at Home', 'Precision Home Health Care, Inc', 'All By Grace Home Health', 'Gold Health Home Care, Corp.', 'Omni Park Health Care, LLC', 'In-Home Health Care Services', 'THERACARE SERVICES, LLC', 'Compassionate Home Health Services, inc'];
    const ADDRESSES = ['749 CHERRY BLOSSOM LN ALLEN TX 75002', '1102 Knollwood Dr. North Barrington IL 60010', '800 HILL AVE AURORA IL 60505', '6400 N SHERIDAN RD CHICAGO IL 60626', '317 MOTLEY ST GRAND PRAIRIE TX 75051', '709 E 130TH PL CHICAGO IL 60827', '6426 BEDVIEW DR SALINE MI 48176', '4103 SAN AUGUSTINE AVE PASADENA TX 77503', '9809 Sinclair St KELLER TX 76244', '24757 Primrose Ln SOUTHFIELD MI 48033', '10019 LEYBURN CT ORLANDO FL 32825', '4229 Blackjack Oak Drive MCKINNEY TX 75070', '441 N COWAN AVE  LEWISVILLE TX 75057', '4121 S ALAMO RD EDINBURG TX 78539', '6820 N DOOLITTLE RD EDINBURG TX 78539', '10600 BLOOMFIELD DR ORLANDO FL 32825', '6501 Excellence Way  PLANO TX 75023', '368 WILSHIRE ST PARK FOREST IL 60466', '660 N MAIN STREET WEST BRIDGEWATER MA 02379', '24900 Franklin Farms  FRANKLIN MI 48025', '1349 W ESTES AVE, APT J4 CHICAGO IL 60625', '284 W SAUK TRL SOUTH CHICAGO HEIGHTS IL 60411', '5611 OLD ROWLETT RD ROWLETT TX 75089', '12359 Northlawn St DETROIT MI 48204', '1713 Wiseman Ave FORT WORTH TX 76105'];
    const RATES = [10, 20, 30, 40, 50, 60, 70, 80, 90];
    const COMMENTS = ["Please call the patient prior to the visit, and see if they are home and available to be seen. If the patient does not answer or if any issues arise please call the DON Carolyn at 972-3719469 or Winter at office # 972-649-6400 or 469-753-5793", "extra $5.00 for parking", "COVID 19 RATE APPLIED", "Please call Mrs. Dodd (Emergency Contact) with a scheduled time BEFORE the visit.", "SPAINSH SPEAKING ONLY", "Clean with normal saline apply 4X4 fluffy gauze and abd pad with paper tape. Supplies in home.  No complications - Flap revision, quadriplegic. Educate to off - load and nutrition.", "Left leg diabetic ulcer: Cleanse with NSS, pat dry, cover with sterile dressing. This is just temporary while waiting for wound MD to see patient. Just call office (224) 251-7930 for any questions. Thanks."];
    const DESCRIPTIONS = ["Pt is Spanish speaking ONLY", "wc to great left toe", "SUPERVISORY VISIT", "Need PT INR drawn so we need a nurse that has a machine if not we can provide", "This is a Night shift from 11PM to 7: AM Mon- to Fri. paying $152.00 for 8 hrs ", "DM, heart failure, OA", "Recertification period is from 5/27/2018 - 5/29/2018. If you're not available this 5/27/18, let us know so we can call patient.", "Wednesdays only at noon, patient request.", "Patient goes to Dialysis M-W-F. He prefer to be seen around 1PM."];
    const DISCIPLINE_NAMES = ['Shaundria Tillman', 'Claudia Sierra', 'Miatta Kopoi', 'Tammie Burnett', 'Carmen Castro', 'Amanda Hansen', 'Yenisey Cruz', 'Cathy Griffin', 'Yadira Baez', 'Christine Morellos', 'Mariano Clara', 'Hellen Cahallan', 'Jazib Nassem', 'Judy Belli', 'Marian Obioha', 'Pamela Mavilla', 'Luiz Lopez', 'Sydeny Savillo', 'Heather Cox', 'Antonio Tays', 'Shradha Aiyer'];
    const PHONE_NUMBERS = ['917-522-7653', '724-869-9341', '631-706-9640', '662-539-8056', '248-529-6577', '562-439-6699', '740-522-4375',  '740-490-4857', '201-571-2284', '860-342-5643', '253-238-8113', '715-672-2516', '323-551-2850', '323-551-2850', '214-259-7669', '214-259-7669', '573-784-2982', '573-784-2982', '573-784-2982', '408-357-7153'];
    const JOB_STATUS = ['Posted', 'Assigned'];
    const FIRST_NAMES = ['Shaundria', 'Claudia', 'Miatta', 'Tammie', 'Carmen', 'Osagie', 'Sharmain', 'Ronald', 'Shane', 'Amanda', 'Thelma', 'Isaac', 'Carrvenna', 'Brenda', 'Daniel', 'Tina', 'Robin', 'Michelle', 'Alicia', 'Kelsey', 'Tawanda', 'Amanda', 'Yenisey', 'Cathy'];
    const LAST_NAMES = ['Tillman', 'Sierra', 'Kopoi', 'Burnett', 'Castro', 'Ezobi', 'Mccullough', 'Ty', 'Polatis', 'Labounty', 'Vasquez', 'Tindell', 'Ornelas', 'Maddox', 'Locke', 'Seguin', 'Breshears', 'Kelley', 'Cole', 'Tyre', 'Woolard', 'Makubika', 'Hansen', 'Cruz', 'Griffin'];
    const ROLES = [1, 2, 3, 4, 5, 6, 7, 8];

    /**
     * Return a list of visit details.
     *
     * @param   Illuminate\Http\Request  $request
     * @return  array
     */
    public function visits(Request $request)
    {
        $visits = Cache::remember('axxesscare-api-fake:visits', now()->addMinutes(10), function () {
            return $this->randomVisits(self::VISIT_COUNT);
        });

        $visitsCollection = collect($visits)
            ->when($request->jobType, function ($collection, $jobType){
                return $collection->where('jobtype', $jobType);
            })
            ->when($request->discipline, function ($collection, $discipline){
                return $collection->where('Discipline', $discipline);
            })
            ->when($request->radius, function ($collection, $radius) {
                return $collection->whereBetween('DistancefromClinician', [0, $radius]);
            })
            ->when($request->dateRange, function ($collection, $endDate) {
                $endDate = Carbon::parse($endDate)->format('m-d-Y');
                return $collection->where('Visit Date', '<=', $endDate);
            })
            ->sortBy($request->orderBy);

        return [
            'items' => $visitsCollection->forPage($request->query('page', 1), $request->query('perPage', self::PER_PAGE))->toArray(),
            'total' => $visitsCollection->count(),
        ];
    }

    /**
     * Genrate a random 'visits' array.
     *
     * @param   integer  $count
     * @return  array
     */
    private function randomVisits($count = 10)
    {
        $visits = [];

        foreach (range(1, $count) as $id) {
            $randomPcount = (rand(1, 8) === 1) ? rand(1, 15) : rand(16, 300);
            $randomDistance = round(rand(1, 500) / 10, 1);
            $visitDaysAgo = rand(1, 365);
            $postingDaysAgo = rand(1, 365);

            $visits[] = AxxessCareApiFactory::visits($id, [
                'Discipline' => Arr::randomWeighted(self::DISCIPLINES),
                'VisitRatePT' => Arr::random(self::RATES),
                'VisitRatePTA' => Arr::random(self::RATES),
                'CustomRatePT' => Arr::random(self::RATES),
                'CustomRatePTA' => Arr::random(self::RATES),
                'jobtype' => Arr::random(self::JOB_TYPES),
                'pcount' => $randomPcount,
                'Visit Date' => today()->subDays($visitDaysAgo)->format('m-d-Y'),
                'Discipline Task' => Arr::random(self::DISCIPLINE_TASKS),
                'Speciality' => Arr::random(self::SPECIALITYS),
                'Posting Agency' => Arr::random(self::AGENCY_NAMES),
                'Visit Rate RN' => Arr::random(self::RATES),
                'Visit Rate LVN' => Arr::random(self::RATES),
                'Custom Rate RN' => Arr::random(self::RATES),
                'Custom Rate LVN' => Arr::random(self::RATES),
                'CustomRateOASISRN' => Arr::random(self::RATES),
                'CustomRateOASISPT' => Arr::random(self::RATES),
                'OasisRnCost' => Arr::random(self::RATES),
                'OasisPtCost' => Arr::random(self::RATES),
                'JobAddress' => Arr::random(self::ADDRESSES),
                'DistancefromClinician' => $randomDistance,
                'PostingDate' => today()->subDays($postingDaysAgo)->format('m-d-Y'),
            ]);
        }

        return $visits;
    }

    /**
     * Return the visit details.
     *
     * @param   Illuminate\Http\Request  $request
     * @param   string  $id
     * @return  array
     */
    public function visit(Request $request, $id)
    {
        if (! Cache::has('axxesscare-api-fake:visits')) {
            return $this->randomVisit($id);
        }

        $visits = Cache::get('axxesscare-api-fake:visits');
        $visitDetails = collect($visits)->firstWhere('jobid', $id);

        return AxxessCareApiFactory::visit([
            'jobid' => $id,
            'jobcomments' => Arr::random(self::COMMENTS),
            'jobdescription' => Arr::random(self::DESCRIPTIONS),
            'Discipline' => $visitDetails['Discipline'],
            'VisitRatePT' => $visitDetails['VisitRatePT'],
            'VisitRatePTA' => $visitDetails['VisitRatePTA'],
            'CustomRatePT' => $visitDetails['CustomRatePT'],
            'CustomRatePTA' => $visitDetails['CustomRatePTA'],
            'jobtype' => $visitDetails['jobtype'],
            'JobAddress' => $visitDetails['JobAddress'],
            'DisciplineTask' => $visitDetails['Discipline Task'],
            'Specialty' => $visitDetails['Speciality'],
            'AgencyName' => $visitDetails['Posting Agency'],
            'VisitDate' => $visitDetails['Visit Date'],
            'VisitRateLVN' => $visitDetails['Visit Rate LVN'],
            'VisitRateRN' => $visitDetails['Visit Rate RN'],
            'CustomRateLVN' => $visitDetails['Custom Rate LVN'],
            'CustomRateRN' => $visitDetails['Custom Rate RN'],
            'CustomRateOASISRN' => $visitDetails['CustomRateOASISRN'],
            'CustomRateOASISPT' => $visitDetails['CustomRateOASISPT'],
            'OasisRnCost' => $visitDetails['OasisRnCost'],
            'OasisPtCost' => $visitDetails['OasisPtCost'],
        ]);
    }

    /**
     * Genrate a random 'visit' array.
     *
     * @param   string  $id
     * @return  array
     */
    private function randomVisit($id)
    {
        $postingDaysAgo = rand(1, 365);
        $visitDaysAgo = rand(1, 365);

        return AxxessCareApiFactory::visit([
            'jobid' => $id,
            'jobcomments' => Arr::random(self::COMMENTS),
            'jobdescription' => Arr::random(self::DESCRIPTIONS),
            'Discipline' => Arr::randomWeighted(self::DISCIPLINES),
            'VisitRatePT' => Arr::random(self::RATES),
            'VisitRatePTA' => Arr::random(self::RATES),
            'CustomRatePT' => Arr::random(self::RATES),
            'CustomRatePTA' => Arr::random(self::RATES),
            'jobtype' => Arr::random(self::JOB_TYPES),
            'JobAddress' => Arr::random(self::ADDRESSES),
            'DisciplineTask' => Arr::random(self::DISCIPLINE_TASKS),
            'Specialty' => Arr::random(self::SPECIALITYS),
            'AgencyName' => Arr::random(self::AGENCY_NAMES),
            'VisitDate' => today()->subDays($visitDaysAgo)->format('m-d-Y'),
            'VisitRateLVN' => Arr::random(self::RATES),
            'VisitRateRN' => Arr::random(self::RATES),
            'CustomRateLVN' => Arr::random(self::RATES),
            'CustomRateRN' => Arr::random(self::RATES),
            'CustomRateOASISRN' => Arr::random(self::RATES),
            'CustomRateOASISPT' => Arr::random(self::RATES),
            'OasisRnCost' => Arr::random(self::RATES),
            'OasisPtCost' => Arr::random(self::RATES),
        ]);
    }

    /**
     * Return a list of visit details.
     *
     * @param   Illuminate\Http\Request  $request
     * @param   string  $id
     * @return  array
     */
    public function clinicians(Request $request, $id)
    {
        $clients = Cache::remember('axxesscare-api-fake:clinician', now()->addMinutes(10), function () use ($id) {
            return $this->randomClinicians($id, $count = rand(25, 100));
        });

        $clientCollection = collect($clients)
            ->whereBetween('DistancefromClinician', [0, $request->input('radius', 20)])
            ->sortBy('DistancefromClinician')
            ->sortBy('ClinicianName');

        return $clientCollection;
    }

    /**
     * Genrate a random 'clinicians' array.
     *
     * @param   string   $jobId
     * @param   integer  $count
     * @return  array
     */
    private function randomClinicians($jobId, $count = 10)
    {
        $clientDetails = [];

        $professionalIds = Professional::limit($count)->pluck('Id');

        foreach (range(1, $count) as $id) {
            $n = $id - 1;
            $visitDaysAgo = rand(1, 365);
            $postingDaysAgo = rand(1, 365);
            $randomDistance = round(rand(1, 500) / 10, 1);

            $clientDetails[] = AxxessCareApiFactory::clinicians($id, [
                'CompletedJobsCount' => rand(0, 20),
                'AppliedJobsCount' => rand(0, 20),
                'profid' => $professionalIds[$n],
                'ClinicianName' => Arr::random(self::DISCIPLINE_NAMES),
                'Clinician Phone#' =>  Arr::random(self::PHONE_NUMBERS),
                'Role' => Arr::randomWeighted(self::DISCIPLINES),
                'Visit Date' => today()->subDays($visitDaysAgo)->format('m-d-Y'),
                'Discipline Task' => Arr::random(self::DISCIPLINE_TASKS),
                'Speciality' => Arr::random(self::SPECIALITYS),
                'Posting Agnecy' => Arr::random(self::AGENCY_NAMES),
                'Visit Rate RN' =>  Arr::random(self::RATES),
                'Visit Rate LVN' =>  Arr::random(self::RATES),
                'Custom Rate RN' =>  Arr::random(self::RATES),
                'Custom Rate LVN' =>  Arr::random(self::RATES),
                'JobAddress' => Arr::random(self::ADDRESSES),
                'DistancefromClinician' => $randomDistance,
                'Posting Date' => today()->subDays($postingDaysAgo)->format('m-d-Y'),
                'Job ID' => $jobId,
            ]);
        };

        return $clientDetails;
    }

    /**
     * Return a list of job listing details.
     *
     * @param   Illuminate\Http\Request  $request
     * @param   string  $professionalId
     * @return  array
     */
    public function jobs(Request $request, $professionalId)
    {
        $jobs = Cache::remember('axxesscare-api-fake:jobs', now()->addMinutes(10), function () use ($professionalId) {
            return $this->randomJobs($professionalId, $count = rand(10, 50));
        });

        return collect($jobs);
    }

    /**
     * Genrate a random 'jobs' array.
     *
     * @param   integer  $count
     * @return  array
     */
    private function randomJobs($professionalId, $count = 10)
    {
        $jobs = [];

        foreach (range(1, $count) as $id) {
            $randomDistance = round(rand(1, 500) / 10, 1);
            $visitDaysAgo = rand(1, 365);
            $postingDaysAgo = rand(1, 365);
            $applicantCount = rand(0, 3);

            $jobs[] = AxxessCareApiFactory::jobs($id, [
                'applicantcount' => $applicantCount,
                'jobstatus' => Arr::random(self::JOB_STATUS),
                'Discipline' => Arr::randomWeighted(self::DISCIPLINES),
                'VisitRatePT' => Arr::random(self::RATES),
                'VisitRatePTA' => Arr::random(self::RATES),
                'CustomRatePT' => Arr::random(self::RATES),
                'CustomRatePTA' => Arr::random(self::RATES),
                'id' => $professionalId,
                'Clinician First Name' => Arr::random(self::FIRST_NAMES),
                'Clinician Last Name' => Arr::random(self::LAST_NAMES),
                'Clinician Phone#' => Arr::random(self::PHONE_NUMBERS),
                'Role' => Arr::random(self::ROLES),
                'Visit Date' => today()->subDays($visitDaysAgo)->format('m-d-Y'),
                'Discipline Task' => Arr::random(self::DISCIPLINE_TASKS),
                'Speciality' => Arr::random(self::SPECIALITYS),
                'PostingAgency' => Arr::random(self::AGENCY_NAMES),
                'Visit Rate RN' => Arr::random(self::RATES),
                'Visit Rate LVN' => Arr::random(self::RATES),
                'Custom Rate RN' => Arr::random(self::RATES),
                'Custom Rate LVN' => Arr::random(self::RATES),
                'JobAddress' => Arr::random(self::ADDRESSES),
                'Distance from Clinician' => $randomDistance,
                'Posting Date' => today()->subDays($postingDaysAgo)->format('m-d-Y'),
                'Applicant Status' => 'No Applicant',
            ]);
        }

        return $jobs;
    }
}
