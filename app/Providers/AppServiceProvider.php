<?php

namespace App\Providers;

use App\Repository\Interfaces\StudentPromotionInterface;
use App\Repository\Interfaces\StudentRepositoryInterface as InterfacesStudentRepositoryInterface;
use App\Repository\StudentPromotionRepo;
use App\Repository\StudentRepository;
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
        $this->app->bind(InterfacesStudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(StudentPromotionInterface::class, StudentPromotionRepo::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
