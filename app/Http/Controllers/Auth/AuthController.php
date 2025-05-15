<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Validator;
use Auth;

class AuthController extends Controller
{
    use ApiResponse;


    // api functions starts 
    public function register(Request $request){
        $validation = Validator::make($request->all(),[
            'name'    => 'required|string|max:255',
            'email'   => 'required|string|email|unique:users,email',
            'password'=> 'required|string|min:6'
        ]);

        if($validation->fails()){
            return $this->error($validation->errors()->first(),400,[]);
        }

        $user = User::create([
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'address' => $request->password,
            'email' => $request->email
        ]);

        $customer = Role::where('slug','customer')->first();

        $user->roles()->attach($customer);

        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    public function login(Request $request){
        $validation = Validator::make($request->all(),[
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);
        if($validation->fails()){
            return $this->error($validation->errors()->first(),400,[]);

        }
        $data  = $request->all();
        if (!Auth::attempt($data)) {
            return $this->error('Credentials not match', 401);
        }
        // $user = User::find(auth()->id());
        $user = auth()->user();
        $user['token'] = $user->createToken('API Token')->plainTextToken;
        return $this->success(['user' => $user], 'Login successful');
    }

    public function showUser(Request $request){
        return response()->json($request->user());
        //  return $request->user();
    }

    public function updateUser(Request $request) {
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
            return $this->error($validation->errors()->first(), 404, 'Error');
        }

        // Update user links
        $user->name          = $request->name;
        $user->email         = $request->email;
        $user->phone         = $request->phone;
        $user->address       = $request->address;
        $user->x_link        = $request->x_link;
        $user->facebook_link = $request->facebook_link;
        $user->insta_link    = $request->insta_link;

        // Handle profile image upload
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

        $user->save();

        return $this->success(200, 'Profile updated successfully');
    }

    public function apiUserLogout(Request $request){
        // Revoke the current access token
        // $request->user()->currentAccessToken()->delete();
        // Logout from All Devices
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'Success',
            'message' => 'Logged out successfully'
        ], 200);
    }

    // api functions end


    function adminLogin(){
        return view('admin/auth/signIn');
    }

    function dashboard(){
        return view('admin/index');
    }

    function loginUser(Request $request){
        $validation = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string|min:4'
        ]);

        if($validation->fails()){
            return response()->json(['status'=>400, 'message'=>$validation->errors()->first()]);
        }else{
            $cred = array('email' => $request->email, 'password' => $request->password);
            if(Auth::Attempt($cred,false)){
                if(Auth::User()->hasRole('admin')){
                    return response()->json(['status' => 200, 'message' => 'Login successful','url' => '/admin/dashboard']);
                }else{
                    $user = User:: find(Auth::User()->id)->first();
                    $user['token'] = $user->createToken('API Token')->plainTextToken;
                    return $this->success(['user' => $user], 'Login successful');
                    // return response()->json(['status' => 200, 'message' => 'Login successful']);

                }
            }else{
                return response()->json(['status' => 404, 'message' => 'Wrong details']);
            }

        }
    }



    function logout(Request $request) {
        Auth::logout();

        // Invalidate session & regenerate CSRF token (optional)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page or any other route
        return redirect()->route('admin.login'); // Change to the appropriate route
    }


}
