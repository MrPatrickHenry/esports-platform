<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->adminAPIRoutes();

        $this->userAPIRoutes();

        $this->tournamentsAPIRoutes();

        $this->arcadeAPIRoutes();

        $this->teamsRosterAPIRoutes();
    }

    /**
     * Define the "Admin and future SASS" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */

protected function adminAPIRoutes()
{
Route::prefix('api/v2/admin')
            ->middleware('auth:api')
            ->namespace('App\Http\Controllers')
            ->group(function () {
                require base_path('routes/v2/_admin.php');
            });
}


protected function userAPIRoutes()
{
Route::prefix('api/v2/user')
            ->middleware('auth:api')
            ->namespace('App\Http\Controllers')
            ->group(function () {
                require base_path('routes/v2/user.php');
            });
}

protected function developerAPIRoutes()
{
Route::prefix('api/v2/developer')
            ->middleware('auth:api')
            ->namespace('App\Http\Controllers')
            ->group(function () {
                require base_path('routes/v2/developer.php');
            });
}


protected function arcadeAPIRoutes()
{
Route::prefix('api/v2/arcade')
            ->middleware('auth:api')
            ->namespace('App\Http\Controllers')
            ->group(function () {
                require base_path('routes/v2/arcade.php');
            });
}

protected function tournamentsAPIRoutes()
{
Route::prefix('api/v2/tournaments')
            ->middleware('auth:api')
            ->namespace('App\Http\Controllers')
            ->group(function () {
                require base_path('routes/v2/tournaments.php');
            });
}


protected function teamsRosterAPIRoutes()
{
Route::prefix('api/v2/teams')
            ->middleware('auth:api')
            ->namespace('App\Http\Controllers')
            ->group(function () {
                require base_path('routes/v2/team.php');
            });
}


    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
