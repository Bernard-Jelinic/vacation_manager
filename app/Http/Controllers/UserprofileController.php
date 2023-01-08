<?php

namespace App\Http\Controllers;

use App\Models\Userprofile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserprofileRequest;

class UserprofileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Userprofile  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function show(Userprofile $userprofile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Userprofile  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function edit(Userprofile $userprofile)
    {
        return view('userprofile.edit', compact('userprofile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserprofileRequest  $request
     * @param  \App\Models\Userprofile  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserprofileRequest $request, Userprofile $userprofile)
    {
        $data = $request->only('name', 'last_name', 'email', 'password');

        if ($request->file()) {

            if(\File::exists(Auth::user()->image)) {
                \File::delete(Auth::user()->image);
            }

            $imageName = time().'.'.$request->image->extension();
            $publicPath = 'assets/profilepictures/';
            $fullImagePath = $publicPath . $imageName;
            $request->image->move(public_path($publicPath), $imageName);
            $data['image'] = $fullImagePath;
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }else {
            unset($data['password']);
        }

        $userprofile->update($data);

        return redirect()->route('userprofile.edit', $userprofile->id)
                        ->with('success', 'Userprofile updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Userprofile  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Userprofile $userprofile)
    {
        //
    }
}
