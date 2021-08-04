<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAxxesscareProfessionalsTable extends Migration
{
	/**
     * The database connection.
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
        Schema::connection($this->connection)->create('axxesscare_Professionals', function (Blueprint $table) {
            $table->char('Id', 36)->default('')->primary();
			$table->char('ProfilePictureId', 36)->default('');
			$table->string('NPI', 11)->nullable();
			$table->string('DriversLicenseState', 2)->nullable();
			$table->string('YearsOfExperience', 2)->nullable();
			$table->integer('Status');
			$table->boolean('IsDeprecated');
			$table->dateTime('Created');
			$table->dateTime('Modified');
			$table->dateTime('DOB');
			$table->dateTime('DriversLicenseExpiration');
			$table->string('LicenseType', 20)->nullable();
			$table->string('TitleType', 50)->nullable();
			$table->string('TitleTypeOther', 100)->nullable();
			$table->string('FirstName', 100);
			$table->string('LastName', 100);
			$table->string('MiddleName', 50)->nullable();
			$table->text('Languages')->nullable();
			$table->text('Specialties')->nullable();
			$table->boolean('FinishedSignup');
			$table->decimal('MinimumPayRate', 18);
			$table->decimal('MaximumPayRate', 18);
			$table->integer('MaxDistancePreference');
			$table->string('Biography', 750)->nullable();
			$table->string('LinkedInProfileLink', 50)->nullable();
			$table->string('OtherProfessionalLink', 50)->nullable();
			$table->boolean('IsProfilePhotoVerified');
			$table->string('VerificationComment')->nullable();
			$table->char('Identity_Id', 36)->nullable();
			$table->boolean('IsPhoneNumberVerified');
			$table->boolean('RecieveTextMessages');
			$table->float('Rating', 10, 0);
			$table->integer('NumberOfReviewers');
			$table->string('PhoneVerificationTokenId', 25)->nullable();
			$table->string('CheckrCandidateId', 100)->nullable();
			$table->integer('PaymentAccountStatus');
			$table->string('PaymentAccountId', 100)->nullable();
			$table->boolean('MinnesotaOklahomaRecieveCopy');
			$table->boolean('CaliforniaRecieveCopy');
			$table->dateTime('BackgroundComplete');
			$table->dateTime('OigPassDate');
			$table->float('Latitude', 10, 0);
			$table->float('Longitude', 10, 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('axxesscare_Professionals');
    }
}
