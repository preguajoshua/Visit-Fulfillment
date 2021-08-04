<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAxxesscarevisitfulfillmentFollowupTable extends Migration {

	/**
     * The database schema.
     *
     * @var string
     */
    protected $connection;

    /**
     * Create a new migration instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->connection = config('database.dw_default');
    }
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection($this->connection)->create('axxesscarevisitfulfillment_followup', function(Blueprint $table)
		{
			$table->char('ID', 38)->unique('ID_UNIQUE');
			$table->char('EntityId', 38);
			$table->char('UserId', 38);
			$table->text('FollowUpDetail', 16777215)->nullable();
			$table->date('FollowUpDate')->nullable();
			$table->integer('Type')->nullable()->default(0);
			$table->timestamp('Created')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('isDeprecated')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection($this->connection)->dropIfExists('axxesscarevisitfulfillment_followup');
	}

}
