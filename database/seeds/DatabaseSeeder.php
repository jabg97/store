<?php

use App\Model\Code;
use App\Model\Product;
use Illuminate\Database\Seeder;

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
            $product->price = $faker->numberBetween($min = 10000, $max = 1200000);
            $product->image_url = $faker->placeholder('500x500', 'jpg', substr($faker->hexcolor, 1), 'ffffff');
            $product->save();
        }

        $code = new Code;
        $code->code = 'CREATED';
        $code->group = 'ORDER_STATUS';
        $code->name = 'Creada';
        $code->icon = 'far fa-calendar-plus';
        $code->css = 'bg-color-gradient-primary';
        $code->save();

        $code = new Code;
        $code->code = 'PAYED';
        $code->group = 'ORDER_STATUS';
        $code->name = 'Pagada';
        $code->icon = 'far fa-calendar-check';
        $code->css = 'bg-color-gradient-success';
        $code->save();

        $code = new Code;
        $code->code = 'PENDING';
        $code->group = 'ORDER_STATUS';
        $code->name = 'Pendiente';
        $code->icon = 'fas fa-stopwatch';
        $code->css = 'bg-color-gradient-warning';
        $code->save();

        $code = new Code;
        $code->code = 'REJECTED';
        $code->group = 'ORDER_STATUS';
        $code->name = 'Rechazada';
        $code->icon = 'far fa-calendar-times';
        $code->css = 'bg-color-gradient-danger';
        $code->save();

        /******************************/
        $code = new Code;
        $code->code = 'NEW';
        $code->group = 'PRODUCT_STATE';
        $code->name = 'Nuevo';
        $code->save();

        $code = new Code;
        $code->code = 'USED';
        $code->group = 'PRODUCT_STATE';
        $code->name = 'Usado';
        $code->save();
    }
}
