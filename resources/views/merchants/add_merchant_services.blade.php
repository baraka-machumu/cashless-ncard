<!-- Modal for adding pos-->
<div class="modal fade bd-example-modal-lg" id="add-pos-merchant-service-modal" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl" role="document" >
        <div class="modal-content">
            <div class="modal-header h4-background">
                <h5 class="modal-title" id="exampleModalLabel">Add New Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-body">

                                <div class="row">


                                    <div class="col-md-4">

                                        <div class="form-group" id="s">

                                            <label for="merchant-add-service" >Service</label> <br>

                                            <select  data-validation="required" data-validation-error-msg-required="service name required" class="select2 form-control custom-select select2-merchant-service" name="service"  id="merchant-add-service" style="width: 100%; height:36px;">
                                                @foreach($services as $service)

                                                    <option></option>
                                                    <option value="{{$service->id}}">{{$service->name}}</option>

                                                @endforeach

                                            </select>

                                        </div>

{{--                                        <div class="form-group" id="s">--}}

{{--                                            <label for="merchant-service-type" >Select type </label> <br>--}}
{{--                                            <select  data-validation="required" data-validation-error-msg-required="service name required" class="select2 form-control custom-select select2-merchant-service-type" name="service"  id="merchant-service-type" style="width: 100%; height:36px;">--}}

{{--                                                    <option></option>--}}
{{--                                                    <option value="1">Pre defined service</option>--}}
{{--                                                <option value="0">Not predefined service</option>--}}

{{--                                            </select>--}}


{{--                                        </div>--}}

{{--                                        <div class="form-group" id="merchant-service-price-div">--}}

{{--                                            <label for="merchant-service-price" >Price </label> <br>--}}

{{--                                            <input type="text" name="price" id="merchant-service-price" class="form-control">--}}

{{--                                        </div>--}}


                                        <button type="button" id="btn-add-merchant-serviceto-table" class="btn btn-cyan mdi mdi-plus"></button>
                                        {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                                        <button  id="btn-form-submit-add-merchant-service"  type="submit" class="btn btn-success">Save</button>


                                    </div>
                                    <div class="col-md-8">

                                        <form id="add-merchant-service-form" method="post" action="{{url('merchants/add-merchant-service')}}">
                                            {{csrf_field()}}
                                            {{--{{ method_field('POST') }}--}}
                                            <input type="hidden" value="{{$merchant->tin}}" name="tin">
                                            <label class="err-warning-table"></label>

                                            <table id="table-pos-added"   class="table table-striped table-pos-added" style="margin-top: 10px;">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Service</th>
{{--                                                    <th>Price</th>--}}
{{--                                                    <th>Type</th>--}}
                                                    <th>Action</th>

                                                </tr>
                                                </thead>
                                                <tbody id="add-merchant-service-tr">

                                                </tbody>
                                            </table>


                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>
                </div>
            </div>

            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
