@if(sizeof($airlines) == 0 && $airlines->currentPage() == 1)
    <tr>
        <td colspan="100">Sin registros</td>
    </tr>
@else
    @foreach($airlines as $index => $airline)
        <tr>
            <td>{{$index+1}}</td>
            <td>{{$airline->name}}</td>
            <td>
                {{$airline->airport->name}}
            </td>
            <td>
                <a class="btn btn-info mb-3" onclick="ce_airline({{$airline->id}})" >Edit peluqueria</a>
                <a class="btn btn-danger mb-3" onclick="delete_airline({{$airline->id}})" >Eliminar peluqueria</a>
            </td>
        </tr>
    @endforeach

    <tr>
        <td class="text-center" colspan="100">
            <div class="row col-lg-12 justify-content-center">
                {{ $airlines->links('vendor.pagination.bootstrap-5') }}
            </div>
        </td>
    </tr>
@endif
