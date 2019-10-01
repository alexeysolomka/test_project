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

                        Intersections
                        <a href="{{ route('intersections.create') }}">Create new intersection</a>
                    </div>
                    <div class="table-responsive">
                            <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Intersection</th>
                                        <th scope="col">Delete</th>
                                        <th scope="col">Edit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($intersections as $intersection)
                                    <tr>
                                        <th>{{ $intersection->id }}</th>
                                            <td>{{ $intersection->name }}</td>
                                            <td>
                                                {{ Form::open(['action' => ['IntersectionController@delete', $intersection->id], 'method' => 'POST'])}}
                                                    <button type="submit"
                                                    onclick="return confirm('Are you sure want to delete this intersection?');"
                                                    class="btn btn-danger">
                                                    Delete
                                                </button>
                                                {{ Form::close() }}
                                            </td>
                                            <td>
                                                    <a href="{{ route('intersections.edit', ['intersection_id' => $intersection->id]) }}"
                                                            class="btn btn-info">Edit</a>
                                            </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                    </div>
                    <div class="row justify-content-center">
                            {{ $intersections->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
