<?php


Route::redirect('home','dashboard');

Route::group(['namespace' => 'Admin'], function () {
    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::get('profit-calculator', 'HomeController@profitCalculator');
    Route::post('balance-sheet', 'ReportController@balanceSheet');
    Route::get('calculator', 'CalculatorController@index');

    Route::resource('stores', 'StoreController');
    Route::resource('categories', 'CategoriesController');
    Route::get('get-store-categories/{store_id}','CategoriesController@getStoreCategories');
    Route::resource('products', 'ProductsController');
    Route::patch('products/update-store/{product_id}', 'ProductsController@updateStore');
    Route::patch('products/update-combo-products/{product_id}', 'ProductsController@updateComboProducts');
    Route::delete('products/remove-variant/{variant_id}','ProductsController@removeVariant');
    Route::delete('products/remove-combo/{combo_id}','ProductsController@removeCombo');
    Route::post('products/store-image','ProductsController@storeImage');
    Route::get('products/delete-image/{id}','ProductsController@deleteImage');
    Route::post('products/set-default-image','ProductsController@setDefaultImage');
    Route::get('products/get-store-categories/{store_id}','ProductsController@getStoreCategories');
    Route::get('get-all-store-categories/{product_id?}','ProductsController@getAllStoreCategories');
    Route::post('products/create-product-attribute','ProductsController@createProductAttribute');
    Route::get('products/get-product-attributes/{product_id}','ProductsController@getProductAttributes');
    Route::delete('products/remove-product-attribute/{id}','ProductsController@removeProductAttribute');
    Route::post('products/create-product-variant','ProductsController@createProductVariant');
    Route::get('products/get-product-variants/{product_id}','ProductsController@getProductVariants');
    Route::post('products/set-product-as-default','ProductsController@setProductAsDefault');
    Route::get('products/get-product-modifiers/{product_id}','ProductsController@getProductModifiers');
    Route::post('products/set-product-modifier','ProductsController@setProductModifier');
    Route::get('products/edit/{product_id}','ProductsController@editVariant');
    Route::patch('products/update-variant-product/{product_id}','ProductsController@updateVariantProduct');
    Route::get('get-combo-products','ProductsController@getComboProducts');
    Route::get('get-product-stocks','ProductsController@productStocks');
    Route::get('product-stocks/{product_id}','ProductsController@productStocks');
    Route::get('get-product-stocks/{product_id}','ProductsController@getProductStocks');
    Route::post('upload-csv-products','ProductsController@uploadCsvProducts');
    Route::post('update-invoice','OrdersController@updateInvoice')->name('update.invoice');
    Route::get('products/make-copy/{product_id}','ProductsController@makeCopy');
    Route::post('products/delete-multi-products','ProductsController@deleteMultiProducts');

    Route::resource('van-store','VanStoreController');
    Route::get('get-van-store-product-row/{barcode?}', 'VanStoreController@getProductRow');
    
    Route::resource('manage-stocks', 'StockController');
    Route::get('get-store-products', 'StockController@getStoreProducts');
    
    Route::resource('shopkeepers', 'ShopkeeperController');
    Route::GET('shopkeeper-orders','ShopkeeperController@orders')->name('shopkeepers.orders');
    
    Route::resource('wholesalers', 'WholesalerController');
    Route::GET('whole-saler-orders','WholesalerController@wholeSalerOrders')->name('whole.saler.orders');
    Route::resource('drop-shipper', 'DropShipperController');
    Route::get('shipper-orders', 'DropShipperController@dropShipperOrders')->name('shipper.orders');
    Route::resource('courier-assignment', 'CourierAssignmentsController');
    Route::resource('subcategories', 'SubCategoriesController');
    Route::POST('load-subcategory', 'SubCategoriesController@loadSubCategory')->name('load.subcategory');
    Route::resource('customers', 'CustomerController');
    Route::get('customers/{user_id}/wallet-statment', 'CustomerController@walletStatment');
    Route::get('delete-wallet-statement/{id}', 'CustomerController@deleteWalletStatment');

    Route::post('add-wallet-amount','CustomerController@addWalletAmount')->name('add.wallet.amount');
    Route::post('add-2pay-amount','CustomerController@add2PayAmount')->name('add.2pay.amount');
    
    Route::get('retailer-orders','CustomerController@retailerOrders')->name('retailer.orders');
    Route::resource('variants', 'VariantController');
    Route::resource('suppliers', 'SuppliersController');
    Route::resource('brands', 'BrandController');
    Route::resource('shippings', 'ShippingController');
    Route::resource('couriers', 'CourierController');
    Route::resource('currencies', 'CurrencyController');
    Route::resource('tax-rates', 'TaxRatesController');
    Route::resource('sliders', 'SliderController');
    
    Route::resource('expense-types', 'ExpenseTypeController');
    Route::resource('expenses', 'ExpenseController');

    Route::resource('promotions', 'PromotionController');

    Route::resource('admins', 'AdminController');
    Route::resource('sale-reps', 'SaleRepController');
    Route::get('login-sale-reps/{id}', 'SaleRepController@login');
    Route::get('profile', 'ProfileController@index');

    Route::get('get-users', 'ProfileController@getInvoiceList');
    Route::post('profile/update', 'ProfileController@update');
    Route::get('change-password', 'ProfileController@changePasswordView');
    Route::post('change-password', 'ProfileController@changePassword');

    Route::get('settings', 'SettingsController@index');
    Route::post('settings/update', 'SettingsController@update');

    Route::resource('pages', 'PageController');
    Route::resource('faqs', 'FaqsController');

    //Reports
    Route::get('reports/retail', 'ReportController@index');
    Route::post('reports/retail-dashboard', 'ReportController@index');
    Route::get('reports/stock/{store_id?}', 'ReportController@stocksChart');
    Route::get('reports/sale', 'ReportController@saleReport');
    Route::get('reports/customer', 'ReportController@customerReport');
    Route::get('reports/product', 'ReportController@productReport');

    // Role and Permissions
    Route::resource('roles', 'RoleController');
    Route::get('roles/permissions/{role_id}', 'RoleController@getRolePermissions');
    Route::put('roles/permissions/{role_id}', 'RoleController@updateRolePermission');
    Route::resource('permissions', 'PermissionController');

    // Newsletter
    Route::resource('newsletters', 'NewslettersController');
    Route::get('subscribers','NewslettersController@index');
    Route::get('subscribers','NewslettersController@subscribers');
    Route::put('is_subscribed/{id}','NewslettersController@is_subscribed');
    Route::get('manage-newsletters','NewslettersController@newsletters_listing');
    Route::get('get_newsletters','NewslettersController@get_newsletters');
    Route::put('newsletter_action/{id}','NewslettersController@newsletter_action');

    // Orders
    Route::resource('orders', 'OrdersController');
    Route::put('orders/change-status/{id}/{cart_id}','OrdersController@changStatus');
    Route::put('orders/change-courier/{id}/{cart_id}','OrdersController@changeCourier');
    Route::get('order-print/{id}','OrdersController@orderPrint');
      Route::put('orders/update-order-status/{cart_id}','OrdersController@updateOrderStatus');
    Route::post('invoice/update-product-courier','OrdersController@updateProductCourier');

    //Admin orders
    Route::resource('admin-orders', 'AdminOrderController');
    Route::get('get-product-row', 'AdminOrderController@getProductRow');
    Route::get('get-product-details/{id}', 'AdminOrderController@getProductDetails');
    Route::get('admin-order-print/{id}','AdminOrderController@orderPrint');
    Route::get('admin-orders/quotation/{id}','AdminOrderController@getQuotation');
    Route::get('admin-order-quotation-print/{id}','AdminOrderController@orderQuotationPrint');
    Route::post('admin-orders/update-quotation','AdminOrderController@updateQuotation');
    
    Route::get('order-users', 'OrderUserController@index');
    Route::get('users/import', 'OrderUserController@import');
    Route::post('users/import', 'OrderUserController@importUsers');
    
    Route::any('quotation-invoices', 'AdminOrderController@quotationInvoices');
    Route::get('invoices/details', 'AdminOrderController@getInvoiceAmount');
    Route::any('invoices', 'AdminOrderController@getAllInvoices');
    Route::get('admin-orders/delete-quotation/{id}', 'AdminOrderController@deleteQuotation');
    Route::post('admin-orders/cancel-quotation', 'AdminOrderController@cancelQuotation');
    Route::post('admin-orders/undo-quotation', 'AdminOrderController@undoQuotation');
    
    //Purchase orders
    Route::resource('purchase-orders', 'PurchaseOrderController');
    Route::get('purchase-orders/supplier/{id}','PurchaseOrderController@suppierPurchaseOrders');
    Route::get('purchase-order-print/{id}','PurchaseOrderController@orderPrint');
    
    // Courier Assignment
    Route::resource('courier-assignment', 'CourierAssignmentsController');
    Route::get('courier-assignment/{id}', 'CourierAssignmentsController@edit');
    Route::get('courier-assignment/cartDetails/{id}', 'CourierAssignmentsController@cartDetails');
    Route::post('courier-assignment/{id}/store', 'CourierAssignmentsController@update');
    Route::get('cancel-request/{id}/admin', 'CourierAssignmentsController@cancelRequestAdmin');
    Route::get('courier/reset/{id}/admin', 'CourierAssignmentsController@resetCourier');

    Route::get('product-feedback', 'ProductsController@productFeedBack');
    Route::delete('delete-comment/{id}', 'ProductsController@deleteFeedBack');

    Route::get('update-status/{name}/{id?}', 'AdminController@updateStatusPayment');
    Route::get('update-status-order/{id}', 'AdminController@updateStatusOrder');
    Route::get('update-delivery-status/{id}', 'AdminController@updateDeliveryStatus');
    Route::get('login-as-admin', 'AdminController@login');
    
    Route::get('send-email', 'HomeController@sendEmailView');
    Route::post('send-email', 'HomeController@sendEmail');
       
    
    Route::get('get-wallet-amount/{id}','AdminOrderController@getWalletAmount');
});

