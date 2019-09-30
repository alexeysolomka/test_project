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
                    {{ Form::model($branch, ['action' => 'BranchController@store']) }}
                    <div class="form-group">
                        {{ Form::label('name', 'Name') }}
                        {{ Form::text('name', '', ['maxlength' => 30, 'class' => 'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{ Form::label('metro_id', 'Metro') }}
                        {{ Form::select('metro_id', $metros->pluck('location', 'id'), '',
                         ['class' => 'form-control'])}}
                    </div>
                    {{ Form::button('Store Branch', ['type' => 'submit', 'class' => 'btn btn-success'] )  }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
