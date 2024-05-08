@if(sizeof($airports) == 0 && $airports->currentPage() == 1)
    <tr>
        <td colspan="100">Sin registros</td>
    </tr>
@else
    @foreach($airports as $index => $airport)
        <tr>
            <td>{{$index+1}}</td>
            <td>{{$airport->name}}</td>
            <td>
                {{$airport->country->name}}
            </td>
            <td>
                <a class="btn btn-info mb-3" onclick="ce_airport({{$airport->id}})" >Edit peluqueria</a>
                <a class="btn btn-danger mb-3" onclick="delete_airport({{$airport->id}})" >Eliminar peluqueria</a>
            </td>
        </tr>
    @endforeach

    <tr>
        <td class="text-center" colspan="100">
            <div class="row col-lg-12 justify-content-center">
                {{ $airports->links('vendor.pagination.bootstrap-5') }}
            </div>
        </td>
    </tr>
@endif
