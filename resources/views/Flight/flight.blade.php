@if(sizeof($flights) == 0 && $flights->currentPage() == 1)
    <tr>
        <td colspan="100">Sin registros</td>
    </tr>
@else
    @foreach($flights as $index => $flight)
        <tr>
            <td>{{$index+1}}</td>
            <td>{{$flight->airline_id}}</td>
            <td>{{$flight->airport_exit}}</td>
            <td>{{$flight->airport_entrance}}</td>
            <td>{{$flight->max_seats}}</td>
            <td>{{$flight->reserved_seats}}</td>
            <td>{{$flight->code}}</td>
            <td>{{$flight->airport->name ?? ''}}</td>
            {{--<td>{{$flight->airplane->code ?? ''}}</td>
            --}}
            <td>{{$flight->is_full}}</td>
            <td>
                {{$flight->next_maintenance}}
            </td>
            <td>
                <a class="btn btn-info mb-3" onclick="ce_flight({{$flight->id}})" >Edit vuelo</a>
                <a class="btn btn-danger mb-3" onclick="delete_flight({{$flight->id}})" >Eliminar vuelo</a>
            </td>
        </tr>
    @endforeach

    <tr>
        <td class="text-center" colspan="100">
            <div class="row col-lg-12 justify-content-center">
                {{ $flights->links('vendor.pagination.bootstrap-5') }}
            </div>
        </td>
    </tr>
@endif
