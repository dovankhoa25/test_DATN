<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cateSeed = [];
        for($i=0;$i<10;$i++){
            $cateSeed[]=[
                'name'=>fake()->name(),
                'status'=>fake()->numberBetween(0,1),
            ];
        }
        DB::table('categories')->insert($cateSeed);
    }
}
