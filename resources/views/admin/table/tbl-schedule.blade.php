<?php $count = 0 ?>
@foreach ($schedule as $sd)
    @if($sd->company_id==Auth::user()->company_id)
    <tr>
        <td></td>
        <!-- Route ID Column -->
        <td><strong>{{$sd->route->from_to_location}}</strong></td>
        <!-- Trip Info Column -->
        <td>First Trip: {{$sd->first_trip}} <br> Last Trip: {{$sd->last_trip}}</td>
        <!-- Interval Mins Column -->
        <td>{{$sd->interval_mins}} mins</td>
        <!-- No of Assigned Schedule Column -->
        @foreach($personnel_schedule as $ps)
            @if($ps->schedule_id == $sd->id)
                <?php $count += 3; ?>
            @endif
        @endforeach
        <td style="text-align:center;">{{$count}}</td>
        <?php $count = 0 ; ?>
        <!-- Status column -->
        @if ($sd->status == 1)
        <td><span class="badge bg-label-success me-1">Active</span></td>
        @elseif ($sd->status == 2)
        <td><span class="badge bg-label-danger me-1">Not Active</span></td>
        @endif
        <!-- Actions Column -->
        <td>
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <!-- Edit -->
                    <button onclick="Edit({{ $sd->id }})" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-edit-alt me-1"></i>
                        Edit
                    </button>
                    <!-- Delete -->
                    <button onclick="Delete({{ $sd->id }})" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-trash me-1"></i>
                        Delete
                    </button>
                </div>
            </div>
        </td>
    </tr>
    @endif
@endforeach