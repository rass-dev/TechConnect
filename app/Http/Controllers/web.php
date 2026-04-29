<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CartController;


Auth::routes(['register' => false]);

Route::get('user/login', 'FrontendController@login')->name('login.form');
Route::post('user/login', 'FrontendController@loginSubmit')->name('login.submit');
Route::get('user/logout', 'FrontendController@logout')->name('user.logout');

Route::get('user/register', 'FrontendController@register')->name('register.form');
Route::post('user/register', 'FrontendController@registerSubmit')->name('register.submit');
// Reset password
Route::post('password-reset', 'FrontendController@showResetForm')->name('password.reset');
// Socialite 
Route::get('login/{provider}/', 'Auth\LoginController@redirect')->name('login.redirect');
Route::get('login/{provider}/callback/', 'Auth\LoginController@Callback')->name('login.callback');

Route::get('/', 'FrontendController@home')->name('home');

// Frontend Routes
Route::get('/home', 'FrontendController@index');
Route::get('/about-us', 'FrontendController@aboutUs')->name('about-us');
Route::get('/contact', 'FrontendController@contact')->name('contact');
Route::post('/contact/message', 'MessageController@store')->name('contact.store');
Route::get('product-detail/{slug}', 'FrontendController@productDetail')->name('product-detail');
Route::post('/product/search', 'FrontendController@productSearch')->name('product.search');
Route::get('/product-cat/{slug}', 'FrontendController@productCat')->name('product-cat');
Route::get('/product-sub-cat/{slug}/{sub_slug}', 'FrontendController@productSubCat')->name('product-sub-cat');
Route::get('/product-brand/{slug}', 'FrontendController@productBrand')->name('product-brand');

// Cart section
Route::get('/add-to-cart/{slug}', 'CartController@addToCart')->name('add-to-cart')->middleware('user');
Route::post('/add-to-cart', 'CartController@singleAddToCart')->name('single-add-to-cart')->middleware('user');
Route::get('cart-delete/{id}', 'CartController@cartDelete')->name('cart-delete');
Route::post('cart-update', 'CartController@cartUpdate')->name('cart.update');

// Cart section
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::view('/cart/empty', 'frontend.pages.cart-empty')->name('cart-empty');
Route::post('/cart/update-quantity/{id}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::post('/cart/update-quantity/{id}', [App\Http\Controllers\CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
// Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout');

// Cart routes for toggling
Route::post('/cart/toggle-check/{id}', [CartController::class, 'toggleCheck'])->name('cart.toggle-check');
Route::post('/cart/toggle-check-all', [CartController::class, 'toggleCheckAll'])->name('cart.toggle-check-all');

// Route to fetch order history via AJAX
Route::get('admin/order-history/{id}', [App\Http\Controllers\OrderController::class, 'history'])->name('order.history');
Route::get('admin/order-history/{id}', [OrderController::class, 'history'])->name('order.history');

use App\Http\Controllers\UserOrderController;

Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders/to-process', [UserOrderController::class, 'toProcess'])->name('orders.to-process');
    Route::get('/my-orders/to-ship', [UserOrderController::class, 'toShip'])->name('orders.to-ship');
    Route::get('/my-orders/to-receive', [UserOrderController::class, 'toReceive'])->name('orders.to-receive');
    Route::get('/my-orders/complete-delivered', [UserOrderController::class, 'completeDelivered'])->name('orders.complete-delivered');
    Route::get('/my-orders/cancelled', [UserOrderController::class, 'cancelled'])->name('orders.cancelled');

    // Optional: default redirect
    Route::get('/my-orders', function () {
        return redirect()->route('orders.to-process');
    })->name('my-orders');
});




Route::post('/cart/empty', [CartController::class, 'emptyCart'])->name('cart.empty');


use App\Http\Controllers\AdminController;

Route::get('/cart', function () {
    return view('frontend.pages.cart');
})->name('cart');
Route::get('/checkout', 'CartController@checkout')->name('checkout')->middleware('user');
// Wishlist
Route::get('/wishlist', function () {
    return view('frontend.pages.wishlist');
})->name('wishlist');
Route::get('/wishlist/{slug}', 'WishlistController@wishlist')->name('add-to-wishlist')->middleware('user');
Route::get('wishlist-delete/{id}', 'WishlistController@wishlistDelete')->name('wishlist-delete');
Route::post('cart/order', 'OrderController@store')->name('cart.order');
Route::get('order/pdf/{id}', 'OrderController@pdf')->name('order.pdf');
Route::get('/income', 'OrderController@incomeChart')->name('product.order.income');
Route::get('/product-grids', 'FrontendController@productGrids')->name('product-grids');
Route::get('/product-lists', 'FrontendController@productLists')->name('product-lists');
Route::match(['get', 'post'], '/filter', 'FrontendController@productFilter')->name('shop.filter');
// Order Track
Route::get('/product/track', 'OrderController@orderTrack')->name('order.track');
Route::post('product/track/order', 'OrderController@productTrackOrder')->name('product.track.order');

// NewsLetter
Route::post('/subscribe', 'FrontendController@subscribe')->name('subscribe');

// Product Review
Route::resource('/review', 'ProductReviewController');
Route::post('product/{slug}/review', 'ProductReviewController@store')->name('review.store');

