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
                <h3 class="card-title">Add Payment</h3>
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{url(route('payments.store'))}}" method="post">
                    @csrf
                    <label for="restaurant_id">name</label>
                    <select name="restaurant_id" id="restaurant_id" class="form-control" required>
                        <option value="" selected disabled> --Restaurants--</option>
                        @foreach ($restaurants as $restaurant)
                            <option value="{{$restaurant->id }}">{{$restaurant->name }}</option>
                        @endforeach
                    </select>
                        <label for="note">note</label>
                        <input class="form-control form-control-lg" name="note" type="text"
                               aria-label=".form-control-lg example">
                        <label for="paid">paid</label>
                        <input class="form-control form-control-lg" name="paid"  type="text"
                               aria-label=".form-control-lg example">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
@endsection
