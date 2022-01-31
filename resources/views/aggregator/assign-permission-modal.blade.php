<!-- Modal -->


<div class="modal fade bd-example-modal-lg" id="assign-permission" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <form method="post" action="{{url('agents/roles/save',[$agent_code])}}" id="edit-agent-form">

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

                            <div class="col-md-4" style="margin: 0;">

                                <ul class="rol-perm-list">
                                    @foreach($roles as  $index=>$role)

                                        @if($index<4)
                                            <li>
                                                <span class="perm-role-span"><input type="checkbox" name="role[]" class="checkbox-custom" value="{{$role->id}}"> {{$role->name}} </span>
                                            </li>

                                        @endif
                                    @endforeach

                                </ul>
                            </div>

                            <div class="col-md-4">

                                <ul class="rol-perm-list">

                                    @foreach($roles as  $index=>$role)

                                        @if($index>=4)

                                            <li>
                                                <span class="perm-role-span"><input type="checkbox" name="role[]" class="checkbox-custom" value="{{$role->id}}"> {{$role->name}} </span>
                                            </li>

                                        @endif
                                    @endforeach

                                </ul>
                            </div>

                        </div>


                    </div>

                </div>


                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success submit-edit-agent">save</button>
                </div>
            </div>
        </div>
    </form>

</div>

