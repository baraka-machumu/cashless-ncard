@extends('layouts.master')

@section('content')


    <div class="col-md-12" style="margin-top: 20px;">

        @include('partials.error_message')
        <form method="get" action="{{url('reg')}}">

            <label>Phone</label>
            <input type="text" name="phone">

            <label>Card Number</label>

            <input type="text" name="card">

            <label>Card Uid (option)</label>

            <input type="text" name="card_uid">



            <button type="submit" class="btn btn-primary">Save</button>
        </form>

    </div>
@endsection
