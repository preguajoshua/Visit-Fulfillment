<?php

namespace App\Models\DataWarehouse;

use Illuminate\Support\Carbon;
use Kirschbaum\PowerJoins\PowerJoins;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facility extends Model
{
    use HasFactory, PowerJoins;

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
    protected $table = 'axxesscare_Facilities';

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
     * Get the notes associated with the facilities.
     */
    public function note()
    {
        return $this->hasOne(AgencyNote::class, 'FacilityID', 'Id');
    }

    /**
     * Get the agency location associated with the facilities.
     */
    public function location()
    {
        return $this->hasOne(AgencyLocation::class, 'AgencyId', 'Id');
    }

    /**
     * Get the jobs associated with the facilities.
     */
    public function jobs()
    {
        return $this->hasMany(Job::class, 'FacilityId', 'Id');
    }

    /**
     * Get the logs associated with the facilities.
     */
    public function logs()
    {
        return $this->hasMany(Log::class, 'EntityId', 'Id');
    }

    /**
     * Get the follow-up of the facilities.
     */
    public function followUps()
    {
        return $this->hasMany(FollowUp::class, 'EntityId', 'Id');
    }
    
    /**
     * Get the payrates that assgined to facility.
    */
    public function payrates()
    {
        return $this->hasOne(PayRate::class, 'FacilityId', 'Id');
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
     * Scope a query to filter note attributes.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterAgencyNoteAttributes($query, array $filters)
    {
        $note = (new AgencyNote)->getTable();

        $query
            // Ratings
            ->when($filters['rating'], function ($query, $ratingDescription) use ($note) {
                $query->whereIn("{$note}.Rating", AgencyNote::ratingRangeFromDescription($ratingDescription));
            });
    }


    // Accessors & Mutators

    /**
     * Get the First posting date.
     *
     * @return  string
     */
    public function getFirstPostDateAttributes()
    {
        return Carbon::parse("{$this->FirstPostDate}")->format('m-d-Y');
    }

    /**
     * Get the Last posting date.
     *
     * @return  string
     */
    public function getLastPostDateAttributes()
    {
        return Carbon::parse("{$this->LastPostDate}")->format('m-d-Y');
    }
}