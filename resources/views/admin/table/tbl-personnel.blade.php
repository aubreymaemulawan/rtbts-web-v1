@foreach ($personnel as $pn)
    @if($pn->company_id==Auth::user()->company_id)
    <tr>
        <td></td>
        <!-- Profile Column -->
        <td>
            @if($pn->profile_path==null)
            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="{{$pn->name}}">
                    <img src="{{ asset('assets/img/avatars/default.jpg') }}" alt="Avatar" class="rounded-circle" />
                </li>
            </ul>
            @else
            <?php
                $str = $pn->profile_path;
                $str = ltrim($str, 'public/');
            ?>
            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="{{$pn->name}}">
                    <img src="{{ asset('../storage/'.$str) }}" alt="Avatar" class="rounded-circle" />
                </li>
            </ul>
            @endif
        </td>
        <!-- Name Column -->
        <td><strong>{{$pn->name}}</strong></td>
        <!-- Personnel No. Column -->
        <td>{{$pn->personnel_no}}</td>
        <!-- User Type Column -->
        @if ($pn->user_type == 2)
        <td>Conductor</td>
        @elseif ($pn->user_type == 3)
        <td>Dispatcher</td>
        @elseif ($pn->user_type == 4)
        <td>Operator</td>
        @endif
        <!-- Status column -->
        @if ($pn->status == 1)
        <td><span class="badge bg-label-success me-1">Active</span></td>
        @elseif ($pn->status == 2)
        <td><span class="badge bg-label-danger me-1">Not Active</span></td>
        @endif
        <!-- Account Status Column -->
        @if(DB::table('users')->where('personnel_id',$pn->id)->exists())
        <td><span class="badge bg-label-success me-1">Enabled</span></td>
        @elseif( DB::table('account')->where('personnel_id',$pn->id)->exists() && !(DB::table('users')->where('personnel_id',$pn->id)->exists()) )
        <td><span class="badge bg-label-danger me-1">Disabled</span></td>
        @elseif( !(DB::table('account')->where('personnel_id',$pn->id)->exists()) && !(DB::table('users')->where('personnel_id',$pn->id)->exists()) )
        <td><span class="badge bg-label-warning me-1">No Account</span></td>
        @endif
        <!-- Actions Column -->
        <td>
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <!-- View -->
                    @if($pn->profile_path==null)
                    <button onclick="View({{ $pn->id }},document.getElementById('view-uploadedAvatar').src='{{ asset('assets/img/avatars/default.jpg') }}')" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-info-square me-1"></i>
                        View
                    </button>
                    @else
                    <button onclick="View({{ $pn->id }},document.getElementById('view-uploadedAvatar').src='{{ asset('../storage/'.$str) }}')" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-info-square me-1"></i>
                        View
                    </button>
                    @endif
                    <!-- Edit -->
                    @if($pn->profile_path==null)
                    <button onclick="Edit({{ $pn->id }},document.getElementById('edit-uploadedAvatar').src='{{ asset('assets/img/avatars/default.jpg') }}')" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-edit-alt me-1"></i>
                        Edit
                    </button>
                    @else
                    <button onclick="Edit({{ $pn->id }},document.getElementById('edit-uploadedAvatar').src='{{ asset('../storage/'.$str) }}')" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-edit-alt me-1"></i>
                        Edit
                    </button>
                    @endif
                    <!-- Delete -->
                    <button onclick="Delete({{ $pn->id }})" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-trash me-1"></i>
                        Delete
                    </button>
                </div>
            </div>
        </td>
    </tr>
    @endif
@endforeach