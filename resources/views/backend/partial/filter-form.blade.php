@php
if(!isset($params)){
    $params = [
        'show_filter'=>false,
        'show_medical'=>false,
        'show_company'=>false,
        'show_demand'=>false,
        'show_checkup_date'=>false,
        'show_interview_status'=>false,
        'show_selected_date'=>false,
        'show_medical_status'=>false,
        'show_document_status'=>false,
        'show_visa_status'=>false,
        'show_labour_permit_status'=>false,
        'show_eticket_status'=>false,
        'show_evisa_status'=>false,
        'show_engaged_status'=>false,
    ];
}
@endphp
@if($params['show_filter'])
<div class="col-lg-12 mb-2">
    <div class="card">
        <div class="card-body">
            <form action="#">
               <div class="row">

                    @if(($params['show_company'] ?? false))
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


                    @if(($params['show_demand'] ?? false))
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Demand:</label>
                                <select name="demand" id="demand" class="form-control form-control-sm">
                                    <option value="">Please Select</option>
                                    @foreach((@$demands ?? [] ) as $index=>$demand)
                                        <option value="{{$demand->id}}">{{$demand->demand_code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    @if(($params['show_medical'] ?? false))
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


                    @if(($params['show_interview_status'] ?? false))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Interview Status:</label>
                            <select name="interview_status" id="interview_status" class="form-control form-control-sm">
                                <option value="" selected>All</option>
                                <option value="scheduled">Scheduled</option>
                                <option value="selected">Selected</option>
                                <option value="rejected">Rejected</option>
                                <option value="KIV">KIV</option>
                            </select>
                        </div>
                    </div>
                    @endif

                    @if(($params['show_checkup_date'] ?? false))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Checkup Date:</label>
                            <input type="text" name="checkup_date" id="checkup_date" value="" class="date_range form-control form-control">
                        </div>
                    </div>
                    @endif


                    @if(($params['show_selected_date'] ?? false))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Selected Date:</label>
                            <input type="text" name="selected_date" id="selected_date" value="" class="date_range form-control form-control">
                        </div>
                    </div>
                    @endif

                    @if(($params['show_medical_status'] ?? false))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Medical Status:</label>
                            <select name="medical_status" id="medical_status" class="form-control form-control-sm">
                                <option value="">Please select</option>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Tested">Tested</option>
                                <option value="Unfit">Unfit</option>
                                <option value="Fit" @if(@$medical_selected == "Fit")  selected @endif>Fit</option>
                                <option value="All">All</option>
                            </select>
                        </div>
                    </div>
                    @endif

                    @if(($params['show_document_status'] ?? false))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Document Status:</label>
                            <select name="document_status" id="document_status" class="form-control form-control-sm">
                                <option value="">All</option>
                                <option value="Completed">Completed</option>
                                <option value="Unfit">In Progress</option>
                            </select>
                        </div>
                    </div>
                    @endif


                    @if(($params['show_visa_status'] ?? false))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Visa Status:</label>
                            <select name="visa_status" id="visa_status" class="form-control form-control-sm">
                                <option value="">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Successed">Successed</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                    @endif


                    @if(($params['show_evisa_status'] ?? false))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">EVisa Status:</label>
                            <select name="evisa_status" id="evisa_status" class="form-control form-control-sm">
                                <option value="">Plesae Select</option>
                                <option value="Pending">Pending</option>
                                <option value="Successed">Successed</option>
                               
                            </select>
                        </div>
                    </div>
                    @endif

                    @if(($params['show_labour_permit_status'] ?? false))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Labour Permit Status:</label>
                            <select name="labour_permit_status" id="labour_permit_status" class="form-control form-control-sm">
                                <option value="">Plesae Select</option>
                                <option value="Pending">Pending</option>
                                <option value="Successed">Successed</option>
                               
                            </select>
                        </div>
                    </div>
                    @endif


                    @if(($params['show_eticket_status'] ?? false))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Eticke Status:</label>
                            <select name="eticket_status" id="eticket_status" class="form-control form-control-sm">
                                <option value="">Plesae Select</option>
                                <option value="Pending">Pending</option>
                                <option value="Successed">Successed</option>
                            </select>
                        </div>
                    </div>
                    @endif


                    @if(($params['show_engaged_status'] ?? false))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Engaged Status:</label>
                            <select name="engaged_status" id="engaged_status" class="form-control form-control-sm">
                                <option value="">Plesae Select</option>
                                <option value="1">Engaged</option>
                                <option value="2">Open To Work</option>
                            </select>
                        </div>
                    </div>
                    @endif

                    
                    <div class="col-md-12 mt-2">
                        <button type="button" id="clear_filter" class="ms-1 btn btn-sm btn-danger float-end">Clear</button>
                        <button type="button" id="filter-btn" class="btn btn-primary btn-sm float-end">Filter</button>
                    </div>
               </div>
            </form>
        </div>
    </div>
</div>
@endif