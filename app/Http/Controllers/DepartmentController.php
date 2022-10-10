<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();

        $managers = User::all()->where('role', 'manager');

        $depart_manag = array();

        foreach ($departments as $department) {

            $data = array();
            $data = (object) $data;

            $data->id = $department->id;
            $data->department_name = $department->name;

            $managers_full_name = "Department doesn't have manager";

            foreach ($managers as $manager) {

                if ($department->id == $manager->department_id) {
                    $managers_full_name = $manager->name . ' ' . $manager->last_name;
                }

                $data->manager_name = $managers_full_name;
            }

            $depart_manag[] = $data;
        }

        return view('department.index', ['departments' => $depart_manag]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $managers = User::getManagers();
        return view('department.create', ['managers' => $managers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Department::create($request->only('name'));
        return redirect('department');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $managers = User::getManagers();
        $current_department_manager = User::all()->where('department_id', $department->id)->where('role', 'manager')->first();
        return view('department.edit', ['department' => $department, 'managers' => $managers, 'current_department_manager' => $current_department_manager]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $data['name'] = $request->input('name');
        $data['updated_at'] = date("Y-m-d H:i:s");

        $department->update($data);

        // admin doesn't need to select manager
        if ($request->input('manager_id') != 'Select departments manager') {
            $user = User::find($request->input('manager_id'));
            $user->department_id = $department->id;
            $user->save();
        }

        return redirect('department');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect('department');
    }
}
