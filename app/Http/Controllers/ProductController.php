<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view("products.index", compact("products"));
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("products.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        
        $image = $request->file('image');
		$slug = Str::slug($request->name);

			if (isset($image))
			{
				$currentDate = Carbon::now()->toDateString();
				$imagename = $slug.'-'.$currentDate.'-'. uniqid() .'.'. $image->getClientOriginalExtension();

				if (!file_exists('uploads/products'))
				{
					mkdir('uploads/products',0777,true);
				}
				$image->move('uploads/products',$imagename);
			}else{
				$imagename = "";
			}
            

            $product = new Product();
			
			$product->name= $request->name;
			$product->purchase_price= $request->purchase_price;
			$product->description= $request->description;
            $product->stock_quantity= $request->stock_quantity;
            $product->expiration_date= $request->expiration_date;
            $product->image=$imagename;
            $product->status=1;
            $product->registered_by=$request->user()->id;
			$product->save();

            return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product){
        return view ("products.edit",compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id){
  
			$product = Product::find($id);
			$image = $request->file('image');
			$slug = str::slug($request->name);
			if (isset($image))
			{
				$currentDate = Carbon::now()->toDateString();
				$imagename = $slug.'-'.$currentDate.'-'. uniqid() .'.'. $image->getClientOriginalExtension();

				if (!file_exists('uploads/products'))
				{
					mkdir('uploads/products',0777,true);
				}
				$image->move('uploads/products',$imagename);
			}else{
				$imagename = $product->image;
			}
			
            $product->name= $request->name;
			$product->purchase_price= $request->purchase_price;
			$product->description= $request->description;
            $product->stock_quantity= $request->stock_quantity;
            $product->expiration_date= $request->expiration_date;
            $product->image=$imagename;
            $product->status=1;
            $product->registered_by=$request->user()->id;
			$product->save();
            return redirect()->route('products.index')->with('successMsg','El registro se actualizó exitosamente');
         
    }
    
		
        
        

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('eliminar','ok');
    }

    public function changestatus_product(Request $request)
    {
        $product = Product::find($request->product_id);
		$product->status=$request->status;
		$product->save();
    }

   

}