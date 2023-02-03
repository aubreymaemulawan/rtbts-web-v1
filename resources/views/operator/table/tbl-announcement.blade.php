@foreach($announce as $an)
    <tr>
        <td>
            <div class="avatar flex-shrink-0 me-3">
                <span class="avatar-initial rounded bg-label-primary">
                    <i class="bx bx-envelope"></i>
                </span>
            </div>
        </td>
        <td>
            <?php
                $user_type = '';
                if($an->user_type == 1){
                    $user_type = 'All';
                }else if($an->user_type == 2){
                    $user_type = 'Conductors';
                }else if($an->user_type == 3){
                    $user_type = 'Dispatchers';
                }else if($an->user_type == 4){
                    $user_type = 'Operators';
                }else if($an->user_type == 5){
                    $user_type = 'Passengers';
                }else if($an->user_type == 6){
                    $user_type = 'All Personnel';
                }
            ?>
            <strong>{{$user_type}}</strong>
        </td>
        <td class="abbreviation">{{$an->subject}}</td>
        <td class="abbreviation">{{$an->message}}</td>
            <?php
                $date = new DateTime($an->created_at);
                $result = $date->format('F j, Y, g:i a');
            ?>
        <td>{{$result}}</td>
        <td>
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <!-- Status Logs -->
                    <button onclick="View({{$an}})" class="dropdown-item" href="javascript:void(0);">
                        <i class="bx bx-info-square me-1"></i>
                        View
                    </button>
                </div>
            </div>
        </td>
    </tr>
@endforeach