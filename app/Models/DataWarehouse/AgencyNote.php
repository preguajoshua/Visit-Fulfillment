<?php

namespace App\Models\DataWarehouse;

use Kirschbaum\PowerJoins\PowerJoins;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgencyNote extends Model
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
    protected $table = 'axxesscarevisitfulfillment_agencynotes';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'FacilityID';

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
     * Rating descriptions.
     *
     * @var array
     */
    const RATING_DESCRIPTIONS = [
        1 => 'poor',
        2 => 'poor',
        3 => 'poor',
        4 => 'poor',
        5 => 'neutral',
        6 => 'neutral',
        7 => 'neutral',
        8 => 'good',
        9 => 'good',
        10 => 'good',
    ];

    
    // Relationships

    /**
     * Get the facilities that owns the notes.
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class, 'Id', 'FacilityID');
    }


    // Accessors & Mutators

    /**
     * Get the rating description.
     *
     * @return string
     */
    public function getRatingDescriptionAttribute()
    {
        return self::RATING_DESCRIPTIONS[$this->Rating] ?? '';
    }


    // Methods

    /**
     * Convert the given rating description into a range of ratings.
     *
     * @param   string  $description
     * @return  array
     */
    public static function ratingRangeFromDescription($description)
    {
        return collect(self::RATING_DESCRIPTIONS)
            ->filter(function ($range) use ($description) {
                return $range == $description;
            })
            ->keys()
            ->all();
    }
}