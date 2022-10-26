<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

// Common Resource Routes: konvencije valjda
// index - show all Listings
// show - show single listing
// create - show form to create new listing POKAZE FORMU ZA SUBMIT
// store - store new listing                STORA ISPUNJENU FORMU
// edit - show form to edit listing         POKAZE FORMU ZA SUBMIT    
// update - update listing
// destroy - delete listing

//REDOSLIJED RUTA JE BITAN
//kad mi je 'create form' ruta bila nakon 'single listinga' onda shvati create kao ID u ruti za pojedinacne listinge

//all listings
Route::get('/', [ListingController::class, 'index']); //referiramo se na taj kontroler unutar kojeg je metoda index

//show create form
Route::get('/listings/create', [ListingController::class, 'create'])
    ->middleware('auth');
    //ovo stavljanje middleware zove se ROUTE PROTECTION

//Store listing creation (nakon sto submita moram imat post)
Route::post('/listings', [ListingController::class, 'store'])
    ->middleware('auth');

//show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit']) //ROUTE MODEL BINDING {}
    ->middleware('auth');

//update db with edit form
Route::put('/listings/{listing}', [ListingController::class, 'update'])   //ROUTE MODEL BINDING {}
    ->middleware('auth');

//delete listing (destroy je naming convention)
Route::delete('/listings/{listing}', [ListingController::class, 'destroy']) //ROUTE MODEL BINDING {}
    ->middleware('auth');

//manage listings
Route::get('/listings/manage', [ListingController::class, 'manage'])
    ->middleware('auth');

//single listings (najbolje stavit za zadnje)
Route::get('/listings/{listing}', [ListingController::class, 'show']);   //ROUTE MODEL BINDING {}

//show register form
Route::get('/register', [UserController::class, 'create'])
    ->middleware('guest');
    //ako ovo ne dodamo mos accessat register formu kroz url i dok si loginan
    //middleware redirecta na homepage definisan u RouteServiceProviders
    //bio je '/home' pa sam prebacio na samo slash '/'

//store new user
Route::post('/users', [UserController::class, 'store']);

//logout
Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth');

//show login form
Route::get('/login', [UserController::class, 'login'])
    ->name('login')
    ->middleware('guest');

//login user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);







/* NA KRAJU OVO SVE U KONTROLER PREBACIO
//All listings
Route::get('/', function () {
    return view('listings', [  //ovde nam data u routu a inace ce nam data biti u modelu ORM eloquent koristimo
        // 'heading' => 'Latest Listings', ne treba vise
        'listings' => Listing::all()
    ]);
});

// Single listing
//verzija 3, najbolja
Route::get('/listings/{listing}', function(Listing $listing) { //KAKO ZNA KOJI ATRIBUT DA PASSA U URI argumentu od geta (ispitati taj RMB)
    return view('listing', [
        'listing' => $listing
    ]);
});
//404 funkcija odma ovde pa ne moras IF
//ROUTE MODEL BINDING omoguci da ne moras ID passat
------sad ovo gore u kontroleru*/


// verzija 2
// Route::get('/listings/{id}', function($id) {
//     $listing = Listing::find($id);

//     if ($listing) {
//         return view('listing', [
//             'listing' => $listing
//         ]);
//     } else {
//         abort('404');
//     }
// });

//verzija 1, ispod prije bilo ali problem bude ako u url ukucaj veci broj od moguceg IDa onda izbaci neki drugi error exception, a ne 404 NOT FOUND
// Route::get('/listings/{id}', function($id) {
//     return view('listing', [
//         'listing' => Listing::find($id)
//     ]);
// });


/*
Route::get('/hello', function () {
    return response('<h1>Hello World</h1>')
        ->header('Content-Type', 'text/plain')
        ->header('foo', 'bar'); //CUSTOM FOO KEY, u headersima
});

Route::get('/posts/{id}', function ($id) {
    // dd($id); //debugging helper metoda DIEandDUMP DD, samo vrati id i 500 passa
    // ddd($id); //DIE DUMP DEBUG, sve ti kaze kume
    return response('Post ' . $id);
})->where('id', '[0-9]+'); //ovo je constraint na id, mozes stavis RE koji hos
//u ovom slucaju mora biti brojevi od 0-9

Route::get('/search', function(Request $request) {   //desni klik na request i import class
    dd($request);
    //kad queryamo /search?name=Brad&city=Boston bude pod query
});

Route::get('/searchreturn', function(Request $request) {
    return $request->name . ' ' . $request->city;
    //kad queryamo /searchreturn?name=mesko&city=sarajvo returna to
});
*/