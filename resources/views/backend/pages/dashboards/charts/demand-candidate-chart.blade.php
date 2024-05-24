<div class="col-lg-4 col-md-4 col-sm-12">
    <div class="top-chart-wrap">
        <div id="chart1"></div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function(){
            $.ajax({
                url: '{{ route('user.demandCandidatesRecord') }}',
                type: 'GET',
                error: function(err){
                    console.log(err);
                },
                success: function(res){
                    initiateChart1(res.demands, res.candidates);
                }
            })
        })

        function initiateChart1(demands, candidates){
            //stacked chart
            c3.generate({
                bindto: '#chart1',
                data: {
                    columns: [
                    candidates,
                    ],
                    types: {
                        Candidates: 'area-spline',
                        // 'line', 'spline', 'step', 'area', 'area-step' are also available to stack
                    },
                    colors: {
                        Candidates: '#4040D0',
                    }
                },
                bar: {
                    width: 10
                },
                axis:{
                    x: {
                        type: 'category',
                        categories: demands,
                        tick: {
                            rotate: -60
                        }
                    }
                },
                padding: {
                    bottom: 50
                }
            });
        }
    </script>
@endpush