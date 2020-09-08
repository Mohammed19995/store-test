<?php
/**
 * Created by PhpStorm.
 * User: Al
 * Date: 13/6/2020
 * Time: 05:15 م
 */

namespace App\Services\Firebase;

use Kreait\Firebase\Factory;


class FirebaseService
{

    public $factory;
    public $database;
    public $messaging;
    public $notification;

    public function __construct()
    {
        $this->factory = (new Factory)
            ->withServiceAccount(public_path().'/firebase_credentials/larattest-firebase-adminsdk-sunn4-fc43f01b8d.json')
            ->withDatabaseUri(env('FIRBASE_DATABASE_URL'));

        $this->database = $this->factory->createDatabase();
        $this->messaging  = $this->factory->createMessaging();
    }

}