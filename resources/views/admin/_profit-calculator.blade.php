<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
    <div class="dt-buttons pull-right" style="margin-bottom: 10px;">   
        <!--<button class="dt-button buttons-csv buttons-html5 btn btn-sm btn-round btn-success" tabindex="0" aria-controls="datatable"><span><span data-toggle="tooltip" title="Export CSV"><i class="fa fa-lg fa-file-text-o"></i> CSV</span></span></button>--> 
        <button class="dt-button buttons-print btn btn-sm btn-round btn-info" tabindex="0" aria-controls="datatable"><span><span data-toggle="tooltip" title="Print"><i class="fa fa-lg fa-print"></i> Print</span></span></button> 
        <button class="dt-button buttons-pdf buttons-html5 btn btn-sm btn-round btn-danger" tabindex="0" aria-controls="datatable"><span><span data-toggle="tooltip" title="Export PDF"><i class="fa fa-lg fa-file-pdf-o"></i> PDF</span></span></button> 
    </div>
    <table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="datatable_info" style="width: 967px;">
        <thead>
        <tr>
            <th>Date</th>
            <th>Total Sale</th>
            <th>Stock Worth</th>
            <th>Total Expense</th>
            <th>Profit/Loss</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $totalSale = $totalStockWorth = $totalExpence = $totalProfitLoss = 0;
            foreach($merged as $date => $merge) {
                $rowSale = $rowStockWorth = $rowExpence = $rowProfitLoss = 0;
                foreach($merge as $data){
                    $type = (@$data->type == 'sale') ? 'Sale' : 'Expense';
                    if ($type=='Sale') {
                        $rowSale = $rowSale + $data->amount;
                        $rowStockWorth = $rowStockWorth + $data->cost_of_goods;
                    } else {
                        $rowExpence = $rowExpence + $data->amount;
                    }

                    $rowProfitLoss = $rowSale - $rowStockWorth - $rowExpence;
                }

                $totalSale = $totalSale + $rowSale;
                $totalStockWorth = $totalStockWorth + $rowStockWorth;
                $totalExpence = $totalExpence + $rowExpence;
                $totalProfitLoss = $totalProfitLoss + $rowProfitLoss;
                ?>

                <tr role="row" class="odd">
                    <td>{{ date('d-m-Y', strtotime($date)) }}</td>
                    <td>{{ $rowSale }}</td>
                    <td>{{ $rowStockWorth }}</td>
                    <td>{{ $rowExpence }}</td>
                    <td class="{{ ($rowProfitLoss<0) ? 'text-danger' : 'text-success' }}">{{ $rowProfitLoss }}</td>
                </tr>

            <?php } ?>
                <tr role="row" class="odd">
                    <th colspan="4"><span class="pull-right">Total Sale</span></th>
                    <td>{{ $totalSale }}</td>
                </tr>
                <tr role="row" class="odd">
                    <th colspan="4"><span class="pull-right">Total Stock Worth</span></th>
                    <td>{{ $totalStockWorth }}</td>
                </tr>
                <tr role="row" class="odd">
                    <th colspan="4"><span class="pull-right">Total Expense</span></th>
                    <td>{{ $totalExpence }}</td>
                </tr>
                <tr role="row" class="odd">
                    <th colspan="4"><span class="pull-right">Total Profit/Loss</span></th>
                    <td class="{{ ($totalProfitLoss<0) ? 'text-danger' : 'text-success' }}">{{ $totalProfitLoss }}</td>
                </tr>
        </tbody>
    <!--    <tfoot>
        <tr><th rowspan="1" colspan="1">Date</th><th rowspan="1" colspan="1">Name</th><th rowspan="1" colspan="1">Amount</th><th rowspan="1" colspan="1">Expense By</th><th rowspan="1" colspan="1">Action</th></tr>
      </tfoot>-->
    </table>
</div>
