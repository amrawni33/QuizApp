<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->api([], 1, $validator->errors()->first(),statusCode: 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $data['user'] = new UserResource($user);
            $data['token'] = $user->createToken('my-app-token')->plainTextToken;

            return response()->api($data);
        } else {

            return response()->api([], 1, __('auth.failed'), statusCode: 401);
        } //end of else

    } //end of login

    public function show(User $user){

        return response()->api([
            'grade' => new UserResource($user)
        ]);
    }

    public function getEdus(){

        $educs = User::query()
        ->where('isEduo', true)->get();

        return response()->api([
            'educators' => UserResource::collection($educs)
        ]);
    }

    public function getstudents(){

        $students = User::query()
        ->where('isEduo', false)->get();

        return response()->api([
            'students' => UserResource::collection($students)
        ]);
    }

    public function logout(User $user)
    {
        $user->tokens()->delete();
        return response()->api();
    }

}
