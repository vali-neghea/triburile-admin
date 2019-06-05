<?php


namespace App\Jobs;


use App\Console\Commands\CronTest;

class TestJob extends Job
{
    protected $cronTest;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CronTest $cronTest)
    {
        $this->cronTest = $cronTest;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->cronTest->handle();
    }
}