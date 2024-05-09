@extends('layouts.header')

@section('title', 'Aeropuerto')


@section('content')
    <div class="modal" tabindex="-1" id="MainModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Añadir nueva aeropuerto</h5>
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
                <div class="col-3">
                    <select name="country_id" class="form-control" >
                        <option value="0">Seleccionar</option>
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">{{$country->name ?? ''}}</option>
                        @endforeach
                    </select>

                </div>

                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

        </div>



        <div class="div.col-md-6 p-5" style="margin-top: 2em">
            <h3>Aeropuertos Activos</h3>
            <hr>
            <div style="text-align: right">
                <button class="btn btn-secondary" onclick="ce_airport()"> Añadir </button>
            </div>
            <div class="row" style="margin: 2em">
                <table id="central-table" class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Pais</th>
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
        var airports = <?php echo json_encode($airports); ?>;

        var origin_url = '{{url('/get-airports')}}';

        // form_filter
        $("#form_filter").submit(function (e) {
            e.preventDefault();


            if (true) {
                get_airports(origin_url)
            }})


        function ce_airport(airport_id = 0) {
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('view_ce_airport')}}',
                data: {airport_id:airport_id},
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

        function send_ce_airport(response){
            toastr.success('Acción exitosa')
            get_airports(origin_url)
            $('#MainModal').modal("hide")
        }

        function delete_airport(airport_id){

            if(confirm("Seguro?")){
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{url('airport-delete')}}',
                    data: {airport_id: airport_id},
                    success: function (response) {
                        toastr.success('Eliminacion exitosa')
                        get_airports(origin_url)


                    }, error(e) {
                        console.log('error:', e)
                    }
                })
            }
        }

        function get_airports(url){
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
                    airports = response.airports ?? []
                    console.log('airports',airports)
                }, error(e) {
                    console.log('error',e)
                }
            })
        }


        get_airports(origin_url)


        $('#central-table').children('tbody').on('click', '.pagination a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            console.log('url:', url)
            get_airports(url)
        })
    </script>
@endsection
