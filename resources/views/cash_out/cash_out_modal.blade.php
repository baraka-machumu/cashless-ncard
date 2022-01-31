<!-- Modal for adding pos-->
<div class="modal fade bd-example-modal-sm" id="cash-out-modal" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-md" role="document" >
        <div class="modal-content">
            <div class="modal-header h4-background">
                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" action="{{url('Fund/transfer-to-merchant')}}">

                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-12">

                                            <input type="text" name="date" class="form-control"  readonly id="date-c">

                                            <input type="hidden" name="tin" value="{{$tin}}">

                                            <p>Are you sure , you want to push this transaction?</p>

                                        </div>

                                    </div>

                                </div>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button  id="btn-form-submit-add-merchant-service"  type="submit" class="btn btn-success">Save</button>

                </div>
            </form>
        </div>
    </div>
</div>
