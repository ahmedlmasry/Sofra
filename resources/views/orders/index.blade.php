@extends('layouts.master')
@section('page_title')
    Orders
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List of Orders</h3>
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
                    <input name="search" value="{{request('search')}}" class="form-control form-control-navbar" type="search" placeholder="Search"
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
                                <th scope="col">Client</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">Note</th>
                                <th scope="col">State</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Address</th>
                                <th scope="col">Delivery Charge</th>
                                <th scope="col">Commission</th>
                                <th scope="col">Show</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td class="text-center">{{$record->restaurant->name}}</td>
                                    <td class="text-center">{{$record->client->name}}</td>
                                    <td class="text-center">{{$record->payment_method}}</td>
                                    <td class="text-center">{{$record->note}}</td>
                                    <td class="text-center">{{$record->state}}</td>
                                    <td class="text-center">{{$record->total_price}}</td>
                                    <td class="text-center">{{$record->address}}</td>
                                    <td class="text-center">{{$record->delivery_charge}}</td>
                                    <td class="text-center">{{$record->commission}}</td>
                                    <td>
                                        <a type="button" class="btn btn-info"
                                           href="{{url(route('orders.show',$record->id))}}">show</a>
                                    </td>

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

