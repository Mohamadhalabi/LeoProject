<?php

#region home page
Route::get('/', [App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('home');
Route::post('pending/payment/datatable', [App\Http\Controllers\Backend\UserWalletController::class, 'datatable'])->name('pending.payment.datatable');
Route::post('save-token', [App\Http\Controllers\Backend\DashboardController::class, 'save_token'])->name('save.token');
#endregion

#region logout
Route::get('logout', [\App\Http\Controllers\Backend\DashboardController::class, 'logout'])->name('logout');
Route::get('locale/{locale}', [\App\Http\Controllers\Backend\DashboardController::class, 'change_locale'])->name('set_locale');
#endregion

#region admins
Route::resource('admins', \App\Http\Controllers\Backend\ManagerAccess\AdminsController::class, ['except' => 'show']);
Route::post('admins/datatable', [\App\Http\Controllers\Backend\ManagerAccess\AdminsController::class, 'datatable'])->name('admins.datatable');
Route::post('admins/change/status', [\App\Http\Controllers\Backend\ManagerAccess\AdminsController::class, 'change_status'])->name('admins.change.status');
Route::post('admins/delete-selected', [\App\Http\Controllers\Backend\ManagerAccess\AdminsController::class, 'delete_selected_items'])->name('admins.delete-selected');

#endregion

#region profile
Route::get('profile', [\App\Http\Controllers\Backend\ProfileController::class, 'index'])->name('profile');
Route::post('profile', [\App\Http\Controllers\Backend\ProfileController::class, 'update'])->name('profile.update');

#endregion

#region media
Route::get('media', [\App\Http\Controllers\Backend\MediaController::class, "index"])->name('media.index');
Route::group(['prefix' => 'media', 'as' => 'media.'], function () {
    Route::post('get/files', [\App\Http\Controllers\Backend\MediaModelController::class, 'get'])->name('get.files');
    Route::post('delete/files', [\App\Http\Controllers\Backend\MediaController::class, 'delete_files'])->name('delete.files');
    Route::post('details/files', [\App\Http\Controllers\Backend\MediaController::class, 'file_details'])->name('details.files');
    Route::post('upload/files', [\App\Http\Controllers\Backend\MediaController::class, 'upload_files'])->name('upload.files');
    Route::post('check/files', [\App\Http\Controllers\Backend\MediaController::class, 'check'])->name('check.files');
    Route::post('update/files', [\App\Http\Controllers\Backend\MediaController::class, 'update'])->name('update.files');
    Route::post('create/folder', [\App\Http\Controllers\Backend\MediaController::class, 'create_folder'])->name('create.folder');
    Route::post('delete/folder', [\App\Http\Controllers\Backend\MediaController::class, 'delete_folder'])->name('delete.folder');
    Route::post('model/get', [\App\Http\Controllers\Backend\MediaModelController::class, 'get'])->name('model.get');
    Route::group(['prefix' => 'cut', 'as' => 'cut.'], function () {
        Route::post('get/folder', [\App\Http\Controllers\Backend\MediaController::class, 'cut_get_folder'])->name('get.folder');
        Route::post('set/folder', [\App\Http\Controllers\Backend\MediaController::class, 'cut_set_folder'])->name('set.folder');
    });
});
#endregion

#region role
Route::resource('roles', \App\Http\Controllers\Backend\ManagerAccess\RoleController::class, ['except' => 'show']);
Route::post('roles/datatable', [\App\Http\Controllers\Backend\ManagerAccess\RoleController::class, 'datatable'])->name('roles.datatable');
Route::post('roles/get/permission', [\App\Http\Controllers\Backend\ManagerAccess\RoleController::class, 'getPermission'])->name('roles.get.permission');
Route::post('roles/delete-selected', [\App\Http\Controllers\Backend\ManagerAccess\RoleController::class, 'delete_selected_items'])->name('roles.delete-selected');

#endregion
#region setting
Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
    #region website
    Route::get('/', [\App\Http\Controllers\Backend\SettingController::class, 'index'])->name('index');
    Route::post('/', [\App\Http\Controllers\Backend\SettingController::class, 'update'])->name('update');
    #endregion

    #region stmp
    Route::get('smtp', [\App\Http\Controllers\Backend\SettingController::class, 'smtp'])->name('smtp');
    Route::post('smtp', [\App\Http\Controllers\Backend\SettingController::class, 'smtp_update'])->name('smtp.update');
    #endregion

    #region global
    Route::get('global', [\App\Http\Controllers\Backend\SettingController::class, 'global_seo'])->name('global');
    Route::post('global', [\App\Http\Controllers\Backend\SettingController::class, 'global_seo_update'])->name('global.update');
    #endregion

    #region social
    Route::get('social', [\App\Http\Controllers\Backend\SettingController::class, 'social_media'])->name('social');
    Route::post('social', [\App\Http\Controllers\Backend\SettingController::class, 'social_media_update'])->name('social.update');
    #endregion

    #region contact
    Route::get('contact', [\App\Http\Controllers\Backend\SettingController::class, 'contact'])->name('contact');
    Route::post('contact', [\App\Http\Controllers\Backend\SettingController::class, 'contact_update'])->name('contact.update');
    #endregion

    #region translate
    Route::get('translate', [\App\Http\Controllers\Backend\SettingController::class, 'translate'])->name('translate');
    #endregion
    #region payment
    Route::get('payment', [\App\Http\Controllers\Backend\SettingController::class, 'payment_methods'])->name('payment');
    Route::post('payment', [\App\Http\Controllers\Backend\SettingController::class, 'payment_update'])->name('payment.update');
    #endregion

    #region shipping
    Route::get('shipping', [\App\Http\Controllers\Backend\SettingController::class, 'shipping'])->name('shipping');
    Route::post('shipping', [\App\Http\Controllers\Backend\SettingController::class, 'store_shipping'])->name('shipping.update');
    #endregion
    #region frontend
    Route::get('frontend', [\App\Http\Controllers\Backend\SettingController::class, 'frontend'])->name('frontend');
    Route::post('frontend', [\App\Http\Controllers\Backend\SettingController::class, 'frontend_update'])->name('frontend.update');
    #endregion

    #region notifications

    Route::get('notifications', [\App\Http\Controllers\Backend\SettingController::class, 'notifications'])->name('notifications');
    Route::post('notifications', [\App\Http\Controllers\Backend\SettingController::class, 'update_notifications'])->name('notifications.update');
    #endregion

    #region payment methods
    Route::resource('payment-methods', \App\Http\Controllers\Backend\PaymentMethodsController::class, ['except' => 'show']);
    Route::group(['as' => 'payment-methods.', 'prefix' => 'payment-methods'], function () {
        Route::post('datatable', [\App\Http\Controllers\Backend\PaymentMethodsController::class, 'datatable'])->name('datatable');
        Route::post('change/status', [\App\Http\Controllers\Backend\PaymentMethodsController::class, 'change_status'])->name('change.status');
        Route::post('delete-selected', [\App\Http\Controllers\Backend\PaymentMethodsController::class, 'delete_selected_items'])->name('delete-selected');
    });
    #end region
});
#endregion

