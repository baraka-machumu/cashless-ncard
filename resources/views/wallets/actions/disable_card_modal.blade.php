<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="show-card-disable-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <form method="post" action="{{url('wallet/disabled-consumer-card')}}">

        {{csrf_field()}}
        <div class="modal-dialog modal-md" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Change Card Status </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="alert alert-danger">

                                <p>Are you sure you want to disable this card ?</p>

                            </div>

                            <input type="hidden"  name="walletId" value="{{$walletDetails->wallet_id}}">

                        </div>

                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Disable</button>
                </div>


                <div class="modal-footer">

                </div>
            </div>
        </div>
    </form>

</div>
