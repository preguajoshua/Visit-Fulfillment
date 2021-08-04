<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Register any custom database migration paths that use the "testing" database.
         */
        if (App::environment('testing')) {
            $this->loadMigrationsFrom([
                database_path('migrations/datawarehouse'),
            ]);
        }

        /**
         * Get one random value from an array, biased by the given weightings.
         * eg: ['A' => 5, 'B' => 45, 'C' => 50]
         */
        Arr::macro('randomWeighted', function ($value) {
            $rand = mt_rand(1, (int) array_sum($value));

            foreach ($value as $key => $weight) {
                $rand -= $weight;

                if ($rand <= 0) {
                    return $key;
                }
            }
        });
    }
}