#region ticket replies
#region category
Route::resource('categories', \App\Http\Controllers\Backend\CategoyController::class, ['except' => 'show']);
Route::group(['as' => 'categories.', 'prefix' => 'categories'], function () {
    Route::post('datatable', [\App\Http\Controllers\Backend\CategoyController::class, 'datatable'])->name('datatable');
    Route::post('change/status', [\App\Http\Controllers\Backend\CategoyController::class, 'change_status'])->name('change.status');
    Route::post('check/slug', [\App\Http\Controllers\Backend\CategoyController::class, 'check_slug'])->name('check.slug');
    Route::post('delete-selected', [\App\Http\Controllers\Backend\CategoyController::class, 'delete_selected_items'])->name('delete-selected');
    Route::post('load/parents', [\App\Http\Controllers\Backend\CategoyController::class, 'load_parents'])->name('load.parents');
});
#endregion

#region Language
Route::resource('languages', \App\Http\Controllers\Backend\LanguageController::class, ['except' => 'show']);
Route::post('languages/datatable', [\App\Http\Controllers\Backend\LanguageController::class, 'datatable'])->name('languages.datatable');
Route::post('languages/change/status', [\App\Http\Controllers\Backend\LanguageController::class, 'change_status'])->name('languages.change.status');
Route::post('languages/change/is_default', [\App\Http\Controllers\Backend\LanguageController::class, 'change_default'])->name('languages.change.default');
Route::post('languages/delete-selected', [\App\Http\Controllers\Backend\LanguageController::class, 'delete_selected_items'])->name('languages.delete-selected');

#endregion

