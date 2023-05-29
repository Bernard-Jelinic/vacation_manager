@extends('index')

@section('vacation')

<script>
    $(document).ready(function(){
        var minDate = new Date();
        $("#depart").datepicker({
            showAnim: 'drop',
            numberOfMonth: 1,
            minDate: minDate,
            dateFormat: 'yy-mm-dd',
            onClose: function(selectedDate){
                if (selectedDate) { // Not null
                    var nextDay = $('#depart').datepicker('getDate', '+1d');
                    nextDay.setDate(nextDay.getDate()+1);
                    $('#return').datepicker("option","minDate",nextDay);
                }
            }
        });
        $("#return").datepicker({
            showAnim: 'drop',
            numberOfMonth: 1,
            minDate: minDate,
            dateFormat: 'yy-mm-dd',
            onClose: function(selectedDate){
                if (selectedDate) { // Not null
                    var previousDay = $('#return').datepicker('getDate', '+1d');
                    previousDay.setDate(previousDay.getDate()-1);
                    $('#depart').datepicker("option","maxDate",previousDay);
                }
            }
        });
        $("#created").datepicker({
            showAnim: 'drop',
            numberOfMonth: 1,
            dateFormat: 'yy-mm-dd',
            onClose: function(selectedDate){
                if (selectedDate) { // Not null
                    var previousDay = $('#created').datepicker('getDate', '+1d');
                    previousDay.setDate(previousDay.getDate()-1);
                }
            }
        });
    });
</script>
    
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
                            @can('employee_area')
                                <td></td>
                            @endcan
                        </tr>
                    @endforeach
                    <form action="{{ route('vacation', request()->segment(count(request()->segments())) ) }}" method="GET">
                        <td><input value="{{ request()->query('name') }}" type="text" class="form-control mr-2" name="name" placeholder="Filter by Name"></td>
                        <td><input value="{{ request()->query('last_name') }}" type="text" class="form-control mr-2" name="last_name" placeholder="Filter by Last Name"></td>
                        <td><input value="{{ request()->query('depart') }}" type="text" class="form-control mr-2" id="depart" name="depart" placeholder="Filter by Depart date"></td>
                        <td><input value="{{ request()->query('return') }}" type="text" class="form-control mr-2" id="return" name="return" placeholder="Filter by Return date"></td>
                        <td><input value="{{ request()->query('created') }}" type="text" class="form-control mr-2" id="created" name="created" placeholder="Filter by Date of application"></td>
                        <td>
                            @if (request()->segment(count(request()->segments())) == 'all')
                                <select name="status_id" class="form-control" >
                                    @if (request()->query('status_id') == 1)
                                        <option value="-1">Display all</option>
                                        <option value="1"selected>Waiting for approval</option>
                                        <option value="2">Approved</option>
                                        <option value="3">Deny</option>
                                    @elseif (request()->query('status_id') == 2)
                                        <option value="-1">Display all</option>
                                        <option value="1">Waiting for approval</option>
                                        <option value="2" selected>Approved</option>
                                        <option value="3">Deny</option>
                                    @elseif (request()->query('status_id') == 3)
                                        <option value="-1">Display all</option>
                                        <option value="1">Waiting for approval</option>
                                        <option value="2">Approved</option>
                                        <option value="3" selected>Deny</option>
                                    @elseif (request()->query('status_id') == -1 || !request()->filled('status_id')  )
                                        <option value="-1" selected>Display all</option>
                                        <option value="1">Waiting for approval</option>
                                        <option value="2">Approved</option>
                                        <option value="3">Deny</option>
                                    @endif
                                </select>
                            @endif
                        </td>
                        <td><button type="submit" class="btn-sm btn btn-primary"><i class="fa fa-filter"> Filter</i></button></td>
                    </form>
                @endif
            </x-table.table>

        <div class="row">
            <div class="col-md-12 text-center">
                {{ $vacations->onEachSide(1)->links() }}
            </div>
        </div>

    </div>

@endsection