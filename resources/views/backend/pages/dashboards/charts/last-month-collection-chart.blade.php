<div class="col-lg-8 col-md-8 col-sm-12">
    <div class="top-chart-wrap">
        <div id="chart2"></div>
    </div>
</div>

@push('scripts')
    <script>
        
        $(document).ready(function(){
            $.ajax({
                url: '{{ route('user.lastThirtyCollection') }}',
                type: 'GET',
                error: function(err){
                    console.log(err);
                },
                success: function(res){
                    initiateChart2(res.dates, res.collections, res.expenses);
                }
            })
        });

        function initiateChart2(dates, collections, expenses){
            c3.generate({
                bindto: '#chart2',
                data: {
                    columns: [
                        collections,
                        expenses
                    ],
                    types: {
                        Collection: 'spline',
                        Expenses: 'spline',
                        // 'line', 'spline', 'step', 'area', 'area-step' are also available to stack
                    },
                    colors: {
                        Collection: '#4FCA5D',
                        Expenses: '#FF5038',
                    }
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