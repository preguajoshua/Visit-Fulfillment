<?php

namespace App\Models\DataWarehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalRole extends Model
{
    use HasFactory;

    /**
     * Professional roles.
     *
     * @var array
     */
    const ROLES = [
        0 => 'None',
        1 => 'NP',
        2 => 'LPN',
        3 => 'LVN',
        4 => 'MSN',
        5 => 'RN',
        6 => 'BSN',
        7 => 'PT',
        8 => 'PTA',
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
    protected $table = 'axxesscare_ProfessionalRoles';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'Id';

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

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
     * Get the professional that owns the role.
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'Id', 'ProfessionalId');
    }


    // Accessors & Mutators

    /**
     * Get the role description.
     *
     * @return  string
     */
    public function getRoleAttribute($value)
    {
        return (array_key_exists($value, self::ROLES))
            ? self::ROLES[$value]
            : $value;
    }
}
