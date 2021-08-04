<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAxxesscareIdentitiesTable extends Migration
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
        Schema::connection($this->connection)->create('axxesscare_Identities', function (Blueprint $table) {
            $table->char('Id', 36)->default('');
			$table->char('EntityId', 36)->default('')->index('Entid_idx');
			$table->string('DisplayName');
			$table->integer('Type');
			$table->string('AddressLine1', 160)->nullable();
			$table->string('AddressLine2', 80)->nullable();
			$table->string('City', 80)->nullable();
			$table->string('StateCode', 2)->nullable();
			$table->string('ZipCode', 10);
			$table->string('PhoneNumber', 16)->nullable();
			$table->integer('Status');
			$table->dateTime('Created');
			$table->boolean('IsAxxess');
			$table->primary(['Id','EntityId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('axxesscare_Identities');
    }
}
