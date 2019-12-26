<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class User2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderlist = [
            [
                "name" => "Name (ascending)",
                "column" => "name",
                "order" => "asc"
            ],
            [
                "name" => "Name (descending)",
                "column" => "name",
                "order" => "desc"
            ],
            [
                "name" => "Email (ascending)",
                "column" => "email",
                "order" => "asc"
            ],
            [
                "name" => "Email (descending)",
                "column" => "email",
                "order" => "desc"
            ],
            [
                "name" => "not active",
                "column" => "active",
                "order" => "asc"
            ],
            [
                "name" => "admin",
                "column" => "admin",
                "order" => "desc"
            ],
        ];

        $name = $request->input('name') ?? '%';
        $order = $request->sort ?? 0;


        $users = User::orderBy($orderlist[$order]["column"], $orderlist[$order]["order"])
            ->where('name', 'like', '%' . $name . '%')
            ->orWhere('email', 'like', '%' . $name . '%')
            ->paginate(10)
            ->appends(['name' => $request->input('name'), 'email' => $request->input('email')]);
        $result = compact('users', 'orderlist');
        Json::dump($result);
        return view('admin.users2.index', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('admin/users2');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return redirect('admin/users2');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return redirect('admin/users2');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        if ($user->id == auth()->id()) {
            session()->flash('danger', 'You can not update yourself');
            return redirect('admin/users2');
        }


        $this->validate($request, [
            'name' => 'required|min:3|unique:users,name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id
        ]);

        #Radio Button validation
        if ($request->active == 1) {
            $user->active = 1;
        } else {
            $user->active = 0;
        }

        if ($request->admin == 1) {
            $user->admin = 1;
        } else {
            $user->admin = 0;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return response()->json([
            'type' => 'success',
            'text' => "The user <b>$user->name</b> has been updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->id == auth()->id()) {
            session()->flash('danger', 'You can not delete yourself');
            return redirect('admin/users2');
        }

        $user->delete();
        session()->flash('success', "The genre <b>$user->name</b> has been deleted");
        return redirect('admin/users2');
    }
}