#region Attributes
Route::resource('attributes', \App\Http\Controllers\Backend\AttributeController::class, ['except' => 'show']);
Route::post('attributes/datatable', [\App\Http\Controllers\Backend\AttributeController::class, 'datatable'])->name('attributes.datatable');
Route::post('attributes/change/status', [\App\Http\Controllers\Backend\AttributeController::class, 'change_status'])->name('attributes.change.status');
Route::post('attributes/delete-selected', [\App\Http\Controllers\Backend\AttributeController::class, 'delete_selected_items'])->name('attributes.delete-selected');

#region sub-attrbuite
//Route::resource('attributes' , \App\Http\Controllers\Backend\AttributeController::class ,['except'=>'show']);
Route::get('attributes/{attribute_id}', [\App\Http\Controllers\Backend\SubAttributeController::class, 'index'])->name('attributes.sub-attributes.index');
Route::get('attributes/{attribute_id}/sub-attributes/create', [\App\Http\Controllers\Backend\SubAttributeController::class, 'create'])->name('attributes.sub-attributes.create');
Route::get('attributes/{attribute_id}/sub-attributes/edit/{id}', [\App\Http\Controllers\Backend\SubAttributeController::class, 'edit'])->name('attributes.sub-attributes.edit');
Route::post('attributes/{attribute_id}/sub-attributes/store', [\App\Http\Controllers\Backend\SubAttributeController::class, 'store'])->name('attributes.sub-attributes.store');
Route::patch('attributes/{attribute_id}/sub-attributes/update', [\App\Http\Controllers\Backend\SubAttributeController::class, 'update'])->name('attributes.sub-attributes.update');
Route::delete('attributes/sub-attributes/destroy/{sub_attribute}', [\App\Http\Controllers\Backend\SubAttributeController::class, 'destroy'])->name('attributes.sub-attributes.destroy');
Route::post('attributes/sub-attributes/delete-selected', [\App\Http\Controllers\Backend\SubAttributeController::class, 'delete_selected_items'])->name('attributes.sub-attributes.delete-selected');

Route::post('attributes/sub-attribute/change/status', [\App\Http\Controllers\Backend\SubAttributeController::class, 'change_status'])->name('attributes.sub-attributes.change.status');
Route::post('attributes/sub-attribute/{attribute_id}/datatable/', [\App\Http\Controllers\Backend\SubAttributeController::class, 'datatable'])->name('attributes.sub-attribute.datatable');

#endregion

#region Language
Route::resource('coupons', \App\Http\Controllers\Backend\CouponController::class, ['except' => 'show']);
Route::post('coupons/datatable', [\App\Http\Controllers\Backend\CouponController::class, 'datatable'])->name('coupons.datatable');
Route::post('coupons/change/status', [\App\Http\Controllers\Backend\CouponController::class, 'change_status'])->name('coupons.change.status');
Route::post('coupons/delete-selected', [\App\Http\Controllers\Backend\CouponController::class, 'delete_selected_items'])->name('coupons.delete-selected');

#endregion

