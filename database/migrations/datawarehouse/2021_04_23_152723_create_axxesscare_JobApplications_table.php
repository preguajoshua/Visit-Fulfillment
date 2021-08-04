<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAxxesscareJobApplicationsTable extends Migration {

	 /**
     * The database schema.
     *
     * @var string
     */
    protected $connection;

    /**
     * Create a new migration instance.
	 * 
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
		Schema::connection($this->connection)->create('axxesscare_JobApplications', function(Blueprint $table)
		{
			$table->char('Id', 36)->default('')->primary();
			$table->char('JobId', 36)->default('')->index('IDX_JOB');
			$table->char('ProfessionalId', 36)->default('')->index('ProfID_IDX');
			$table->integer('Status');
			$table->boolean('HasWorkedWithPatient');
			$table->boolean('HasWorkedWithFacility');
			$table->dateTime('Created');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::connection($this->connection)->dropIfExists('axxesscare_JobApplications');
	}

}
