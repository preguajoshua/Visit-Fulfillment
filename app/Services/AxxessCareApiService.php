<?php

namespace App\Services;

use App\Models\AxxessCare\Visit;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use App\Models\AxxessCare\Clinician;
use Illuminate\Pagination\LengthAwarePaginator;

class AxxessCareApiService
{
    /**
     * Number of requested visits per page.
     *
     * @var  integer
     */
    const PER_PAGE = 24;

    /**
     * Fetch all filtered visits.
     *
     * @param   array  $queryString
     * @return  \Illuminate\Pagination\LengthAwarePaginator
     */
    public function visits($queryString): LengthAwarePaginator
    {
        $queryString['perPage'] = self::PER_PAGE;

        $response = Http::get(config('axxess.axxesscare.api_base_url') . '/visits', $queryString);

        return new LengthAwarePaginator(
            $items = array_map(fn($visit) => Visit::fromIndexResponse($visit), $response->json('items')),
            $total = $response->json('total'),
            $perPage = $queryString['perPage'],
            $currentPage = $queryString['page'],
            $options = [
                'path' => route('visits.index'),
                'pageName' => 'page',
            ]
        );
    }

    /**
     * Fetch the specified visit.
     *
     * @param   integer  $id
     * @return  \App\Models\AxxessCare\Visit
     */
    public function visit($id): Visit
    {
        $response = Http::get(config('axxess.axxesscare.api_base_url') . '/visits/' . $id);

        $visit = Visit::fromShowResponse($response->json());

        return $visit;
    }

    /**
     * Fetch all clinicians.
     *
     * @param   string  $jobId
     * @return  array
     */
    public function clinicians($jobId)
    {
        $response = Http::get(config('axxess.axxesscare.api_base_url') . '/visits/' . $jobId . '/clinicians');

        return array_map(fn($client) => Clinician::fromResponse($client), $response->json());
    }

    /**
     * Fetch all jobs.
     *
     * @param  integer  $clinicianId
     */
    public function jobs($clinicianId): Collection
    {
        $response = Http::get(config('axxess.axxesscare.api_base_url') . '/clinicians/' . $clinicianId . '/jobs');

        $jobs = array_map(fn($job) => Visit::fromJobResponse($job), $response->json());

        return collect($jobs);
    }
}
