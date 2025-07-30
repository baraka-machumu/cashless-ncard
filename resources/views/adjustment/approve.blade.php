<div class="modal fade bd-example-modal-lg" id="adjustment-app" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="post" action="{{url('adjustment/approve')}}">
        {{csrf_field()}}
        <div class="modal-dialog modal-md" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Adjustment Approval <span id="merchant-name"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <p>Account Details : <span id="adFullName"></span></p>
                        <p>Card Details : <span id="adCard"></span></p>
                        <br><br>
                        <p>Are you sure to approve TZS <span id="amountTx"></span></p>
                        <div class="col-md-6">
                            <input type="hidden" name="adId" id="adId">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
    </form>

</div>
