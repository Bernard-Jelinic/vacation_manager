@extends('index')

@section('vacation')
    
    <div class="container-fluid">
        <br>
            @if ($display == 'pending')
                <h3>Pending Vacations</h3><br>
            @elseif ($display == 'approved')
                <h3>Approved Vacations</h3><br>
            @elseif ($display == 'not approved')
                <h3>Not Approved Vacations</h3><br>
            @elseif ($display = 'all')
                <h3>Vacations History</h3><br>
            @endif

        <table class="table table-striped table-hover">

            <thead>
                <tr><th>User</th><th>User Id</th><th>Depart date</th><th>Return date</th><th>Date od application</th><th>Status</th><th>Action</th></tr>
            </thead>

            <tbody>
                @if ($vacations)
                    @foreach ($vacations as $vacation)

                        <tr><td>{{$vacation->user->name}}</td>
                        <td id="user_id" class="user_id" name="user_id" value="{{$vacation->id}}">{{$vacation->id}}</td>
                        <td>{{$vacation->depart}}</td>
                        <td>{{$vacation->return}}</td>
                        <td>{{$vacation->created_at->format('Y-m-d')}}</td>
                        
                        <td>
                            @if ($vacation->status == 0)
                                <span style="color: blue">waiting for approval</span>

                            @elseif ($vacation->status == 1)
                                <span style="color: green">Approved</span>
                                
                            @elseif ($vacation->status == 2)
                                <span style="color: red">Not Approved</span>
                            @endif

                        </td>
                        <td>
                            <a href="{{ route('vacation.edit', [$vacation->id]) }}">
                                <button class="btn-sm btn btn-success"><i class="fa fa-edit"></i> Edit</button>
                            </a>
                        </td>
                        </tr>

                    @endforeach
                @endif
            </tbody>

        </table>

    </div>

@endsection