@foreach ($persched as $sched)
    @if($sched->status == 1)
    <tr> 
        <td><strong>{{$sched->schedule->company->company_name}}</strong></td>
        <td>{{$sched->schedule->route->from_to_location}}</td>
        @if($sched->bus->bus_type==1)
        <td>{{$sched->bus->bus_no}} - AC</td>
        @elseif($sched->bus->bus_type==2)
        <td>{{$sched->bus->bus_no}} - Non-AC</td>
        @endif
        <?php
            $date1 = new DateTime($sched->schedule->first_trip);
            $first_trip = $date1->format('g:i a');
            $date2 = new DateTime($sched->schedule->last_trip);
            $last_trip = $date2->format('g:i a');
        ?>
        <td>{{$first_trip}}</td>
        <td>{{$last_trip}}</td>
        <td>{{$sched->schedule->interval_mins}} mins</td>
    </tr>
    @endif
@endforeach