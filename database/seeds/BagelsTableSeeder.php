<?php

use Illuminate\Database\Seeder;

class BagelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Bagel::class, 20)->create();
    }
}
