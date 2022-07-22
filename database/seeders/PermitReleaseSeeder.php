<?php

namespace Database\Seeders;

use App\Models\PermitRelease;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PermitReleaseSeeder extends Seeder
{
    public function run()
    {
        //create default release date
        PermitRelease::insert([
            [
                'release_date' => Carbon::now()->addMonths(1),
            ]
        ]);
    }
}
