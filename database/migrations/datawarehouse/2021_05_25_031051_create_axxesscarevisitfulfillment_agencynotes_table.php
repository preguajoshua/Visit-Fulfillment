<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAxxesscarevisitfulfillmentAgencynotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('axxesscarevisitfulfillment_agencynotes', function(Blueprint $table)
		{
			$table->char('id', 38)->primary();
			$table->string('FacilityID', 45)->nullable()->unique('Facility_UNIQUE');
			$table->text('Note', 16777215)->nullable();
			$table->integer('IsDnc')->nullable()->default(0);
			$table->integer('IsPaused')->nullable()->default(0);
			$table->integer('Rating')->nullable()->default(0);
			$table->timestamp('Modified')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->dateTime('LastContacted')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('axxesscarevisitfulfillment_agencynotes');
	}

}
