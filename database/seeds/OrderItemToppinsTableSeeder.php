<?php

use Illuminate\Database\Seeder;

class OrderItemToppinsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\OrderItemTopping::class, 40)->create();
    }
}
