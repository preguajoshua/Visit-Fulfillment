<?php

namespace App\Models\AxxessCare;

use Illuminate\Support\Carbon;
use App\Models\DataWarehouse\Job;
use App\Models\DataWarehouse\PayRate;
use App\Models\DataWarehouse\Facility;
use App\Models\DataWarehouse\CustomJobRate;
use Spatie\DataTransferObject\DataTransferObject;

class Visit extends DataTransferObject
{
    public ?string $jobId;
    public ?string $jobType;
    public ?string $jobDescription;
    public ?string $jobComments;
    public ?string $jobStatus;
    public ?string $jobAddress;
    public ?float $distanceFromClinician;
    public ?string $agencyName;

    public ?string $speciality;
    public ?string $discipline;
    public ?string $disciplineTask;

    public ?float $visitRateRn;
    public ?float $visitRateLvn;
    public ?float $customRateRn;
    public ?float $customRateLvn;
    public ?float $visitRatePt;
    public ?float $visitRatePta;
    public ?float $customRatePt;
    public ?float $customRatePta;
    public ?float $oasisRnCost;
    public ?float $oasisPtCost;
    public ?float $customRateOasisRn;
    public ?float $customRateOasisPt;

    public ?Carbon $postingDate;
    public ?Carbon $visitDate;

    public ?int $applicantCount;
    public ?int $pCount;


    public static function fromIndexResponse($response): self
    {
        return new self([
            'jobId' => $response['jobid'],
            'jobType' => $response['jobtype'],
            'jobDescription' => null,
            'jobComments' => null,
            'jobStatus' => 'Unknown',
            'jobAddress' => $response['JobAddress'],
            'distanceFromClinician' => $response['DistancefromClinician'],
            'agencyName' => $response['Posting Agency'],

            'speciality' => $response['Speciality'],
            'discipline' => $response['Discipline'],
            'disciplineTask' => $response['Discipline Task'],

            'visitRateRn' => $response['Visit Rate RN'],
            'visitRateLvn' => $response['Visit Rate LVN'],
            'customRateRn' => $response['Custom Rate RN'],
            'customRateLvn' => $response['Custom Rate LVN'],
            'visitRatePt' => $response['VisitRatePT'],
            'visitRatePta' => $response['VisitRatePTA'],
            'customRatePt' => $response['CustomRatePT'],
            'customRatePta' => $response['CustomRatePTA'],
            'oasisRnCost' => $response['OasisRnCost'],
            'oasisPtCost' => $response['OasisPtCost'],
            'customRateOasisRn' => $response['CustomRateOASISRN'],
            'customRateOasisPt' => $response['CustomRateOASISPT'],

            'postingDate' => Carbon::createFromFormat('m-d-Y', $response['PostingDate']),
            'visitDate' => Carbon::createFromFormat('m-d-Y', $response['Visit Date']),

            'applicantCount' => null,
            'pCount' => $response['pcount'],
        ]);
    }

    public static function fromShowResponse($response): self
    {
        return new self([
            'jobId' => $response['jobid'],
            'jobType' => $response['jobtype'],
            'jobDescription' => $response['jobdescription'],
            'jobComments' => $response['jobcomments'],
            'jobStatus' => 'Unknown',
            'agencyName' => $response['AgencyName'],
            'jobAddress' => $response['JobAddress'],
            'distanceFromClinician' => 0,

            'speciality' => $response['Specialty'],
            'discipline' => $response['Discipline'],
            'disciplineTask' => $response['DisciplineTask'],

            'visitRateRn' => $response['VisitRateRN'],
            'visitRateLvn' => $response['VisitRateLVN'],
            'customRateRn' => $response['CustomRateRN'],
            'customRateLvn' => $response['CustomRateLVN'],
            'visitRatePt' => $response['VisitRatePT'],
            'visitRatePta' => $response['VisitRatePTA'],
            'customRatePt' => $response['CustomRatePT'],
            'customRatePta' => $response['CustomRatePTA'],
            'oasisRnCost' => $response['OasisRnCost'],
            'oasisPtCost' => $response['OasisPtCost'],
            'customRateOasisRn' => $response['CustomRateOASISRN'],
            'customRateOasisPt' => $response['CustomRateOASISPT'],

            'postingDate' => Carbon::now(),
            'visitDate' => Carbon::createFromFormat('m-d-Y', $response['VisitDate']),

            'applicantCount' => null,
            'pCount' => null,
        ]);
    }

    public static function fromJobResponse($response): self
    {
        return new self([
            'jobId' => $response['Job ID'],
            'jobType' => 'Unknown',
            'jobDescription' => null,
            'jobComments' => null,
            'jobStatus' => $response['jobstatus'],
            'agencyName' => $response['PostingAgency'],
            'jobAddress' => $response['JobAddress'],
            'distanceFromClinician' => $response['Distance from Clinician'],

            'speciality' => $response['Speciality'],
            'discipline' => $response['Discipline'],
            'disciplineTask' => $response['Discipline Task'],

            'visitRateRn' => $response['Visit Rate RN'],
            'visitRateLvn' => $response['Visit Rate LVN'],
            'customRateRn' => $response['Custom Rate RN'],
            'customRateLvn' => $response['Custom Rate LVN'],
            'visitRatePt' => $response['VisitRatePT'],
            'visitRatePta' => $response['VisitRatePTA'],
            'customRatePt' => $response['CustomRatePT'],
            'customRatePta' => $response['CustomRatePTA'],
            'oasisRnCost' => null,
            'oasisPtCost' => null,
            'customRateOasisRn' => null,
            'customRateOasisPt' => null,

            'postingDate' => Carbon::createFromFormat('m-d-Y', $response['Posting Date']),
            'visitDate' => Carbon::createFromFormat('m-d-Y', $response['Visit Date']),

            'applicantCount' => $response['applicantcount'],
            'pCount' => null,
        ]);
    }
    
    /**
     * Job status descriptions.
     *
     * @var array
     */
    const STATUS_DESCRIPTION = [
        1 => 'Posted',
        2 => 'Assigned',
        8 => 'Returned',
        9 => 'Returned',
        10 => 'Not Started',
        11 => 'Removed',
        12 => 'Pending Acceptance',
    ];

    public static function fromJobAgencyResponse($response): self
    {
        return new self([
            'jobId' => $response['Id'],
            'facilityId' => $response['FacilityId'],
            'jobStatus' => self::STATUS_DESCRIPTION[$response['Status']],
            'disciplineTask' => $response['DisciplineTask'],
            'speciality' => $response['Specialty'],
            'jobAddress' => $response['Address1'].", ".$response['City'].", ".$response['State'].", ".$response['Zipcode'],
            'agencyName' => $response['facility']['Name'],

            'discipline' => 'Nursing', // Todo

            'visitRateRn' => $response['RnCost'] ?? null,
            'visitRateLvn' => $response['LvnLpnCost']  ?? null,
            'customRateRn' => (isset($response['customjobrates'][0]) ) ? $response['customjobrates'][0]['Rate'] : null,
            'customRateLvn' => (isset($response['customjobrates'][1]) ) != null ? $response['customjobrates'][1]['Rate'] : null,
            'oasisRnCost' => null,
            'oasisPtCost' => null,
            'customRateOasisRn' => null,
            'customRateOasisPt' => null,
            
            'applicantCount' => count($response['applications']) ?? 0,

            'postingDate' => Carbon::now(), // Todo
            'visitDate' => Carbon::parse($response['VisitDate']),
        ]);
    }
}
