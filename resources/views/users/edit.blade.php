@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('users.update', ['userId' => $user->id]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value={{ $user->id}}>
                        <div class="form-group row">
                            <label for="profile_image" class="col-md-4 col-form-label text-md-right">Profile
                                Image</label>
                            <div class="col-md-6">
                                <input id="avatar" type="file" class="form-control-file" name="avatar">
                                @if ($user->avatar)
                                    <img src="{{ asset($user->avatar) }}">
                                    <br>
                                    <a href="{{ route('users.avatar-delete', ['userId' => $user->id]) }}"
                                       class="btn btn-danger">Delete avatar</a>
                                @endif
                                @if ($errors->has('avatar'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if(!empty($roles) && auth()->user()->checkRole('admin'))
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">User Role</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="role_id" required>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}"
                                                    @if($user->role_id == $role->id) selected @endif>{{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if(auth()->user()->role->name != 'user' && auth()->user()->id != $user->id)
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Is Active</label>
                                <div class="col-md-6">
                                    Is Active <input type="radio" name="is_active" @if($user->is_active) checked
                                                     @endif value="1">
                                    Is in active <input type="radio" name="is_active" @if(!$user->is_active) checked
                                                        @endif value="0">
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="is_active" value="{{ $user->is_active }}">
                        @endif
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" maxlength="30"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                       value="{{ old('name', $user->name) }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email"
                                   class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" maxlength="40"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value="{{ old('email', $user->email) }}" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                                <label for="phone_number" maxlength="13"
                                       class="col-md-4 col-form-label text-md-right">Phone number</label>
                                <div class="col-md-6">
                                    <input id="phone_number" type="text" min="13" max="13" maxlength="13"
                                           class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number"
                                           value="{{ old('phone_number', $user->phone_number) }}" required>
                                    @if ($errors->has('phone_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        <div class="form-group row">
                            <label for="created" class="col-md-4 col-form-label text-md-right">Created at</label>
                            <div class="col-md-6">
                                {{ $user->created_at }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="updated" class="col-md-4 col-form-label text-md-right">Updated at</label>
                            <div class="col-md-6">
                                {{  $user->updated_at  }}
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary float-md-right mb-3">
                                        Update
                                    </button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
