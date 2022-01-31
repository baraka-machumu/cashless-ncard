
@extends('layouts.master')


@section('content')


<div class="container-fluid">
    <div class="row">

        <div class="col-md-12">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))

                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                        <a href="#" class="close" data-dismiss="alert" aria-label="close"></a></p>
                @endif
            @endforeach
        </div>
        {{--<div class="col-md-12 modal-background" style="margin-left: 15px;">--}}
            {{--<span style="text-align: start">Toptup Agent</span>--}}

        {{--</div>--}}

    </div>
    <div class="row">
        {{--<div class="col-md-12 show-user-details-2">--}}



                {{--<span style="text-align: start">Info</span>--}}



        {{--</div>--}}

        <div class="col-md-12">

            <div class="card">

                <form method="post" action="{{route('store-topup',$agent_code)}}">

                    {{csrf_field()}}

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 show-user-details-2">



                            <span style="text-align: start">Topup</span>



                            </div>

                            <div class="col-md-6">
                                <div class="form-group">

                                    <label for="amount">Amont</label>
                                    <input type="text"  data-validation="number" data-validation-allowing="float"
                                           data-validation-decimal-separator=","class="form-control" name="amount" id="amount" placeholder="Amount">

                                </div>
                                <div class="form-group">

                                    <label for="reference">Reference Number</label>
                                    <input type="text" data-validation="required" data-validation-error-msg-required="No reference number provided" class="form-control" name="reference" id="reference" placeholder="Reference Number">

                                </div>


                                <div class="form-group">

                                    <label for="reference">Pay slip</label>
                                    <input type="file" data-validation="required" data-validation-error-msg-required="No image provided" class="form-control" name="pay_slip" id="reference" placeholder="Reference Number">

                                </div>



                            </div>
                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="topup-bank">Bank</label>
                                    <select data-validation="required" data-validation-error-msg-required="No bank selected"  class="select2 form-control custom-select gender" name="bank"  id="topup-banks" style="width: 100%; height:36px;">

                                        <option></option>
                                        @foreach($banks as $bank)

                                        <option value="{{$bank['id']}}">{{$bank['name']}}</option>

                                        @endforeach

                                    </select>
                                </div>


                                <div class="form-group">

                                    <label for="topup-branch">Branch</label>
                                    <select data-validation="required" data-validation-error-msg-required="No branch selected" class="select2 form-control custom-select role" name="branch"  id="topup-branchs" style="width: 100%; height:36px;">

                                        <option></option>

                                        @foreach($branches as $branch)

                                        <option value="{{$branch['id']}}">{{$branch['name']}}</option>

                                        @endforeach

                                    </select>

                                </div>
                                <div class="form-group">

                                    <button type="submit" style="margin-top: 28px;" class="btn btn-success" name="">Save</button>
                                    <a  href="{{url()->previous()}}" style="margin-top: 28px;" class="btn btn-info" name="edit-merchant">
                                        <i class="fa fa-backward" aria-hidden="true"></i>
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>
                </form>
            </div>


        </div>
    </div>

</div>


@stop