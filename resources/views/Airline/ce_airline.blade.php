
<form id="form_ce_airline">
    <div class="modal-body">

        <input type="hidden" name="id" value="{{$airline->id ?? 0}}">
        <div>
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{$airline->name ?? ''}}">
            <br>
            @error('name')
            @enderror
        </div>
        <div class="form-group mb-3">
            <label>Aeropuerto</label>
            <select name="airport_id" class="form-control">
                <option value="">Seleccionar</option>
                @foreach($airports as $airport)
                    <option
                        {{$airline->airport_id == $airport->id ? "selected" : ""}} value="{{$airport->id}}">{{$airport->name ?? ''}}
                    </option>
                @endforeach
            </select>
            @error('airport_id')
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

    $('#form_ce_airline').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $("#form_ce_airline").submit(function (e) {
        e.preventDefault();
        var data = $('#form_ce_airline').serializeArray().reduce(function (obj, item) {
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
                url: '{{url('/airline-edit')}}',
                data: data,
                success: function (response) {
                    send_ce_airline(response)
                }, error(e) {

                    console.log('error:', e)
                    console.log('error:', e.responseJSON.message)
                    toastr.warning(e.responseJSON.message)
                }

            })
        }
    })
</script>
