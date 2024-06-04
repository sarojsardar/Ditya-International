<div class="col-lg-12 mb-2">
    <div class="card">
        <div class="card-body">
            <form action="#">


               <div class="row">

                    @if((int)auth()->user()->user_type == \App\Enum\UserTypes::MEDICAL_OFFICER)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Medical:</label>
                                <select name="medical" id="medical" class="form-control form-control-sm">
                                    <option value="">Please Select</option>
                                    @foreach ($medicals as $medical)
                                        <option value="{{$medical->id}}">{{$medical->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif


                    @if(auth()->user()->user_type !== \App\Enum\UserTypes::COMPANY)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Company:</label>
                                <select name="company" id="company" class="form-control form-control-sm">
                                    <option value="">Please Select</option>
                                    @foreach ($companies as $company)
                                        <option value="{{$company->id}}">{{$company->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Demand:</label>
                            <select name="demand" id="demand" class="form-control form-control-sm">
                                <option value="">Please Select</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Checkup Date:</label>
                            <input type="text" name="checkup_date" id="checkup_date" value="" class="date_range form-control form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Status:</label>
                            <select name="status" id="status" class="form-control form-control-sm">
                                <option value="Fit" selected>Fit</option>
                                <option value="Tested">Scheduled</option>
                                <option value="Tested">Tested</option>
                                <option value="Unfit">Unfit</option>
                                <option value="All">All</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <button type="button" id="clear_filter" class="ms-1 btn btn-sm btn-danger float-end">Clear</button>
                        <button type="button" id="filter-btn" class="btn btn-primary btn-sm float-end">Filter</button>
                    </div>

                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary btn-sm" id="proceed-btn-to-visa-process">Proceed to Visa Process</button>
                    </div>
               </div>
            </form>
        </div>
    </div>
</div>