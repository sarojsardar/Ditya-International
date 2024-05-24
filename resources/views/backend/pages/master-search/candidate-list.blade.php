<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" id="candidate-datatable">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Candidate ID</th>
                        <th>Demand Code</th>
                        <th class="notexport">Image</th>
                        <th>Full Name</th>
                        <th>Passport Number</th>
                        <th>Passport Expiry</th>
                        <th>Permanent Address</th>
                        <th>Temporary Address</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>PRO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (@$candidates as $key => $can)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                <a href="{{ route('candidate.detail', $can->id) }}" target="_blank">{{ $can->reference_id }}</a>
                            </td>
                            <td>
                                <a href="{{ route('company-demand.detail', $can->demand->id) }}" target="_blank">{{ $can->demand->demand_code }}</a>
                            </td>
                            <td>
                                @if($can->profile)
                                    <img src='{{ url('/storage/public/uploads/candidate-profiles/'.$can->profile) }}' alt='candidate profile' style='height: 80px;'>
                                @else
                                    <img src='{{ asset('no-profile.jpg') }}' alt='candidate profile' style='height: 80px;'>
                                @endif
                            </td>
                            <td>
                                <span>{{ $can->first_name.' '.$can->middle_name.' '.$can->last_name }}</span>
                            </td>
                            <td>
                                @if(@$can->passportDetails)
                                    {{ @$can->passPortDetails->passport_no }}
                                @endif
                            </td>
                            <td>
                                @if(@$can->passportDetails)
                                    {{ @$can->passPortDetails->passport_expiry_date }}
                                @endif
                            </td>
                            <td>
                                {{ $can->permanent_address }}
                            </td>
                            <td>
                                {{ $can->temp_address }}
                            </td>
                            <td>
                                {{ $can->contact }}
                            </td>
                            <td>
                                {{ $can->email }}
                            </td>
                            <td>
                                {{ $can->pro->userInfo->first_name.' '.$can->pro->userInfo->middle_name.' '.$can->pro->userInfo->last_name }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#candidate-datatable').DataTable({
                dom: 'Blfrtip',
                buttons: [{
                    extend: 'excel',
                    text: 'Export Search Results',
                    className: 'btn btn-default',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                }],                
                "columnDefs": [{
                "targets": [0, 1],
                "orderable": false,
                "searchable": false,
                }] 
            });
        })
    </script>
@endpush