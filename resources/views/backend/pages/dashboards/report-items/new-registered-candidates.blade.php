@php
    $newCandidates = (new \App\Data\Dashboard\DashboardData())->newRegisteredCandidates();
@endphp

<div class="col-xl-4">
    <div class="card m-b-30">
        <div class="card-body">
            <h4 class="mt-0 header-title mb-4">New Candidates</h4>
            @foreach ($newCandidates as $candidate)    
                <div class="friends-suggestions">
                    <a href="#" class="friends-suggestions-list">
                        <div class="border-bottom position-relative">
                            <div class="float-left mb-0 mr-3">
                                @if (@$candidate->profile)
                                    <img src="{{ url('/storage/public/uploads/candidate-profiles/'.$candidate->profile) }}" alt="{{ $candidate->first_name }}" class="rounded-circle thumb-md">
                                @else
                                    <img src="{{ asset('no-profile.jpg') }}" alt="images" class="rounded-circle thumb-md">
                                @endif
                            </div>
                            <div class="desc">
                                <h5 class="font-14 mb-1 pt-2 text-dark">{{ $candidate->first_name.' '.$candidate->middle_name.' '.$candidate->last_name }}</h5>
                                @role(['Company'])
                                <p class="text-muted">Demand: {{  $candidate->demand->demand_code}}</p>
                                @else
                                <p class="text-muted">PRO: {{  $candidate->pro->userInfo->first_name.' '.$candidate->pro->userInfo->middle_name.' '.$candidate->pro->userInfo->last_name }}</p>
                                @endrole
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>