<?php

namespace App\Models\DataWarehouse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Models\User;

class Log extends Model
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
    protected $table = 'axxesscarevisitfulfillment_logs';

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
     * Get the professional that owns the clinician log.
     */
    public function professional()
    {
        return $this->belongsTo(Professional::class, 'Id', 'EntityId');
    }

    /**
     * Get the facility that owns the clinician log.
     */
    public function facility()
    {
        return $this->belongsTo(Professional::class, 'Id', 'EntityId');
    }



    // Accessors & Mutators

    /**
     * Get the formatted date that the log was created.
     *
     * @return string
     */
    public function getCreatedAttribute($value)
    {
        return Carbon::parse($value)->format('F d, Y h:i A');
    }

    /**
     * Get the name of the user.
     *
     * @return string
     */
    public function getUsernameAttribute()
    {
        $user = User::where('id', $this->UserId)->first();

        return ($user) ? $user->name : 'Unknown';
    }


    // Scopes

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('isDeprecated', 0);
    }


    // Methods

    /**
     * Depricate the log instance.
     *
     * @return  void
     */
    public function deprecate(): void
    {
        $this->update([
            'isDeprecated' => 1,
        ]);
    }
}
