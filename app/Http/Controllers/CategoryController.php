<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
use Validator;

class CategoryController extends Controller
{ 
	public function create(Request $request)
	{
		$data = $request->only('name');

		$validator = Validator::make($data , [
			'name' => 'required|max:255| min:2'
		]);

		if ($validator->fails()) {
			return redirect()->route('home.index')
			->withInput()
			->withErrors($validator);
		}

		Category::create($data);

		return redirect()->route('home.index');
	}

	public function show($id)
	{
		$category = Category::findOrFail($id);

		return view('product.view-category', [
            'products' => $category->products()->simplePaginate(24)
        ]);
	}

	public function destroy($category)
	{
		$category = Category::findOrFail($category);
        $category->products()->delete();
        $category->delete();

		return redirect()->route('home.index');
	}

}
