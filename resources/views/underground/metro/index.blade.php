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

                        Metro
                        <a href="{{ route('metros.create') }}">Create new metro</a>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Delete</th>
                            <th scope="col">Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($metros as $metro)
                        <tr>
                            <th>{{ $metro->id }}</th>
                                <td>{{ $metro->location }}</td>
                                <td>{{ $metro->type->name }}</td>
                                <td>
                                    {{ Form::open(['action' => ['MetroController@delete', $metro->id], 'method' => 'POST'])}}
                                        <button type="submit"
                                        onclick="confirm('Are you sure want to delete this metro?');"
                                        class="btn btn-danger">
                                        Delete
                                    </button>
                                    {{ Form::close() }}
                                </td>
                                <td>
                                        <a href="{{ route('metros.edit', ['metro_id' => $metro->id]) }}"
                                                class="btn btn-info">Edit</a>
                                </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $metros->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
