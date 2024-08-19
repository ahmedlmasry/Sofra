@extends('layouts.master')
@section('page_title')
     Settings
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> Edit Settings</h3>
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
                <form action="{{url(route('settings.update',$model->id))}}"  method="post">
                    @csrf
                    @method('put')
                    <label for="commission">commission</label>
                    <input class="form-control form-control-lg " name="commission" value="{{$model->commission}}" type="text"
                           aria-label=".form-control-lg example">
                    <label for="google_play_link">Google play</label>
                    <input class="form-control form-control-lg" name="google_play_link" value="{{$model->google_play_link}}" type="text"
                           aria-label=".form-control-lg example">
                    <label for="app_store_link">App Store</label>
                    <input class="form-control form-control-lg" name="app_store_link" value="{{$model->app_store_link}}" type="text"
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