// Coupon
Route::post('/coupon-store', 'CouponController@couponStore')->name('coupon-store');
// Payment
Route::get('payment', 'PayPalController@payment')->name('payment');
Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
Route::get('payment/success', 'PayPalController@success')->name('payment.success');

// Backend section start
Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'AdminController@index')->name('admin');
    Route::get('/file-manager', function () {
        return view('backend.layouts.file-manager');
    })->name('file-manager');
    // user route
    Route::resource('users', 'UsersController');
    // Banner
    Route::resource('banner', 'BannerController');
    // Brand
    Route::resource('brand', 'BrandController');

    // Profile
    Route::get('/profile', 'AdminController@profile')->name('admin-profile');
    Route::post('/profile/{id}', 'AdminController@profileUpdate')->name('profile-update');
    Route::post('/profile/{id}/photo', [AdminController::class, 'profileUpdatePhoto'])->name('profile.update.photo');

    // Category
    Route::resource('/category', 'CategoryController');
    // Product
    Route::resource('/product', 'ProductController');
    // Ajax for sub category
    Route::post('/category/{id}/child', 'CategoryController@getChildByParent');
    // Message
    Route::resource('/message', 'MessageController');
    Route::get('/message/five', 'MessageController@messageFive')->name('messages.five');

    // Order
    Route::resource('/order', 'OrderController');
    // Shipping
    Route::resource('/shipping', 'ShippingController');
    // Coupon
    Route::resource('/coupon', 'CouponController');
    // Settings
    Route::get('settings', 'AdminController@settings')->name('settings');
    Route::post('setting/update', 'AdminController@settingsUpdate')->name('settings.update');

    // Notification
    Route::get('/notification/{id}', 'NotificationController@show')->name('admin.notification');
    Route::get('/notifications', 'NotificationController@index')->name('all.notification');
    Route::delete('/notification/{id}', 'NotificationController@delete')->name('notification.delete');
    // Password Change
    Route::get('change-password', 'AdminController@changePassword')->name('change.password.form');
    Route::post('change-password', 'AdminController@changPasswordStore')->name('change.password');
});


Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

// routes/web.php
Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');


Route::post('/orders/{id}/confirm', [OrderController::class, 'confirmDelivery'])->name('order.confirm');



use App\Http\Controllers\MyOrdersController;

// Route para sa order details gamit ang MyOrdersController
Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders/to-process', [MyOrdersController::class, 'toProcess'])->name('orders.to-process');
    Route::get('/my-orders/to-ship', [MyOrdersController::class, 'toShip'])->name('orders.to-ship');
    Route::get('/my-orders/to-receive', [MyOrdersController::class, 'toReceive'])->name('orders.to-receive');
    Route::get('/my-orders/complete-delivered', [MyOrdersController::class, 'completeDelivered'])->name('orders.complete-delivered');
    Route::get('/my-orders/cancelled', [MyOrdersController::class, 'cancelled'])->name('orders.cancelled');

    Route::get('/my-orders', function () {
        return redirect()->route('orders.to-process');
    })->name('my-orders');
});


// Order
use App\Http\Controllers\OrderController;
Route::get('order/{id}/pdf', [OrderController::class, 'pdf'])->name('order.pdf');
// Order Delete
Route::delete('/admin/order/item/{id}', [OrderController::class, 'destroyItem'])->name('order.item.destroy');

Route::get('admin/order-history/{id}', [OrderController::class, 'history']);


// User section start
Route::group(['prefix' => '/user', 'middleware' => ['user']], function () {

    Route::get('/', 'HomeController@index')->name('user');

    // Profile
    Route::get('/profile', 'HomeController@profile')->name('user-profile'); // view page
    Route::post('/profile', 'HomeController@profileUpdate')->name('user-profile-update'); // update

    // Password Change
    Route::get('/change-password', 'HomeController@changePassword')->name('user.change.password.form');
    Route::post('/change-password', 'HomeController@changePasswordStore')->name('user.change.password');

    // Delete Account
    Route::get('/delete-account', 'HomeController@deleteAccount')->name('user.delete.account');

    // Order
    Route::get('/order', 'HomeController@orderIndex')->name('user.order.index');
    Route::get('/order/show/{id}', 'HomeController@orderShow')->name('user.order.show');
    Route::delete('/order/delete/{id}', 'HomeController@userOrderDelete')->name('user.order.delete');

    // Product Review
    Route::get('/user-review', 'HomeController@productReviewIndex')->name('user.productreview.index');
    Route::delete('/user-review/delete/{id}', 'HomeController@productReviewDelete')->name('user.productreview.delete');
    Route::get('/user-review/edit/{id}', 'HomeController@productReviewEdit')->name('user.productreview.edit');
    Route::patch('/user-review/update/{id}', 'HomeController@productReviewUpdate')->name('user.productreview.update');

    // Post comment
    Route::get('/user-post/comment', 'HomeController@userComment')->name('user.post-comment.index');
    Route::delete('/user-post/comment/delete/{id}', 'HomeController@userCommentDelete')->name('user.post-comment.delete');
    Route::get('/user-post/comment/edit/{id}', 'HomeController@userCommentEdit')->name('user.post-comment.edit');
    Route::patch('/user-post/comment/update/{id}', 'HomeController@userCommentUpdate')->name('user.post-comment.update');

});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});  // laravel file manager (Reserved)