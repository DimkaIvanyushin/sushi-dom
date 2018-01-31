<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Cart;
use App\Http\Requests;
use App\Product;
use App\Category;
use App\Order;
use App\Like;
use Validator;
use Session;
use Auth;
use Response;
use Image;

class ProductController extends Controller
{

    public function create(Request $request)
    {
        $data = $request->only('name', 'weight', 'price', 'composition', 'pictures');

        $validator = Validator::make($data , [
            'name' => 'required|max:255| min:2',
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
            'composition' => 'required|max:400| min:2',
            'pictures' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->route('home.index')
            ->withInput()
            ->withErrors($validator);
        }

        $data['pictures'] = Image::make($request->file('pictures'))->encode('jpg', 90);

        $category = Category::find($request->category_id);
        $category->products()->create($data);

        return redirect()->route('home.index');
    }

    public function show($product)
    {
        $product = Product::findOrFail($product);
        return view('product.view', [
            'product' => $product
        ]);
    }

    public function edit($product)
    {
        $product = Product::findOrFail($product);

        return view('product.edit', [
            'product' => $product,
            'categories' => Category::get()
        ]);
    }

    public function update($product, Request $request)
    {
       $product = Product::findOrFail($product);

       $data = $request->only('name', 'weight', 'price', 'composition', 'pictures');
       $data['pictures'] = Image::make($request->file('pictures'))->encode('jpg', 90);
       
       $product->update($data);

       return redirect()->route('home.index');
    }

    public function destroy($product)
    {
        Product::findOrFail($product)->delete();

        return redirect()->route('home.index');
    }

    public function like($product)
    {
        $existing_like = Like::where('product_id', $product)->where('user_id', Auth::id())->first();

        if (is_null($existing_like)) {
            $like = new Like();
            $like['product_id'] = $product;
            $like['user_id'] = Auth::id();
            $like->save();
        } else {
            $existing_like->delete();
        }

        return redirect()->route('home.index');
    }
}
