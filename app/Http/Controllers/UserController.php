<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->model = User::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->model::query();

        if ( isset($request->name) ) {
            $keyword = $request->name; // The search keyword
            $users = $users->where('name', 'like', "%{$keyword}%");
        }
        if ( isset($request->last_name) ) {
            $keyword = $request->last_name; // The search keyword
            $users = $users->where('last_name', 'like', "%{$keyword}%");
        }
        if ( isset($request->role) ) {
            $users = $users->where('role', $request->role);
        }
        if ( isset($request->department_id) ) {
            $users = $users->where('department_id', $request->department_id);
        }
        if ( isset($request->email) ) {
            $keyword = $request->email; // The search keyword
            $users->where('email', 'like', "%{$keyword}%");
        }

        $users = $users->paginate(10);
        $departments = Department::all();
        
        return view('user.index', compact('users', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        return view('user.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = $request->only('name', 'last_name', 'role', 'department_id', 'email', 'email_verified_at' ,'password', 'remember_token');

        $user['email_verified_at'] = now();
        $user['password'] = Hash::make($user['password']);
        $user['remember_token'] = Str::random(10);

        $this->model::create($user);
        return redirect()->route('user.index')
                    ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $departments = Department::all();
        return view('user.edit', compact('user', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->only('name', 'last_name', 'role', 'department_id', 'email', 'password');

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('user.edit', $user->id)
                        ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')
                        ->with('success', 'User deleted successfully');
    }
}
