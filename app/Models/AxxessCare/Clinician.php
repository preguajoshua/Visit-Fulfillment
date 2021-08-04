<?php

namespace App\Models\AxxessCare;

use App\Models\DataWarehouse\Professional;
use App\Models\DataWarehouse\ProfessionalNote;
use Spatie\DataTransferObject\DataTransferObject;

class Clinician extends DataTransferObject
{
    public string $id;
    public string $fullName;
    public string $phoneNumber;
    public string $role;
    public int $appliedJobsCount;
    public int $completedJobsCount;
    public float $distanceFromClinician;
    public ProfessionalNote $note;

    public static function fromResponse($response): self
    {
        return new self([
            'id' => $response['profid'],
            'fullName' => $response['ClinicianName'],
            'phoneNumber' => $response['Clinician Phone#'],
            'role' => $response['Role'],
            'appliedJobsCount' => $response['AppliedJobsCount'],
            'completedJobsCount' => $response['CompletedJobsCount'],
            'distanceFromClinician' => $response['DistancefromClinician'],
            'note' => Professional::findOrFail($response['profid'])->note,
        ]);
    }
}
