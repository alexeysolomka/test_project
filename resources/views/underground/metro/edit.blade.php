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
                            {{ Form::model($metro, ['action' => ['MetroController@update', $metro->id]]) }}
                            <div class="form-group">
                                {{ Form::label('location', 'Location') }}
                                {{ Form::text('location', $metro->location, ['maxlength' => 30, 'class' => 'form-control'])}}
                            </div>
                            <div class="form-group">
                                    {{ Form::label('type_id', 'Type') }}
                                    {{ Form::select('type_id', $types->pluck('name', 'id'), $metro->type_id,
                                     ['class' => 'form-control'])}}
                                </div>
                        <div class="form-group">
                                {{ Form::button('Update metro', ['type' => 'submit', 'class' => 'btn btn-success'] )  }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
