<div class="col-lg-12 col-md-12 col-sm-12 mt-3">
    <div class="top-chart-wrap">
        <h4 class="mt-0 header-title mb-4">Document Activities of Candidates Registered in Following Dates </h4>
        <div id="documentProcess"></div>
    </div>
</div>

@push('scripts')
    <script>
        
        $(document).ready(function(){
            $.ajax({
                url: '{{ route('user.getStageDocumentData') }}',
                type: 'GET',
                error: function(err){
                    console.log(err);
                },
                success: function(res){
                    console.log(res);
                    
                    initiateDocumentProcess(res.dates, res.collections);
                }
            })
        });
        function initiateDocumentProcess(dates, collections){
            c3.generate({
                bindto: '#documentProcess',
                data: {
                    columns: collections,
                    types: {
                        // Collection: 'spline',
                        // Expenses: 'spline',
                        // 'line', 'spline', 'step', 'area', 'area-step' are also available to stack
                    },
                    // colors: {
                    //     Collection: '#4FCA5D',
                    //     Expenses: '#FF5038',
                    // }
                },
                bar: {
                    width: 10
                },
                axis:{
                    x: {
                        type: 'category',
                        categories: dates,
                        tick: {
                            rotate: -60
                        }
                    }
                },
                padding: {
                    bottom: 20
                }
            });
        }
    </script>
@endpush