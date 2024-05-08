
<form id="form_ce_airplane">
    <div class="modal-body">

        <input type="hidden" name="id" value="{{$airplane->id ?? 0}}">
        <div>
            <label>CODIGO</label>
            <input type="text" name="code" class="form-control" value="{{$airplane->code ?? ''}}">
            <br>
            @error('code')
            @enderror
        </div>
        <div class="form-group mb-3">
            <label>Aerolinea</label>
            <select name="airline_id" class="form-control">
                <option value="">Seleccionar</option>
                @foreach($airlines as $airline)
                    <option
                        {{$airplane->airline_id == $airline->id ? "selected" : ""}} value="{{$airline->id}}">{{$airline->name ?? ''}}
                    </option>
                @endforeach
            </select>
            @error('airline_id')
            @enderror
        </div>

        <div class="form-group mb-3">
            <label>Fecha de creacion</label>
            <input type="date" name="create_date" class="form-control" value="{{$airplane->create_date ?? ''}}">
            @error('create_date')
            @enderror
        </div>
        <div class="form-group mb-3">
            <label>Fecha de siguiente mantenimiento</label>
            <input type="date" name="next_maintenance" class="form-control" value="{{$airplane->next_maintenance ?? ''}}">
            @error('next_maintenance')
            @enderror
        </div>

        <br>
        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary" id="saveBtn">
                Guardar
            </button>
        </div>

    </div>

</form>

<script>




    $('#form_ce_airplane').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $("#form_ce_airplane").submit(function (e) {
        e.preventDefault();
        var data = $('#form_ce_airplane').serializeArray().reduce(function (obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});
        console.log('data:', data)

        if (true) {
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('/airplane-edit')}}',
                data: data,
                success: function (response) {
                    send_ce_airplane(response)
                }, error(e) {

                    console.log('error:', e)
                    console.log('error:', e.responseJSON.message)
                    toastr.warning(e.responseJSON.message)
                }

            })
        }

    })
</script>
