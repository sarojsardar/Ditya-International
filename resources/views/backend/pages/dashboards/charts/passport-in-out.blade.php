<div class="col-xl-4">
    <div class="card m-b-30">
        <div class="card-body">
            <h4 class="mt-0 header-title mb-4">Passport In Out</h4>
            <div id="chart5"></div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function(){
            $.ajax({
                url: '{{ route('user.getPassportData') }}',
                type: 'GET',
                error: function(err){
                    console.log(err);
                },
                success: function(res){
                    initializePassportChart(res.in, res.out, res.total);
                }
            })
        })

        function initializePassportChart(inPassport, out, total){
            var chart = c3.generate({
                bindto: '#chart5',
                data: {
                    columns: [
                        ['In', inPassport],
                        ['Out', out],
                        ['Candidates', total]
                    ],
                    colors: {
                        In: '#5EE59C',
                        Out: '#FF5038',
                        Candidates: '#004E94',
                    },
                    type : 'donut',
                    // onclick: function (d, i) { console.log("onclick", d, i); },
                    // onmouseover: function (d, i) { console.log("onmouseover", d, i); },
                    // onmouseout: function (d, i) { console.log("onmouseout", d, i); }
                },
                donut: {
                    title: "Passport In Out"
                }
            });
        }
    </script>
@endpush