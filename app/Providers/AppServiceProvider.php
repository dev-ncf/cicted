<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
    use App\Models\Submission;
use App\Models\Review;
use App\Models\ThematicArea;

use App\Policies\SubmissionPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\ThematicAreaPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
protected $policies = [
    Submission::class   => SubmissionPolicy::class,
    Review::class       => ReviewPolicy::class,
    ThematicArea::class => ThematicAreaPolicy::class,
];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
       
    }



}
