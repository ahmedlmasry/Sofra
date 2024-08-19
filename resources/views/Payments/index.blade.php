@extends('layouts.master')
@section('page_title')
    Payments
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List of Payments</h3>
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
                <a href="{{url(route('payments.create'))}}" class=" btn btn-primary"><i class="fas fa-plus"></i>Create
                Payments</a>
                <form method="get">
                    <input name="search" class="form-control form-control-navbar" value="{{request('search')}}" type="search" placeholder="Search"
                           aria-label="Search">
                </form>
                @include('flash::message')
                @if(count($records))
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Restaurant</th>
                                <th scope="col">Note</th>
                                <th scope="col">Paid</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$record->restaurant->name}}</td>
                                    <td>{{$record->note}}</td>
                                    <td>{{$record->paid}}</td>
                                    <td >
                                        <a href={{url(route('payments.edit',$record->id))}} class=" btn btn-success btn-xs"><i
                                            class="fas fa-edit"></i></a>
                                    </td>
                                    <td >
                                        <form method="post"
                                              action={{url(route('payments.destroy',$record->id))}}>
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
