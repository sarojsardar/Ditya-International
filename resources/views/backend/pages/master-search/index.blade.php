@extends('backend.layout')

@section('title')
Master Search | {{ config('app.name') }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('master.search') }}" method="GET" id="search-form">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Candidate ID</label>
                                <input type="search" name="candidate_id" value="{{ $filters['candidate_id'] }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Fullname</label>
                                <input type="search" name="full_name" value="{{ $filters['full_name'] }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">Contact Number</label>
                                <input type="search" name="contact" value="{{ $filters['contact'] }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="">PRO</label>
                                <input type="search" name="pro" value="{{ $filters['pro'] }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-search"></i> Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        @if(@$candidate)
            @include('backend.pages.master-search.single-candidate')  
        @endif

        @if(@$candidates)
            @include('backend.pages.master-search.candidate-list')
        @endif
    </div>
</div>

@endsection
