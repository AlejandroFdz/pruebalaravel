<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Route::get('/countries', function()
{
	return Countries::getList('es', 'json');
});

Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

/**
 * Routes for users with trial or pro plans
 */
Route::group(['middleware' => 'auth'], function() {

  Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/planes', 'PlanController@index')->name('plans.index');
	Route::get('/plan/{plan}', 'PlanController@show')->name('plans.show');

	Route::get('/braintree/token', 'BraintreeTokenController@token')->name('braintree.token');
	Route::post('/subscription', 'SubscriptionController@create')->name('subscription.create');

  Route::get('/user/profile', 'ClientsController@profile')->name('user.profile');
  Route::put('/user/update', 'ClientsController@update')->name('user.update');

  Route::get('/trial/activar', 'TrialController@activar')->name('trial.activar');

  /** Pagos regulares por paypal. */
  Route::get('paypal/express-checkout', 'PaypalController@expressCheckout')->name('paypal.express-checkout');
  Route::get('paypal/express-checkout-success', 'PaypalController@expressCheckoutSuccess');
  Route::post('paypal/notify', 'PaypalController@notify');
  Route::get('paypal/suspend/{id}', 'PaypalController@suspend');

});

/**
 * Routes for admin
 */
Route::group(['middleware' => ['admin']], function () {

  Route::get('/admin', 'AdminController@dashboard')->name('admin.dashboard');

});


Route::post('contacts/form_subscribe', 'ContactsController@form_subscribe');

Route::get('contacts/unsubscribe/{id}', 'ContactsController@unsubscribe');

/**
 * Routes for clients
 */
Route::group(['middleware' => ['auth']], function () {

  /** 
   * Si hay evidencia de que el usuario modifica los id's de la url
   * se le redirije hacia una pantalla de aviso indicándole que su cuenta
   * puede ser bloqueada.
   */
  Route::get('/watson', 'WatsonController@index');

  Route::get('/subscriptor', 'SubscriptorController@dashboard')->name('subscriptor.dashboard');
  
  Route::get('/campaigns/{id}/send', 'CampaignsController@send')->name('campaigns.send');
  Route::post('/campaigns/send_campaign', 'CampaignsController@send_campaign')->name('campaigns.send_campaign');
  //Route::delete('/campaigns/destroy/{id}', 'CampaignsController@destroy')->name('campaigns.destroy');
  Route::resource('campaigns', 'CampaignsController');
  
  Route::resource('lists', 'ListsController');

  Route::resource('contacts', 'ContactsController');

  Route::resource('groups', 'GroupsResourceController');

  Route::post('/templates/previewtofile', 'TemplatesController@previewtofile')->name('templates.previewtofile');
  Route::post('/templates/upload_image', 'TemplatesController@upload_image')->name('templates.upload_image');
  Route::delete('/templates/destroy/{id}', 'TemplatesController@destroy')->name('templates.destroy');
  Route::resource('templates', 'TemplatesController');

  /** Tickets */
  Route::resource('tickets', 'TicketsController');

  /** Comentarios de los tickets */
  Route::resource('ticket_comments', 'TicketCommentsController');

});

/** Ajax */

// Obtenemos una lista de grupos dado un id de lista comparando el token de usuario:
Route::get('/groups/glist/{user_token}/{id_list}', 'CampaignsController@glist')->name('campaigns.glist');
Route::get('/groups/scount/{user_token}/{id_group}', 'CampaignsController@scount')->name('campaigns.scount');

/** Creamos una ruta para poder visualizar las previews de las plantillas guardadas en /storage */
Route::get('storage/uploads/template_users/{year}/{month}/{filename}', function ($year, $month, $filename)
{
    $path = storage_path('uploads/template_users/' . $year . '/' . $month .'/'. $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

/** Creamos una ruta para poder leer las imágenes del blog. */
Route::get('storage/app/uploads/blog/{year}/{month}/{filename}', function ($year, $month, $filename)
{
    $path = storage_path('app/uploads/blog/' . $year . '/' . $month .'/'. $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

/** Creamos una ruta para poder leer las imágenes de los tickets. */
Route::get('storage/app/uploads/tickets/{year}/{month}/{filename}', function ($year, $month, $filename)
{
    $path = storage_path('app/uploads/tickets/' . $year . '/' . $month .'/'. $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});


/** Blog */
Route::resource('blog', 'BlogController');

/** Registro de correos abiertos por los usuarios. */
Route::get('/email/opened/{list_id}/{subscriber_id}/{emails_sended}')->name('email.opened');
Route::get('/email/opened/{list_id}/{subscriber_id}/{emails_sended}', 'EmailController@opened')->name('email.opened');

/** Registro de los correos donde el usuario hizo click. */
Route::get('/email/clicked/{list_id}/{subscriber_id}/{emails_sended}/{url}', 'EmailController@clicked')->name('email.clicked')->where('url', '.*');