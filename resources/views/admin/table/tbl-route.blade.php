<?php $count = 1; ?>
@foreach ($route as $rt)
    @if($rt->company_id==Auth::user()->company_id)
    <tr>
        <td></td>
        <!-- List No. Column -->
        <td><strong>{{$count++}}</strong></td>
        <!-- Route Column -->
        <td>{{$rt->from_to_location}}</td>
        <td>{{$rt->orig_address}}</td>
        <td>{{$rt->dest_address}}</td>
        <!-- Actions Column -->
        <td>
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <!-- Edit -->
                    <button onclick="Edit({{ $rt->id }})" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-edit-alt me-1"></i>
                        Edit
                    </button>
                    <!-- Delete -->
                    <button onclick="Delete({{ $rt->id }})" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-trash me-1"></i>
                        Delete
                    </button>
                </div>
            </div>
        </td>
    </tr>
    @endif
@endforeach