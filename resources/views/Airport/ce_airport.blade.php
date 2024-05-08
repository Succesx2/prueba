
<form id="form_ce_airport">
    <div class="modal-body">

        <input type="hidden" name="id" value="{{$airport->id ?? 0}}">
        <div>
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{$airport->name ?? ''}}">
            <br>
            @error('name')
            @enderror
        </div>

        <div class="form-group mb-3">
            <label>Pais</label>
            <select name="country_id" class="form-control">
                <option value="">Seleccionar</option>
                @foreach($countries as $country)
                    <option
                        {{$airport->country_id == $country->id ? "selected" : ""}} value="{{$country->id}}">{{$country->name ?? ''}}
                    </option>
                @endforeach
            </select>
            @error('country_id')
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

    $('#form_ce_airport').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $("#form_ce_airport").submit(function (e) {
        e.preventDefault();
        var data = $('#form_ce_airport').serializeArray().reduce(function (obj, item) {
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
                url: '{{url('/airport-edit')}}',
                data: data,
                success: function (response) {
                    send_ce_airport(response)
                }, error(e) {

                    console.log('error:', e)
                    console.log('error:', e.responseJSON.message)
                    toastr.warning(e.responseJSON.message)
                }

            })
        }
    })
</script>
