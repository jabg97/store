<?php

use Illuminate\Database\Seeder;
use App\Model\Code;
use App\Model\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 12) as $i) {
            $faker = \Faker\Factory::create();
            $faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));
            $faker->addProvider(new \Bezhanov\Faker\Provider\Placeholder($faker));
            $product = new Product;
            $product->name = $faker->productName;
            $product->price = $faker->numberBetween($min = 250000, $max = 3000000);
            $product->image_url = $faker->placeholder('500x500', 'jpg', substr($faker->hexcolor, 1), 'ffffff');
            $product->save();
        }

        $code = new Code;
        $code->id = 'CREATED';
        $code->group = 'ORDER_STATUS';
        $code->name = 'Creada';
        $code->icon = 'far fa-calendar-plus';
        $code->css = 'indigo';
        $code->save();

        $code = new Code;
        $code->id = 'PAYED';
        $code->group = 'ORDER_STATUS';
        $code->name = 'Pagada';
        $code->icon = 'far fa-calendar-check';
        $code->css = 'teal';
        $code->save();

        $code = new Code;
        $code->id = 'REJECTED';
        $code->group = 'ORDER_STATUS';
        $code->name = 'Rechazada';
        $code->icon = 'far fa-calendar-times';
        $code->css = 'red';
        $code->save();

        /******************************/
        $code = new Code;
        $code->id = 'NEW';
        $code->group = 'PRODUCT_STATE';
        $code->name = 'Nuevo';
        $code->save();

        $code = new Code;
        $code->id = 'USED';
        $code->group = 'PRODUCT_STATE';
        $code->name = 'Usado';
        $code->save();
    }
}
