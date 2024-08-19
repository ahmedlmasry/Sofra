@extends('layouts.master')
@section('page_title')
    Restaurants
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List of Restaurants</h3>
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
                <form action="restaurants/search" method="post">
                    @csrf
                    @method('post')
                    <input name="search" class="form-control form-control-navbar" type="search" placeholder="Search"
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
                                <th scope="col">Email</th>
                                <th scope="col">District</th>
                                <th scope="col">Contact whats</th>
                                <th scope="col">Contact Phone</th>
                                <th scope="col">Minimum Order</th>
                                <th scope="col">Delivery Charge</th>
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
                                    <td>{{$record->district->name}}</td>
                                    <td class="text-center">{{$record->contact_whats}}</td>
                                    <td class="text-center">{{$record->contact_phone}}</td>
                                    <td class="text-center">{{$record->minimum_order}}</td>
                                    <td class="text-center">{{$record->delivery_charge}}</td>
                                    <td>{{$record->status}}</td>
                                    <td><a href="{{ route('restaurants.active', $record->id) }}"
                                           class="btn btn-success">Active</a>
                                    </td>
                                    <td><a href="{{ route('restaurants.deactive', $record->id) }}"
                                           class="btn btn-danger">DeActive</a></td>

                                    <td>

                                        <form method="post" action={{url(route('restaurants.destroy',$record->id))}}>
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
