<?php

namespace App\Models\DataWarehouse;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfessionalNote extends Model
{
    use HasFactory;

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
    protected $table = 'axxesscare_professionalnotes';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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
     * Get the professional that owns the note.
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'Id', 'ProfessionalID');
    }


    // Accessors & Mutators

    /**
     * Get the last contacted date as a difference for humans.
     *
     * @return string
     */
    public function getVisitedAgoAttribute()
    {
        return ($this->LastContacted)
            ? Carbon::parse($this->LastContacted)->diffForHumans()
            : '';
    }

    /**
     * Get the formatted last contacted date.
     *
     * @return string
     */
    public function getLastContactedDateAttribute()
    {
        return Carbon::parse($this->LastContacted)->format('F d, Y');
    }

    /**
     * Indicates if star responder.
     *
     * @return bool
     */
    public function getStarResponderAttribute()
    {
        return ($this->isStarResponder == 1) ? true : false;
    }

    /**
     * Indicates if 'Paused'.
     *
     * @return bool
     */
    public function getPausedAttribute()
    {
        return ($this->IsPaused == 1) ? true : false;
    }

    /**
     * Indicates 'Do Not Contact'.
     *
     * @return bool
     */
    public function getDncAttribute()
    {
       return ($this->IsDnc == 1) ? true : false;
    }

    /**
     * Indicates if there's a 'Technical Issue'.
     *
     * @return bool
     */
    public function getTechIssueAttribute()
    {
        return ($this->IsTechIssue == 1) ? true : false;
    }

    /**
     * Indicates if is an 'Axxessian'.
     *
     * @return bool
     */
    public function getAxxessianAttribute()
    {
        return ($this->isAxxessian == 1) ? true : false;
    }

    /**
     * Get the rating description.
     *
     * @return string
     */
    public function getRatingDescriptionAttribute()
    {
        return self::RATING_DESCRIPTIONS[$this->Rating] ?? '';
    }


    // Scopes

    /**
     * Scope a query to only include non-axxessians.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNonAxxessian($query)
    {
        return $query->where(function ($query) {
            $query->where('isAxxessian', 0)->orWhereNull('isAxxessian');
        });
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
