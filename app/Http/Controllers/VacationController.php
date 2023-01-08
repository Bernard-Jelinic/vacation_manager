<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

            Vacation::query()->update(['' . Auth::user()->role . '_read' => 1]);

            $vacations = Vacation::with('user')->get();  
        } else {
            if ($display == 'pending') {
                $get_status = 0;
            } elseif ($display == 'approved') {
                $get_status = 1;
            } elseif ($display == 'notapproved') {
                $get_status = 2;
            }

            Vacation::where('status', $get_status)->update(['' . Auth::user()->role . '_read' => 1]);
            
            $vacations = Vacation::with('user')->where('status', $get_status)->get();
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
            'status' => 0,
            'admin_read' => 0,
            'manager_read' => 0,
            'employee_read' => 0,
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
        $vacation->update(['' . Auth::user()->role . '_read' => 1]);
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
        $vacation->update($request->only('status'));
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
