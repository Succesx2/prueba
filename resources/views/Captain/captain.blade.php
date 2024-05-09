@if(sizeof($captains) == 0 && $captains->currentPage() == 1)
    <tr>
        <td colspan="100">Sin registros</td>
    </tr>
@else
    @foreach($captains as $index => $captain)
        <tr>
            <td>{{$index+1}}</td>
            <td>{{$captain->name}}</td>
            <td>{{$captain->last_name}}</td>
            <td>
                {{$captain->flight->code ?? ''}}
            </td>

            <td>
                {{$captain->document}}
            </td>
            <td>
                <a class="btn btn-info mb-3" onclick="ce_captain({{$captain->id}})" >Edit capitan</a>
                <a class="btn btn-danger mb-3" onclick="delete_captain({{$captain->id}})" >Eliminar capitan</a>
            </td>
        </tr>
    @endforeach

    <tr>
        <td class="text-center" colspan="100">
            <div class="row col-lg-12 justify-content-center">
                {{ $captains->links('vendor.pagination.bootstrap-5') }}
            </div>
        </td>
    </tr>
@endif

