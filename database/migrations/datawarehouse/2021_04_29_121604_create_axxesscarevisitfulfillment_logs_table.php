<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAxxesscarevisitfulfillmentLogsTable extends Migration {

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
		Schema::connection($this->connection)->create('axxesscarevisitfulfillment_logs', function(Blueprint $table)
		{
			$table->char('Id', 38)->primary();
			$table->char('EntityId', 38);
			$table->char('UserId', 38);
			$table->text('Log', 16777215)->nullable();
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
		Schema::connection($this->connection)->dropIfExists('axxesscarevisitfulfillment_logs');
	}

}
