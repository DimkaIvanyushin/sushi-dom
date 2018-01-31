<?php

namespace App;
use Goutte\Client;

class Parser 
{
	private $client = null;
	private $crawler = null;
	private $products = [];

	public function __construct($url)
	{
		$this->client = new Client();

		if ($url)
		{
			$this->crawler = $this->client->request('GET', $url);
		}
	}

	public function getProducts()
	{
		$this->crawler->filter('.post')->each(function ($node){
			$picture = $node->attr('style');
			preg_match('/\((.+)\)/', $picture, $result);
			
			$product['pictures'] = $result[1];
			$product['name'] = $node->filter('h2')->text();

			$price = $node->filter('div.desc > div.price')->text();
			$product['price'] = floatval($price);

			$desc = $node->filter('div.desc')->children()->eq(1)->text();
			$desc = preg_split("/[\\r\\t\\n]+/", $desc);

			$product['weight'] = isset($desc[1]) ? intval(preg_replace("/[^0-9]/", '', $desc[1])) : '';

			$product['composition'] = isset($desc[2]) ? $desc[2] : '';

			$this->products[] = $product;

			return $node->text();
		});	
	
		return $this->products;
	}
}