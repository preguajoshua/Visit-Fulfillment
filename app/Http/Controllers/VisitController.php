<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AxxessCareApiService;
use App\Models\DataWarehouse\VisitNote;

class VisitController extends Controller
{
    /**
     * List the visits.
     *
     * @return  View
     */
    public function index()
    {
        return view('visits.index');
    }

    /**
     * Show the specified visit.
     *
     * @return  View
     */
    public function show($id, AxxessCareApiService $axxessCareApiService)
    {
        return view('visits.show',[
            'visit' => $axxessCareApiService->visit($id),
            'clinicians' => $axxessCareApiService->clinicians($id),
        ]);
    }
}
