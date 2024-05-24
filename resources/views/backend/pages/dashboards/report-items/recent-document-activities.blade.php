
<div class="col-xl-4">
    <div class="card m-b-30">
        <div class="card-body">

            <h4 class="mt-0 header-title mb-4">Interview Activity</h4>
            <ol class="activity-feed mb-0">
                {{-- @php
                    $stages = \App\Enum\DocumentProcessStatus::getAllValues();
                @endphp                    
                @foreach ($stages as $stageKey => $stage) 
                    
                @endforeach --}}
                <li class="feed-item">
                    <div class="feed-item-list">
                        <p class="text-muted mb-1">New</p>
                        @php
                            $newInt = (new \App\Data\Dashboard\DashboardData())->newInterviewCount();
                        @endphp
                        <p class="font-15 mt-0 mb-0">{{ $newInt }} Candidates</p>
                    </div>
                </li>
                <li class="feed-item">
                    <div class="feed-item-list">
                        <p class="text-muted mb-1">Approved</p>
                        @php
                        $approvedInt = (new \App\Data\Dashboard\DashboardData())->approvedInterviewCount();
                    @endphp
                    <p class="font-15 mt-0 mb-0">{{ $approvedInt }} Candidates</p>                    
                </div>
                </li>
                <li class="feed-item">
                    <div class="feed-item-list">
                        <p class="text-muted mb-1">Rejected</p>
                        @php
                        $rejectedInt = (new \App\Data\Dashboard\DashboardData())->rejectedInterviewCount();
                    @endphp
                    <p class="font-15 mt-0 mb-0">{{ $rejectedInt }} Candidates</p>                    </div>
                </li>
            </ol>

        </div>
    </div>
</div>