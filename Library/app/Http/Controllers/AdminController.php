<?php
namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function getUsers()
    {
        $user = User::all();
        return $user;
    }

    public function createNewUser(Request $request)
    {
        $status = 0;
        $data = $request->validate([
            'name' => 'string',
            'surname' => 'string',
            'email' => 'string',
            'password' => 'string',
            'remember_token' => 'string',
            'role' => 'string',
        ]);
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
    public function deleteUser($id)
    {
        $user =  User::where('id', $id)->first();
        $user->delete();
        return('deleted');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        return('Обновление успешно');

    }

}
