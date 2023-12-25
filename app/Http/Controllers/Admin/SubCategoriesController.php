<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SubCategoryRequest;
use App\Models\Categories;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session, Image, File, Hashids, DataTables;

class SubCategoriesController extends Controller
{
    public $resource = 'admin/subcategories';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $all_categories = SubCategory::with(['categories'])->get();
            return DataTables::of($all_categories)
                ->addColumn('action', function ($category) {
                    $action = '';
                    if (Auth::user()->can('edit categories'))
                        $action .= '<a href="subcategories/' . Hashids::encode($category->id) . '/edit" class="text-primary" data-toggle="tooltip" title="Edit Category"><i class="fa fa-lg fa-edit"></i></a>';
                    if (Auth::user()->can('delete categories'))
                        $action .= '<a href="subcategories/' . Hashids::encode($category->id) . '" class="text-danger btn-delete" data-toggle="tooltip" title="Delete Category""><i class="fa fa-lg fa-trash"></i></a>';

                    return $action;
                })
                ->make(true);
        }

        return view($this->resource . '/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->resource . '/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoryRequest $request)
    {
        SubCategory::create($request->except(['_token']));
        Session::flash('success', 'Category added!');
        return redirect($this->resource);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = decodeId($id);

        $category = SubCategory::find($id);


        return view($this->resource.'/edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = decodeId($id);
        $category = SubCategory::findOrFail($id);
        $category->update($request->except(['_token']));

        Session::flash('success', 'Sub Category updated!');

        return redirect($this->resource);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = decodeId($id);

        $categories = SubCategory::find($id);

        if($categories){
            $categories->delete();
            $response['message'] = 'Sub Categories deleted!';
            $status = $this->successStatus;
        }else{
            $response['message'] = 'Sub Categories not exist against this id!';
            $status = $this->errorStatus;
        }

        return response()->json(['result'=>$response], $status);
    }

    public function loadSubCategory()
    {
        $categories = SubCategory::where('category_id',\request()->Id)->get(['id','sub_name as text']);
        return response()->json(['data'=>$categories], $this->successStatus);
    }
}
