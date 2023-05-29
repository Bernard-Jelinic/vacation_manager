@extends('index')

@section('vacation')
    
    <div class="container-fluid">
        <br>
            <h3>{{ $display_text }}</h3><br>

            @php
                $headers = ['Name', 'Last Name', 'Depart date', 'Return date', 'Date of application', 'Status'];
                if ('can:admin_manager_area') {
                    $headers[] = 'Action';
                }
            @endphp

            <x-table.table :headers="$headers">
                @if ($vacations)
                    @foreach ($vacations as $vacation)
                        <tr>
                            <td>{{$vacation->user->name}}</td>
                            <td>{{$vacation->user->last_name}}</td>
                            <td>{{$vacation->depart}}</td>
                            <td>{{$vacation->return}}</td>
                            <td>{{$vacation->created_at->format('Y-m-d')}}</td>
                            <td>
                                @if ($vacation->status_id == 1)
                                    <span style="color: blue">waiting for approval</span>
                                @elseif ($vacation->status_id == 2)
                                    <span style="color: green">Approved</span>
                                @elseif ($vacation->status_id == 3)
                                    <span style="color: red">Deny</span>
                                @endif
                            </td>
                            @can('admin_manager_area')
                            <td>
                                <a href="{{ route('vacation.edit', [$vacation->id]) }}">
                                    <button class="btn-sm btn btn-success"><i class="fa fa-edit"></i> Edit</button>
                                </a>
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                @endif
            </x-table.table>

        <div class="row">
            <div class="col-md-12 text-center">
                {{ $vacations->onEachSide(1)->links() }}
            </div>
        </div>

    </div>

@endsection