#region user
Route::resource('users', \App\Http\Controllers\Backend\UserController::class);
Route::group(['as' => 'users.', 'prefix' => 'users'], function () {

    Route::post('datatable', [\App\Http\Controllers\Backend\UserController::class, 'datatable'])->name('datatable');
    Route::post('change/status', [\App\Http\Controllers\Backend\UserController::class, 'change_status'])->name('change.status');
    Route::post('/delete-selected', [\App\Http\Controllers\Backend\UserController::class, 'delete_selected_items'])->name('delete-selected');
    Route::post('load/cities', [\App\Http\Controllers\Backend\UserController::class, 'load_cities'])->name('load.cities');
    Route::group(['prefix' => '{user_id}'], function () {
        Route::post('addresses', [\App\Http\Controllers\Backend\UserController::class, 'addresses'])->name('addresses');
        Route::post('overview', [\App\Http\Controllers\Backend\UserController::class, 'overview'])->name('overview');
        Route::post('update', [\App\Http\Controllers\Backend\UserController::class, 'update'])->name('update');
        Route::post('tickets', [\App\Http\Controllers\Backend\UserController::class, 'tickets'])->name('tickets');
        Route::post('tickets/datatable', [\App\Http\Controllers\Backend\UserController::class, 'ticket_datatable'])->name('tickets.data_table');
        Route::post('wishlists', [\App\Http\Controllers\Backend\UserController::class, 'wishlist'])->name('wishlists');
        Route::post('wishlists/datatable', [\App\Http\Controllers\Backend\UserController::class, 'wishlist_datatable'])->name('wishlists.data_table');
        Route::post('reviews', [\App\Http\Controllers\Backend\UserController::class, 'reviews'])->name('reviews');
        Route::post('reviews/datatable', [\App\Http\Controllers\Backend\UserController::class, 'reviews_datatable'])->name('reviews.datatable');
        Route::post('carts', [\App\Http\Controllers\Backend\UserController::class, 'carts'])->name('carts');
        Route::post('carts/datatable', [\App\Http\Controllers\Backend\UserController::class, 'cart_datatable'])->name('carts.datatable');
        Route::post('orders', [\App\Http\Controllers\Backend\UserController::class, 'orders'])->name('orders');
        Route::post('orders/datatable', [\App\Http\Controllers\Backend\UserController::class, 'orders_datatable'])->name('orders.datatable');
        Route::group(['prefix' => 'wallet'], function () {
            Route::post('/', [\App\Http\Controllers\Backend\UserController::class, 'wallet'])->name('wallet');
            Route::post('datatable', [\App\Http\Controllers\Backend\UserController::class, 'wallet_datatable'])->name('wallet.datatable');
            Route::post('send/statement/account', [\App\Http\Controllers\Backend\UserController::class, 'send_account_statement'])->name('wallet.send.account.statement');
            Route::post('send/reminder', [\App\Http\Controllers\Backend\UserController::class, 'send_reminder'])->name('wallet.send.reminder');
        });
        Route::post('coupon', [\App\Http\Controllers\Backend\UserController::class, 'coupon'])->name('coupon');
        Route::post('coupon/datatable', [\App\Http\Controllers\Backend\UserController::class, 'coupon_datatable'])->name('coupon.datatable');
        Route::post('coupon/orders', [\App\Http\Controllers\Backend\UserController::class, 'coupons_orders'])->name('coupon.order');
        Route::post('cards', [\App\Http\Controllers\Backend\UserController::class, 'cards'])->name('cards');
        Route::post('cards/datatable', [\App\Http\Controllers\Backend\UserController::class, 'cards_datatable'])->name('cards.datatable');
        Route::post('compares', [\App\Http\Controllers\Backend\UserController::class, 'compares'])->name('compares');
        Route::post('compares/datatable', [\App\Http\Controllers\Backend\UserController::class, 'compares_datatable'])->name('compares.datatable');
    });
});
#endregion

#region Language
Route::resource('pages', \App\Http\Controllers\Backend\PageController::class, ['except' => 'show']);
Route::group(['as' => 'pages.', 'prefix' => 'pages'], function () {
    Route::post('datatable', [\App\Http\Controllers\Backend\PageController::class, 'datatable'])->name('datatable');
    Route::post('change/status', [\App\Http\Controllers\Backend\PageController::class, 'change_status'])->name('change.status');
    Route::post('check/slug', [\App\Http\Controllers\Backend\PageController::class, 'check_slug'])->name('check.slug');
    Route::post('delete-selected', [\App\Http\Controllers\Backend\PageController::class, 'delete_selected_items'])->name('delete-selected');

});

#region cms
Route::group(['prefix' => 'cms', 'as' => 'cms.'], function () {
    #region status
    #region slider
    Route::resource('sliders', \App\Http\Controllers\Backend\SliderController::class)->except(['show']);
    Route::post('sliders/datatable', [\App\Http\Controllers\Backend\SliderController::class, 'datatable'])->name('sliders.datatable');
    Route::post('sliders/change/status', [\App\Http\Controllers\Backend\SliderController::class, 'change_status'])->name('sliders.change.status');
    Route::post('sliders/delete-selected', [\App\Http\Controllers\Backend\SliderController::class, 'delete_selected_items'])->name('sliders.delete-selected');
    #endregion
     #region slider
     Route::resource('notifications', \App\Http\Controllers\Backend\NotificationsController::class)->except(['show']);
     Route::post('notifications/datatable', [\App\Http\Controllers\Backend\NotificationsController::class, 'datatable'])->name('notifications.datatable');
     Route::post('notifications/change/status', [\App\Http\Controllers\Backend\NotificationsController::class, 'change_status'])->name('notifications.change.status');
     Route::post('notifications/delete-selected', [\App\Http\Controllers\Backend\NotificationsController::class, 'delete_selected_items'])->name('notifications.delete-selected');
     #endregion   



});
#endregion
#region orders
Route::resource('orders', \App\Http\Controllers\Backend\OrderController::class)->except('update');
Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
    Route::post('datatable', [\App\Http\Controllers\Backend\OrderController::class, 'datatable'])->name('datatable');
    Route::post('delete-selected', [\App\Http\Controllers\Backend\OrderController::class, 'delete_selected_items'])->name('delete-selected');
});

