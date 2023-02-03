@foreach ($account as $ac)
    @if($ac->personnel->company_id==Auth::user()->company_id)
    <tr>
        <td></td>
        <!-- Personnel No. Column -->
        <td data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="{{$ac->personnel->name}}"><strong>{{$ac->personnel->personnel_no}}</strong></td>
        <!-- User Type Column -->
        @if ($ac->personnel->user_type == 2)
        <td>Conductor</td>
        @elseif ($ac->personnel->user_type == 3)
        <td>Dispatcher</td>
        @elseif ($ac->personnel->user_type == 4)
        <td>Operator</td>
        @endif
        <!-- Username Column -->
        <td>{{$ac->email}}</td>
        <!-- Password Column -->
        <td>{{$ac->password}}</td>
        <!-- Account Status Column -->
        @if(DB::table('users')->where('personnel_id',$ac->personnel_id)->exists())
        <td><span class="badge bg-label-success me-1">Enabled</span></td>
        @elseif( DB::table('account')->where('personnel_id',$ac->personnel_id)->exists() && !(DB::table('users')->where('personnel_id',$ac->personnel_id)->exists()) )
        <td><span class="badge bg-label-danger me-1">Disabled</span></td>
        @endif
    </tr>
    @endif
@endforeach