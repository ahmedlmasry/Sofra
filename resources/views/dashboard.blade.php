@extends('layouts.master')
@inject('client','App\Models\Client')
@inject('order','App\Models\Order')
@inject('restaurant','App\Models\Restaurant')
@section('page_title')
    Dashboard
@endsection
@section('small_title')
    Statsics
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$order->count()}}</h3>
                        <p>New Orders</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="{{url('admin/orders')}}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$settings->commission}}<sup style="font-size: 20px">%</sup></h3>
                        <p>App Commission</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <a href="{{url('admin/settings')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$client->count()}}</h3>
                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="{{url('admin/clients')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$restaurant->count()}}</h3>
                        <p>Restaurants</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-pizza-slice"></i>
                    </div>
                    <a href="{{url('admin/restaurants')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Title</h3>
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
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{session('status')}}
                    </div>
                @endif
                you are logged in!
            </div>    </section>
@endsection
