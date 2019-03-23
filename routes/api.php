<?php

use Illuminate\Http\Request;
use App\Contact;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware'=>'api'], function(){
    //fetch contacts
    Route::get('contacts',function(){
        return Contact::latest()->orderBy('created_at','desc')->get();
        });
    //get single contact
    Route::get('contact/{id}',function($id){
        return Contact::findOrFail($id);
    });
    //add contact
    Route::post('contact/store',function(Request $request){
        return Contact::create(['FirstName' => $request->input(['FirstName']),
                                'LastName' => $request->input(['LastName']),
                                'PhoneNumber' => $request->input(['PhoneNumber']),
                                'MobileNumber' => $request->input(['MobileNumber']),
                                'BirthDate' => $request->input(['BirthDate']),
                                'Address' => $request->input(['Address']),
                                'Email' => $request->input(['Email'])]);
    });
    Route::patch('contact/{id}',function(Request $request, $id){
        Contact::findOrFail($id)->update(['FirstName' => $request->input(['FirstName']),
        'LastName' => $request->input(['LastName']),
        'PhoneNumber' => $request->input(['PhoneNumber']),
        'MobileNumber' => $request->input(['MobileNumber']),
        'BirthDate' => $request->input(['BirthDate']),
        'Address' => $request->input(['Address']),
        'Email' => $request->input(['Email'])]);

    });
    Route::delete('contact/{id}',function($id){
        return Contact::destroy($id);
    });
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
