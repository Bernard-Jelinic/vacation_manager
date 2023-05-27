@extends('index')

@section('user.index')

    <div class="container-fluid">
        <br>

        <h3>Manage Employee</h3><br>

        <table class="table table-striped table-hover">

            <thead>
                <tr><th>Name</th><th>Role</th><th>Department</th><th>Email</th><th>Action</th></tr>
            </thead>

            <tbody>
                @if ($users)
                    @foreach ($users as $user)
                    @if ($user->department)
                        <tr><td>{{$user->name . ' ' . $user->last_name}}</td><td>{{$user->role}}</td><td>{{$user->department->name}}</td><td>{{$user->email}}</td>
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
                @endif
            </tbody>

        </table>

        <div class="row">
            <div class="col-md-12 text-center">
                {{ $users->onEachSide(1)->links() }}
            </div>
        </div>

    </div>

@endsection