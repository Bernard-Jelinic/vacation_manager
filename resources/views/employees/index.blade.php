@extends('dashboards.admins.index')

@section('employees.index')

    <div class="container-fluid">
        <br>

        <h3>Manage Employee</h3><br>

        <table class="table table-striped table-hover">

            <thead>
                <tr><th>Name</th><th>Role</th><th>Department</th><th>Email</th><th>Action</th></tr>
            </thead>

            <tbody>
                @if ($employees)
                    @foreach ($employees as $employee)
                    @if ($employee->department)
                        <tr><td>{{$employee->name . ' ' . $employee->last_name}}</td><td>{{$employee->role}}</td><td>{{$employee->department->name}}</td><td>{{$employee->email}}</td>
                            <td>
                        
                                <a href="{{ route('employees.edit', [$employee->id]) }}">
                                    <button class="btn-sm btn btn-success"><i class="fa fa-edit"></i> Edit</button>
                                </a>
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-sm btn btn-warning"><i class="fa fa-times"></i> Delete</button>
                                </form>

                            </td>
                        </tr>
                    @endif

                    @endforeach
                @endif
            </tbody>

        </table>

    </div>

@endsection