<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::getAllProduct();
        return view('backend.product.index')->with('products', $products);
    }

    public function create()
    {
        $brands = Brand::get();
        $categories = Category::where('is_parent', 1)->get();
        return view('backend.product.create')
            ->with('categories', $categories)
            ->with('brands', $brands);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'description' => 'nullable|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock' => 'required|numeric',
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:standard,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric|max:100',
        ]);

        $data = $request->all();

        // Handle photo upload
        if($request->hasFile('photo')){
            $image = $request->file('photo');
            $name = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $name);
            $data['photo'] = 'uploads/products/'.$name;
        }

        // Generate unique slug
        $slug = Str::slug($request->title);
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;

        // Handle featured checkbox
        $data['is_featured'] = $request->input('is_featured', 0);

        // Create product
        $product = Product::create($data);

        if ($product) {
            return redirect()->route('product.index')->with('success','Product successfully added!');
        } else {
            return redirect()->back()->with('error','Something went wrong, please try again.');
        }
    }

    public function edit($id)
    {
        $brands = Brand::get();
        $product = Product::findOrFail($id);
        $categories = Category::where('is_parent', 1)->get();
        return view('backend.product.edit')
            ->with('product', $product)
            ->with('brands', $brands)
            ->with('categories', $categories);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:active,inactive',
            'cat_id' => 'required|integer',
        ]);

        $product->title = $request->title;
        $product->summary = $request->summary;
        $product->description = $request->description;
        $product->is_featured = $request->has('is_featured') ? 1 : 0;
        $product->cat_id = $request->cat_id;
        $product->child_cat_id = $request->child_cat_id;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->brand_id = $request->brand_id;
        $product->condition = $request->condition;
        $product->stock = $request->stock;
        $product->status = $request->status;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($product->photo && file_exists(public_path($product->photo))) {
                unlink(public_path($product->photo));
            }
            $file = $request->file('photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/products/'), $filename);
            $product->photo = 'uploads/products/' . $filename;
        }

        $product->save();

        return redirect()->route('product.index')->with('success','Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if(file_exists(public_path($product->photo))){
            @unlink(public_path($product->photo));
        }

        $status = $product->delete();

        if ($status) {
            request()->session()->flash('success', 'Product successfully deleted');
        } else {
            request()->session()->flash('error', 'Error while deleting product');
        }

        return redirect()->route('product.index');
    }
}
