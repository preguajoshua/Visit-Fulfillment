<?php

namespace App\Models\DataWarehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Kirschbaum\PowerJoins\PowerJoins;

class Job extends Model
{
    use HasFactory, PowerJoins;

    /**
     * Statuses that are considered completed.
     *
     * @var array
     */
    const STATUS_COMPLETED = [4, 5, 6, 7, 13];

    /**
     * Statuses that are considered not complete.
     *
     * @var array
     */
    const STATUS_INCOMPLETE = [1, 2, 8, 9, 10, 11, 12];

    /**
     * Job descriptions.
     *
     * @var array
     */
    const JOB_STATUS_DESCRIPTIONS = [
        1 => 'Posted',
        2 => 'Assigned',
        8 => 'Returned',
        9 => 'Returned',
        10 => 'Not Started',
        11 => 'Removed',
        12 => 'Pending Acceptance',
    ];

    /**
    * Create a new Eloquent model instance.
    *
    * @param array $attributes
    * @return void
    */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->setConnection(config('database.dw_default'));
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'axxesscare_Jobs';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'Id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    // Relationships

    /**
     * Get the applications for the jobs.
     */
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'JobId', 'Id');
    }

    /**
     * Get the professional that owns the job.
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'Id', 'ProfessionalId');
    }

    /**
     * Get the facility that owns the job.
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class, 'FacilityId', 'Id');
    }

    /**
     * Get the pay rates for assigned jobs.
     */
    public function payrates()
    {
        return $this->hasMany(PayRate::class, 'FacilityId', 'FacilityId');
    }

    /**
     * Get the custom jobs rate that assgined to jobs.
     */
    public function customjobrates()
    {
        return $this->hasMany(CustomJobRate::class, 'JobId', 'Id');
    }

    // Accessors & Mutators

    /**
     * Get the date when profile was created.
     *
     * @return  string
     */
    public function getCreatedAttribute($value)
    {
        return Carbon::parse($value)->format('F d, Y'); 
    }

    /**
     * Get the job status description.
     *
     * @return string
     */
    public function getStatusDescriptionAttribute()
    {
        return self::JOB_STATUS_DESCRIPTIONS[$this->Status] ?? '';
    }

    /**
     * Get the complete address.
     *
     * @return string
     */
    public function getAddressAttribute()
    {
        return "{$this->Address1} {$this->city} {$this->state} {$this->zipcode}";
    }


    // Scopes

    /**
     * Scope a query to switch on column qualifying.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeQualifyColumns($query)
    {
        $this->qualify = true;

        return $query;
    }

    /**
     * Scope a query to only include status completed.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatusCompleted($query)
    {
        return $query->whereIn('Status', self::STATUS_COMPLETED);
    }

    /**
     * Scope a query to only include incomplete status..
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIdentifyIncompleteStatus($query)
    {
        $jobs = (new Job)->getTable();

        return $query->whereIn("{$jobs}.Status", self::STATUS_INCOMPLETE);
    }
}
