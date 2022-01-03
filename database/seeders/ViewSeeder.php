<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Views;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Views::factory(300)->create();
    }
}
