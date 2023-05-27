<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\Vacation;
use App\Models\VacationStatus;

class VacationController extends Controller
{
    private function getModelClassName(): string
    {
        return Vacation::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $status_request)
    {
        $vacations = $this->getModelClassName()::query();
        $display_text = '';
        if ($status_request == 'all') {
            $status = $status_request;
            $display_text = 'Vacations History';
        } else{
            $status = VacationStatus::where('name', $status_request)->first();
            $vacations = $vacations->where('status_id', $status->id);
            $display_text = $status->name . ' Vacations';
        }
        $vacations = $vacations->paginate(10);

        return view('vacation.index', compact('vacations', 'display_text'));
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

        $this->getModelClassName()::create([
            'depart' => $depart,
            'return' => $return
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
