@extends('dashboards.admins.index')

@section('vacations.edit')

    <div class="container-fluid col-lg-5">
        <form action="{{ route('vacations.update', $vacation->id) }}" method="post" enctype="multipart/form-data"><br>

            <h3>Edit Vacation</h3><br>

            @if ($vacation)
                <div class="form-group">
                    <label>Users Name</label>
                    <h4>{{Auth::user()->name . ' ' . Auth::user()->last_name}}</h4>
                </div>

                <div class="form-group">
                    <label>Depart date</label>
                    <h4>{{$vacation->depart}}</h4>
                </div>

                <div class="form-group">
                    <label>Return date</label>
                    <h4>{{$vacation->return}}</h4>
                </div>

                <div class="form-group">
                    <label>Date od application</label>
                    <h4>{{$vacation->created_at}}</h4>
                </div>

                <div class="form-group">
                    <label>Vacation Status</label>
                
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-control">
                            @if ($vacation->status == 0)
                                <option value="0"selected>Waiting for approval</option>
                                <option value="1">Approved</option>
                                <option value="2">Not Approved</option>

                            @elseif ($vacation->status == 1)
                                <option value="0">Waiting for approval</option>
                                <option value="1" selected>Approved</option>
                                <option value="2">Not Approved</option>
                                
                            @else
                                <option value="0">Waiting for approval</option>
                                <option value="1">Approved</option>
                                <option value="2" selected>Not Approved</option>
                            @endif
                        </select>
                            
                </div>
            @endif

            <input class="btn btn-primary" type="submit" value="Change">

        </form>
    </div>

@endsection