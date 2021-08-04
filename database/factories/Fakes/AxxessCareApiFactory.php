<?php

namespace Database\Factories\Fakes;

use Illuminate\Support\Arr;

class AxxessCareApiFactory
{
    /**
     * Define an empty dataset for a visit index card.
     *
     * @param   integer  $id
     * @param   array    $attributes
     * @return  array
     */
    public static function visits($id, $attributes = [])
    {
        $jobId = sprintf('00000000-0000-0000-0000-%s', str_pad($id, 12, 0, STR_PAD_LEFT));

        return [
            'Discipline' => $attributes['Discipline'] ?? 'Unknown',
            'VisitRatePT' => $attributes['VisitRatePT'] ?? 0,
            'VisitRatePTA' => $attributes['VisitRatePTA'] ?? 0,
            'CustomRatePT' => $attributes['CustomRatePT'] ?? 0,
            'CustomRatePTA' => $attributes['CustomRatePTA'] ?? 0,
            'jobtype' => $attributes['jobtype'] ?? 'Unknown',
            'jobid' => $attributes['jobid'] ?? $jobId,
            'facid' => $attributes['facid'] ?? '00000000-0000-0000-0000-00000000',
            'pcount' => $attributes['pcount'] ?? null,
            'profid' => $attributes['profid'] ?? '00000000-0000-0000-0000-00000000',
            'Visit Date' => $attributes['Visit Date'] ?? today()->format('m-d-Y'),
            'Discipline Task' => $attributes['Discipline Task'] ?? 'Unknown',
            'Speciality' => $attributes['Speciality'] ?? 'Unknown',
            'Posting Agency' => $attributes['Posting Agency'] ?? 'Unknown',
            'Visit Rate RN' => $attributes['Visit Rate RN'] ?? 0,
            'Visit Rate LVN' => $attributes['Visit Rate LVN'] ?? 0,
            'Custom Rate RN' => $attributes['Custom Rate RN'] ?? 0,
            'Custom Rate LVN' => $attributes['Custom Rate LVN'] ?? 0,
            'CustomRateOASISRN' => $attributes['CustomRateOASISRN'] ?? 0,
            'CustomRateOASISPT' => $attributes['CustomRateOASISPT'] ?? 0,
            'OasisRnCost' => $attributes['OasisRnCost'] ?? 0,
            'OasisPtCost' => $attributes['OasisPtCost'] ?? 0,
            'JobAddress' => $attributes['JobAddress'] ?? 'Unknown',
            'DistancefromClinician' => $attributes['DistancefromClinician'] ?? 0,
            'PostingDate' => $attributes['PostingDate'] ?? today()->format('m-d-Y'),
            'Job ID' => $attributes['Job ID'] ?? $jobId,
            'Applicant Status' => $attributes['Applicant Status'] ?? 'Unknown',
        ];
    }

    /**
     * Define an empty dataset for a visit show card.
     *
     * @param   array   $attributes
     * @return  array
     */
    public static function visit($attributes = [])
    {
        return [
            'jobid' => $attributes['jobid'] ?? '00000000-0000-0000-0000-00000000',
            'jobcomments' => $attributes['jobcomments'] ?? null,
            'jobdescription' => $attributes['jobdescription'] ?? null,
            'Discipline' => $attributes['Discipline'] ?? 'Unknown',
            'VisitRatePT' => $attributes['VisitRatePT'] ?? 0,
            'VisitRatePTA' => $attributes['VisitRatePTA'] ?? 0,
            'CustomRatePT' => $attributes['CustomRatePT'] ?? 0,
            'CustomRatePTA' => $attributes['CustomRatePTA'] ?? 0,
            'jobtype' => $attributes['jobtype'] ?? 'Unknown',
            'descomments' => $attributes['descomments'] ?? 'Unknown',
            'facid' => $attributes['facid'] ?? '00000000-0000-0000-0000-000000000000',
            'JobAddress' => $attributes['JobAddress'] ?? 'Unknown',
            'DisciplineTask' => $attributes['DisciplineTask'] ?? 'Unknown',
            'Specialty' => $attributes['Specialty'] ?? 'Unknown',
            'AgencyName' => $attributes['AgencyName'] ?? 'Unknown',
            'PostingDate' => $attributes['PostingDate'] ?? now()->format('Y-m-d H:i:s'),
            'VisitDate' => $attributes['VisitDate'] ?? today()->format('m-d-Y'),
            'VisitRateLVN' => $attributes['VisitRateLVN'] ?? 0,
            'VisitRateRN' => $attributes['VisitRateRN'] ?? 0,
            'CustomRateLVN' => $attributes['CustomRateLVN'] ?? 0,
            'CustomRateRN' => $attributes['CustomRateRN'] ?? 0,
            'CustomRateOASISRN' => $attributes['CustomRateOASISRN'] ?? 0,
            'CustomRateOASISPT' => $attributes['CustomRateOASISPT'] ?? 0,
            'OasisRnCost' => $attributes['OasisRnCost'] ?? 0,
            'OasisPtCost' => $attributes['OasisPtCost'] ?? 0,
        ];
    }

