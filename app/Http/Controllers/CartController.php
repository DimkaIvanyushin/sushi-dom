<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cart;
use App\Product;
use App\Order;
use Session;
use Validator;
use Auth;

class CartController extends Controller
{
	public function get()
	{
		if (!Session::has('cart')) {
			return view('shop.shopping-cart');
		}

		$oldCart = Session::get('cart');
		$cart = new Cart($oldCart);

		return view('shop.shopping-cart', [
			'products' => $cart->items, 
			'totalPrice' => $cart->totalPrice
		]);
	}

	public function postCheckout(Request $request)
	{
		if (!Session::has('cart')) {
			return redirect()->route('shoppingCart');
		}

		$oldCart = Session::get('cart');
		$cart = new Cart($oldCart);

		$data = $request->only('name', 'phone', 'comment','street', 'house', 'apartment', 'housing', 'entrance', 'floor');

		$data['cart'] = serialize($cart);
		$data['confirmed'] = false;

		$validator = Validator::make($data , [
			'name' => 'required|max:255| min:2',
			'phone' => 'required|max:255| min:6',
			'street' => 'max:255',
			'house' => 'max:255',
			'apartment' => 'max:255',
			'housing' => 'max:255',
			'entrance' => 'max:255',
			'floor' => 'max:255',
			'comment' => 'max:255'
		]);

		if ($validator->fails()) {
			return redirect()->route('cart.get')
			->withInput()
			->withErrors($validator);
		}

		$order = new Order($data);

		if (Auth::guest()){
			$order->save();
		} else {
			Auth::user()->orders()->save($order);
		}

		Session::forget('cart');
		return redirect()->route('home.index')->with('success', 'Success, complite');
	}

	public function add(Request $request, $id)
	{
		$product = Product::find($id);
		$oldCart = Session::has('cart') ? Session::get('cart') : null;
		$cart = new Cart($oldCart);
		$cart->add($product, $product->id);

		$request->session()->put('cart', $cart);

		return redirect()->route('cart.get');
	}

	public function destroy(Request $request, $id)
	{
		$product = Product::find($id);
		$oldCart = Session::has('cart') ? Session::get('cart') : null;
		$cart = new Cart($oldCart);
		$cart->delete($product, $product->id);

		$request->session()->put('cart', $cart);

		return redirect()->route('cart.get');
	}
}