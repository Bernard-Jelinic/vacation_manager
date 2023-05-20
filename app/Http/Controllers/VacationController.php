<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class VacationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $display)
    {
        if ($display == 'all') {

            $vacations = Vacation::with('user')->get();
        } else {
            if ($display == 'pending') {
                $get_status = 1;
            } elseif ($display == 'approved') {
                $get_status = 2;
            } elseif ($display == 'notapproved') {
                $get_status = 3;
            }
            
            $vacations = Vacation::with('user')->where('status_id', $get_status)->get();
        }

        return view('vacation.index', compact('vacations', 'display'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vacation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //converting input to date because input is type string
        $depart = date('Y-m-d', strtotime($request->input('depart')));
        $return = date('Y-m-d', strtotime($request->input('return')));

        $validated = $request->validate([
            'depart' => 'required',
            'return' => 'required',
        ]);

        $date = date("Y-m-d H:i:s");

        Vacation::create([
            'depart' => $depart,
            'return' => $return,
            'created_at' => $date,
            'updated_at' => $date,
            'status_id' => 1,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('vacation', 'all')
                        ->with('success', 'Vacation created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function show(Vacation $vacation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacation $vacation)
    {
        auth()->user()->unreadNotifications()->where('data', 'LIKE', '%"vacation_id":'.$vacation->id.'%')->get()->markAsRead();

        return view('vacation.edit', compact('vacation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vacation $vacation)
    {
        $vacation->update($request->only('status_id'));
        return redirect()->route('vacation', 'all')
                        ->with('success', 'Vacation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacation $vacation)
    {
        //
    }
}
