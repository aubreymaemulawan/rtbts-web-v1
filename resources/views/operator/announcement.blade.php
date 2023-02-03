@extends('layouts.app')
@section('title','Announcements')

@section('modal')
    <!-- Status Modal --> 
        <div class="modal fade" id="view-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <!-- Status Form -->
                <form class="modal-content" id="view_logs">
                    <div class="modal-header">
                        <h5 class="modal-title" id="view-modalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="body" class="modal-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-2">
                            
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-envelope"></i>
                                </span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h5 class="mb-1" id="subject"></h5>
                                    <small id="to"></small>
                                </div>
                            </div>
                        </div>
                        <hr class="hr-style">
                        <li class="d-flex mb-1 pb-1">
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <p class="mb-4" id="message"></p>
                                <small class="col-12">From : {{$comp_name}}</small>
                                <small class=" col-12" id="date"></small>
                            </div>
                        </li> 
                    </div>
                </form>
            </div>
        </div>
    <!-- End of Status Modal -->
@endsection

@section('operator_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light">Bus Reminders /</span> Announcements
        </h4>
        <div class="alert alert-primary" style="padding:20px">
            <i class="bx bx-info-circle me-1"></i>
            View announcements from your management here.
        </div>
        <!-- Schedule Table -->
        <div class="card">
            <div class="card-body pad">
                <div class="tbl table-responsive text-nowrap">
                    <table id=dataTable class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th>To</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="realtime_table_operator_announcement" class="table-border-bottom-0">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Sidebar
        $('[id^="main"]').removeClass('active open')
        $('#main-operator-announcement').addClass('active open')
        $('[id^="menu-"]').removeClass('active')

        // Data Table
        $('#dataTable').DataTable({
            searching: false, 
            paging: false, 
            info: false,
            order: [[0, 'desc']],
            "bPaginate": false,
        });

        // Onclick Status Function
        function View(data){
            $('#view_content').html('');
            $('#view-modal-footer').html('')
            document.getElementById("view-modalTitle").innerHTML="View Announcement";
            // Show Values in Modal
            var date = moment(data.created_at).format('MMMM Do YYYY, h:mm a')
            user_type = '';
            if(data.user_type == 1){
                user_type = 'All';
            }else if(data.user_type == 2){
                user_type = 'Conductors';
            }else if(data.user_type == 3){
                user_type = 'Dispatchers';
            }else if(data.user_type == 4){
                user_type = 'Operators';
            }else if(data.user_type == 5){
                user_type = 'Passengers';
            }else if(data.user_type == 6){
                user_type = 'All Personnel';
            }
            $('#subject').html(data.subject);
            $('#to').html('To : '+user_type);
            $('#message').html(data.message);
            $('#date').html(date);
            $('#view-modal').modal('show')
        }
    </script>
    <script>
        function loadXMLDoc() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("realtime_table_operator_announcement").innerHTML =
                    this.responseText;
                }
            };
            xhttp.open("GET", "./tbl-operator-announcement", true);
            xhttp.send();
        }
        setInterval(function(){
            $('[data-bs-toggle="tooltip"]').tooltip('hide');
            loadXMLDoc();
            // 1sec
        },10000);
        window.onload = loadXMLDoc;
    </script>
@endsection