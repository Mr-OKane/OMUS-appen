<?php

namespace App\Console\Commands;

use App\Models\CakeArrangement;
use App\Models\PracticeDate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MakeCakeArrangement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cakeArrangement {do=make}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'creates a list of 2 people per practice date to bring cake that day.';

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
     * @return int
     */
    public function handle()
    {
        switch ($this->argument('do')) {
            case 'make':
                $this->make();
                break;
            case 'remove':
                $this->remove();
                break;
            default:
                $this->info('Select either make or remove');
                break;
        }
    }

    private function make(){
        $practiceDates = PracticeDate::withoutTrashed()->get();

        foreach ($practiceDates as $practiceDate)
        {

            $users = $this->cakeArrangementUserCount();
            foreach ($users as $user){

                $cakeArrangement = new CakeArrangement();
                $cakeArrangement->user()->associate($user);
                $cakeArrangement->practiceDate()->associate($practiceDate);

                $cakeArrangement->save();
            }
        }

    }

    private function cakeArrangementUserCount()
    {
        $userWithLessThen2Count = User::withoutTrashed()->with('cakeArrangements', function ($query) {
                $year = Carbon::now()->year;
                $startDate = Carbon::createFromDate($year,7,1,'Europe/Copenhagen');
                $endDate = Carbon::createFromDate($year+1,6,31,'Europe/Copenhagen');

                $query->where('cake_arrangements.created_at','BETWEEN', [$startDate, $endDate]);
        })
                ->withCount('cakeArrangements')
                ->has('cakeArrangements', '<', 2)
                ->get();

        return $userWithLessThen2Count->random(2);

    }

    private function remove(){

    }

    /**
     * executes commands into terminal
     */
    private function command($cmd)
    {
        return exec($cmd);
    }
}
