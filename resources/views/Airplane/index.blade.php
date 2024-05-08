@extends('layouts.header')

@section('title', 'Aviones')


@section('content')
    <div class="modal" tabindex="-1" id="MainModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Añadir nuevo avion</h5>
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
            <h3>Aviones Activos</h3>
            <hr>
            <div style="text-align: right">
                <button class="btn btn-secondary" onclick="ce_airplane()"> Añadir </button>
            </div>
            <div class="row" style="margin: 2em">
                <table id="central-table" class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Aerolinea</th>
                        <th scope="col">Fecha de creacion</th>
                        <th scope="col">Fecha de siguiente mantenimiento</th>
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
        var airplanes = <?php echo json_encode($airplanes); ?>;

        var origin_url = '{{url('/get-airplanes')}}';

        // form_filter
        $("#form_filter").submit(function (e) {
            e.preventDefault();


            if (true) {
                get_airplanes(origin_url)
            }})


        function ce_airplane(airplane_id = 0) {
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('view_ce_airplane')}}',
                data: {airplane_id:airplane_id},
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

        function send_ce_airplane(response){
            toastr.success('Acción exitosa')
            get_airplanes (origin_url)
            $('#MainModal').modal("hide")
        }

        function delete_airplane(airplane_id){

            if(confirm("Seguro?")){
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{url('airplane-delete')}}',
                    data: {airplane_id: airplane_id},
                    success: function (response) {
                        toastr.success('Eliminacion exitosa')
                        get_airplanes(origin_url)


                    }, error(e) {
                        console.log('error:', e)
                    }
                })
            }
        }

        function get_airplanes(url){
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
                    airplanes = response.airplanes ?? []
                    console.log('airplanes',airplanes)
                }, error(e) {
                    console.log('error',e)
                }
            })
        }


        get_airplanes(origin_url)


        $('#central-table').children('tbody').on('click', '.pagination a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            console.log('url:', url)
            get_airplanes(url)
        })
    </script>
@endsection
