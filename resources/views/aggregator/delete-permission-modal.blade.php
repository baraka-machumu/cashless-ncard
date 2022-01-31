<!-- Modal -->


<div class="modal fade bd-example-modal-lg" id="delete-permission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <form method="post" action="{{url('agents/roles/disable',[$agent_code])}}" >
        {{csrf_field()}}

        @method('post')

        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header modal-background">
                    <h5 class="modal-title" id="exampleModalLabel">Agent Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{--<div class="col-md-12 show-user-details" style="margin-bottom: 10px;">--}}

                    {{--<span>Details for Baraka toe</span>--}}

                    {{--</div>--}}
                    <div class="row">


                        <div class="col-md-12">



{{--                                <input type="hidden" name="agent_code" value="{{$agent_code}}">--}}

                                <p>Are sure you want to delete this permission from agent?</p>
                                <input type="hidden" name="posId" id="posId">
{{--                            </form>--}}
                        </div>


                    </div>

                </div>


                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger submit-edit-agent">save</button>
                </div>
            </div>
        </div>
    </form>

</div>

