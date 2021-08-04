<?php

namespace App\Http\Controllers;

use App\Models\AxxessCare\Visit;
use App\Models\DataWarehouse\Job;
use App\Models\DataWarehouse\PayRate;
use App\Models\DataWarehouse\Facility;
use App\Models\DataWarehouse\JobApplication;
use App\Models\DataWarehouse\CustomJobRate;

use Livewire\WithPagination;

class AgencyController extends Controller
{
    use WithPagination;

    const PER_PAGE = 20;

    /**
     * List the agencies.
     *
     * @return  View
     */
    public function index()
    {
        return view('agencies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param   \App\Models\DataWarehouse\Facility  $agency
     */
    public function show(Facility $agency)
    {
        $job = (new Job)->getTable();
        $payrate = (new PayRate)->getTable();
        $customJobRate = (new CustomJobRate)->getTable();

        $query = Job::qualifyColumns()
            ->leftJoinRelationship('customjobrates')
            ->leftJoinRelationship('applications')
            ->leftJoinRelationship('facility')
            ->leftJoinRelationship('payrates')
            ->IdentifyIncompleteStatus()
            ->select([
                "{$job}.Id",
                "{$job}.FacilityId",
                "{$job}.Status",
                "{$job}.DisciplineTask",
                "{$job}.Specialty",
                "{$job}.VisitDate",
                "{$job}.Address1",
                "{$job}.City",
                "{$job}.State",
                "{$job}.Zipcode",
                "{$payrate}.RnCost",
                "{$payrate}.LvnLpnCost",
            ])
            ->with([
                'customjobrates:JobId,Role,Rate',
                'applications:Id,JobId,ProfessionalId',
                'facility:Id,Name'
            ])
            ->groupBy("{$job}.Id")
            ->where([
                ["{$job}.FacilityId", $agency->Id],
                ["{$job}.VisitDate",'<=', today()->format('Y-m-d H:i:s')],
            ])
            ->orderBy("{$job}.VisitDate")
            ->get();
        
        $result = array_map(fn($result) => Visit::fromJobAgencyResponse($result), $query->toArray());
        
        return view('agencies.show', [
            'agency' => $agency,
            'jobs' => collect($result),
        ]);
    }
}