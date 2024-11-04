<?php

namespace Database\Seeders;

use App\Models\JobListing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seedConfig = config('models.seeding.jobListing');
        $jobLists = $seedConfig['default_list'];

        foreach ($jobLists as $jobList) {
            JobListing::updateOrCreate(
                [
                    'title' => $jobList['title'],
                ],
                [
                    'company' => $jobList['company'],
                    'description' => $jobList['description'],
                    'location' => $jobList['location'],
                    'type' => $jobList['type'],
                    'salary' => $jobList['salary'],
                    'application_deadline' => $jobList['application_deadline'],
                ]
            );
        }

        $useFactory = $seedConfig['factory'];
        $factoryCount = $seedConfig['factory_count'];

        if ($useFactory) {
            JobListing::factory()->count($factoryCount)->create();
        }
    }
}
