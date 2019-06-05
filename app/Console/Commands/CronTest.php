<?php


namespace App\Console\Commands;


use App\User;
use Illuminate\Console\Command;

class CronTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
    */
    protected $signature = 'command:crontest';

    /**
     * The console command description.
     *
     * @var string
    */
    protected $description = 'Command description';

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
        $user = User::find(11);
        $user->x_coordinates += 1;
        $user->save();
    }
}