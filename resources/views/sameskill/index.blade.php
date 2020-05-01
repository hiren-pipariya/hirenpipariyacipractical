@extends('layouts.web')
@section("title", "Friend") 
@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Same Skill User</h5>
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
                            <th>Request</th>
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
                url: 'sameskill/datatable',
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
                    data: 'userdetail.image',
                    name: 'userdetail.image',
                    "orderable": false,
                    "searchable": false,
                    "render": function(data) {
                        var element =  
                        `<div class="justify-content-center">
                                <img src="${data}" class="img-thumbnail" alt="Image">
                        </div>`;
                        return element;
                    }
                },
                {
                    data: null,
                    name: null,
                    "orderable": false,
                    "searchable": false,
                    "render": function(data) {
                        var element = `<a href='javascript:void(0);' class="send-request" data-id="${data.id}">Send</a>`;
                        return element;
                    }
                },
            ]
        });
    });

    $("#refreshDataTable").click(function(e) {
        dtable.draw();
    });
    
    $(document).on('click',".send-request" ,function(e) {
      var id = $(this).data('id');
        $.ajax({
            url: "send_request/" + id,
            type: "get",
            processData: false,
            cache: false,
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(success) {
               alert('Request sent')
               dtable.draw(false);
            },
            error: function(error) {
                alert('Something went wrong')
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