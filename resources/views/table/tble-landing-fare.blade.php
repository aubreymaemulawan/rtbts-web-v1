@foreach ($fare as $fr)
    <tr>
        <td><strong>{{$fr->route->from_to_location}}</strong></td>
        <td>{{$fr->route->company->company_name}}</td>
        @if($fr->bus_type==1)
        <td>AC</td>
        @elseif($fr->bus_type==2)
        <td>Non-AC</td>
        @endif
        <td>₱{{$fr->price}}</td>
        <td>
        <?php
            $date = new DateTime($fr->updated_at);
            $res3 = $date->format('F j, Y');
        ?>
        {{$res3}}
        </td>
    </tr>
@endforeach