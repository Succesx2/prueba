@if(sizeof($airplanes) == 0 && $airplanes->currentPage() == 1)
    <tr>
        <td colspan="100">Sin registros</td>
    </tr>
@else
    @foreach($airplanes as $index => $airplane)
        <tr>
            <td>{{$index+1}}</td>
            <td>{{$airplane->code}}</td>
            <td>{{$airplane->airline->name}}</td>
            <td>{{$airplane->create_date}}</td>
            <td>
                {{$airplane->next_maintenance}}
            </td>
            <td>
                <a class="btn btn-info mb-3" onclick="ce_airplane({{$airplane->id}})" >Edit avion</a>
                <a class="btn btn-danger mb-3" onclick="delete_airplane({{$airplane->id}})" >Eliminar avion</a>
            </td>
        </tr>
    @endforeach

    <tr>
        <td class="text-center" colspan="100">
            <div class="row col-lg-12 justify-content-center">
                {{ $airplanes->links('vendor.pagination.bootstrap-5') }}
            </div>
        </td>
    </tr>
@endif
