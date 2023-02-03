@foreach ($bus as $bs)
    @if($bs->company_id==Auth::user()->company_id)
    <tr>
        <td></td>
        <!-- Bus No. Column -->
        <td><strong>{{$bs->bus_no}}</strong></td>
        <!-- Bus Type No. Column -->
        @if ($bs->bus_type == 1)
        <td>Airconditioned</td>
        @elseif ($bs->bus_type == 2)
        <td>Non Airconditioned</td>
        @endif
        <!-- Plate No. Column -->
        <td>{{$bs->plate_no}}</td>
        <!-- Color In Map Column -->
        <td><span class="badge me-2" style="background-color:{{$bs->color}};color:{{$bs->color}}">color</span></td>
        <!-- Status column -->
        @if ($bs->status == 1)
        <td><span class="badge bg-label-success me-1">Active</span></td>
        @elseif ($bs->status == 2)
        <td><span class="badge bg-label-danger me-1">Not Active</span></td>
        @endif
        <!-- Actions Column -->
        <td>
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <!-- View -->
                    <button onclick="View({{ $bs->id }})" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-info-square me-1"></i>
                        View
                    </button>
                    <!-- Edit -->
                    <button onclick="Edit({{ $bs->id }})" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-edit-alt me-1"></i>
                        Edit
                    </button>
                    <!-- Delete -->
                    <button onclick="Delete({{ $bs->id }})" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-trash me-1"></i>
                        Delete
                    </button>
                </div>
            </div>
        </td>
    </tr>
    @endif
@endforeach