<?php

namespace App\Providers;

use App\Services\FileService;
use App\Services\Firebase\FirebaseNotification;
use App\Services\Firebase\FirebaseRealTimeDatabase;
use App\Services\Firebase\FirebaseService;
use App\Services\Tree\SWWWTreeTraversal;
use Illuminate\Support\ServiceProvider;

class FacadeProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // firebase
        $this->app->bind('firebase-realtime-Service' ,FirebaseRealTimeDatabase::class);
        $this->app->bind('firebase-notification-Service' ,FirebaseNotification::class);

        // file facade
        $this->app->bind('file-Service' ,function (){
            return new FileService();
        });


    }
}
