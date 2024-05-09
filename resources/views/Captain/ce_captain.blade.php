
<form id="form_ce_captain">
    <div class="modal-body">

        <input type="hidden" name="id" value="{{$captain->id ?? 0}}">
        <div>
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{$captain->name ?? ''}}">
            <br>
            @error('name')
            @enderror
        </div>
        <div>
            <label>Apellidos</label>
            <input type="text" name="last_name" class="form-control" value="{{$captain->last_name ?? ''}}">
            <br>
            @error('last_name')
            @enderror
        </div>
        <div class="form-group mb-3">
            <label>Vuelo</label>
            <select name="flight_id" class="form-control">
                <option value="">Seleccionar</option>
                @foreach($flights as $flight)
                    <option
                        {{$captain->flight_id == $flight->id ? "selected" : ""}} value="{{$flight->id}}">{{$flight->code ?? ''}}
                    </option>
                @endforeach
            </select>
            @error('flight_id')
            @enderror
        </div>
        <div>
            <label>Documento</label>
            <input type="text" name="document" class="form-control" value="{{$captain->document ?? ''}}">
            <br>
            @error('document')
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

    $('#form_ce_captain').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $("#form_ce_captain").submit(function (e) {
        e.preventDefault();
        var data = $('#form_ce_captain').serializeArray().reduce(function (obj, item) {
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
                url: '{{url('/captain-edit')}}',
                data: data,
                success: function (response) {
                    send_ce_captain(response)
                }, error(e) {

                    console.log('error:', e)
                    console.log('error:', e.responseJSON.message)
                    toastr.warning(e.responseJSON.message)
                }

            })
        }
    })
</script>
