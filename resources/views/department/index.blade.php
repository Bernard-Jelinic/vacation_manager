@extends('index')

@section('department.index')

    <div class="container-fluid">
        <br>

        <h3>Manage Departments</h3><br>

        <x-table.table :headers="['Department', 'Manager', 'Action']">
            @if ($departments)
                @foreach ($departments as $department)
                    <tr>
                        <td>{{$department->name}}</td>
                        <td>{{ isset($department->manager->full_name) ? $department->manager->full_name : $department->manager }}</td>
                        <td>
                            <a href="{{ route('department.edit', [$department->id]) }}">
                                <button class="btn-sm btn btn-success"><i class="fa fa-edit"></i> Edit</button>
                            </a>
                            <form action="{{ route('department.destroy', [$department->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn btn-warning"><i class="fa fa-times"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </x-table.table>
    </div>

@endsection