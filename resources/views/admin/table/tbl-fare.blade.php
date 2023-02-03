<?php $count = 1;?>
@foreach ($fare as $fr)
    @if($fr->route->company_id==Auth::user()->company_id)
    <tr>
        <td></td>
        <!-- List No. -->
        <td><strong>{{$count++}}</strong></td>
        <!-- Route Column -->
        <td>{{$fr->route->from_to_location}}</td>
        <!-- Bus Type No. Column -->
        @if ($fr->bus_type == 1)
        <td>Airconditioned</td>
        @elseif ($fr->bus_type == 2)
        <td>Non Airconditioned</td>
        @endif
        <!-- Price Column -->
        <td>₱ {{$fr->price}}</td>
        <!-- Actions Column -->
        <td>
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <!-- Edit -->
                    <button onclick="Edit({{ $fr->id }})" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-edit-alt me-1"></i>
                        Edit
                    </button>
                    <!-- Delete -->
                    <button onclick="Delete({{ $fr->id }})" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-trash me-1"></i>
                        Delete
                    </button>
                </div>
            </div>
        </td>
    </tr>
    @endif
@endforeach