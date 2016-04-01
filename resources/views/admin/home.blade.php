@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if(Session::has('message'))
            <div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ Session::get('message') }}
            </div>
        @endif

        <a href="manage/create">
            <button class="btn btn-default add-casino" type="button">Add Casino</button>
        </a>

        <div class="panel panel-default">
            <div class="panel-heading">Manage casino entries </div>

            <div class="panel-body">

                @if (!empty($casinos))
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Web Address</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Manage</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($casinos as $casino)
                                <tr>
                                <td>{{ $casino->id }}</td>
                                <td>{{ $casino->name }}</td>
                                <td>{{ $casino->web_address }}</td>
                                <td>{{ $casino->latitude }}</td>
                                <td>{{ $casino->longitude }}</td>
                                <td class="col-sm-2">
                                    {{ Form::open(array('url' => 'manage/' . $casino->id)) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        <a href="manage/{{ $casino->id }}/edit/" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a> <button class="btn btn-sm btn-danger" type="submit" value="Delete"><i class="fa fa-trash"></i> Delete</button>
                                    {{ Form::close() }}
                                </td>
                              </tr>
                            @endforeach
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
