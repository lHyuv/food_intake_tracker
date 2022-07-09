@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}  <code> <small> * </small></code></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }} <code> <small> * </small></code></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}  <code> <small> * </small></code></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}  <code> <small> * </small></code></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>


                        <!--Additional Fields--> 
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Role  <code> <small> * </small></code></label>

                            <div class="col-md-6">
                                 <select name="role_id" id="role_id" class = "form-control" required>
                                 <option disabled selected>Select a role..</option>
                                 @foreach($roles as $r)
                                    <option   value = "{{ $r->id }}"> &nbsp; <small>  {{ $r->name }}</small><br>
                                 @endforeach
                                 </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Age  <code> <small> * </small></code></label>

                            <div class="col-md-6">
                                <input id="age" type="number" class="form-control" name="age"  required>


                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Weight  <code> <small> * </small></code></label>

                            <div class="col-md-6">
                                <input id="weight" type="number" step = "0.01" class="form-control" name="weight"  required>


                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Gender  <code> <small> * </small></code></label>

                            <div class="col-md-6">
                                 <select name="gender" id="gender" class = "form-control">
                                    <option disabled selected>Select a gender..</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                 </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Physical Activity  <code> <small> * </small></code></label>

                            <div class="col-md-6">
                                 <select name="physical_activity" id="physical_activity" class = "form-control">
                                    <option disabled selected>Select a physical activity..</option>
                                    <option value="sedentary">Sedentary</option>
                                    <option value="moderate">Moderate Physical</option>
                                    <option value="high">High Physical</option>
                                 </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Health Issues (check if there is)</label>

                            <div class="col-md-6">
                                
                          
                            @foreach($healthissues as $hi)
                            <input type="checkbox"  id = "healthissue_id_{{ $hi->id }}" name = "healthissues[{{$hi->id}}]" value = "{{ $hi->id }}"> &nbsp; <small>  {{ $hi->name }}</small><br>
                            @endforeach
                            </div>
                        </div>
                        <!--Additional Fields:end--> 
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Register') }} <i class="fas fa-sign-in-alt"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
