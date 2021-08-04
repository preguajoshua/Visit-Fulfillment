<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAxxesscareVisitnotesTable extends Migration
{
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
		Schema::connection($this->connection)->create('axxesscare_visitnotes', function(Blueprint $table) {
			$table->char('id', 38)->primary();
			$table->string('JobID', 45)->nullable()->unique('JobID_UNIQUE');
			$table->text('Note', 16777215)->nullable();
			$table->integer('isUnderstaffed')->nullable()->default(0);
			$table->integer('isLowvisitrate')->nullable()->default(0);
			$table->integer('isRescheduleremove')->nullable()->default(0);
			$table->integer('isAttemptedFulfillment')->nullable()->default(0);
			$table->timestamp('Modified')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection($this->connection)->drop('axxesscare_visitnotes');
	}
}
