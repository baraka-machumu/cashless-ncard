

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="user-status-activate-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        {{csrf_field()}}
        <div class="modal-dialog modal-md" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Activate user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{url('access/users/activate')}}" method="post">
                    {{csrf_field()}}

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">

                                <div class="row" style="height: 60px;">



                                    <div class="col-md-12">
                                        <div class="alert alert-danger">
                                            <p>Are you sure you want to activate this user?</p>

                                        </div>
                                    </div>

                                        <input type="hidden" id="userIdActivate" name="userId">

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

        $('.user-status-activate').click( function (e) {

            e.preventDefault();

            let userId  =  $(this).attr('id');

            $('#userIdActivate').val(userId);

            $('#user-status-activate-modal').modal('show');

        });



    </script>

    @stop
