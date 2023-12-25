<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product;

use App\Models\StoreProduct;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Session, Hashids, DataTables;
use App\Models\Supplier;

class PurchaseOrderController extends Controller
{

    public $resource = 'admin/purchase-orders';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {   
        
        if ($request->ajax()) {
            
            $suppliers = Supplier::query();                
        
            return Datatables::of($suppliers)
                ->addColumn('image', function ($supplier) {
                    return '<img width="30" src="'.checkImage('suppliers/thumbs/'. $supplier->image).'" />';
                })
                ->addColumn('action', function ($supplier) {
                    $action = '';
                    $action .= '<a href="purchase-orders/create?id='. Hashids::encode($supplier->id).'" class="text-success" data-toggle="tooltip" title="Create Purchase Order"><i class="fa fa-lg fa-calculator"></i></a>';
                    $action .= '<a href="purchase-orders/supplier/'. Hashids::encode($supplier->id).'" class="text-primary" data-toggle="tooltip" title="View Purchase Orders"><i class="fa fa-lg fa-eye"></i></a>';
                    return $action;
                    
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view($this->resource . '/suppliers');
    }
    
    public function suppierPurchaseOrders(Request $request,$id)
    {   
        
        if ($request->ajax()) {
            $id = decodeId($id);
            $orders = PurchaseOrder::where('supplier_id', $id);

            if($request->filled('order')) {
                $orderBy = $request->order;
                if ($orderBy[0]['column'] == 1) {
                    $orders->orderBy('created_at', $orderBy[0]['dir']);
                }
            } else {
                $orders->orderBy('updated_at','desc');
            }
            
            return Datatables::of($orders)
                ->addColumn('date', function ($order) {
                    return date('d-m-Y H:i', strtotime($order->created_at));
                })
                ->addColumn('action', function ($order) {
                    $action = '<a href="'.url('admin/purchase-order-print/' . Hashids::encode($order->id)) . '" target="_blank" class="text-primary btn-order" data-toggle="tooltip" title="Print Purchase Order"><i class="fa fa-print fa-lg"></i></a>';
                    $action .= '<a href="'.url('admin/purchase-orders/' . Hashids::encode($order->id)) . '" class="text-success btn-order" data-toggle="tooltip" title="View Purchase Order"><i class="fa fa-eye fa-lg"></i></a>';
                    $action .= '<a href="'.url('admin/purchase-orders/'.Hashids::encode($order->id)).'" class="text-danger btn-delete" data-toggle="tooltip" title="Delete Purchase Order"><i class="fa fa-lg fa-trash"></i></a>';
                    return $action;
                })
                ->rawColumns(['date','action'])
                ->make(true);
        }

        return view($this->resource . '/index', compact('id'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        
        $suppliers = Supplier::get();

        if ($request->filled('id')) {
            $supplier = Supplier::find(decodeId($request->id));
        }
        

        $products = Product::orderBy('name', 'asc')->get();

        //$products = Product::with('store_products')
                // ->where('supplier_id', $supplier->id)
                // ->orWhere('supplier_id_2', $supplier->id)
                // ->orWhere('supplier_id_3', $supplier->id)
                // ->orWhere('supplier_id_4', $supplier->id)
                // ->orderBy('updated_at', 'desc')
                // ->get();
        
        return view($this->resource . '/create', get_defined_vars());
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
        $products = [];
        $totalQuantity = 0;
        $totalPrice = 0;
        $supplier = Supplier::find($request->supplier_id);
        if ($request->filled('products') && $supplier) {
            foreach($request->products as $productId => $product) {
                if ($product['price'] > 0 && $product['quantity'] > 0) {
                    
                    
                    
                    $productName = '';
                    $productDB = Product::with('store_products')->find($productId);

                    if ($productDB) {

                        $newQuantity = $product['quantity'];
                        $newCost = $product['price'];

                        // save new store product
                        $storeId = 1;
                        $storeProduct['product_id'] = $productId;
                        $storeProduct['store_id'] = $storeId;
                        $storeProduct['quantity'] = $newQuantity;

                        StoreProduct::create($storeProduct);
                        updateProductStockByData($productId, $storeId, $newQuantity, 1, 2, 0, 0, 'Edit Product');
                    
                        
                        $oldQuantity = 0;
                        $oldCost = $productDB->cost;
                        if (@$productDB->store_products[0]) {
                            $oldQuantity = $productDB->store_products[0]->quantity;
                        }

                        if ($oldQuantity > 0) {
                            $oldTotal = $oldCost * $oldQuantity;
                            $newTotal = $newCost * $newQuantity;
                            $quantityTotal = $oldQuantity + $newQuantity;

                            $newCost = ($oldTotal + $newTotal) / $quantityTotal;

                            $productDB->update(['cost' => $newCost]);
                        } else {
                            $productDB->update(['cost' => $newCost]);
                        }

                        $productName = $productDB->name;
                        $totalQuantity = $totalQuantity + $product['quantity'];
                        $totalPrice = $totalPrice + ($product['price'] * $product['quantity']);
                        
                        $products[] = [
                            'product_id' => $productId,
                            'product_name' => $productName,
                            'quantity' => (integer) $product['quantity'],
                            'price' => (float) $product['price'],
                        ];
                    }
                    
                } 
            }
            
            if ($totalPrice>0) {
                PurchaseOrder::create([
                    'supplier_id' => $supplier->id,
                    'supplier_name' => $supplier->name,
                    'total_quantity' => $totalQuantity,
                    'total_price' => $totalPrice,
                    'products' => json_encode($products),
                ]);
            }
        }
        
        
        
        return response()->json([
            'success'  => true,
            'message'  => 'Purchase order successfully created'
        ], $this->successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = decodeId($id);
        $order = PurchaseOrder::findOrFail($id);
        $supplier = Supplier::find($order->supplier_id);
        return view($this->resource . '/invoice', get_defined_vars());
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {   
        $id = Hashids::decode($id)[0];
        
        $order = PurchaseOrder::find($id);
        
        if($order){

            $order->delete();
            $response['message'] = 'Purchase Order deleted!';
            $status = $this->successStatus;  
        }else{
            $response['message'] = 'Order not exist against this id!';
            $status = $this->errorStatus;  
        }
        
        return response()->json(['result'=>$response], $status);

    }

    public function orderPrint($id)
    {
        $id = decodeId($id);
        $order = PurchaseOrder::findOrFail($id);
        $supplier = Supplier::find($order->supplier_id);
        return view($this->resource . '/invoice-print', get_defined_vars());
    }


}
