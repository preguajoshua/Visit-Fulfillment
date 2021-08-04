<?php

namespace App\Models\DataWarehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Kirschbaum\PowerJoins\PowerJoins;

class Professional extends Model
{
    use HasFactory, PowerJoins;

    /**
     * Professional status.
     *
     * @var array
     */
    const STATUSES = [
        1 => 'Profile Started',
        2 => 'Profile Started',
        3 => 'Profile Started',
        4 => 'Profile Started',
        5 => 'Pending Background Check',
        6 => 'Approved',
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
    protected $table = 'axxesscare_Professionals';

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

    /**
     * When true, will qualify columns with the table name.
     *
     * @var  boolean
     */
    protected $qualify = false;


    // Relationships

    /**
     * Get the identity associated with the professional.
     */
    public function identity()
    {
        return $this->hasOne(Identity::class, 'EntityId', 'Id');
    }

    /**
     * Get the note associated with the professional.
     */
    public function note()
    {
        return $this->hasOne(ProfessionalNote::class, 'ProfessionalID', 'Id')->withDefault([
            'id' => '00000000-0000-0000-0000-000000000000',
        ]);
    }

    /**
     * Get the roles for the professional.
     */
    public function roles()
    {
        return $this->hasMany(ProfessionalRole::class, 'ProfessionalId', 'Id');
    }

    /**
     * Get the job applications of the professional.
     */
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'ProfessionalId', 'Id');
    }

    /**
     * Get the jobs of the professional.
     */
    public function jobs()
    {
        return $this->hasMany(Job::class, 'ProfessionalId', 'Id');
    }

    /**
     * Get the follow-up of the professional.
     */
    public function followUps()
    {
        return $this->hasMany(FollowUp::class, 'EntityId', 'Id');
    }

    /**
     * Get the logs of the professional.
     */
    public function logs()
    {
        return $this->hasMany(Log::class, 'EntityId', 'Id');
    }


    // Accessors & Mutators

    /**
     * Get the clinicians full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->FirstName} {$this->LastName}";
    }

    /**
     * Get the status description.
     *
     * @return string
     */
    public function getStatusAttribute($value)
    {
        return (array_key_exists($value, self::STATUSES))
            ? self::STATUSES[$value]
            : $value;
    }

    /**
     * Get the formatted date that the profile was created.
     *
     * @return string
     */
    public function getCreatedAttribute($value)
    {
        return Carbon::parse($value)->format('F d, Y');
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
     * Scope a query to only include valid status codes.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValidStatus($query)
    {
        $statusColumn = ($this->qualify) ? "{$this->table}.Status" : 'Status';

        return $query->whereIn($statusColumn, array_keys(self::STATUSES));
    }

    /**
     * Scope a query to sort by name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortByName($query)
    {
        $firstNameColumn = ($this->qualify) ? "{$this->table}.FirstName" : 'FirstName';
        $lastNameColumn = ($this->qualify) ? "{$this->table}.LastName" : 'LastName';

        return $query->orderBy($firstNameColumn)->orderBy($lastNameColumn);
    }


    // Foreign Scopes

    /**
     * Scope a query to only include participating states.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIdentityParticipatingState($query)
    {
        $identity = (new Identity)->getTable();

        return $query->whereIn("{$identity}.StateCode", Identity::PARTICIPATING_STATES);
    }

    /**
     * Scope a query to only include non-axxessians.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNoteNonAxxessian($query)
    {
        $note = (new ProfessionalNote)->getTable();

        return $query->where(function ($query) use ($note) {
            $query->where("{$note}.isAxxessian", 0)->orWhereNull("{$note}.isAxxessian");
        });
    }

    /**
     * Scope a query to filter note attributes.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterNoteAttributes($query, array $filters)
    {
        $note = (new ProfessionalNote)->getTable();

        $query
            // Badges
            ->when($filters['starResponder'], function ($query, $starResponder) use ($note) {
                $query->where("{$note}.isStarResponder", $starResponder);
            })
            ->when($filters['technicalIssue'], function ($query, $technicalIssue) use ($note) {
                $query->where("{$note}.IsTechIssue", $technicalIssue);
            })
            ->when($filters['paused'], function ($query, $paused) use ($note) {
                $query->where("{$note}.IsPaused", $paused);
            })
            ->when($filters['doNotContact'], function ($query, $doNotContact) use ($note) {
                $query->where("{$note}.IsDnc", $doNotContact);
            })
            // Ratings
            ->when($filters['rating'], function ($query, $ratingDescription) use ($note) {
                $query->whereIn("{$note}.Rating", ProfessionalNote::ratingRangeFromDescription($ratingDescription));
            });
    }

    /**
     * Scope a query to order the professionals.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $orderBy
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderClinicianResults($query, string $orderBy)
    {
        if ($orderBy === 'name') {
            $query->sortByName();

        } elseif ($orderBy === 'lastContacted') {
            $note = (new ProfessionalNote)->getTable();

            $query->orderByDesc("{$note}.LastContacted");
        }
    }
}
