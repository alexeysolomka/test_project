@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                            @if(!empty($errors))
                            @foreach ($errors->all() as $error)
                               <div>{{ $error }}</div>
                           @endforeach
                         @endif
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
                    <div class="ml-5 mr-5">
                            {{ Form::model($intersection, ['action' => ['IntersectionController@update', $intersection->id]]) }}
                            <div class="form-group">
                                {{ Form::label('name', 'Name') }}
                                {{ Form::text('name', $intersection->name, ['maxlength' => 30, 'class' => 'form-control'])}}
                            </div>
                            {{ Form::button('Update intersection', ['type' => 'submit', 'class' => 'btn btn-success'] )  }}
                            {{ Form::close() }}
                            <hr>
                            {{ Form::model($intersection, ['action' => ['IntersectionController@addStationToIntersection', $intersection->id]])}}
                            <div class="form-group">
                                {{ Form::label('station', 'Station')}}
                                {{ Form::select('station_id', $availableStations->pluck('name', 'id'), '', ['class' => 'form-control'])}}
                            </div>
                            <div class="form-group">
                                    {{ Form::button('Add station to intersection', ['type' => 'submit', 'class' => 'btn btn-default btn-sm'] )  }}
                                </div>
                            {{ Form::close() }}
                    </div>
                    @if($intersection->stations->isNotEmpty())
                    <div class="ml-5 mr-5">
                            <h3 >Stations for this intersection</h3>
                            <ul class="list-group">
                            @foreach($intersection->stations as $station)
                                  <li class="list-group-item">{{ $station->name }}, {{ $station->branch->name }} line. 
                                        {{ Form::open(['action' => ['IntersectionController@deleteStationFromIntersection', $intersection->id, $station->id], 'method' => 'POST'])}}
                                        {{ Form::button('remove station', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm'])}}
                                    {{ Form::close() }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
