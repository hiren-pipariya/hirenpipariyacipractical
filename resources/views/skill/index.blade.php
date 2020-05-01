@extends('layouts.admin')
@section("title", "Skill") 
@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Skill</h5>
                    <ul>
                        <li>
                            <a href="{{ url('skill/create')}}">
                                Create
                            </a>
                        </li>
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
                            <th>Id</th>
                            <th>Skill</th>
                            <th>Action</th>
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
                url: 'skill/datatable',
            },
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'skill',
                    name: 'skill'
                },
                {
                    "data": null,
                    "name": "action",
                    "orderable": false,
                    "searchable": false,
                    "render": function(o) {
                        var element =  "<a href='{{url('skill/')}}/" + o.id +
                            "/edit' >Edit</a>&nbsp; <a href='javascript:void(0);" + o.id + "'  onclick='deleteForm(" + o.id + ")'>Delete</a>";
                        return element;
                    }
                }
            ]
        });
    });

    $("#refreshDataTable").click(function(e) {
        dtable.draw();
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