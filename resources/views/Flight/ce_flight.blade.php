
<form id="form_ce_flight">
    <div class="modal-body">

        <input type="hidden" name="id" value="{{$flight->id ?? 0}}">

        <div class="form-group mb-3">
            <label>Aerolinea</label>
            <select name="airline_id" class="form-control">
                <option value="">Seleccionar</option>
                @foreach($airlines as $airline)
                    <option
                        {{$flight->airline_id == $airline->id ? "selected" : ""}} value="{{$airline->id}}">{{$airline->name ?? ''}}
                    </option>
                @endforeach
            </select>
            @error('airline_id')
            @enderror
        </div>
        <div>
            <label>Salida</label>
            <input type="date" name="airport_exit" class="form-control" value="{{$flight->airport_exit ?? ''}}">
            <br>
            @error('airport_exit')
            @enderror
        </div>
        <div>
            <label>Entrada</label>
            <input type="date" name="airport_entrance" class="form-control" value="{{$flight->airport_entrance ?? ''}}">
            <br>
            @error('airport_entrance')
            @enderror
        </div>
        <div>
            <label>Max asientos</label>
            <input type="number" name="max_seats" class="form-control" value="{{$flight->max_seats ?? ''}}">
            <br>
            @error('max_seats')
            @enderror
        </div>
        <div>
            <label>Reservados asientos</label>
            <input type="number" name="reserved_seats" class="form-control" value="{{$flight->reserved_seats ?? ''}}">
            <br>
            @error('reserved_seats')
            @enderror
        </div>

        <div>
            <label>Codigo</label>
            <input type="text" name="code" class="form-control" value="{{$flight->code ?? ''}}">
            <br>
            @error('code')
            @enderror
        </div>
        <div class="form-group mb-3">
            <label>Aeropuerto</label>
            <select name="airport_id" class="form-control">
                <option value="">Seleccionar</option>
                @foreach($airports as $airport)
                    <option
                        {{$flight->airport_id == $airport->id ? "selected" : ""}} value="{{$airport->id}}">{{$airport->name ?? ''}}
                    </option>
                @endforeach
            </select>
            @error('airport_id')
            @enderror
        </div>
        <div class="form-group mb-3">
            <label>Avion</label>
            <select name="airplane_id" class="form-control">
                <option value="">Seleccionar</option>
                @foreach($airplanes as $airplane)
                    <option
                        {{$flight->airplane_id == $airplane->id ? "selected" : ""}} value="{{$airplane->id}}">{{$airplane->code ?? ''}}
                    </option>
                @endforeach
            </select>
            @error('airplane_id')
            @enderror
        </div>

        <div class="form-group mb-3">
            <label>Capacidad</label>
            <select name="is_full" class="form-control">
                <option value="">Seleccionar</option>
                    <option value="0">Vacio</option>
                    <option value="1">Tiene Espacio</option>
            </select>
            @error('is_full')
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

    $('#form_ce_flight').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    $("#form_ce_flight").submit(function (e) {
        e.preventDefault();
        var data = $('#form_ce_flight').serializeArray().reduce(function (obj, item) {
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
                url: '{{url('/flight-edit')}}',
                data: data,
                success: function (response) {
                    send_ce_flight(response)
                }, error(e) {

                    console.log('error:', e)
                    console.log('error:', e.responseJSON.message)
                    toastr.warning(e.responseJSON.message)
                }

            })
        }
    })
</script>