    /**
     * Define an empty dataset for a clinician index card.
     *
     * @param   integer  $id
     * @param   array  $attributes
     * @return  array
     */
    public static function clinicians($id, $attributes = [])
    {
        $profId = sprintf('00000000-0000-0000-0000-%s', str_pad($id, 12, 0, STR_PAD_LEFT));

        return [
            'CompletedJobsCount' => $attributes['CompletedJobsCount'] ?? 0,
            'AppliedJobsCount' => $attributes['AppliedJobsCount'] ?? 0,
            'profid' => $attributes['profid'] ?? $profId,
            'ClinicianName' => $attributes['ClinicianName'] ?? 'Unknown',
            'Clinician Phone#' =>  $attributes['Clinician Phone#'] ?? 'Unknown',
            'Role' => $attributes['Role'] ?? 'Unknown',
            'Visit Date' => $attributes['Visit Date'] ?? today()->format('m-d-Y'),
            'Discipline Task' => $attributes['Discipline Task'] ?? 'Unknown',
            'Speciality' => $attributes['Speciality'] ?? 'Unknown',
            'Posting Agnecy' => $attributes['Posting Agnecy'] ?? 'Unknown',
            'Visit Rate RN' => $attributes['Visit Rate RN'] ?? 0,
            'Visit Rate LVN' => $attributes['Visit Rate LVN'] ?? 0,
            'Custom Rate RN' => $attributes['Custom Rate RN'] ?? 0,
            'Custom Rate LVN' => $attributes['Custom Rate LVN'] ?? 0,
            'JobAddress' => $attributes['JobAddress'] ?? 'Unknown',
            'DistancefromClinician' => $attributes['DistancefromClinician'] ?? 0,
            'Posting Date' => $attributes['Posting Date'] ?? now()->format('Y-m-d H:i:s'),
            'Job ID' => $attributes['Job ID'] ?? '00000000-0000-0000-0000-000000000000',
            'Applicant Status' => 'No Applicant',
        ];
    }

    /**
     * Define an empty dataset for a job card.
     *
     * @param   integer  $id
     * @param   array    $attributes
     * @return  array
     */
    public static function jobs($id, $attributes = [])
    {
        $jobId = sprintf('00000000-0000-0000-0000-%s', str_pad($id, 12, 0, STR_PAD_LEFT));

        return [
            'applicantcount' => $attributes['applicantcount'] ?? null,
            'jobstatus' => $attributes['jobstatus'] ?? 'Unknown',
            'Discipline' => $attributes['Discipline'] ?? 'Unknown',
            'VisitRatePT' => $attributes['VisitRatePT'] ?? 0,
            'VisitRatePTA' => $attributes['VisitRatePTA'] ?? 0,
            'CustomRatePT' => $attributes['CustomRatePT'] ?? 0,
            'CustomRatePTA' => $attributes['CustomRatePTA'] ?? 0,
            'id' => $attributes['id'] ?? '00000000-0000-0000-0000-000000000000',
            'Clinician First Name' => $attributes['Clinician First Name'] ?? 'Unknown',
            'Clinician Last Name' => $attributes['Clinician Last Name'] ?? 'Unknown',
            'Clinician Phone#' => $attributes['Clinician Phone'] ?? 'Unknown',
            'Role' => $attributes['Role'] ?? 'Unknown',
            'Visit Date' => $attributes['Visit Date'] ?? today()->format('m-d-Y'),
            'Discipline Task' => $attributes['Discipline Task'] ?? 'Unknown',
            'Speciality' => $attributes['Speciality'] ?? 'Unknown',
            'PostingAgency' => $attributes['PostingAgency'] ?? 'Unknown',
            'Visit Rate RN' => $attributes['Visit Rate RN'] ?? 0,
            'Visit Rate LVN' => $attributes['Visit Rate LVN'] ?? 0,
            'Custom Rate RN' => $attributes['Custom Rate RN'] ?? 0,
            'Custom Rate LVN' => $attributes['Custom Rate LVN'] ?? 0,
            'JobAddress' => $attributes['JobAddress'] ?? 'Unknown',
            'Distance from Clinician' => $attributes['Distance from Clinician'] ?? 0,
            'Posting Date' => $attributes['Posting Date'] ?? today()->format('m-d-Y'),
            'Job ID' => $attributes['Job ID'] ?? $jobId,
            'Applicant Status' => 'No Applicant',
        ];
    }
}
