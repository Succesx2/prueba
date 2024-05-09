@extends('layouts.header')

@section('title', 'vuelos')


@section('content')
    <div class="modal" tabindex="-1" id="MainModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Añadir nuevo capitan</h5>
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
            <h3>Capitanes vigentes</h3>
            <hr>
            <div style="text-align: right">
                <button class="btn btn-secondary" onclick="ce_captain()"> Añadir </button>
            </div>
            <div class="row" style="margin: 2em">
                <table id="central-table" class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Vuelo</th>
                        <th scope="col">Documentos</th>


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
        var captains = <?php echo json_encode($captains); ?>;

        var origin_url = '{{url('/get-captains')}}';

        // form_filter
        $("#form_filter").submit(function (e) {
            e.preventDefault();


            if (true) {
                get_captains(origin_url)
            }})


        function ce_captain(captain_id = 0) {
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('view_ce_captain')}}',
                data: {captain_id:captain_id},
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

        function send_ce_captain(response){
            toastr.success('Acción exitosa')
            get_captains(origin_url)
            $('#MainModal').modal("hide")
        }

        function delete_captain(captain_id){

            if(confirm("Seguro?")){
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{url('captain-delete')}}',
                    data: {captain_id: captain_id},
                    success: function (response) {
                        toastr.success('Eliminacion exitosa')
                        get_captains(origin_url)


                    }, error(e) {
                        console.log('error:', e)
                    }
                })
            }
        }

        function get_captains(url){
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
                    captains = response.captains ?? []
                    console.log('captains',captains)
                }, error(e) {
                    console.log('error',e)
                }
            })
        }


        get_captains(origin_url)


        $('#central-table').children('tbody').on('click', '.pagination a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            console.log('url:', url)
            get_captains(url)
        })
    </script>
@endsection
