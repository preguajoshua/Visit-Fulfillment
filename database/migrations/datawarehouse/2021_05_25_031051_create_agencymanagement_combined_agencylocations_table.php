<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgencymanagementCombinedAgencylocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agencymanagement_combined_agencylocations', function(Blueprint $table)
		{
			$table->char('Id', 36)->primary();
			$table->char('AgencyId', 36)->index('Agency_IDX');
			$table->string('Name', 100);
			$table->string('FullName', 100)->nullable();
			$table->string('CustomId', 15)->nullable();
			$table->char('MedicareProviderNumber', 10)->nullable();
			$table->string('AddressLine1', 100);
			$table->string('AddressLine2', 100)->nullable();
			$table->string('AddressCity', 100);
			$table->char('AddressStateCode', 2);
			$table->char('AddressZipCode', 5);
			$table->char('AddressZipCodeFour', 4)->nullable();
			$table->char('ZipNineStatus', 1)->nullable()->default('P');
			$table->char('PhoneWork', 10)->nullable();
			$table->char('FaxNumber', 10)->nullable();
			$table->date('TrackingNumberEffectiveDate')->nullable();
			$table->boolean('IsMainOffice');
			$table->boolean('IsTrackingNumberRequired')->default(0);
			$table->date('Created');
			$table->string('TimeZone', 45)->default('Central Standard Time');
			$table->date('Modified');
			$table->text('Cost', 16777215)->nullable();
			$table->text('BillData', 16777215)->nullable();
			$table->boolean('IsDeprecated')->default(0);
			$table->char('TaxId', 10)->nullable();
			$table->string('TaxIdType', 50)->nullable();
			$table->char('NationalProviderNumber', 10)->nullable();
			$table->string('HomeHealthAgencyId', 20)->nullable();
			$table->string('ContactPersonFirstName', 100)->nullable();
			$table->string('ContactPersonLastName', 100)->nullable();
			$table->string('ContactPersonEmail', 100)->nullable();
			$table->string('ContactPersonPhone', 100)->nullable();
			$table->boolean('IsAxxessTheBiller')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agencymanagement_combined_agencylocations');
	}

}