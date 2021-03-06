<?php

namespace App\Console\Commands\Custom\Setup;

use Illuminate\Console\Command;

class Database extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:db';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Database Connection using Artisan Command';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment(' Setup Database Configuration in Env..');

        $connection = $this->ask('What is your connection type?', 'mysql');
        $host       = $this->ask('What is your database host?', '127.0.0.1');
        $port       = $this->ask('What is your database port?', 3306);
        $database   = $this->ask('What is your database name?', 'my_db');
        $username   = $this->ask('What is your database user?', 'root');

        $password   = $this->secret('What is your database user\'s password?', '');

        $default_connection = $this->laravel['config']['database.default'];
        $connection_details = $this->laravel['config']['database.connections.' . $default_connection];

        file_put_contents($this->laravel->environmentFilePath(), str_replace(
            [
                'DB_CONNECTION=' . $default_connection,
                'DB_HOST=' . $connection_details['host'],
                'DB_PORT=' . $connection_details['port'],
                'DB_DATABASE=' . $connection_details['database'],
                'DB_USERNAME=' . $connection_details['username'],
                'DB_PASSWORD=' . $connection_details['password'],
            ],
            [
                'DB_CONNECTION=' . $connection,
                'DB_HOST=' . $host,
                'DB_PORT=' . $port,
                'DB_DATABASE=' . $database,
                'DB_USERNAME=' . $username,
                'DB_PASSWORD=' . $password,
            ],
            file_get_contents($this->laravel->environmentFilePath())
        ));

        $this->call('cache:clear'); // clear up cache
        $this->comment(' Setup Database Completed..');

//        if ($this->confirm('Do you want to run migration?')) {
//            $this->comment(' Migrating..');
//            $this->call('migrate');
//        }
//
//        if ($this->confirm('Do you want to run data seeder?')) {
//            $this->comment(' Seeding..');
//            $this->call('db:seed');
//        }
    }
}