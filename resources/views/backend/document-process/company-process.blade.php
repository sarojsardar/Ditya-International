<div class="tab-pane active p-3" id="submission" role="tabpanel">
    @include('backend.document-process.submission')
</div>
<div class="tab-pane p-3" id="visa-process" role="tabpanel">
    @include('backend.document-process.visa-process')
</div>
<div class="tab-pane p-3" id="visa" role="tabpanel">
    @include('backend.document-process.visa-received')
</div>
<div class="tab-pane p-3" id="ticket" role="tabpanel">
    @include('backend.document-process.ticket-done')
</div>
<div class="tab-pane p-3" id="rejected" role="tabpanel">
    @include('backend.document-process.rejected')
</div>