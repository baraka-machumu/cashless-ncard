

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="user-reset-password-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        {{csrf_field()}}
        <div class="modal-dialog modal-md" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Reset password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{url('access/users/reset-password')}}" method="post">
                    {{csrf_field()}}


                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">

                                <div class="row" style="height: 60px;">


                                    <div class="col-md-12">
                                        <div class="alert alert-danger">
                                            <p>Are you sure you want to reset password for this user?</p>

                                        </div>
                                    </div>

                                        <input type="hidden" id="userId"  value="{{$id}}" name="userId">

                                </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
                </form>

            </div>

        </div>


</div>

@section('js')

    <script>

        $('.user-status').click( function (e) {

            e.preventDefault();
            let userId  =  $(this).attr('id');

            $('#userId').val(userId);

            $('#user-status-modal').modal('show');

        });



    </script>

    @stop
