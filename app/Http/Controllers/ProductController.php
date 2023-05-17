<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class,'product');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Products/Index',[
            'products' => Product::select(['*'])->latest('created_at')->filter(request(['search']))->paginate(10)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Products/CreateEditProduct');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributtes = $request->validate([
            'name' => 'required|max:40',
            'quantity' => 'required|integer|gt:0',
            'price' => 'required|gt:0|numeric'
        ]);

        Product::create($attributtes);

        session()->flash('flash.banner', 'Product Created Successfully!.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //no 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return Inertia::render('Products/CreateEditProduct',[
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $attributtes = $request->validate([
            'name' => 'required|max:40',
            'quantity' => 'required|integer|gt:0',
            'price' => 'required|gt:0|numeric'
        ]);

        $product->update($attributtes);
        
        session()->flash('flash.banner', 'Product Updated Successfully !.');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        session()->flash('flash.banner', 'Deleted Successfully !.');
        session()->flash('flash.bannerStyle', 'success');

        return back();
    }
}
