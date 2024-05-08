@extends('layouts.header')

@section('title', 'vuelos')


@section('content')
    <div class="modal" tabindex="-1" id="MainModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Añadir nuevo vuelo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal_body">

                </div>

            </div>
        </div>
    </div>


    <div class="">
        <div class=" p-5" style="margin-top: 2em">
            <h3>Filtros</h3>
            <form class="d-flex" role="search" id="form_filter">
                <div class="col-3">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">

                </div>

                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

        </div>



        <div class="div.col-md-6 p-5" style="margin-top: 2em">
            <h3>Aeropuertos Activos</h3>
            <hr>
            <div style="text-align: right">
                <button class="btn btn-secondary" onclick="ce_flight()"> Añadir </button>
            </div>
            <div class="row" style="margin: 2em">
                <table id="central-table" class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Aerolinea</th>
                        <th scope="col">Salida del aeropuerto</th>
                        <th scope="col">Entrada del aeropuerto</th>
                        <th scope="col">Max asientos</th>
                        <th scope="col">Asientos reservados</th>
                        <th scope="col">Codigo de vuelo</th>
                        <th scope="col">Aeropuerto</th>
                        {{--<th scope="col">Avion</th>--}}
                        <th scope="col">Capacidad</th>

                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        var flights = <?php echo json_encode($flights); ?>;

        var origin_url = '{{url('/get-flights')}}';

        // form_filter
        $("#form_filter").submit(function (e) {
            e.preventDefault();


            if (true) {
                get_flights(origin_url)
            }})


        function ce_flight(flight_id = 0) {
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('view_ce_flight')}}',
                data: {flight_id:flight_id},
                success: function (response) {
                    console.log('response',response)
                    // $('#MainModal .modal-body').html(response.body)
                    $('#modal_body').html(response.body)
                    $('#MainModal').modal("show")
                }, error(e) {

                    console.log('error',e)
                }
            })
        }

        function send_ce_flight(response){
            toastr.success('Acción exitosa')
            get_flights(origin_url)
            $('#MainModal').modal("hide")
        }

        function delete_flight(flight_id){

            if(confirm("Seguro?")){
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{url('flight-delete')}}',
                    data: {flight_id: flight_id},
                    success: function (response) {
                        toastr.success('Eliminacion exitosa')
                        get_flights(origin_url)


                    }, error(e) {
                        console.log('error:', e)
                    }
                })
            }
        }

        function get_flights(url){
            var data = $('#form_filter').serializeArray().reduce(function (obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});
            console.log('data:', data)

            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                data: data,
                success: function (response) {
                    $('#central-table').children('tbody').html(response.body)
                    flights = response.flights ?? []
                    console.log('flights',flights)
                }, error(e) {
                    console.log('error',e)
                }
            })
        }


        get_flights(origin_url)


        $('#central-table').children('tbody').on('click', '.pagination a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            console.log('url:', url)
            get_flights(url)
        })
    </script>
@endsection
