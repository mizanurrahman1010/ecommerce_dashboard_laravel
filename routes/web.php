<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PagesController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SubsubcategoryController;
use App\Http\Controllers\SitesettingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Models\Category;


// this routes only for developers (Returns json data)
Route::get('check_session', [PagesController::class, 'check_session']);
Route::get('remove_session', [PagesController::class, 'remove_session']);

// Category


// for APIS
// Route::get('product_add', [PagesController::class, "add_to_cart"]);
// Route::get('product_show', [PagesController::class, "cart_show"]);

// // Route::get('/', [PagesController::class,'index'])->name('index');
// Route::get('/category/{id}', [PagesController::class,'category'])->name('category');
// Route::get('/subcategory/{id}', [PagesController::class,'subcategory'])->name('subcategory');
// Route::get('/subsubcategory/{id}', [PagesController::class, 'subsubcategory'])->name('subsubcategory');
// Route::post('/search', [PagesController::class, 'search'])->name('search');
// Route::post('/filter', [PagesController::class, 'filter'])->name('filter');
Route::get('/invoice/{id}', [PagesController::class, 'invoice'])->name('invoice');

// Route::get('/product/{id}', [PagesController::class, 'product'])->name('product');
// Route::get('/cart', [PagesController::class, 'cart'])->name('cart');
// // Route::get('/wish', [PagesController::class, 'wish')->name('wish');

// Route::post('/load', [PagesController::class, 'load'])->name('load');
// Route::get('/getsliders', [PagesController::class, 'getsliders'])->name('getsliders');
// Route::get('/getdesktopcategories', [PagesController::class, 'getdesktopcategories'])->name('getdesktopcategories');
// Route::get('/load_highlight_product', [PagesController::class, 'load_highlight_product'])->name('load_highlight_product');
// Route::get('/load_parent_categories', [PagesController::class, 'load_parent_categories'])->name('load_parent_categories');

Route::get('/login', [PagesController::class, 'login'])->name('login');
// Route::get('/logout', [PagesController::class, 'logout'])->name('logout');
// Route::post('/logincheck', [CustomerController::class, 'logincheck'])->name('logincheck');
// Route::get('/registration', [PagesController::class, 'registration'])->name('registration');
// Route::post('/createregistration', [CustomerController::class, 'store'])->name('createregistration');
// Route::post('/matchotp', [CustomerController::class, 'matchotp'])->name('matchotp');

// for client cart management...................................................................
// Route::get('/add-to-cart', [CartController::class, 'add_to_cart'])->name('add-to-cart');
// Route::get('/show-cart', [CartController::class, 'show_cart'])->name('show-cart');
// Route::get('/isCartExist', [CartController::class, 'isCartExist']);
// Route::get('/delete-cart/{id}', [CartController::class, 'delete_cart'])->name('delete-cart');
// Route::get('/update-cart', [CartController::class, 'update_cart'])->name('update-cart');


// vendor routes

Route::get('/vendor/login', [VendorController::class, 'login' ])->name('vendor.login');
Route::get('/vendor/logout', [VendorController::class, 'logout'])->name('vendor.logout');
Route::post('/vendor/vendorlogincheck', [VendorController::class, 'vendorlogincheck'])->name('vendor.vendorlogincheck');
Route::get('/vendor/registration', [VendorController::class, 'registration'])->name('vendor.registration');

