<?php

namespace App\Models\DataWarehouse;

use Kirschbaum\PowerJoins\PowerJoins;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgencyLocation extends Model
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
    protected $table = 'agencymanagement_combined_agencylocations';

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
     * Get the facility associated with the agency location.
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class, 'Id', 'AgencyId');
    }


    // Accessors & Mutators

    /**
     * Get the complete address.
     *
     * @return string
     */
    public function getAddressAttribute()
    {
        return "{$this->AddressLine1} {$this->AddressLine2} {$this->AddressCity} {$this->AddressStateCode} {$this->AddressZipCode} {$this->AddressZipCodeFour}";
    }

     /**
     * Get the formatted phone number.
     *
     * @return string
     */
    public function getPhoneWorkAttribute($value)
    {
        $digits = preg_replace('/[^\d]/', '', $value);

        return (strlen($digits) === 10)
            ? preg_replace('/^1?(\d{3})(\d{3})(\d{4})$/', '$1-$2-$3', $digits)
            : $digits;
    }
}