#endregion

#endregion

#endregion

#region rank system
Route::resource('ranks', \App\Http\Controllers\Backend\RankController::class, ['except' => 'show']);
Route::group(['prefix' => 'ranks', 'as' => 'ranks.'], function () {
    Route::post('datatable', [\App\Http\Controllers\Backend\RankController::class, 'datatable'])->name('datatable');
    Route::post('delete-selected', [\App\Http\Controllers\Backend\RankController::class, 'delete_selected_items'])->name('delete-selected');
    Route::post('change/status', [\App\Http\Controllers\Backend\RankController::class, 'change_status'])->name('change.status');

});
#endregion

#region product
Route::resource('products', \App\Http\Controllers\Backend\ProductController::class, ['except' => 'show']);
Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::post('datatable', [\App\Http\Controllers\Backend\ProductController::class, 'datatable'])->name('datatable');
    Route::post('check/slug', [\App\Http\Controllers\Backend\ProductController::class, 'check_slug'])->name('check.slug');
    Route::post('check/sku', [\App\Http\Controllers\Backend\ProductController::class, 'check_sku'])->name('check.sku');
    Route::post('brand/get/models', [\App\Http\Controllers\Backend\ProductController::class, 'brands'])->name('brands');
    Route::post('select/get/product', [\App\Http\Controllers\Backend\ProductController::class, 'getProduct'])->name('get.product');
    Route::post('change/status', [\App\Http\Controllers\Backend\ProductController::class, 'change_status'])->name('change.status');
    Route::post('change/column', [\App\Http\Controllers\Backend\ProductController::class, 'change_value_column'])->name('change.column');
    Route::post('delete-selected', [\App\Http\Controllers\Backend\ProductController::class, 'delete_selected_items'])->name('delete-selected');
    Route::get('out-of-stock', [\App\Http\Controllers\Backend\ProductController::class, 'show_out_of_stock'])->name('show_out_of_stock');
    Route::post('out-of-stock-datatable', [\App\Http\Controllers\Backend\ProductController::class, 'out_of_stock_datatable'])->name('out_of_stock_datatable');
    Route::get('out-of-stock/{product_id}', [\App\Http\Controllers\Backend\ProductController::class, 'product_requests'])->name('product_requests');
    Route::post('out-of-stock/{product_id}/requests_datatable', [\App\Http\Controllers\Backend\ProductController::class, 'products_requests_datatable'])->name('products_requests_datatable');
    Route::post('check_manufacturer_type', [\App\Http\Controllers\Backend\ProductController::class, 'check_manufacturer_type'])->name('check_manufacturer_type');

    Route::get('{id}/series/number', [\App\Http\Controllers\Backend\ProductController::class, 'series_number'])->name('series.number');
    Route::post('{id}/series/number/datatable', [\App\Http\Controllers\Backend\ProductController::class, 'series_number_datatable'])->name('series.number.datatable');
    Route::get('import', [\App\Http\Controllers\Backend\ProductController::class, 'import_from_excel'])->name('import');
    Route::post('import/upload', [\App\Http\Controllers\Backend\ProductController::class, 'upload_excel'])->name('import.upload');
    Route::post('get-category-type', [\App\Http\Controllers\Backend\ProductController::class, 'get_category_type'])->name('get-category-type');
    Route::group(['prefix' => 'attribute', 'as' => 'attribute.'], function () {
        Route::post('create', [\App\Http\Controllers\Backend\ProductController::class, 'create_new_attribute'])->name('create');
        Route::post('sub/create', [\App\Http\Controllers\Backend\ProductController::class, 'create_new_sub_attribute'])->name('sub.create');
        Route::post('sub/store', [\App\Http\Controllers\Backend\ProductController::class, 'store_new_sub_attribute'])->name('sub.store');
    });
    #region product
    Route::post('get-quantity', [\App\Http\Controllers\Backend\ProductController::class, 'get_quantity'])->name('get-quantity');
#endregion
});
#endregion

