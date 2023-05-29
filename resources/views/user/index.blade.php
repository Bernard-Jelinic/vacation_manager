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
            @endif
        </x-table.table>

        <div class="row">
            <div class="col-md-12 text-center">
                {{ $users->onEachSide(1)->links() }}
            </div>
        </div>

    </div>

@endsection