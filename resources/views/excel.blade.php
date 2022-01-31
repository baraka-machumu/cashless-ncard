@extends('layouts.master')

@section('content')


    <div class="col-md-12" style="margin-top: 20px;">

        @include('partials.error_message')

        <form method="post" action="{{url('excel-top-up')}}" enctype="multipart/form-data">

            @csrf

            <label>File (make sure to put max 20 records)</label>

            <input type="file" name="file" class="form-control">

            <br><br>
            <button type="submit" class="btn btn-primary">upload</button>
        </form>

    </div>
@endsection
