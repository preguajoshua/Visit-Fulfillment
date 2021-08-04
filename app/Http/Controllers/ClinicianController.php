<?php

namespace App\Http\Controllers;

use App\Services\AxxessCareApiService;
use App\Models\DataWarehouse\Professional;

class ClinicianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clinicians.index');
    }

    /**
     * Display the specified resource.
     *
     * @param   \App\Models\DataWarehouse\Professional  $clinician
     * @param   \App\Services\AxxessCareApiService  $axxessCareApiService
     * @return  \Illuminate\Http\Response
     */
    public function show(Professional $clinician, AxxessCareApiService $axxessCareApiService)
    {
        return view('clinicians.show', [
            'clinician' => $clinician,
            'jobsApplied' => $clinician->applications->count(),
            'jobsCompleted' => $clinician->jobs()->statusCompleted()->count(),
            'lastJobCompleted' => $clinician->jobs()->latest('Created')->first()?->Created,
            'firstJobCompleted' => $clinician->jobs()->oldest('Created')->first()?->Created,
            'jobs' => $axxessCareApiService->jobs($clinician->Id),
        ]);
    }
}
