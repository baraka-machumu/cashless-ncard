{{--MODEL EDIT--}}

<!-- Modal -->
<div class="modal fade bd-example-modal-lg show-consumer-modal" id="show-consumer-wallet-details-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="post" action="#">

        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Wallet Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 show-user-details" style="margin-bottom: 10px;">

                        <span>Details for <span class="dname" id="first_name"></span></span>

                    </div>
                    <div class="row">


                        <div class="col-lg-6">


                            <table class="table table-striped">


                                <tbody id="consumer-wallet-details-left">

                                </tbody>
                            </table>

                        </div>


                        <div class="col-lg-6">


                            <table class="table table-striped">


                                <tbody id="consumer-wallet-details-right">


                                </tbody>
                            </table>

                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--<button type="submit" class="btn btn-success">Reverse Transaction</button>--}}
                </div>


                <div class="modal-footer">

                </div>
            </div>
        </div>
    </form>

</div>

