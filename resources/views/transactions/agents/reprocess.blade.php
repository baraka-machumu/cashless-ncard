


<div class="modal fade bd-example-modal-lg" id="reprocess-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <form method="post" action="{{url('/agent-request-logs',[$result->agent_code])}}" id="form-topup-agent"  enctype="multipart/form-data">

        {{csrf_field()}}
        <div class="modal-dialog modal-md" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Reprocess TopUp</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <p> Are you sure to submit this request ?</p>
                    <div class="row">
                        <input type="hidden" value="{{$result->id}}" name="tx_id">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Submit</button>

                </div>
            </div>
        </div>
    </form>

</div>
