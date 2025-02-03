<?php

    use App\Http\Controllers\Admin\UserController;
    use App\Http\Controllers\Auth\AuthenticatedSessionController;
    use App\Http\Controllers\Auth\RegisteredUserController;
    use App\Http\Controllers\Auth\VerifyEmailController;
    use Illuminate\Support\Facades\Route;

    Route::middleware('guest')->group(function () {
        Route::post('register',[RegisteredUserController::class, 'store'])->name('register');
        Route::post('login',[AuthenticatedSessionController::class, 'store'])->name('login');
        ##TODO: make reset password route
    });
    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
         ->middleware(['auth', 'signed', 'throttle:6,1'])
         ->name('verification.verify');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::delete('logout',[AuthenticatedSessionController::class,'destroy']);
        Route::prefix('admin')->group(function () {
           Route::resource('user',UserController::class);
           Route::resource('product-category',\App\Http\Controllers\Admin\ProductCategoryController::class);
           Route::resource('attribute',\App\Http\Controllers\Admin\AttributeController::class);
           Route::resource('menu',\App\Http\Controllers\Admin\MenuController::class);
           Route::resource('product',\App\Http\Controllers\Admin\ProductController::class);
           Route::resource('reviews',\App\Http\Controllers\Admin\ReviewController::class)->except(['create','update']);

            /**
             * Admin routes for static pages
             */
            Route::prefix('page')->group(function () {
                Route::get('contacts',[\App\Http\Controllers\Pages\ContactsPageController::class,'show']);
                Route::post('contacts',[\App\Http\Controllers\Pages\ContactsPageController::class,'update']);
                Route::get('home',[\App\Http\Controllers\Pages\HomePageController::class,'show']);
                Route::post('home',[\App\Http\Controllers\Pages\HomePageController::class,'update']);
                Route::get('about',[\App\Http\Controllers\Pages\AboutPageController::class,'show']);
                Route::post('about',[\App\Http\Controllers\Pages\AboutPageController::class,'update']);
                Route::get('payment-and-delivery',[\App\Http\Controllers\Pages\PaymentDeliveryPageController::class,'show']);
                Route::post('payment-and-delivery',[\App\Http\Controllers\Pages\PaymentDeliveryPageController::class,'update']);
                Route::get('payment-tutorial',[\App\Http\Controllers\Pages\PaymentTutorialPageController::class,'show']);
                Route::post('payment-tutorial',[\App\Http\Controllers\Pages\PaymentTutorialPageController::class,'update']);
                Route::get('analytics',[\App\Http\Controllers\Pages\AnalyticsPageController::class,'show']);
                Route::post('analytics',[\App\Http\Controllers\Pages\AnalyticsPageController::class,'update']);
            });


        });

        Route::prefix('wishlist')->group(function () {
            Route::get('get',[\App\Http\Controllers\WishlistController::class,'index']);
            Route::get('add/{id}',[\App\Http\Controllers\WishlistController::class,'add']);
            Route::delete('remove/{id}',[\App\Http\Controllers\WishlistController::class,'remove']);
        });

        Route::post('review',[\App\Http\Controllers\ReviewController::class,'store']);
        Route::put('review/{review}',[\App\Http\Controllers\ReviewController::class,'store']);
        Route::delete('review/{review}',[\App\Http\Controllers\ReviewController::class,'destroy']);
    });

    Route::middleware([\App\Http\Middleware\CheckApiBearerToken::class])->group(function () {
        Route::prefix('cart')->group(function () {
            Route::get('',[\App\Http\Controllers\CartController::class,'show']);
            Route::post('/add',[\App\Http\Controllers\CartController::class,'add']);
            Route::post('/update',[\App\Http\Controllers\CartController::class,'update']);
            Route::get('/clear',[\App\Http\Controllers\CartController::class,'clear']);
        });

        Route::post('checkout',[\App\Http\Controllers\OrderController::class,'store']);
    });
    Route::get('/products',[\App\Http\Controllers\ShopController::class,'index']);
    Route::get('/products/{product_category}',[\App\Http\Controllers\CategoryController::class,'index']);
    ##TODO MAKE BREADCRUMBS
    ##TODO MAKE TG BOT FOR ORDERS
