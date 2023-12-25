<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\ExpenseType;
use App\Models\Expense;
use Illuminate\Http\Request;
use Session, Image, File, Hashids, DataTables;


class ExpenseController extends Controller
{

    public $resource = 'admin/expenses';
    public $uploadPath = 'uploads/expenses';

    public function __construct()
   {
        $this->middleware('permission:view expenses', ['only' => ['index']]);
        $this->middleware('permission:add expenses', ['only' => ['create','store']]);
        $this->middleware('permission:edit expenses', ['only' => ['edit','update']]);
        $this->middleware('permission:delete expenses', ['only' => ['destroy']]);

        $this->uploadPath = public_path($this->uploadPath);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        
        if($request->ajax()){

            $expenses = Expense::with('admin');
          
            
                   if(!empty($request->from_date)){
                $expenses->whereDate('date', '>=' , $request->from_date);
            }
            
            if(!empty($request->to_date)){
                $expenses->whereDate('date', '<=' , $request->to_date);
            }
            
    /* if (roleName() != 'Admin') {
                $expenses->where('admin_id', Auth::id());
            }

            if($request->filled('order')) {
                $orderBy = $request->order;
                if ($orderBy[0]['column'] == 0) {
                    $expenses->orderBy('date', $orderBy[0]['dir']);
                }
            } else {
                $expenses->orderBy('updated_at','desc');
            }
*/
            return Datatables::of($expenses)
                ->addColumn('date', function ($expense) {
                    return date('d-m-Y', strtotime($expense->date));
                })
                ->addColumn('action', function ($expense) {
                    $action = '';
                    if(Auth::user()->can('edit expenses'))
                        $action .= '<a href="expenses/'. Hashids::encode($expense->id).'/edit" class="text-primary" data-toggle="tooltip" title="Edit Expense"><i class="fa fa-lg fa-edit"></i></a>';
                    if(Auth::user()->can('delete expenses'))
                        $action .= '<a href="expenses/'.Hashids::encode($expense->id).'" class="text-danger btn-delete" data-toggle="tooltip" title="Delete Expense"><i class="fa fa-lg fa-trash"></i></a>';

                    return $action;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view($this->resource.'/index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $expenseTypes = ExpenseType::pluck('name', 'id');
        return view($this->resource.'/create', get_defined_vars());
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
        $this->validate($request, [
            // 'type_id' => 'required',
            'name' => 'required|max:255',
            'date' => 'required',
            'amount' => 'required|numeric',
        ]);

        $requestData = $request->all();
        $requestData['date'] = date('Y-m-d', strtotime($request->date));
        $requestData['admin_id'] = Auth::id();
        $requestData['admin'] = 'no';
        if (roleName() == 'Admin') {
            $requestData['admin'] = 'yes';
        }
        
        $expense = Expense::create($requestData);

        //save image
        if($request->hasFile('image')){
            $image = $request->file('image'); // file
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $fileName = $expense->id.'-'.str_random(10).'.'.$extension; // renameing image

            $img = Image::make($image->getRealPath());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($this->uploadPath.'/thumbs/'.$fileName);

            $image->move($this->uploadPath, $fileName); // uploading file to given path

            //update image record
            $expense_image['image'] = $fileName;
            $expense->update($expense_image);
        }

        Session::flash('success', 'Expense added!');

        return redirect($this->resource);
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

        $id = Hashids::decode($id)[0];

        $expense = Expense::findOrFail($id);
        $expenseTypes = ExpenseType::pluck('name', 'id');
        
        return view($this->resource.'/edit', get_defined_vars());
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
        $id = Hashids::decode($id)[0];

        $this->validate($request, [
            // 'type_id' => 'required',
            'name' => 'required|max:255',
            'date' => 'required',
            'amount' => 'required|numeric',
        ]);

        $requestData = $request->all();
        $requestData['date'] = date('Y-m-d', strtotime($request->date));
        
        $expense = Expense::findOrFail($id);

        //save image
        if($request->hasFile('image')){
            $image = $request->file('image'); // file
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $fileName = $expense->id.'-'.str_random(10).'.'.$extension; // renameing image

            $img = Image::make($image->getRealPath());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save($this->uploadPath.'/thumbs/'.$fileName);

            $image->move($this->uploadPath, $fileName); // uploading file to given path

            /*unlink old image*/
            File::delete($this->uploadPath.'/'.$expense->image);
            File::delete($this->uploadPath.'/thumbs/'.$expense->image);

            //update image record
            $requestData['image'] = $fileName;
        }

        $expense->update($requestData);

        Session::flash('success', 'Expense updated!');

        return redirect($this->resource);
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
        $id = Hashids::decode($id)[0];

        $expense = Expense::find($id);

        if($expense){

            /*unlink old image*/
            File::delete($this->uploadPath.'/'.$expense->image);
            File::delete($this->uploadPath.'/thumbs/'.$expense->image);

            $brand->delete();
            $response['message'] = 'Expense deleted!';
            $status = $this->successStatus;
        }else{
            $response['message'] = 'Expense not exist against this id!';
            $status = $this->errorStatus;
        }

        return response()->json(['result'=>$response], $status);

    }

}
