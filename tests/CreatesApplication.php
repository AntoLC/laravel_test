<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();
        //$this->createDBTest();
        
        return $app;
    }

    public function createDBTest(){
        $connectionName = config('database.default');
        //$databaseName = config("database.connections.{$connectionName}.database");

        // Set the database name to null so DB commands connect to raw mysql, not a database.
        config(["database.connections.mysql.database" => null]);
        //DB::statement('CREATE DATABASE :schema', array('schema' => env('DB_DATABASE')));
        DB::statement('CREATE DATABASE IF NOT EXISTS RestfulAPIBDTest');
    }
}
