<?php

use Illuminate\Database\Seeder;
use App\Parser;
use App\Category;
use App\Product;
use Image;

class ProductTableSeeder extends Seeder
{

	private function save($category, $url)
	{
		$cat = Category::create([
			'name' => $category
		]);

		$parser = new Parser($url);
		$products = $parser->getProducts();

		foreach ($products as $product) {
			$product['pictures'] = Image::make($product['pictures'])->encode('jpg', 90);

			$cat->products()->create($product);   
		}
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->save('Суши', 'http://sushidom.by/category/sushi/');
    	$this->save('Салаты', 'http://sushidom.by/category/calaty/');
    	$this->save('Китайская лапша', 'http://sushidom.by/category/kitajjskaya-lapsha/');
    	$this->save('Крылышки', 'http://sushidom.by/category/kriliski/');
    	$this->save('Обеды', 'http://sushidom.by/category/obedi/');
    }
}
