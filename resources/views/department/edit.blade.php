@extends('index')

@section('department.edit')

    <div class="container-fluid col-lg-5">
        <form action="{{ route('department.update', $department->id) }}" method="post" enctype="multipart/form-data"><br>

            <h3>Edit Department</h3><br>

            
            @if ($department)

                <div class="form-group">
                    <label>Department Name</label>
                    <input class="form-control @error('name') error-border @enderror" value="{{$department->name}}" id="name" type="text" placeholder="Department Name" name="name">
                    @error('name')
                        <div class="error-text">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            @endif

            <div class="form-group">
                <label>Departments Manager</label>
                <select id="manager_id" name="manager_id" class="form-control">
                    <option>Select departments manager</option>

                    @foreach ($managers as $manager)
                        @if ($current_department_manager)
                        <option value="{{$manager->id}}" {{ $manager->id == $current_department_manager->id ? 'selected' : '' }}>{{$manager->name . ' ' . $manager->last_name}}</option>
                        @else
                            <option value="{{$manager->id}}">{{$manager->name . ' ' . $manager->last_name}}</option>
                        @endif
                    @endforeach

                </select>
            </div>

            @csrf
            @method('PUT')
            <input class="btn btn-primary" type="submit" value="Change">
        </form>
    </div>

@endsection