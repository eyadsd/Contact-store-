<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['FirstName','LastName','Email','PhoneNumber','MobileNumber','BirthDate','Address'];
}
