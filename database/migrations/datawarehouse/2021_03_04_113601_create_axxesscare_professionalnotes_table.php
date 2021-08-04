<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAxxesscareProfessionalNotesTable extends Migration
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
        Schema::connection($this->connection)->create('axxesscare_professionalnotes', function (Blueprint $table) {
            $table->char('id', 38)->primary();
			$table->string('ProfessionalID', 45)->nullable()->unique('ProfessionalID_UNIQUE');
			$table->text('Note', 16777215)->nullable();
			$table->integer('IsDnc')->nullable()->default(0);
			$table->integer('IsPaused')->nullable()->default(0);
			$table->integer('IsTechIssue')->nullable()->default(0);
			$table->integer('isAxxessian')->nullable()->default(0);
			$table->integer('isStarResponder')->nullable();
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
        Schema::connection($this->connection)->dropIfExists('axxesscare_professionalnotes');
    }
}
