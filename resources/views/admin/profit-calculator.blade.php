@extends('admin.layouts.app')

@section('style')
<style>
    .mini-stat{background: #f7f7f7;}
</style>
@endsection
@section('content')

<?php 
 $role = roleName();
 $show = false;
?>

<section id="main-content" >
    <section class="wrapper">
        <div class="row">
            <div class="col-md-12">
                <!--breadcrumbs start -->
                <ul class="breadcrumb">
                    <li class="active"><i class="fa fa-home"></i> Profit Calculator</li>
                </ul>
                <!--breadcrumbs end -->
            </div>
        </div>                
        
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Profit Calculator
                        <span class="pull-right">
                            <div id="reportrange" class="pull-right report-range">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                <span></span> <b class="caret"></b>
                            </div>
                        </span>
                    </header>
                    <div class="panel-body retail-dashboard">
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mini-stat clearfix">
                                    <span class="mini-stat-icon pink"><i class="fa fa-money"></i></span>
                                    <div class="mini-stat-info" data-toggle="tooltip" title="Total income from products sold">
                                        <span id="total_income">0</span>
                                        Total PROFIT/LOSS
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-3">
                                <div class="mini-stat clearfix">
                                    <span class="mini-stat-icon orange"><i class="fa fa-shopping-cart"></i></span>
                                    <div class="mini-stat-info" data-toggle="tooltip" title="Total sales in this time period">
                                        <span id="total_sales">0</span>
                                        Total SALE
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mini-stat clearfix">
                                    <span class="mini-stat-icon pink"><i class="fa fa-shopping-cart"></i></span>
                                    <div class="mini-stat-info" data-toggle="tooltip" title="Total cost in this time period">
                                        <span id="total_costs">0</span>
                                        TOTAL COST
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mini-stat clearfix">
                                    <span class="mini-stat-icon orange"><i class="fa fa-shopping-cart"></i></span>
                                    <div class="mini-stat-info" data-toggle="tooltip" title="Number of sales in this time period">
                                        <span id="total_sale_count">0</span>
                                        SALE COUNT
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mini-stat clearfix">
                                    <span class="mini-stat-icon orange"><i class="fa fa-money"></i></span>
                                    <div class="mini-stat-info" data-toggle="tooltip" title="Average amounts per sale">
                                        <span id="total_expenses">0</span>
                                        TOTAL EXPENSES
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mini-stat clearfix">
                                    <span class="mini-stat-icon orange"><i class="fa fa-money"></i></span>
                                    <div class="mini-stat-info" data-toggle="tooltip" title="Average amounts per sale">
                                        <span id="sale_rep_expenses">0</span>
                                        SALE REP EXPENSES
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mini-stat clearfix">
                                    <span class="mini-stat-icon tar"><i class="fa fa-tag"></i></span>
                                    <div class="mini-stat-info" data-toggle="tooltip" title="Number of unique registered customers served in a time period">
                                        <span id="total_customers">0</span>
                                        CUSTOMER COUNT
                                    </div>
                                </div>
                            </div>                           
                            <div class="col-md-3 hidden">
                                <div class="mini-stat clearfix">
                                    <span class="mini-stat-icon green"><i class="fa fa-money"></i></span>
                                    <div class="mini-stat-info" data-toggle="tooltip" title="Total revenue less the cost of goods sold">
                                        <span id="total_profit">0</span>
                                        GROSS PROFIT
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 hidden">
                                <div class="mini-stat clearfix">
                                    <span class="mini-stat-icon pink"><i class="fa fa-money"></i></span>
                                    <div class="mini-stat-info" data-toggle="tooltip" title="Total amount discounted for this time period">
                                        <span id="total_discount">0</span>
                                        DISCOUNT
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-3 hidden">
                                <div class="mini-stat clearfix">
                                    <span class="mini-stat-icon orange">%</span>
                                    <div class="mini-stat-info" data-toggle="tooltip" title="Total amount discounted for this time period">
                                        <span id="discount_percentage">0</span>
                                        DISCOUNT % 
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 hidden">
                                <div class="mini-stat clearfix">
                                    <span class="mini-stat-icon tar"><i class="fa fa-shopping-cart"></i></span>
                                    <div class="mini-stat-info" data-toggle="tooltip" title="Average amounts per sale">
                                        <span id="basket_value">0</span>
                                        AVERAGE BASKET VALUE
                                    </div>
                                </div>
                            </div>                           
                            <div class="col-md-3 hidden">
                                <div class="mini-stat clearfix">
                                    <span class="mini-stat-icon green"><i class="fa fa-at"></i></span>
                                    <div class="mini-stat-info" data-toggle="tooltip" title="Average number of products per sale">
                                        <span id="basket_size">0</span>
                                        AVERAGE BASKET SIZE
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 profitCalculator">

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>   
    </section>
</section>
      
@endsection


@section('scripts')
<script type="text/javascript">
    
    $(document).ready(function () {
        
    var start = moment().subtract(6, 'days');
    var end = moment();

    function cb(from_date, end_date) {
        
        $(".retail-dashboard").LoadingOverlay("show");
        
        start = from_date;
        end = end_date;
        var store_id = $('#store_reports').val();
        
        $.ajax({
            url :  '{{ url("admin/balance-sheet") }}',
            type: 'post',
            data: 'from_date='+start.format('YYYY/MM/DD')+'&to_date='+end.format('YYYY/MM/DD'),
            dataType: "json",
            complete: function (data, textStatus, jqXHR) {
                $(".profitCalculator").html(data.responseText);
            }
        });
        
        $.ajax({
            url :  '{{ url("admin/reports/retail-dashboard") }}',
            type: 'post',
            data: 'store_id='+store_id+'&from_date='+start.format('YYYY/MM/DD')+'&to_date='+end.format('YYYY/MM/DD'),
            //data: {'from_date':start, 'to_date': end},
            success: function (result) { 
                console.log(result);
                var data = result.result;
                $('#total_income').text(data.total_income);
                $('#total_sale_count').text(data.total_sale_count);
                $('#total_sales').text(data.total_sales);
                $('#total_costs').text(data.cost_of_goods);
                $('#total_customers').text(data.total_customers);
                $('#total_profit').text(data.total_profit);
                $('#total_discount').text(data.total_discount);
                $('#discount_percentage').text(data.discount_percentage);
                $('#basket_value').text(data.basket_value);
                $('#basket_size').text(data.basket_size); 
                $('#total_expenses').text(data.total_expenses); 
                $('#sale_rep_expenses').text(data.sale_rep_expenses); 
        
                $(".retail-dashboard").LoadingOverlay("hide");
               
            }
        });
        
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        
    }
    
    $(document).on('change', '#store_reports', function(){
        cb(start, end)
     });
    
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    });
    
</script>
@endsection                            

