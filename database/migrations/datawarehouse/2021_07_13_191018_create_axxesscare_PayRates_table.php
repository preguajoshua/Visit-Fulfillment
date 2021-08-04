<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAxxesscarePayRatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('axxesscare_PayRates', function(Blueprint $table)
		{
			$table->char('Id', 36)->default('')->primary();
			$table->char('FacilityId', 36)->default('')->index('IX_FacilityId');
			$table->decimal('RnCost', 18);
			$table->decimal('LvnLpnCost', 18);
			$table->decimal('HhaCost', 18);
			$table->decimal('MswCost', 18);
			$table->decimal('PtCost', 18);
			$table->decimal('OtCost', 18);
			$table->decimal('PerMileReimbursement', 18);
			$table->decimal('SupppliesAllowance', 18);
			$table->decimal('RuralJobAllowance', 18);
			$table->dateTime('Created');
			$table->dateTime('Modified');
			$table->decimal('PtaCost', 18);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('axxesscare_PayRates');
	}

}
