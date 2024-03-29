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

                        You are logged in!
                        @if(auth()->user()->role->name != 'user')
                            <a href="{{ route('users.create') }}">Create new user</a>
                        @endif
                        <a href="{{ route('users.profile', ['userId' => auth()->user()->id]) }}">Edit Profile</a>
                    </div>
                    <div class="table-responsive">
                            <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First</th>
                                        <th scope="col">Last</th>
                                        @if(auth()->user()->role->name != 'user')
                                            <th scope="col">Delete</th>
                                        @endif
                                        <th scope="col">Edit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        @if($user->role->name != 'admin')
                                            <tr>
                                                <th scope="row">{{ $user->id }}</th>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                @if(auth()->user()->role->name != 'user')
                                                    <td>
                                                        @if($user->id != auth()->user()->id)
                                                            <form method="POST"
                                                                  action="{{ route('users.delete', ['userId' => $user->id]) }}">
                                                                @csrf
                                                                <button type="submit"
                                                                        onclick="return confirm('Are you sure want to delete this user?');"
                                                                        class="btn btn-danger">Delete
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                @endif
                                                <td>
                                                    @if(auth()->user()->checkRole('user') && auth()->user()->id == $user->id)
                                                        <a href="{{ route('users.edit', ['userId' => $user->id]) }}"
                                                           class="btn btn-info">Edit</a>
                                                    @elseif(auth()->user()->checkRole('moderator') && $user->role->name != 'moderator')
                                                        <a href="{{ route('users.edit', ['userId' => $user->id]) }}"
                                                           class="btn btn-info">Edit</a>
                                                    @elseif(auth()->user()->checkRole('admin'))
                                                        <a href="{{ route('users.edit', ['userId' => $user->id]) }}"
                                                           class="btn btn-info">Edit</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                    </div>
                    <div class="row justify-content-center">
                            {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
