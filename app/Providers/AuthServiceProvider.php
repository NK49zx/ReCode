<?php

namespace App\Providers;

use App\Models\Answer;
use App\Policies\AnswerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // ...existing policies...
        Answer::class => AnswerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('update-answer', [AnswerPolicy::class, 'updateAnswer']);
        Gate::define('delete-answer', [AnswerPolicy::class, 'deleteAnswer']);
        Gate::define('accept-answer', [AnswerPolicy::class, 'acceptAnswer']);
    }
}