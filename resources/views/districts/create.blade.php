@extends('layouts.master')
@section('page_title')
    Create District
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List of Districts</h3>
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
                <form action={{url(route('districts.store'))}}  method="post">
                    @csrf
                    <label for="name">name</label>
                    <input class="form-control form-control-lg" name="name" type="text"
                           aria-label=".form-control-lg example">
                    <select name="city_id" id="city_id" class="form-control" required>
                        <option value="" selected disabled> --Cities--</option>
                        @foreach ($cities as $city)
                            <option value="{{$city->id }}">{{$city->name }}</option>
                        @endforeach
                    </select>
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
