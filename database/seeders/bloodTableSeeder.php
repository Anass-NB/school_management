<?php

namespace Database\Seeders;

use App\Models\Blood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class bloodTableSeeder extends Seeder
{

    public function run()
    {
        DB::table("Nationalities")->delete();
        $all_types = ['O-', 'O+', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];

        foreach($all_types as  $bg){
            Blood::create(['Name' => $bg]);
        }
    }
}