Route::group(['prefix'=>'vendor','middleware'=>'vendorauth:vendor'],function(){

    Route::get('/dashboard', [VendorController::class, 'index'])->name('vendor.dashboard');
    //load category
    Route::post('/product/loadCategories', [ProductController::class, 'getCategoriesApi'])->name('vendor.product.loadCategories');
    //Route::post('/product/loadsubsubcategory', [ProductController::class, 'loadsubsubcategory'])->name('vendor.product.loadsubsubcategory');

    //product crud

    Route::get('/product/create', [ProductController::class, 'create'] )->name('vendor.product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('vendor.product.store');

    Route::get('/product/index', [ProductController::class, 'index'])->name('vendor.product.index');
    Route::get('/product/filter', [ProductController::class, 'filter'])->name('vendor.product.filter');
    Route::get('/product/delete/{id?}', [ProductController::class, 'delete'] )->name('vendor.product.delete');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'] )->name('product.edit');
    Route::post('/product/update/{id}', [ProductController::class, 'update'] )->name('product.update');

    //product pricing
    Route::get('/product/set_pricing', [ProductController::class, 'product_set_price'] )->name('product.set_price');
    Route::post('/product/set_pricing', [ProductController::class, 'product_set_price_store'] )->name('product.set_price.store');
    Route::post('/product/update_pricing', [ProductController::class, 'product_update_price_store'] )->name('product.update_price.store');

    //edit and update product price
    Route::get('product/price', [ProductController::class, 'product_price'])->name('vendor.product.price'); //load view
    Route::post('product/search', [ProductController::class, 'search_product'])->name('vendor.product.search'); //return product name as search result
    Route::get('product/fill_product_info', [ProductController::class, 'fill_product_info']); //return product total info
    Route::get('add_product_qty', [ProductController::class, 'add_product_qty'])->name('product.add_product_qty'); //returns row id color and size wise

    Route::get('product/data_store_wise', [ProductController::class, 'data_store_wise']); //return store wise product price and discount and color size wise quantity

    Route::get('product/price_list', [ProductController::class, 'product_price_list'])->name('vendor.product.price_list');

    // Route::get('get_product_price_store_wise', [ProductController::class, 'get_product_price_store_wise'])->name('product.get_price.store_wise');
    Route::post('product/update_price/store_wise', [ProductController::class, 'update_product_price_store_wise'])->name('product.price_update.store_wise');         //product page

    // // edit and update product quantity
    Route::get('get_product_qty', [ProductController::class, 'get_product_qty'])->name('product.get_product_qty');
    Route::post('update_product_qty', [ProductController::class, 'update_product_qty'])->name('product.qty_update.store_wise');


    // add more image
    Route::get('/product/addmoreimage/{id?}', [ProductController::class, 'addmoreimage'] )->name('product.addmoreimage');
    Route::get('/product/detailimagedelete/{id?}', [ProductController::class, 'detailimagedelete'])->name('vendor.productmoreimage.delete');
    Route::post('/product/detailimage/update/', [ProductController::class, 'detailimageupdate'] )->name('vendor.detailimage.update');
    Route::post('/product/addmoreimagesave/{id}', [ProductController::class, 'addmoreimagesave'] )->name('product.addmoreimage.save');

    //store
    Route::get('store/create', [VendorController::class, 'store_create'])->name('vendor.store.create');
    Route::post('store/save', [VendorController::class, 'store_save'])->name('vendor.store.save');
    Route::get('store/edit', [VendorController::class, 'store_edit'])->name('vendor.store.edit');
    Route::get('store/delete', [VendorController::class, 'store_delete'])->name('vendor.store.delete');
    Route::get('store/status', [VendorController::class, 'store_status'])->name('vendor.store.status');

    // //orders
    // Route::get('/order/pending', [VendorController::class, 'pendingorder'])->name('vendor.order.pending');
    // Route::get('/order/confirm', [VendorController::class, 'confirmorder'])->name('vendor.order.confirm');
    // Route::get('/order/processing', [VendorController::class, 'processingorder'])->name('vendor.order.processing');
    // Route::get('/order/delivered', [VendorController::class, 'deliveredorder'])->name('vendor.order.delivered');

    // Route::get('/order/makeconfirm/{id?}', [VendorController::class, 'makeconfirm'])->name('vendor.order.makeconfirm');
    // Route::get('/order/makeprocessing/{id?}', [VendorController::class, 'makeprocessing'])->name('vendor.order.makeprocessing');
    // Route::get('/order/makedelivered/{id?}', [VendorController::class, 'makedelivered'])->name('vendor.order.makedelivered');

});


// customer routes
// Route::group(['middleware'=>'customerauth:customer'],function(){
//     Route::get('/checkout', [PagesController::class, 'checkout'])->name('checkout');
//     Route::get('/cartempty', [PagesController::class, 'cartempty'])->name('cartempty');
//     Route::post('/placeorder', [PagesController::class, 'placeorder'])->name('placeorder');
//     Route::get('/orders', [PagesController::class, 'orders'])->name('orders');
//     Route::get('/orders/detail/{order_id}', [PagesController::class, 'detailorders'])->name('orders.detail');
//     Route::get('/orders/cancel/{id}', [PagesController::class, 'cancelorders'])->name('orders.cancel');
//     Route::get('/orders/delivered', [PagesController::class, 'deliveredorders'])->name('orders.delivered');
//     Route::get('/order', [PagesController::class, 'order'])->name('order');
//     Route::get('/profile', [PagesController::class, 'profile'])->name('profile');
//     Route::get('/editprofile', [PagesController::class, 'editprofile'])->name('editprofile');
//     Route::post('/updateprofile', [PagesController::class, 'updateprofile'])->name('update.profile');

//     //wishlist

//     Route::get('/addtowishlist', [PagesController::class, 'addtowishlist']);
//     Route::get('/wishlist', [PagesController::class, 'wishlist'])->name('customer.wishlist');
//     Route::get('/removefromwishlist', [PagesController::class, 'removefromwishlist']);

// });


// Owner routes

Route::get('/owner/login', [OwnerController::class,'login'] )->name('owner.login');
Route::get('/owner/logout', [OwnerController::class, 'logout'])->name('owner.logout');
Route::post('/owner/ownerlogincheck', [OwnerController::class, 'ownerlogincheck'])->name('owner.ownerlogincheck');


Route::group(['prefix'=>'owner','middleware'=>'ownerauth:owner'],function(){

    //<<<<<<<<<<<<<<<<<<<<<<<<<<=====================owner: category and sub category========================>>>>>>>>>>>>>>>>>>>>>>>>
    Route::get('/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');
    Route::get('/category/create', [CategoryController::class, 'create'] )->name('owner.category.create');
    Route::get('/category/get/{id?}', [CategoryController::class, 'get'] )->name('owner.category.get');
    Route::post('/category/store', [CategoryController::class, 'store'] )->name('owner.category.store');
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit'] )->name('owner.category.edit');
    Route::post('/category/update', [CategoryController::class, 'update'] )->name('owner.category.update');
    Route::post('/category/delete', [CategoryController::class, 'delete'] )->name('owner.category.delete');

    //sub category
    
    Route::post('/offer/image/delete', [OfferController::class, 'deleteImage'] )->name('owner.offer.image.delete');
    Route::get('/offer/create/{id?}', [OfferController::class, 'offerIndex'] )->name('owner.offer.create');
    Route::get('/offer/index', [OfferController::class, 'index'] )->name('owner.offer.index');
    Route::post('/offer/image/save', [OfferController::class, 'save'] )->name('owner.offer.image.save');
    Route::get('/subcategory/create', [SubCategoryController::class, 'create'] )->name('owner.subcategory.create');
    Route::get('/subcategory/get', [SubCategoryController::class, 'get'] )->name('owner.subcategory.get');
    Route::post('/subcategory/store', [SubCategoryController::class, 'store'] )->name('owner.subcategory.store');
    Route::get('/subcategory/edit/{id}', [SubCategoryController::class, 'edit'] )->name('owner.subcategory.edit');
    Route::post('/subcategory/update/{id}', [SubCategoryController::class, 'update'] )->name('owner.subcategory.update');
    Route::post('/subcategory/delete/{id}', [SubCategoryController::class, 'delete'] )->name('owner.subcategory.delete');

    //sub sub category
    Route::get('/subsubcategory/create', [SubSubCategoryController::class, 'create'] )->name('owner.subsubcategory.create');
    Route::get('/subsubcategory/get', [SubSubCategoryController::class, 'get'] )->name('owner.subsubcategory.get');
    Route::post('/subsubcategory/store', [SubSubCategoryController::class, 'store'] )->name('owner.subsubcategory.store');
    Route::get('/subsubcategory/edit/{id}', [SubSubCategoryController::class, 'edit'] )->name('owner.subsubcategory.edit');
    Route::post('/subsubcategory/update/{id}', [SubSubCategoryController::class, 'update'] )->name('owner.subsubcategory.update');
    Route::post('/subsubcategory/delete/{id}', [SubSubCategoryController::class, 'delete'] )->name('owner.subsubcategory.delete');

    //need to check
    // Route::get('/product/create', [ProductController::class, 'create'])->name('owner.product.create');
    // Route::post('/product/store', [ProductController::class, 'store'])->name('owner.product.store');

    //<<<<<<<<<<<<<<<<<<<<<=====================site setting======================>>>>>>>>>>>>>>>>>>>>>>>>>
    Route::get('/sitesetting/edit', [SitesettingController::class,'edit'])->name('owner.sitesetting.edit');
    Route::get('/logo/edit', [SitesettingController::class, 'logo'])->name('owner.logo.edit');
    Route::put('/logo/update/{id}', [SitesettingController::class, 'logoupdate'] )->name('owner.sitesetting.logoupdate');
    Route::put('/sitesetting/update/{id}', [SitesettingController::class, 'update'])->name('owner.sitesetting.update');

    //<<<<<<<<<<<<<<<<<<<<<=====================sliders======================>>>>>>>>>>>>>>>>>>>>>>>>>

    Route::get('/slider/index', [SliderController::class, 'index'] )->name('owner.slider.index');
    Route::post('/slider/store', [SliderController::class, 'store'] )->name('owner.slider.store');
    Route::get('/slider/get', [SliderController::class, 'get'] )->name('owner.slider.get');
    Route::post('/slider/delete/{id}', [SliderController::class, 'delete'] )->name('owner.slider.delete');

    //<<<<<<<<<<<<<<<<<<<<<=====================product color size group======================>>>>>>>>>>>>>>>>>>>>>>>>>

    Route::get('/color_size_group', [ProductController::class, 'color_size_group'])->name('color.size.group');
    Route::post('/color_size_group', [ProductController::class, 'color_size_group_store'])->name('color.size.group.store');
    Route::get('/color_size_group_edit', [ProductController::class, 'color_size_group_edit'])->name('color-size-group.edit');
    Route::post('/color_size_group_update', [ProductController::class, 'color_size_group_update'])->name('color-size-group.update');
    Route::post('/color_size_group_delete', [ProductController::class, 'color_size_group_delete'])->name('color-size-group.delete');


    //<<<<<<<<<<<<<<<<<<<<<=====================brands======================>>>>>>>>>>>>>>>>>>>>>>>>>

    Route::get('/brand', [BrandController::class, 'index'])->name('owner.brand.index');
    Route::post('/brand/store', [BrandController::class, 'store'])->name('owner.brand.store');
    Route::post('/brand/edit', [BrandController::class, 'edit'])->name('owner.brand.edit');
    Route::get('/brand/get_info', [BrandController::class, 'get_info'])->name('owner.brand.get_info');
    Route::get('/brand/delete', [BrandController::class, 'delete'])->name('owner.brand.delete');
    Route::get('/brand/status_update',[BrandController::class,'status_update'])->name('owner.brand.status_update');

    //<<<<<<<<<<<<<<<<<<<<<=====================campaigns releted======================>>>>>>>>>>>>>>>>>>>>>>>>>

    //campaign type
    Route::get('campaign_type', [CampaignController::class, 'campaign_type_show'])->name('owner.campaign_types.show');
    Route::post('campaign_type_create', [CampaignController::class, 'campaign_type_create'])->name('owner.campaign_types.create');
    Route::get('campaign_type_status', [CampaignController::class, 'campaign_type_status'])->name('owner.campaign_types.status');
    Route::get('campaign_type_edit', [CampaignController::class, 'campaign_type_edit'])->name('owner.campaign_types.edit');
    Route::post('campaign_type_update', [CampaignController::class, 'campaign_type_update'])->name('owner.campaign_types.update');

    //campaigns
    Route::get('campaign', [CampaignController::class, 'campaign_show'])->name('owner.campaigns.show');
    Route::post('campaign_create', [CampaignController::class, 'campaign_create'])->name('owner.campaigns.create');
    Route::get('campaign_status', [CampaignController::class, 'campaign_status'])->name('owner.campaigns.status');
    Route::get('campaign_edit', [CampaignController::class, 'campaign_edit'])->name('owner.campaigns.edit');
    Route::post('campaign_update', [CampaignController::class, 'campaign_update'])->name('owner.campaigns.update');

    //product assign to campaign
    Route::get('campaign_product_add', [CampaignController::class, 'campaign_product_add'])->name('owner.campaigns.add_product');
    Route::post('/product_add_to_campaign', [CampaignController::class, 'product_add_to_campaign']);
    Route::get('/campaign_product_edit', [CampaignController::class, 'campaign_product_edit'])->name('owner.campaigns.edit_product');
    Route::post('/product_update_to_campaign', [CampaignController::class, 'product_update_to_campaign']);
    Route::get('/owner_campaigns_details', [CampaignController::class, 'campaigns_details'])->name('owner.campaigns.details');

    // data call from ajax
    Route::post('/search_store', [VendorController::class, 'search_store']);
    Route::post('/product_name', [ProductController::class, 'product_name']);
    Route::get('/get_price', [ProductController::class, 'get_price']);

    Route::get('product/approvals', [ProductController::class, 'product_approval_show'])->name('owner.product.approval.show');
    Route::post('price_approval', [ProductController::class, 'product_approval'])->name('owner.product.approval');

    //venodors
    Route::get('vendor_create', [OwnerController::class, 'vendor_create'])->name('owner.vendor.create');
    Route::get('vendorinfo_update/{id}', [OwnerController::class, 'vendorinfo_update'])->name('owner.vendor.vendorinfo_update');
    Route::get('owner.vendor_list', [OwnerController::class, 'vendor_list'])->name('owner.vendor_list');
    Route::get('owner.status_update', [OwnerController::class, 'status_update'])->name('owner.status_update');
    Route::post('vendor_create_submit', [OwnerController::class, 'vendor_create_submit'])->name('owner.vendor_create_submit');
    Route::post('vendor_update_submit', [OwnerController::class, 'vendor_update_submit'])->name('owner.vendor_update_submit');

    // Logis as vendor
    Route::get('/login_as_vendor', [OwnerController::class, 'login_as_vendor'])->name('owner.as_vendor.login');
    Route::get('/go_to_owner', [OwnerController::class, 'go_to_owner'])->name('owner.go_to.owner');

    //orders
    Route::get('/order/live', [OrderController::class, 'live_order'])->name('owner.order.live');
    Route::get('/order/all', [OrderController::class, 'allorder'])->name('owner.order.all');
    Route::get('/order/pending', [OrderController::class, 'pendingorder'])->name('owner.order.pending');
    Route::get('/order/confirm', [OrderController::class, 'confirmorder'])->name('owner.order.confirm');
    Route::get('/order/processing', [OrderController::class, 'processingorder'])->name('owner.order.processing');
    Route::get('/order/delivered', [OrderController::class, 'deliveredorder'])->name('owner.order.delivered');

    Route::get('/order/makeconfirm/{id?}', [OrderController::class, 'makeconfirm'])->name('owner.order.makeconfirm');
    Route::get('/order/makeprocessing/{id?}', [OrderController::class, 'makeprocessing'])->name('owner.order.makeprocessing');
    Route::get('/order/makedelivered/{id?}', [OrderController::class, 'makedelivered'])->name('owner.order.makedelivered');

    //filter oredrs
    Route::get('/order/filter',[OrderController::class, 'filter_order'])->name('owner.filter_orders');
    //When owner order confirming (Route call from ajax)

    Route::get('/get_product_detail',[OrderController::class, 'get_product_detail']);
    Route::post('/order_detail_approval', [OrderController::class, 'order_detail_approval']);

    //owner give access to store as global store
    Route::get('/store/list', [OwnerController::class, 'owner_store_list'])->name('owner.store.list');
    Route::get('/store/make_or_remove_for_all', [OwnerController::class, 'owner_type_change'])->name('owner.store.make_or_remove_for_all');

});


// Route::get('/notification', function () {
//     return view('notification');
// });

// Route::get('send',[BrandController::class, 'notification']);

// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