#endregion
#region currency
Route::group(['prefix' => 'currencies', 'as' => 'currencies.'], function () {
    Route::resource('/', \App\Http\Controllers\Backend\CurrencyController::class)->except('edit');
    Route::get('/{currency}/edit', [\App\Http\Controllers\Backend\CurrencyController::class, 'edit'])->name('edit_cur');
    Route::patch('/{currency}/update', [\App\Http\Controllers\Backend\CurrencyController::class, 'update'])->name('update_cur');
    Route::delete('/{currency}/destroy', [\App\Http\Controllers\Backend\CurrencyController::class, 'destroy'])->name('destroy_cur');
    Route::post('/datatable', [\App\Http\Controllers\Backend\CurrencyController::class, 'datatable'])->name('datatable');
    Route::post('/change/status', [\App\Http\Controllers\Backend\CurrencyController::class, 'change_status'])->name('change.status');
    Route::post('/change-default', [\App\Http\Controllers\Backend\CurrencyController::class, 'change_default'])->name('change-default');
    Route::post('/delete-selected', [\App\Http\Controllers\Backend\CurrencyController::class, 'delete_selected_items'])->name('delete-selected');
});
#endregion

#region statistics

Route::group(['as' => 'statistics.', 'prefix' => 'statistics'], function () {
    Route::get('', [\App\Http\Controllers\StatisticsController::class, 'index'])->name('index');
    Route::get('/total-sales', [\App\Http\Controllers\StatisticsController::class, 'total_sales'])->name('total-sales');
    Route::get('/order_count', [\App\Http\Controllers\StatisticsController::class, 'order_count'])->name('order_count');
    Route::get('/shipping', [\App\Http\Controllers\StatisticsController::class, 'shipping'])->name('shipping');
    Route::get('/coupons', [\App\Http\Controllers\StatisticsController::class, 'coupons'])->name('coupons');
    Route::get('/users', [\App\Http\Controllers\StatisticsController::class, 'users'])->name('users');
    Route::get('/user_countries', [\App\Http\Controllers\StatisticsController::class, 'user_countries'])->name('user_countries');
    Route::get('/traffic_source', [\App\Http\Controllers\StatisticsController::class, 'traffic_source'])->name('traffic_source');
    Route::get('/device_category', [\App\Http\Controllers\StatisticsController::class, 'device_category'])->name('device_category');
    Route::get('/operating_system', [\App\Http\Controllers\StatisticsController::class, 'operating_system'])->name('operating_system');
    Route::get('/visits', [\App\Http\Controllers\StatisticsController::class, 'website_visits'])->name('website_visits');
    Route::get('/most-visited-pages', [\App\Http\Controllers\StatisticsController::class, 'pages_view'])->name('most-visited-pages');
    Route::get('/top-selling-products', [\App\Http\Controllers\StatisticsController::class, 'top_selling_products'])->name('top-selling-products');
    Route::get('/top-selling-categories', [\App\Http\Controllers\StatisticsController::class, 'top_selling_categories'])->name('top-selling-categories');
    Route::get('/users_orders', [\App\Http\Controllers\StatisticsController::class, 'users_orders'])->name('users_orders');
    Route::post('/users_orders_datatable', [\App\Http\Controllers\StatisticsController::class, 'users_orders_datatable'])->name('users_orders_datatable');
    Route::get('/google-analytics', [\App\Http\Controllers\StatisticsController::class, 'googleAnalytics'])->name('google_analytics');
    Route::get('/net-revenue', [\App\Http\Controllers\StatisticsController::class, 'net_revenue'])->name('net_revenue');
    Route::get('/show-categories-chart', [\App\Http\Controllers\StatisticsController::class, 'show_categories_chart'])->name('show_categories_chart');
    Route::get('/show-products-chart', [\App\Http\Controllers\StatisticsController::class, 'get_product_chart'])->name('show_products_chart');
    Route::get('/show-stock-chart', [\App\Http\Controllers\StatisticsController::class, 'stock_status'])->name('show_stock_chart');

});

#endregion
#region notification
Route::group(['prefix' => 'notifications', 'as' => 'notifications.'], function () {
    Route::get('/', [\App\Http\Controllers\Backend\NotificationController::class, 'index'])->name('index');
    Route::post('/datatable', [\App\Http\Controllers\Backend\NotificationController::class, 'datatable'])->name('datatable');
    Route::post('/read', [\App\Http\Controllers\Backend\NotificationController::class, 'read'])->name('read');
    Route::post('/read_all', [\App\Http\Controllers\Backend\NotificationController::class, 'read_all'])->name('read_all');
});
#endregion
#endregion