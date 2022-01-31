


<div class="modal fade bd-example-modal-lg" id="show-topup-agent-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <form method="post" action="{{url('/agents/store-topup')}}" id="form-topup-agent"  enctype="multipart/form-data">

        {{csrf_field()}}
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Top Up Agent</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{--<div class="col-md-12 show-user-details" style="margin-bottom: 10px;">--}}

                    {{--<span>Details for Baraka toe</span>--}}

                    {{--</div>--}}

                    <div class="loading">

                        <div class="inner-load">

                            <span> Please wait ..</span> <img src="{{url(asset('assets/images/saveloading.gif'))}}">

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="amount">Amont</label>
                                <input type="text"  required class="form-control" name="amount" id="amount" placeholder="Amount">

                            </div>
                            <div class="form-group">

                                <label for="reference">Reference Number</label>
                                <input type="text" required  class="form-control" name="reference" id="reference" placeholder="Reference Number">

                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="form-group">

                                <label for="reference">agent code</label>
                                <input type="text" class="form-control" readonly  value="{{$agent_code}}" name="agent_code" id="agent_code">

                            </div>

                            <div class="form-group">

                                <button type="submit" style="margin-top: 28px;" class="btn btn-success save-agent" id="save-agent" name="">Save</button>
                                <a  href="{{url()->previous()}}" style="margin-top: 28px;" class="btn btn-info" >
                                    <i class="fa fa-backward" aria-hidden="true"></i>
                                </a>

                            </div>

                        </div>
                    </div>

                </div>


                <div class="modal-footer">

                </div>
            </div>
        </div>
    </form>

</div>
