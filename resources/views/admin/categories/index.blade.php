@extends('admin.layouts.app')

@section('content')
<section id="main-content" >
    <section class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li class="active">Categories</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>                
        
         <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Categories
                        @can('add categories')
                        <span class="tools pull-right">
                            <a href="{{ url('admin/categories/create') }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Add New Category">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add New
                            </a>
                         </span>
                         @endcan
                    </header>
                    <div class="panel-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Prefix</th>
                                <th>Name</th>
                                <th>Total Products</th> 
                                @if(auth()->user()->can('edit categories') || auth()->user()->can('delete categories'))
                                <th>Actions</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                                <tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No data available in table</td></tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Image</th>                                
                                <th>Prefix</th>
                                <th>Name</th>
                                <th>Total Products</th> 
                                @if(auth()->user()->can('edit categories') || auth()->user()->can('delete categories'))
                                <th>Actions</th>
                                @endif
                            </tr>
                          </tfoot>
                        </table>
                    </div>
                </section>
            </div>
        </div>   
            
    </section>
</section>
      
@endsection


@section('scripts')
<script type="text/javascript">
$("document").ready(function () {
        var datatable_url = "{{url('admin/categories')}}";
        var datatable_columns = [
            {data: 'category_image', width: '10%',orderable: false, searchable:false},
            {data: 'prefix'},
            {data: 'category_name'},
            {data: 'products_count', name: 'products_count', width: '20%', className: 'text-center'},
            @if(auth()->user()->can('edit categories') || auth()->user()->can('delete categories'))
            {data: 'action',  width: '10%', orderable: false, searchable: false}
            @endif
            
            ];
        
            create_datatables(datatable_url,datatable_columns);
        
      });            
</script>
@endsection                            
