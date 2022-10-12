@extends('index')

@section('userprofile.edit')

    <div class="container-fluid col-lg-5">
        <form action="{{ route('userprofile.update', $userprofile) }}" method="POST" enctype="multipart/form-data"><br>

            <h3>User Profile</h3><br>

            <div class="form-group centered">
            @if ( $userprofile->image !== NULL )
                <img src="{{ asset($userprofile->image) }}" class="img-circle" width="200">
            @else
                <img src="{{ asset('assets/profilepictures/default.png') }}" class="img-circle" width="200">
            @endif
            </div>

            <div class="form-group">
                <label>Name</label>
                <input value="{{$userprofile->name}}" id="name" type="text" class="form-control @error('name') error-border @enderror" placeholder="Employee name" name="name" autofocus>
                @error('name')
                    <div class="error-text">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input value="{{$userprofile->last_name}}" id="last_name" type="text" class="form-control @error('last_name') error-border @enderror" placeholder="Employee last name" name="last_name" autofocus>
                @error('last_name')
                    <div class="error-text">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input class="form-control @error('email') error-border @enderror" type="text" placeholder="Enter email" name="email" value="{{$userprofile->email}}"/>
                @error('email')
                    <div class="error-text">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input class="form-control @error('password') error-border @enderror" type="password" placeholder="Password" name="password" value="{{old('password')}}"/>
                @error('password')
                    <div class="error-text">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Confirm Password *</label>
                <input class="form-control @error('password_confirmation') error-border @enderror" type="password" placeholder="Confirm Password" name="password_confirmation" value="{{old('password_confirmation')}}"/>
                @error('password_confirmation')
                    <div class="error-text">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <input type="file" class="form-control" name="image" />
            </div>

            @csrf
            @method('PUT')
            <input class="btn btn-primary" type="submit" value="Change">
        </form>
    </div>

@endsection