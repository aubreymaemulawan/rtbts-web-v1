@if(!$status)
    <span class="badge bg-label-dark me-1">N/A</span>
    @else
        <?php
            $date = new DateTime($status->created_at);
            $result1 = $date->format('g:i a');
        ?>
        @if($status->bus_status == 1)
        <span class="badge bg-label-warning me-1">Loading - {{$result1}}</span>
        @elseif($status->bus_status == 2)
        <span class="badge bg-label-secondary me-1">Break - {{$result1}}</span>
        @elseif($status->bus_status == 3)
        <span class="badge bg-label-info me-1">Departed - {{$result1}}</span>
        @elseif($status->bus_status == 4)
        <span class="badge bg-label-danger me-1">Cancelled - {{$result1}}</span>
        @elseif($status->bus_status == 5)
        <span class="badge bg-label-success me-1">Arrived - {{$result1}}</span>
        @endif
@endif