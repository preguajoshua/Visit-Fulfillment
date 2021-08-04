<?php

namespace App\Models\DataWarehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    use HasFactory;

    /**
     * US states in which the service is in use.
     *
     * @var array
     */
    const PARTICIPATING_STATES = [
        'TX',
        'IL',
        'MA',
        'FL',
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
    protected $table = 'axxesscare_Identities';

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
     * Get the professional that owns the identity.
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'Id', 'EntityId');
    }


    // Accessors & Mutators

    /**
     * Get the formatted phone number.
     *
     * @return string
     */
    public function getPhoneNumberAttribute($value)
    {
        $digits = preg_replace('/[^\d]/', '', $value);

        return (strlen($digits) === 10)
            ? preg_replace('/^1?(\d{3})(\d{3})(\d{4})$/', '$1-$2-$3', $digits)
            : $digits;
    }

    /**
     * Get the full address.
     *
     * @return string
     */
    public function getAddressAttribute()
    {
        $addressLine = ($this->AddressLine2) 
            ? "{$this->AddressLine1}, {$this->AddressLine2}"
            : $this->AddressLine1;

        return "{$addressLine}, {$this->City}, {$this->StateCode} {$this->ZipCode}";
    }


    // Scopes

    /**
     * Scope a query to only include participating states.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParticipatingState($query)
    {
        return $query->whereIn('StateCode', self::PARTICIPATING_STATES);
    }
}
