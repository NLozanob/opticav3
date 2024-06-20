<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use Illuminate\Http\Request;
use Illuminate\support\Facades\DB;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale_detail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;


class SaleController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     //$sales = Sale::select('customers.first_name','customers.identification_document', 'sales.sale_date','sales.total_sale','sales.status')
     //-> join ('customers', 'customer_id', '=', 'sales.customer_id')->get();
        //$sales = Sale::with('customer')->get();

        $sales = Sale::select('customers.first_name', 'customers.identification_document', 'sales.id', 'sales.total_sale', 'sales.sale_date','sales.status','sales.registered_by')
            ->join('customers', 'sales.customer_id', '=', 'customers.id')
            ->get();
        return view('sales.index', compact('sales'));
       
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $customers = Customer::where('status','=','1')->orderBy('first_name')->get();
        // $products = Product::where('status','=','1')->orderBy('name')->get();
        // $sale_date = Carbon::now();
        // $sale_date = $sale_date->format('Y-m-d');

        $customers = Customer::all();
        $products = Product::all();
        
        return view("sales.create",compact('customers','products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleRequest $request)
    {
        
        $sale = Sale::create([
            'sale_date' => Carbon::now()->toDateTimeString(),
            'total_sale' => $request->total_sale,
            'route' => "Por hacer",
            'customer_id' => Customer::find($request->customer)->id,
        ]);

        

        $total =0;
        $rawProductId = $request->product_id;
        $rawQuantity = $request->quantity;
    
       
        for ($i = 0; $i < count($rawProductId); $i++) {
           
            $product = Product::find($rawProductId[$i]);
            
    
            $quantity = $rawQuantity[$i];
    
           
            $subtotal = $product->purchase_price * $quantity;
    
           
            $sale->saleDetails()->create([
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'product_id' => $product->id,
            ]);

            $total += $subtotal;
        }

        $sale->total_sale = $total;

         // Generate bill (PDF).
         $pdfName = 'uploads/bills/bill_' . $sale->id . '_' . Carbon::now()->format('YmdHis') . '.pdf';

         $sale = Sale::find($sale->id);
         $customer = Customer::where("id", $sale->customer_id)->first();
         $details = Sale_detail::with('product')
             ->where('sale_details.sale_id', '=', $sale->id)
             ->get();

         $pdf = PDF::loadView('sales.bill', compact("sale", "customer", "details"))
             ->setPaper('letter')
             ->output();

         file_put_contents($pdfName, $pdf);

         $sale->route = $pdfName;
         
         $sale->status = 1;
         $sale->registered_by = $request->registered_by;
        
        $sale->save();

        return redirect()->route("sales.index")->with("success", "The orders has been created.");
        
       
    }

    //metodo para mostrar el pdf
    public function generatePDF($id)
    {

        $sale = Sale::find($id);
        $customer = Customer::where("id", $sale->customer_id)->first();
        $details = Sale_detail::with('product')
            ->where('sale_details.sale_id', '=', $sale->id)
            ->get();
        
        $pdf = PDF::loadView('sales.bill', compact('sale','customer','details'));

        return $pdf->stream('sale_'.$id.'.pdf');
    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $sale = Sale::find($id);
        // $customer = Customer::where("id", $sale->customer_id)->first();
        // $details = Sale_detail::with('product')
        //     ->where('sale_details.sale_id', '=', $id)
        //     ->get();

        $sales=Sale::select('customers.first_name as customerName','customers.identification_document as document','sales.sale_date', 'sales.total_sale', 'sales.id')
        ->join('customers', 'sales.customer_id', '=', 'customers.id')->where('sales.id', '=', $id)->first();
        $details=Sale_detail::select('products.name as productName','products.purchase_price as productPrice', 'sale_details.quantity', 'sale_details.subtotal')
        ->join('products', 'sale_details.product_id', '=', 'products.id')
        ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
        ->where('sale_details.sale_id', '=', $id)
        ->get();
        return view("sales.show", compact('sales','details'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Sale $sale){
    //     return view ("sales.edit",compact('sale'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id){
  
			$sale = Sale::find($id);
			$image = $request->file('image');
			$slug = str::slug($request->name);
			if (isset($image))
			{
				$currentDate = Carbon::now()->toDateString();
				$imagename = $slug.'-'.$currentDate.'-'. uniqid() .'.'. $image->getClientOriginalExtension();

				if (!file_exists('uploads/sales'))
				{
					mkdir('uploads/porducts',0777,true);
				}
				$image->move('uploads/sales',$imagename);
			}else{
				$imagename = $sale->image;
			}
			
            $sale->sale_date= $request->sale_date;
			$sale->total_sale= $request->total_sale;
			$sale->customer_id= $request->customer_id;
            $sale->status=1;
            $sale->registered_by=$request->user()->id;
			$sale->save();
            return redirect()->route('sales.index')->with('successMsg','El registro se actualizó exitosamente');
         
    }
    
		
        
        

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
     {
         $sale->delete();
         return redirect()->route('sales.index')->with('eliminar','ok');
    }

    public function changestatus_sale(Request $request)
    {
        $sale = Sale::find($request->sale_id);
		$sale->status=$request->status;
		$sale->save();
    }

   

}