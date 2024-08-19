@extends('layouts.master')
@section('page_title')
    Offers
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List of Offers</h3>
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
                <form method="get">
                    <input name="search" value="{{request('search')}}" class="form-control form-control-navbar"
                           type="search" placeholder="Search"
                           aria-label="Search">
                </form>
                @include('flash::message')
                @if(count($records))
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Restaurant</th>
                                <th scope="col">Details</th>
                                <th scope="col">image</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$record->name}}</td>
                                    <td>{{$record->restaurant->name}}</td>
                                    <td>{{$record->details}}</td>
                                    <td>{{$record->image}}</td>
                                    <td>{{$record->start_date}}</td>
                                    <td>{{$record->end_date}}</td>

                                    <td>
                                        <form method="post"
                                              action={{url(route('offers.destroy',$record->id))}}>
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
