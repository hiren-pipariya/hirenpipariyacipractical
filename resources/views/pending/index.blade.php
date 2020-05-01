@extends('layouts.web')
@section("title", "Friend") 
@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Pending Request</h5>
                    <ul>
                        <li>
                            <a class="refresh-link" id="refreshDataTable">
                                refresh data
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="skillTable">
                    <thead>
                        <tr>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Username</th>
                            <th>email</th>
                            <th>mobile</th>
                            <th>gender</th>
                            <th>Photo</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    var dtable;
    $(document).ready(function() {
        dtable = $('#skillTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'pending_request/datatable',
            },
            columns: [
                {
                    data: 'userdetail.first_name',
                    name: 'userdetail.first_name'
                },
                {
                    data: 'userdetail.last_name',
                    name: 'userdetail.last_name'
                },
                {
                    data: 'userdetail.user_name',
                    name: 'userdetail.user_name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'userdetail.mobile',
                    name: 'userdetail.mobile'
                },
                {
                    data: 'userdetail.gender',
                    name: 'userdetail.gender'
                },
                {
                    data: null,
                    name: null,
                    "orderable": false,
                    "searchable": false,
                    "render": function(data) {
                        var element = `<a href='javascript:void(0);' class="accept-request" data-id="${data.id}">Accept</a> &nbsp; <a href='javascript:void(0);' class="cancle-request" data-id="${data.id}">Cancle</a>`;
                        return element;
                    }
                },
            ]
        });
    });

    $("#refreshDataTable").click(function(e) {
        dtable.draw();
    });

    $(document).on('click',".accept-request" ,function(e) {
      var id = $(this).data('id');
        $.ajax({
            url: "accept_request/" + id,
            type: "get",
            processData: false,
            cache: false,
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(success) {
               alert('Request Accepted');
               dtable.draw(false);
            },
            error: function(error) {
                alert('Something went wrong');
                dtable.draw(false);
            },
        });
    });
    $(document).on('click',".cancle-request" ,function(e) {
      var id = $(this).data('id');
        $.ajax({
            url: "cancle_request/" + id,
            type: "get",
            processData: false,
            cache: false,
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(success) {
               alert('Request Cancled');
               dtable.draw(false);
            },
            error: function(error) {
                alert('Something went wrong');
                dtable.draw(false);
            },
        });
    });

    function deleteForm(id) {
        $.ajax({
            url: "skill/" + id,
            type: "DELETE",
            processData: false,
            cache: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(success) {
               alert('Skill successfully deleted')
               dtable.draw(false);
            },
            error: function(error) {
                alert('Something went wrong')
                dtable.draw(false);
            },
        });
    }
</script>
@endpush