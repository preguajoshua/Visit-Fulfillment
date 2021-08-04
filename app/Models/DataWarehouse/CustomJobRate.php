<?php

namespace App\Models\DataWarehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Models\User;

class CustomJobRate extends Model
{
    use HasFactory;

    /**
     * Job role.
     *
     * @var array
     */
    const ROLE_DESCRIPTION = [
        0 => 'Custom RN',
        1 => 'Custom LVN',
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
    protected $table = 'axxesscare_CustomJobRates';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'JobId';

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
     * Get the job assigned to a custom job pay rates.
    */
    public function job()
    {
        return $this->belongsTo(Job::class, 'JobId', 'JobId');
    }


    // Accessors & Mutators

    /**
     * Get the job status description.
     *
     * @return string
     */
    public function getRoleDescriptionAttribute()
    {
        return self::ROLE_DESCRIPTION[$this->Role] ?? '';
    }
   
}