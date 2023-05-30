@extends('index')

@section('user.index')

    <div class="container-fluid">
        <br>

        <h3>Manage Employee</h3><br>

        <x-table.table :headers="['Name', 'Last Name', 'Role', 'Department', 'Email', 'Action']">
            @if ($users)
                @foreach ($users as $user)
                @if ($user->department)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->last_name}}</td>
                        <td>{{$user->role}}</td>
                        <td>{{$user->department->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <a href="{{ route('user.edit', [$user->id]) }}">
                                <button class="btn-sm btn btn-success"><i class="fa fa-edit"></i> Edit</button>
                            </a>
                            <form action="{{ route('user.destroy', $user->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn btn-warning"><i class="fa fa-times"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endif
                @endforeach
                <form action="{{ route('user.index') }}" method="GET">
                    <td><input value="{{ request()->query('name') }}" type="text" class="form-control mr-2" name="name" placeholder="Filter by Name"></td>
                    <td><input value="{{ request()->query('last_name') }}" type="text" class="form-control mr-2" name="last_name" placeholder="Filter by Last Name"></td>
                    <td>
                        <select name="role" class="form-control" >
                            @if (request()->query('role') == 'manager')
                                <option value="">Display all</option>
                                <option value="manager" selected>Manager</option>
                                <option value="employee">Employee</option>
                            @elseif (request()->query('role') == 'employee')
                                <option value="">Display all</option>
                                <option value="manager" selected>Manager</option>
                                <option value="employee">Employee</option>
                            @elseif (request()->query('role') == '' || !request()->filled('role')  )
                                <option value="" selected>Display all</option>
                                <option value="manager">Manager</option>
                                <option value="employee">Employee</option>
                            @endif
                        </select>
                    </td>
                    <td>
                        <select name="department_id" class="form-control" >
                            <option {{ !request()->filled('department_id') ? 'selected' : '' }} value="">Display all</option>
                            @foreach ($departments as $department)
                                <option {{ request()->query('department_id') == $department->id ? 'selected' : '' }} value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input value="{{ request()->query('email') }}" type="text" class="form-control mr-2" name="email" placeholder="Filter by Email"></td>
                    <td><button type="submit" class="btn-sm btn btn-primary"><i class="fa fa-filter"> Filter</i></button></td>
                </form>
            @endif
        </x-table.table>

        <div class="row">
            <div class="col-md-12 text-center">
                {{ $users->appends(request()->except('page'))->onEachSide(1)->links() }}
            </div>
        </div>

    </div>

@endsection