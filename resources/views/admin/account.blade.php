@extends('layouts.app')
@section('title','Accounts List')

@section('admin_content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-3">
            <span class="text-muted fw-light">Bus Personnel /</span> Accounts List
        </h4>
        <div class="alert alert-primary" style="padding:20px">
            <i class="bx bx-info-circle me-1"></i>
            View your personnel accounts information here.
        </div>
        <!-- Account Table -->
        <div class="card">
            <div class="card-header color">
                <a type="button" class="btn rounded-pill btn-primary" href="./personnel">Go to Manage</a>
            </div>
            <div class="card-body pad">
                <div class="tbl table-responsive text-nowrap">
                    <table id=dataTable class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th></th>
                                <th>Personnel No.</th>
                                <th>Role</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Account</th>
                            </tr>
                        </thead>
                        <tbody id="realtime_table_account" class="table-border-bottom-0">
                            
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
        $('#main-admin-personnel').addClass('active open')
        $('[id^="menu-"]').removeClass('active')
        $('#menu-account').addClass('active')

        $(document).ready(function (e) {
            // Data Table
            $('#dataTable').DataTable();
        })
    </script>
    <script>
        function loadXMLDoc() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    $(function () {
                        $('[data-bs-toggle="tooltip"]').tooltip();
                    });
                    document.getElementById("realtime_table_account").innerHTML =
                    this.responseText;
                }
            };
            xhttp.open("GET", "./tbl-account", true);
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