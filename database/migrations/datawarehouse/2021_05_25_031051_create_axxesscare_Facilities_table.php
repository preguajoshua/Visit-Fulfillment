<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAxxesscareFacilitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('axxesscare_Facilities', function(Blueprint $table)
		{
			$table->char('Id', 36)->default('')->primary();
			$table->string('Name', 100);
			$table->char('ContactPersonId', 36)->default('');
			$table->string('TaxId', 10);
			$table->string('TaxIdType', 50)->nullable();
			$table->string('NationalProviderNumber', 10)->nullable();
			$table->integer('Status');
			$table->dateTime('Created');
			$table->dateTime('Modified');
			$table->boolean('IsDeprecated');
			$table->string('Software', 200)->nullable();
			$table->integer('ClusterId');
			$table->char('Identity_Id', 36)->nullable()->index('IX_Identity_Id');
			$table->string('FacilityPaymentAccountId', 100)->nullable()->unique('IX_FacilityPaymentAccountId');
			$table->decimal('TransactionFee', 18);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('axxesscare_Facilities');
	}

}
