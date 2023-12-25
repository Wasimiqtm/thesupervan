<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\ExpenseType;
use Illuminate\Http\Request;
use Session, Image, File, Hashids, DataTables;


class ExpenseTypeController extends Controller
{

    public $resource = 'admin/expense-types';

    public function __construct()
   {
        $this->middleware('permission:view expense types', ['only' => ['index']]);
        $this->middleware('permission:add expense types', ['only' => ['create','store']]);
        $this->middleware('permission:edit expense types', ['only' => ['edit','update']]);
        $this->middleware('permission:delete expense types', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        if($request->ajax()){

            $expenses = ExpenseType::query();

            return Datatables::of($expenses)
                ->addColumn('action', function ($expense) {
                    $action = '';
                    if(Auth::user()->can('edit expense types'))
                        $action .= '<a href="expense-types/'. Hashids::encode($expense->id).'/edit" class="text-primary" data-toggle="tooltip" title="Edit Expense type"><i class="fa fa-lg fa-edit"></i></a>';
                    if(Auth::user()->can('delete expense types'))
                        $action .= '<a href="expense-types/'.Hashids::encode($expense->id).'" class="text-danger btn-delete" data-toggle="tooltip" title="Delete Expense type"><i class="fa fa-lg fa-trash"></i></a>';

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
        return view($this->resource.'/create');
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
            'name' => 'required|max:255'
        ]);

        $requestData = $request->all();
        ExpenseType::create($requestData);

        Session::flash('success', 'Expense type added!');

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

        $expense = ExpenseType::findOrFail($id);

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
            'name' => 'required|max:255',
        ]);

        $requestData = $request->all();
        $expense = ExpenseType::findOrFail($id);

        $expense->update($requestData);

        Session::flash('success', 'Expense Type updated!');

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

        $expense = ExpenseType::find($id);

        if($expense){

            $expense->delete();
            $response['message'] = 'Expense type deleted!';
            $status = $this->successStatus;
        }else{
            $response['message'] = 'Expense type not exist against this id!';
            $status = $this->errorStatus;
        }

        return response()->json(['result'=>$response], $status);

    }

}
