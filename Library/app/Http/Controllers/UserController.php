<?php
namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function store(Request $request)
    {
        $status = 0;
       $data = $request->validate([
            'name' => 'string',
            'surname' => 'string',
            'email' => 'string',
            'password' => 'string',
            'api_token' => 'string',
            'role' => 'string',
        ]);
       $token = $data['api_token'] = 'noToken';
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            User::create($data);
            $status = 1;
            return($status);
        }
        else
        {
         return ($status);
        }
    }

}
