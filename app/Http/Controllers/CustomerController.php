<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view("customers.index", compact("customers"));
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("customers.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $customer = new Customer();
        $image = $request->file('image');
		$slug = Str::slug($request->name);
        
			if (isset($image))
			{
				$currentDate = Carbon::now()->toDateString();
				$imagename = $slug.'-'.$currentDate.'-'. uniqid() .'.'. $image->getClientOriginalExtension();

				if (!file_exists('uploads/customers'))
				{
					mkdir('uploads/customers',0777,true);
				}
				$image->move('uploads/customers',$imagename);
				$customer->image=$imagename;
			}
			
    
			
			$customer->first_name= $request->first_name;
			$customer->identification_document= $request->identification_document;
            $customer->email= $request->email;
            $customer->phone= $request->phone;
            $customer->address= $request->address;
            $customer->status=1;
            $customer->registered_by=$request->user()->id;
			$customer->save();

            return redirect()->route('customers.index');
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
    public function edit(Customer $customer
    ){
        return view ("customers.edit",compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request,$id){
  
			$customer = Customer::find($id);
			$image = $request->file('image');
			$slug = str::slug($request->name);
			if (isset($image))
			{
				$currentDate = Carbon::now()->toDateString();
				$imagename = $slug.'-'.$currentDate.'-'. uniqid() .'.'. $image->getClientOriginalExtension();

				if (!file_exists('uploads/customers'))
				{
					mkdir('uploads/customers',0777,true);
				}

                $image->move('uploads/customers',$imagename);
				$customer->image=$imagename;
				
			}
                
			
			
			$customer->first_name= $request->first_name;
			$customer->identification_document= $request->identification_document;
            $customer->email= $request->email;
            $customer->phone= $request->phone;
            $customer->address= $request->address;
            $customer->status=1;
            $customer->registered_by=$request->user()->id;
			$customer->save();
            return redirect()->route('customers.index')->with('successMsg','El registro se actualizó exitosamente');
         
    }
    
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('eliminar','ok');
    }

    public function changestatus_customer(Request $request)
    {
        $customer = Customer::find($request->customer_id);
		$customer->status=$request->status;
		$customer->save();
    }

   

}