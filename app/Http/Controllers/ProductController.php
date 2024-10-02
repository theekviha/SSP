<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;


class ProductController extends Controller
{
    public function index()
    {
        if (Auth::check() && auth()->user()->role->value == 1) {
            return redirect()->route('admin.product.index');
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function create()
    {
        if (Auth::check() && auth()->user()->role->value == 1) {
        return view('windmill-admin.product.form', [
            'product' => new Product(),
            'purpose' => 'Create Product',
        ]);
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function store(Request $request)
    {
       
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $path = 'uploads/products/';
        $filename = time() . $extension;
        $file->move($path, $filename);
    

        Product::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'image' => $path . $filename,
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Product Created Successfully!');
        
    }

    public function edit(Product $product)
    {
        if (Auth::check() && auth()->user()->role->value == 1) {
        return view('windmill-admin.product.form', [
            'product' => $product,
            'purpose' => 'Edit Product',
        ]);
        } else {
            abort(403, 'Unauthorized Access');
        }
    }

    public function update(Request $request, Product $product)
    {
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $path = 'uploads/products/';
        $filename = time() . $extension;
        $file->move($path, $filename);
        $product->image = $path . $filename;

        $product->name = $request->input('name');
        $product->slug = $request->input('slug');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->status = $request->input('status');
       
        $product->update();

        return redirect()->route('admin.product.index')->with('success', 'Product Updated Successfully!');

    }

    public function destroy(Product $product)
    {
        if (Auth::check() && auth()->user()->role->value == 1) {
        $product->delete();
        return redirect()->route('admin.product.index')->with('success', 'Product Deleted Successfully!');
        } else {
            abort(403, 'Unauthorized Access');
        }
    }
}
