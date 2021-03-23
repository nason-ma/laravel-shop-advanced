<?php

use App\Admin\Controllers\UsersController;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    $router->get('users', 'UsersController@index')->name('users.index');

    $router->get('products', 'ProductsController@index')->name('products.index');
    $router->get('products/create', 'ProductsController@create')->name('products.create');
    $router->post('products', 'ProductsController@store')->name('products.store');
    $router->get('products/{id}/edit', 'ProductsController@edit')->name('products.edit');
    $router->put('products/{id}', 'ProductsController@update')->name('products.update');

    $router->get('orders', 'OrdersController@index')->name('orders.index');
    $router->get('orders/{order}', 'OrdersController@show')->name('orders.show');
    $router->post('orders/{order}/ship', 'OrdersController@ship')->name('orders.ship');
    $router->post('orders/{order}/refund', 'OrdersController@handleRefund')->name('orders.handle_refund');

    $router->get('coupon_codes', 'CouponCodesController@index')->name('coupon_codes.index');
    $router->get('coupon_codes/create', 'CouponCodesController@create')->name('coupon_codes.create');
    $router->post('coupon_codes', 'CouponCodesController@store')->name('coupon_codes.store');
    $router->get('coupon_codes/{id}/edit', 'CouponCodesController@edit')->name('coupon_codes.edit');
    $router->put('coupon_codes/{id}', 'CouponCodesController@update')->name('coupon_codes.update');
    $router->delete('coupon_codes/{id}', 'CouponCodesController@destroy')->name('coupon_codes.destroy');

    $router->get('categories', 'CategoriesController@index')->name('categories.index');
    $router->get('categories/create', 'CategoriesController@create')->name('categories.create');
    $router->get('categories/{id}/edit', 'CategoriesController@edit')->name('categories.edit');
    $router->post('categories', 'CategoriesController@store')->name('categories.store');
    $router->put('categories/{id}', 'CategoriesController@update')->name('categories.update');
    $router->delete('categories/{id}', 'CategoriesController@destroy')->name('categories.destroy');
    $router->get('api/categories', 'CategoriesController@apiIndex')->name('categories.api_index');

    $router->get('crowdfunding_products', 'CrowdfundingProductsController@index')->name('crowdfunding.index');
    $router->get('crowdfunding_products/create', 'CrowdfundingProductsController@create')->name('crowdfunding.create');
    $router->post('crowdfunding_products', 'CrowdfundingProductsController@store')->name('crowdfunding.store');
    $router->get('crowdfunding_products/{id}/edit', 'CrowdfundingProductsController@edit')->name('crowdfunding.edit');
    $router->put('crowdfunding_products/{id}', 'CrowdfundingProductsController@update')->name('crowdfunding.update');
});
