<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BagelsTableSeeder::class);
        $this->call(ToppingsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(OrderItemsTableSeeder::class);
        $this->call(OrderItemToppinsTableSeeder::class);
    }
}
