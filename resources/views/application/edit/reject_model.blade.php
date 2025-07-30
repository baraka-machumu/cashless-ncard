<div class="modal fade bd-example-modal-lg" id="reject-ex-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="post" action="{{url('applications/reject-updated-item',$id)}}">

        {{csrf_field()}}

        <div class="modal-dialog modal-md" role="document" >
            <div class="modal-content">
                <div class="modal-header" style="background-color: #b20a0a">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: white;">{{$app->application_name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">

                            <div class="card">
                                <div class="card-body">

                                    <div class="row">


                                        <div class="col-md-12" style="margin-bottom: 5px;">
                                            <span>Are you sure to reject This New Exchange Rate ?</span>


                                        </div>
                                        <div class="col-md-12">
                                            <textarea class="form-control" rows="5" required name="comment"></textarea>

                                        </div>

                                        <input type="hidden" value="{{encrypt($app_type)}}" name="app_type">

                                    </div>

                                </div>
                            </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </form>

</div>
