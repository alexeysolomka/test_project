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

                        Branches
                        <a href="{{ route('branches.create') }}">Create new branch</a>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Branch</th>
                            <th scope="col">Metro</th>
                            <th scope="col">Delete</th>
                            <th scope="col">Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($branches as $branch)
                        <tr>
                            <th>{{ $branch->id }}</th>
                                <td>{{ $branch->name }}</td>
                                <td>{{ $branch->metro->location }}</td>
                                <td>
                                    {{ Form::open(['action' => ['BranchController@delete', $branch->id], 'method' => 'POST'])}}
                                        <button
                                        onclick="return confirm('Are you sure want to delete this branch?');"
                                        class="btn btn-danger">
                                        Delete
                                    </button>
                                    {{ Form::close() }}
                                </td>
                                <td>
                                        <a href="{{ route('branches.edit', ['branch_id' => $branch->id]) }}"
                                                class="btn btn-info">Edit</a>
                                </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $branches->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
