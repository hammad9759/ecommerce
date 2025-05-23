<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Hash;

use Auth;

class AuthController extends Controller
{
    public function createAdmin()
    {
      $user         =  new User();
      $user->name   =  'Admin';
      $user->email   =  'admin@gmail.com';
      $user->phone   =  '0556683292';
      $user->address   =  'Dubai, United Arab Emirates';
      $user->x_link   =  'https://x.com/samk505152';
      $user->facebook_link   =  'https://www.facebook.com/hammad.mohd.786';
      $user->insta_link   =  'https://www.instagram.com/qazi_hammad_mohd/';
      $user->password = Hash::make('1234');
      $user->save();

      $admin = Role::where('slug','admin')->first();
      $user->roles()->attach($admin);
    }
}
