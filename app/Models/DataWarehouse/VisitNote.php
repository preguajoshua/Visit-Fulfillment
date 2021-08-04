<?php

namespace App\Models\DataWarehouse;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitNote extends Model
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
    protected $table = 'axxesscare_visitnotes';
 
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
}
