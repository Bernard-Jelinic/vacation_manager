@extends('dashboards.admins.index')

@section('departments.edit')

    <div class="container-fluid col-lg-5">
        <form action="{{ route('departments.update', $department->id) }}" method="post" enctype="multipart/form-data"><br>

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
                {{-- <?php dd($managers); ?> --}}

                <select id="manager_id" name="manager_id" class="form-control">
                    <option>Select departments manager</option>

                    @foreach ($managers as $manager)
                        <option value="<?=$manager->id?>">{{$manager->name . ' ' . $manager->last_name}}</option>
                    @endforeach

                </select>
            </div>

            @csrf
            @method('PUT')
            <input class="btn btn-primary" type="submit" value="Change">
        </form>
    </div>

@endsection