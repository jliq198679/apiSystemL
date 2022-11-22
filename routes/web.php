<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
/*
$router->group(['prefix' => 'api','middleware' => ['client.credentials'] ],function () use ($router){

});
*/

$router->group(['prefix' => 'api','middleware' => ['auth:api'] ],function () use ($router){
    $router->get('/test', function() use ($router){
        return 'Ready';
    });
    $router->group(['prefix' => 'image'], function () use ($router) {
        $router->post('upload', ['uses' => 'ImageController@upload']);

    });
    $router->group(['prefix' => 'frame-web'], function () use ($router) {
        $router->get('/', ['uses' => 'FrameWebController@list']);
        $router->get('/{name}', ['uses' => 'FrameWebController@show']);
        $router->post('/', ['uses' => 'FrameWebController@store']);
        $router->put('/{name}', ['uses' => 'FrameWebController@update']);
        $router->delete('/{id}', ['uses' => 'FrameWebController@destroy']);
    });
    $router->group(['prefix' => 'group-offer'], function () use ($router) {
        $router->get('/', ['uses' => 'GroupOffersController@list']);
        $router->get('/offers', ['uses' => 'GroupOffersController@listGroupWithOffer']);
        $router->post('/', ['uses' => 'GroupOffersController@store']);
        $router->put('/{id}', ['uses' => 'GroupOffersController@update']);
        $router->delete('/{id}', ['uses' => 'GroupOffersController@destroy']);
        $router->get('/get-subCategory/{category_id}', ['uses' => 'GroupOffersController@listSubCategory']);
        $router->post('/associate/type-side-dish', ['uses' => 'GroupOffersController@associateTypeSideDishes']);
        $router->get('/associate/type-side-dish/{group_offer_id}', ['uses' => 'GroupOffersController@listTypeSideDishes']);
    });
    $router->group(['prefix' => 'offer'], function () use ($router) {
        $router->get('/', ['uses' => 'OfferController@list']);
        $router->get('/not-daily', ['uses' => 'OfferController@listNotDaily']);
        $router->post('/', ['uses' => 'OfferController@store']);
        $router->put('/{id}', ['uses' => 'OfferController@update']);
        $router->delete('/{id}', ['uses' => 'OfferController@destroy']);
    });
    $router->group(['prefix' => 'offer-daily'], function () use ($router) {
        $router->get('/', ['uses' => 'OfferDailyController@listIndex']);
        /** insert one offer daily */
        $router->post('/', ['uses' => 'OfferDailyController@store']);
        $router->post('/package', ['uses' => 'OfferDailyController@storePackage']);
        $router->put('/{id}', ['uses' => 'OfferDailyController@update']);
        $router->delete('/{id}', ['uses' => 'OfferDailyController@destroy']);
        $router->get('/previous', ['uses' => 'OfferDailyController@previous']);
    });
    $router->group(['prefix' => 'offer-promotion'], function () use ($router) {
        $router->get('/', ['uses' => 'OfferPromotionController@list']);
        $router->post('/', ['uses' => 'OfferPromotionController@store']);
        $router->delete('/{id}', ['uses' => 'OfferPromotionController@destroy']);
    });
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->get('/', ['uses' => 'UsersController@list']);
        $router->post('/', ['uses' => 'UsersController@store']);
        $router->put('/{id}', ['uses' => 'UsersController@update']);
        $router->delete('/{id}', ['uses' => 'UsersController@destroy']);
    });
    $router->group(['prefix' => 'type-side-dish'], function () use ($router) {
        $router->get('/', ['uses' => 'TypeSideDishController@list']);
        $router->post('/', ['uses' => 'TypeSideDishController@store']);
        $router->put('/{id}', ['uses' => 'TypeSideDishController@update']);
        $router->delete('/{id}', ['uses' => 'TypeSideDishController@destroy']);
    });

    $router->group(['prefix' => 'side-dish'], function () use ($router) {
        $router->get('/', ['uses' => 'SideDishController@list']);
        $router->post('/', ['uses' => 'SideDishController@store']);
        $router->put('/{id}', ['uses' => 'SideDishController@update']);
        $router->delete('/{id}', ['uses' => 'SideDishController@destroy']);
    });

});

$router->group(['prefix' => 'frame-web'], function () use ($router) {
    $router->get('/', ['uses' => 'FrameWebController@list']);
});
$router->group(['prefix' => 'group-offer'], function () use ($router) {
    $router->get('/', ['uses' => 'GroupOffersController@list']);
    $router->get('/offers', ['uses' => 'GroupOffersController@listGroupWithOffer']);
    $router->get('/get-subCategory/{category_id}', ['uses' => 'GroupOffersController@listSubCategory']);
    $router->get('/associate/type-side-dish/{group_offer_id}', ['uses' => 'GroupOffersController@listTypeSideDishes']);
});
$router->group(['prefix' => 'offer'], function () use ($router) {
    $router->get('/', ['uses' => 'OfferController@list']);
});
$router->group(['prefix' => 'offer-daily'], function () use ($router) {
    $router->get('/', ['uses' => 'OfferDailyController@listIndex']);
    $router->get('/items', ['uses' => 'OfferDailyController@list']);
    $router->get('/category', ['uses' => 'OfferDailyController@listCategory']);
    $router->get('/get-subCategory/{category_id}', ['uses' => 'OfferDailyController@listSubCategory']);
});
$router->group(['prefix' => 'offer-promotion'], function () use ($router) {
    $router->get('/', ['uses' => 'OfferPromotionController@list']);
});
$router->group(['prefix' => 'type-side-dish'], function () use ($router) {
    $router->get('/', ['uses' => 'TypeSideDishController@list']);
});

$router->group(['prefix' => 'side-dish'], function () use ($router) {
    $router->get('/', ['uses' => 'SideDishController@list']);
});

$router->group(['prefix' => 'setting'], function () use ($router) {
    $router->get('/', ['uses' => 'SettingController@get']);
    $router->put('/', ['uses' => 'SettingController@update']);
    $router->get('/municipality', ['uses' => 'MunicipalityController@list']);
    // Delivery place
    $router->get('/delivery-place', ['uses' => 'DeliveryPlaceController@list']);
    $router->post('/delivery-place', ['uses' => 'DeliveryPlaceController@store']);
    $router->put('/delivery-place/{id}', ['uses' => 'DeliveryPlaceController@update']);
    $router->delete('/delivery-place/{id}', ['uses' => 'DeliveryPlaceController@destroy']);
});

$router->group(['prefix' => 'push-notification'], function () use ($router) {
    $router->get('/', ['uses' => 'PushNotificationController@list']);
    $router->post('/', ['uses' => 'PushNotificationController@store']);
    $router->put('/{id}', ['uses' => 'PushNotificationController@update']);
    $router->delete('/{id}', ['uses' => 'PushNotificationController@destroy']);
    $router->post('/send', ['uses' => 'PushNotificationController@send']);
});
