@extends('layouts.master')
@section('page_title')
    Clients
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List of Clients</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
{{--                <form  method="get">--}}
{{--                    <input name="search" value="{{request('search')}}" class="form-control form-control-navbar" type="search" placeholder="Search"--}}
{{--                           aria-label="Search">--}}
{{--                </form>--}}
                        {{ html()->form('get')->open() }}

                        {{ html()->search('search')->placeholder('Search')->value(request('search'))->class("form-control form-control-navbar")->type("search") }}

                        {{ html()->form()->close() }}
                @include('flash::message')
                @if(count($records))
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">phone</th>
                                <th scope="col">District</th>
                                <th scope="col">Image</th>
                                <th scope="col">Status</th>
                                <th scope="col">Active</th>
                                <th scope="col">Deactive</th>
                                <th scope="col">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$record->name}}</td>
                                    <td>{{$record->email}}</td>
                                    <td class="text-center">{{$record->phone}}</td>
                                    <td class="text-center">{{$record->district->name}}</td>
                                    <td>
                                        <img src="{{$record->image}}" class="img-circle elevation-4"
                                           height="40px"  alt="User Image">
                                    </td>
                                    <td>{{$record->status}}</td>
                                    <td><a href="{{ route('clients.active', $record->id) }}" class="btn btn-success">Active</a>
                                    </td>
                                    <td><a href="{{ route('clients.deactive', $record->id) }}"
                                           class="btn btn-danger">DeActive</a></td>
                                    <td>
                                        <form method="post" action={{url(route('clients.destroy',$record->id))}}>
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-xs"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
@endsection
