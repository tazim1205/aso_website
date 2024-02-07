<?php

use App\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        //25 jobs each of type total 100 jobs creation
        for ($statusCount = 1; $statusCount<=4; $statusCount++){
            for ($jobCount = 1; $jobCount<=25; $jobCount++){
                $job = new \App\CustomerGig();
                $job->customer_id   = 47; //phone 01304734666
                $job->title         = $statusCount.$jobCount.'.- I need to repair my AC model number Walton 5566. #title-'.$jobCount;
                $job->description   = 'A job description or JD is a written narrative that describes the general tasks, or other related duties, and responsibilities of a position. ... A job usually includes several roles. According to Hall, the job description might be broadened to form a person specification or may be known as "terms of reference. #Job description-". '.$jobCount;
                $job->address       = 'Address '.$jobCount;
                $job->service_id    = $jobCount;
                $job->day           = $jobCount;
                $job->budget        = 50+$jobCount;
                if ($statusCount == 1){
                    $job->status     = 'active';
                    $job->save();
                }elseif ($statusCount == 2){
                    $job->status     = 'completed';
                    $job->save();
                }elseif($statusCount == 3){
                    $job->status     = 'running';
                    $job->save();
                }else{
                    $job->status     = 'cancelled';
                    $job->save();
                    $cancelJob = new \App\CancelJob();
                    $cancelJob->type = 'bid';
                    $cancelJob->canceller_id = 47;
                    $cancelJob->job_id = $job->id;
                    $cancelJob->save();
                }
            }
        }
*/

        //10 worker gigs
        for ($counter2 = 1; $counter2<=10; $counter2++){
            for ($counter = 1; $counter<=10; $counter++){
                $gig = new \App\WorkerGig();
                $gig->worker_id = 20+$counter;
                $gig->service_id = $counter;
                $gig->title = 'Worker gig title- '.$counter;
                $gig->description = 'Worker gig description - '.$counter;
                $gig->tags = 'Tag, tag';
                $gig->budget = 500+$counter;
                $gig->day = $counter;
                $gig->save();
            }
        }

        //10 customer gigs
        for ($counter2 = 1; $counter2<=10; $counter2++){
            for ($counter = 1; $counter<=10; $counter++){
                $gig = new \App\CustomerGig();
                $gig->customer_id = 40+$counter;
                $gig->service_id = $counter;
                $gig->title = 'Customer gig title- '.$counter;
                $gig->description = 'Customer gig description - '.$counter;
                $gig->address = 'Dhaka 42/1 -'.$counter;
                $gig->budget = 500+$counter;
                $gig->day = $counter;
                $gig->save();
            }
        }

        //Customer bid
        for ($counter2 = 1; $counter2<=10; $counter2++){
            for ($counter = 1; $counter<=10; $counter++){
                $bid = new \App\CustomerBid();
                $bid->worker_gig_id = $counter;
                $bid->customer_id = 40+$counter;
                $bid->status = 'active';
                $bid->budget = 200+$counter;
                $bid->description = 'Customer bid description -'.$counter;
                $bid->address = 'Dhaka 44/558/a -'.$counter;
                $bid->save();
            }
        }

        //Worker bid
        for ($counter2 = 1; $counter2<=10; $counter2++){
            for ($counter = 1; $counter<=10; $counter++){
                $bid = new \App\WorkerBid();
                $bid->customer_gig_id = $counter;
                $bid->worker_id = $counter;
                $bid->budget = 200+$counter;
                $bid->description = 'Worker bid description -'.$counter;
                $bid->is_selected = 0;
                $bid->is_cancelled =0;
                $bid->save();
            }
        }
    }
}
