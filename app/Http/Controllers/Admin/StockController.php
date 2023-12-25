<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Session, Image, File, Hashids, DataTables;
use App\Models\Store;
use App\Models\Stock;
use App\Models\Product;
use App\Models\StoreProduct;
use App\Models\Supplier;

class StockController extends Controller
{

    public function __construct()
   {
        $this->middleware('permission:view manage stocks', ['only' => ['index']]);        
        $this->middleware('permission:add manage stocks', ['only' => ['create','store']]);        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {      

        if($request->ajax()){

            $stocks = Stock::with('product')
                        ->orderBy('id','desc');
                 
            
            return Datatables::of($stocks)
                ->addColumn('created_at', function ($stock) {
                    return date('d-m-Y h:i a', strtotime($stock->created_at));
                })
                ->addColumn('product_name', function ($stock) {
                    return $stock->product->name;
                })            
                ->addColumn('stock_type', function ($stock) {
                    if($stock->stock_type==1)
                        return "IN";
                    elseif($stock->stock_type==2)
                        return "OUT";
                })            
                ->addColumn('origin', function ($stock) {
                    switch ($stock->origin) {
                        case 1:
                            return "Add Product";
                            break;
                        case 2:
                            return "Update Product";
                            break;
                        case 3:
                            return "Sale";
                            break;
                        case 4:
                            return "Sale Return";
                            break;
                        case 5:
                            return "Adjustment";
                            break;
                        default:
                            return "Add Product";
                    }
                })            
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['store_name', 'product_name'])
                ->make(true); 
        }

        return view('admin.stocks.index');
    }   
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {   
        $suppliers = Supplier::pluck('name', 'id')->prepend('Select Supplier', 0);
        $products = Product::pluck('name', 'id')->prepend('Select Product', 0);
        return view('admin.stocks.create', get_defined_vars());                
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {          
        $rules = [ 
            'supplier_id' => 'required',
            'product_id' => 'required',
            'stock_type' => 'required|in:1,2',
            'quantity' => 'required|numeric',
        ];
        
        if($request->stock_type == 1) {
            $rules['cost'] = 'required';
            $rules['aggregate_cost'] = 'required';
            $rules['price'] = 'required';
        }else if($request->stock_type == 2){
           $store_product = StoreProduct::where('product_id',$request->product_id)->where('store_id',$request->store_id)->first();
           $rules['quantity'] = 'required|numeric|max:'.$store_product->quantity;
        }           
        
        $this->validate($request, $rules);
        
        $requestData = $request->all();              
        $requestData['store_id'] = 1;              
        $requestData['origin'] = 5;              
        
        $stock = Stock::create($requestData);
        
        if($stock) {
            updateProductStock($stock->product_id, $stock->store_id);

            Product::where('id', $stock->product_id)->update(['cost' => $request->aggregate_cost, 'price' => $request->price]);
        }
            
            
        Session::flash('success', 'Stock Adjustment added!');        

        return redirect('admin/manage-stocks');  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {                
        return redirect('admin/manage-stocks/create');  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        return redirect('admin/manage-stocks/create');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {           
    }    
    
    
    /**
     * getStoreProducts function
     *      
     * @param  int  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function getStoreProducts(Request $request)
    {      
        $store_id = $request->store_id;
        $search = $request->search;
                                        
       
        $products = Product::with([
                'store_products' => function ($query) use ($store_id) {
                        $query->where('store_id', $store_id);
                    }
            ])->where(function ($query) use ($search)  {
    $query->where('name', 'like', "%".$search."%")
          ->orWhere('sku', 'like', "%".$search."%");
});
        $products = $products->get(); 
            
        $products->map(function ($product) { 
            
            $quantity = 0; 
            if($product->store_products->count()>0)
               $quantity =  $product->store_products[0]->quantity;
            
            $product['text'] = $product->name . '  ('. $quantity .')';

            return $product;
        });
        
        $products = $products->all(); 
        
        $status = $this->successStatus;

        return response()->json(['results' => $products], $status);

    }
        
    
}
