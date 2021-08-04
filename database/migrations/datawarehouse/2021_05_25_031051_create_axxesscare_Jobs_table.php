<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAxxesscareJobsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('axxesscare_Jobs', function(Blueprint $table)
		{
			$table->char('Id', 36)->default('');
			$table->char('FacilityId', 36)->default('')->index('FacID_IDX');
			$table->char('ClientId', 36)->default('');
			$table->char('ProfessionalId', 36)->default('');
			$table->bigInteger('DisciplineId');
			$table->bigInteger('DisciplineTaskId');
			$table->bigInteger('SpecialityId');
			$table->decimal('VisitRate', 18);
			$table->decimal('MileageRate', 18);
			$table->float('Latitude', 10, 0);
			$table->float('Longitude', 10, 0);
			$table->integer('Status');
			$table->dateTime('VisitDate');
			$table->dateTime('Created');
			$table->dateTime('Modified');
			$table->string('Discipline', 50)->nullable();
			$table->string('DisciplineTask');
			$table->string('Specialty');
			$table->string('Description', 1024)->nullable();
			$table->string('Comments', 1024)->nullable();
			$table->dateTime('PaidDate');
			$table->decimal('PaidAmount', 18);
			$table->string('AssetIds', 1024)->nullable();
			$table->string('Address1', 100)->nullable();
			$table->string('Address2', 100)->nullable();
			$table->string('City', 100)->nullable();
			$table->string('State', 2)->nullable();
			$table->string('Zipcode', 5)->nullable();
			$table->string('PostedBy', 100)->nullable();
			$table->integer('FacilityReviewStatus');
			$table->integer('ProfessionalReviewStatus');
			$table->string('CheckoutDevice', 100)->nullable();
			$table->string('DeviceOs', 100)->nullable();
			$table->char('ProfessionalSignatureAssetId', 36)->default('');
			$table->dateTime('QaExpiration');
			$table->char('EventId', 36)->default('');
			$table->char('EpisodeId', 36)->default('');
			$table->boolean('VisitChanged');
			$table->boolean('PrivateJob')->nullable();
			$table->primary(['Id','FacilityId']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('axxesscare_Jobs');
	}

}
