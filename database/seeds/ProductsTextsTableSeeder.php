<?php

use App\ProductText;
use Illuminate\Database\Seeder;

class ProductsTextsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Generate English
        $locale = "en";

        // Generate bagels
        for ($i = 1; $i <= 20; $i++) {
            $productText = new ProductText;
            $productText->locale = $locale;
            $productText->product_type = "bagel";
            $productText->product_id = $i;
            $productText->type = "title";
            $productText->text = str_random(10);
            $productText->save();
        }

        for ($i = 1; $i <= 20; $i++) {
            $productText = new ProductText;
            $productText->locale = $locale;
            $productText->product_type = "bagel";
            $productText->product_id = $i;
            $productText->type = "description";
            $productText->text = str_random(30);
            $productText->save();
        }

        // Generate Toppings
        for ($i = 1; $i <= 20; $i++) {
            $productText = new ProductText;
            $productText->locale = $locale;
            $productText->product_type = "topping";
            $productText->product_id = $i;
            $productText->type = "title";
            $productText->text = str_random(10);
            $productText->save();
        }

        for ($i = 1; $i <= 20; $i++) {
            $productText = new ProductText;
            $productText->locale = $locale;
            $productText->product_type = "topping";
            $productText->product_id = $i;
            $productText->type = "description";
            $productText->text = str_random(30);
            $productText->save();
        }


        // Generate French

        $locale = "fr";
        // Generate bagels
        for ($i = 1; $i <= 20; $i++) {
            $productText = new ProductText;
            $productText->locale = $locale;
            $productText->product_type = "bagel";
            $productText->product_id = $i;
            $productText->type = "title";
            $productText->text = str_random(10);
            $productText->save();
        }

        for ($i = 1; $i <= 20; $i++) {
            $productText = new ProductText;
            $productText->locale = $locale;
            $productText->product_type = "bagel";
            $productText->product_id = $i;
            $productText->type = "description";
            $productText->text = str_random(30);
            $productText->save();
        }

        // Generate Toppings
        for ($i = 1; $i <= 20; $i++) {
            $productText = new ProductText;
            $productText->locale = $locale;
            $productText->product_type = "topping";
            $productText->product_id = $i;
            $productText->type = "title";
            $productText->text = str_random(10);
            $productText->save();
        }

        for ($i = 1; $i <= 20; $i++) {
            $productText = new ProductText;
            $productText->locale = $locale;
            $productText->product_type = "topping";
            $productText->product_id = $i;
            $productText->type = "description";
            $productText->text = str_random(30);
            $productText->save();
        }
    }
}
