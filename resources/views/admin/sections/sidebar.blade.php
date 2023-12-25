<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a  href="{{ route('admin.home') }}" {{ setActive(['admin/dashboard']) }}>
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @can('view admins')
                <li class="sub-menu">
                    <a href="javascript:void(0);" {{ setActive(['admin/admins','admin/sale-reps']) }}>
                        <i class="fa fa-users"></i>
                        <span>Admins</span>
                    </a>
                    <ul class="sub">
                        <li {{ setActive(['admin/admins']) }}><a href="{{ url('admin/admins') }}">Admins</a></li>
                        @can('view sale reps')
                        <li {{ setActive(['admin/sale-reps']) }}><a href="{{ url('admin/sale-reps') }}">Sale Representatives</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('view profit calculator')
                <li>
                    <a  href="{{ url('admin/profit-calculator') }}" {{ setActive(['admin/profit-calculator']) }}>
                        <i class="fa fa-calculator"></i>
                        <span>Profit Calculator</span>
                    </a>
                </li>
                @endcan
                
                @can('view suppliers')
                <li class="sub-menu">
                    <a href="javascript:void(0);" {{ setActive(['admin/suppliers','admin/purchase-orders']) }}>
                        <i class="fa fa-users"></i>
                        <span>Suppliers</span>
                    </a>
                    <ul class="sub">
                        <li {{ setActive(['admin/suppliers']) }}><a href="{{ url('admin/suppliers') }}">Suppliers</a></li>
                        @can('view purchase orders')
                        <li {{ setActive(['admin/purchase-orders']) }}><a href="{{ url('admin/purchase-orders') }}">Purchase Orders</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
               
                
                @can('view products')
                <li class="sub-menu">
                    <a href="javascript:void(0);" {{ setActive(['admin/products','admin/categories','admin/subcategories','admin/stores','admin/brands']) }}>
                        <i class="fa fa-shopping-cart"></i>
                        <span>Products</span>
                    </a>
                    <ul class="sub">
                        @can('view products')
                        <li {{ setActive(['admin/products']) }}><a href="{{ url('admin/products') }}">Products</a></li>
                        @endcan
                        @can('view categories')
                        <li {{ setActive(['admin/categories']) }}><a href="{{ url('admin/categories') }}">Categories</a></li>
                        @endcan
                        @can('view categories')
                        <li {{ setActive(['admin/subcategories']) }}><a href="{{ url('admin/subcategories') }}">Sub Categories</a></li>
                        @endcan
                        @can('view brands')
                        <li {{ setActive(['admin/brands']) }}><a href="{{ url('admin/brands') }}">Brands</a></li>
                        @endcan
                        @can('view stores123')
                        <li {{ setActive(['admin/stores']) }}><a href="{{ url('admin/stores') }}">Stores</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                
                @can('view quotations')
                <li class="sub-menu">
                    <a href="javascript:void(0);" {{ setActive(['admin/admin-orders', 'admin/invoices' ,'admin/purchase-orders', 'admin/quotation-invoices']) }}>
                        <i class="fa fa-shopping-cart"></i>
                        <span>Sales</span>
                    </a>
                    <ul class="sub">
                        <li {{ setActive(['admin/admin-orders']) }}><a href="{{ url('admin/admin-orders') }}">Quotations</a></li>
                        <li {{ setActive(['admin/invoices']) }}><a href="{{ url('admin/invoices') }}">Invoices</a></li>
                        <li {{ setActive(['admin/quotation-invoices']) }}><a href="{{ url('admin/quotation-invoices') }}">Customer Quotations/Invoices</a></li>
                        <li {{ setActive(['admin/invoices/details']) }}><a href="{{ url('admin/invoices/details') }}">Invoices Amount</a></li>
                           
                        
                    </ul>
                </li>
                @endcan
                
                @can('view expenses')
                <li class="sub-menu">
                    <a href="javascript:void(0);" {{ setActive(['admin/expenses','admin/expense-types']) }}>
                        <i class="fa fa-money"></i>
                        <span>Expenses</span>
                    </a>
                    <ul class="sub">
                        <li {{ setActive(['admin/expenses']) }}><a href="{{ url('admin/expenses') }}">Expenses</a></li>
                        @can('view expense types')
                        <li {{ setActive(['admin/expense-types']) }}><a href="{{ url('admin/expense-types') }}">Expense Types</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                
                @can('view wholesaler')
                <li class="sub-menu">
                    <a href="javascript:void(0);" {{ setActive(['admin/shopkeepers','admin/wholesalers','admin/customers']) }}>
                        <i class="fa fa-users"></i>
                        <span>Customers</span>
                    </a>
                    <ul class="sub">
                        <li {{ setActive(['admin/shopkeepers']) }}><a href="{{ url('admin/shopkeepers') }}">Shopkeepers</a></li>
                        <!--<li {{ setActive(['admin/wholesalers']) }}><a href="{{ url('admin/wholesalers') }}">Wholesalers</a></li>-->
                    </ul>
                </li>
                @endcan
                
                @can('view retailers')
                <li class="sub-menu">
                    <a href="javascript:void(0);" {{ setActive(['admin/retailer-orders','admin/shopkeeper-orders', 'admin/whole-saler-orders']) }}>
                        <i class="fa fa-file-text"></i>
                        <span>Orders</span>
                    </a>
                    <ul class="sub">
                        @can('view retailers')
                        <li>
                            <a  href="{{ route('admin.retailer.orders')  }}" {{ setActive(['admin/retailer-orders']) }}>Website Orders ({{checkNewOrder('retailer')}})</a>
                        </li>
                        @endcan
                        <li {{ setActive(['admin/shopkeeper-orders']) }}><a href="{{ url('admin/shopkeeper-orders') }}">Shopkeeper Orders ({{checkNewOrder('wholesaler')}})</a></li>
                        @can('view wholesaler')
                        <li {{ setActive(['admin/whole-saler-orders']) }}><a href="{{ url('admin/whole-saler-orders') }}">Wholesaler Orders ({{checkNewOrder('wholesaler')}})</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                
                @can('view calculator123')
                <li>
                    <a  href="{{ url('admin/calculator') }}" {{ setActive(['admin/calculator']) }}>
                        <i class="fa fa-calculator"></i>
                        <span>Calculator</span>
                    </a>
                </li>
                @endcan
                
                @can('view customers123')
                <li>
                    <a  href="{{ url('admin/customers') }}" {{ setActive(['admin/customers']) }}>
                        <i class="fa fa-users"></i>
                        <span>Retailer</span>
                    </a>
                </li>
                @endcan
                 
                
                @can('view customer orders123')
                <li>
                    <a  href="{{ url('admin/order-users')  }}" {{ setActive(['admin/order-users']) }}>
                        <i class="fa fa-users"></i>
                        <span>Customers</span>
                    </a>
                </li>
                @endcan
                 
                
                 @can('view van stores')
                <li>
                    <a  href="{{ url('admin/van-store')  }}" {{ setActive(['admin/van-store']) }}>
                        <i class="fa fa-shopping-cart"></i>
                        <span>Van Store</span>
                    </a>
                </li>
                 @endcan 
                
                
                @can('view drop_shipper123')
                    <li>
                        <a  href="{{ route('admin.shipper.orders')  }}" {{ setActive(['admin/shipper-orders']) }}>
                            <i class="fa fa-users"></i>
                            <span>Drop Shipper Orders ({{checkNewOrder('dropshipper')}})</span>
                        </a>
                    </li>
                @endcan
                @can('view drop_shipper123')
                <li>
                    <a  href="{{ url('admin/drop-shipper') }}" {{ setActive(['admin/drop-shipper']) }}>
                        <i class="fa fa-users"></i>
                        <span>Drop Shipper</span>
                    </a>
                </li>
                @endcan
                @can('view courier_assignment123')
                <li>
                    <a  href="{{ url('admin/courier-assignment') }}" {{ setActive(['admin/courier-assignment']) }}>
                        <i class="fa fa-paper-plane"></i>
                        <span>Courier Assignment</span>
                    </a>
                </li>
                @endcan
                @can('view user invoices')
                <li>
                    <a  href="{{ url('admin/get-users') }}" {{ setActive(['admin/get-users']) }}>
                        <i class="fa fa-file-text"></i>
                        <span>User Invoices</span>
                    </a>
                </li>
                @endcan
                
                
                @can('view orders123')
                <li>
                    <a  href="{{ url('admin/orders') }}" {{ setActive(['admin/orders']) }}>
                        <i class="fa fa-file-text"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <!-- <li>
                    <a  href="{{ url('admin/sales') }}" {{ setActive(['admin/sales','admin/invoice']) }}>
                        <i class="fa fa-file-text"></i>
                        <span>Sales</span>
                    </a>
                </li> -->
                @endcan
                @can('view manage stocks')
                <li>
                    <a  href="{{ url('admin/manage-stocks') }}" {{ setActive(['admin/manage-stocks']) }}>
                        <i class="fa fa-filter"></i>
                        <span>Manage Stocks</span>
                    </a>
                </li>
                @endcan
                
                @can('view promotions123')
                <li>
                    <a  href="{{ url('admin/promotions') }}" {{ setActive(['admin/promotions']) }}>
                        <i class="fa fa-bullhorn"></i>
                        <span>Promotions</span>
                    </a>
                </li>
                @endcan
                @can('view_comments123')
                    <li>
                        <a  href="{{ url('admin/product-feedback') }}" {{ setActive(['admin/product-feedback']) }}>
                            <i class="fa fa-comments-o"></i>
                            <span>Feed Backs</span>
                        </a>
                    </li>
                @endcan
                
                @can('view reports')
                <li class="sub-menu">
                    <a href="javascript:void(0);" {{ setActive(['admin/reports']) }}>
                        <i class="fa fa-area-chart"></i>
                        <span>Reports</span>
                    </a>
                    <ul class="sub">
                        <li {{ setActive(['admin/reports/retail']) }}><a href="{{ url('admin/reports/retail') }}">Retail Dashboard</a></li>
                        <li {{ setActive(['admin/reports/stock']) }}><a href="{{ url('admin/reports/stock') }}">Stock Report</a></li>
                        <li {{ setActive(['admin/reports/sale']) }}><a href="{{ url('admin/reports/sale') }}">Sale Report</a></li>
                        <li {{ setActive(['admin/reports/product']) }}><a href="{{ url('admin/reports/product') }}">Product Report</a></li>
                        <li {{ setActive(['admin/reports/customer']) }}><a href="{{ url('admin/reports/customer') }}">Customer Report</a></li>
                    </ul>
                </li>
                @endcan
                @can('view pages123')
                <li>
                    <a  href="{{ url('admin/pages') }}" {{ setActive(['admin/pages']) }}>
                        <i class="fa fa-home"></i>
                        <span>CMS Pages</span>
                    </a>
                </li>
                @endcan
                @can('view faqs123')
                <li>
                    <a  href="{{ url('admin/faqs') }}" {{ setActive(['admin/faqs']) }}>
                        <i class="fa fa-question-circle"></i>
                        <span>FAQS</span>
                    </a>
                </li>
                @endcan
                @can('view newsletters123')
                <li class="sub-menu">
                    <a href="javascript:void(0);" {{ setActive(['admin/newsletters','admin/subscribers']) }}>
                        <i class="fa fa-newspaper-o"></i>
                        <span>Newsletters</span>
                    </a>
                    <ul class="sub">
                        <li {{ setActive(['admin/newsletters']) }}><a href="{{ url('admin/newsletters') }}">Newsletters</a></li>
                        @can('view newsletter subscriber')
                        <li {{ setActive(['admin/subscribers']) }}><a href="{{ url('admin/subscribers') }}">Subscribers</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('view settings')
                <li class="sub-menu">
                    <a href="javascript:void(0);" {{ setActive(['admin/shippings','admin/couriers','admin/settings','admin/sliders','admin/currencies','admin/tax-rates','admin/variants','admin/roles','admin/permissions']) }}>
                        <i class="fa fa-cogs"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub">
                        
                        
                        @can('view couriers')
                        <li {{ setActive(['admin/couriers']) }}><a href="{{ url('admin/couriers') }}">Couriers</a></li>
                        @endcan
                        @can('view shippings')
                        <li {{ setActive(['admin/shippings']) }}><a href="{{ url('admin/shippings') }}">Shippings</a></li>
                        @endcan
                        @can('view sliders123')
                        <li {{ setActive(['admin/sliders']) }}><a href="{{ url('admin/sliders') }}">Sliders</a></li>
                        @endcan
                        @can('view currencies123')
                        <li {{ setActive(['admin/currencies']) }}><a href="{{ url('admin/currencies') }}">Currencies</a></li>
                        @endcan
                        @can('view tax rates')
                        <li {{ setActive(['admin/tax-rates']) }}><a href="{{ url('admin/tax-rates') }}">Tax Rates</a></li>
                        @endcan
                        @can('view attributes123')
                        <li {{ setActive(['admin/variants']) }}><a href="{{ url('admin/variants') }}">Attributes</a></li>
                        @endcan
                        @can('view roles123')
                         <li {{ setActive(['admin/roles']) }}><a href="{{ url('admin/roles') }}">Roles</a></li>
                         @endcan
                        @can('view permissions123')
                        <li {{ setActive(['admin/permissions']) }}><a href="{{ url('admin/permissions') }}">Permissions</a></li>
                        @endcan
                        @can('view settings')
                        <li {{ setActive(['admin/settings']) }}><a href="{{ url('admin/settings') }}">System Settings</a></li>
                        @endcan
                    </ul>
                </li>
                @endcan
            </ul>
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
