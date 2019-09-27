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

                        Stations
                        <a href="{{ route('stations.create') }}">Create new station</a>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Station name</th>
                            <th scope="col">Branch</th>
                            <th scope="col">Intersection</th>
                            <th scope="col">Delete</th>
                            <th scope="col">Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stations as $station)
                        <tr>
                            <th>{{ $station->id }}</th>
                                <td>{{ $station->name }}</td>
                                <td>{{ $station->branch->name }}</td>
                                @if($station->intersections->isNotEmpty())
                                <td>Is set</td>
                                @else
                                
                                <td>Not set</td>
                                @endif
                                <td>
                                    {{ Form::open(['action' => ['StationController@delete', $station->id], 'method' => 'POST'])}}
                                        <button type="submit"
                                        onclick="confirm('Are you sure want to delete this user?');"
                                        class="btn btn-danger">
                                        Delete
                                    </button>
                                    {{ Form::close() }}
                                </td>
                                <td>
                                        <a href="{{ route('stations.edit', ['station_id' => $station->id]) }}"
                                                class="btn btn-info">Edit</a>
                                </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $stations->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
