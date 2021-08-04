<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAxxesscareCustomJobRatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('axxesscare_CustomJobRates', function(Blueprint $table)
		{
			$table->char('JobId', 36)->default('');
			$table->integer('Role');
			$table->decimal('Rate', 18);
			$table->primary(['JobId','Role','Rate']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('axxesscare_CustomJobRates');
	}

}
