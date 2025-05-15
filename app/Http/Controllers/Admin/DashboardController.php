<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Validator;
use Auth;


class DashboardController extends Controller
{

    use ApiResponse;


    public function index(){
        return view('admin/profile');
    }

    public function userProfile(){
        return view('admin/profile');
    }


    public function userProfileUpdate(Request $request){
        $user = Auth::user();

        // Validate Input
        $validation = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|unique:users,email,' . $user->id,
            'phone'         => 'required|string|max:255',
            'address'       => 'nullable|string|max:255',
            'x_link'        => 'nullable|string|max:255',
            'facebook_link' => 'nullable|string|max:255',
            'insta_link'    => 'nullable|string|max:255',
            'dp'            => 'nullable|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validation->fails()) {
            // return response()->json(['status' => 400, 'message' => $validation->errors()->first()]);
            return $this->error($validation->errors()->first(),404,'Error');
        }

        // Update user details
        $user->name          = $request->name;
        $user->email         = $request->email;
        $user->phone         = $request->phone;
        $user->address       = $request->address;
        $user->x_link        = $request->twitter;
        $user->facebook_link = $request->facebook;
        $user->insta_link    = $request->instagram;

        // Handle Profile Image Upload
        if ($request->hasFile('dp')) {
            // Delete old image if exists
            if ($user->dp && file_exists(public_path('uploads/userProfiles/' . $user->dp))) {
                unlink(public_path('uploads/userProfiles/' . $user->dp));
            }

            // Upload new image
            $imageName = time() . '.' . $request->dp->extension();
            $request->dp->move(public_path('uploads/userProfiles'), $imageName);
            $user->dp = $imageName;
        }

        // Save Updated User
        $user->save();
        // return redirect()->route('admin.userProfile');
        // return response()->json(['status' => 200, 'message' => 'Profile updated successfully']);
        return $this->success(200,'Profile updated successfully');
    }

}
