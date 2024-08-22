@extends('layouts.main')

@section('title', 'All Task')

@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="container-fluid py-4">
     
      <div class="row mb-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-6">
                  <h6>All Task</h6>
                </div>
                <div class="col-6">
                  <a href="{{ url('task/create') }}" class="btn btn-primary" style="float:right">Add Task</a>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-1">
                <table class="table table-row-bordered table-hover w-100" id="task">
                    <thead>
                        <tr class="fw-bold fs-6 text-muted">
                          <th>Title</th>
                          <th>Priority</th>
                          <th>Deadline</th>
                          <th>Status</th>
                          <th>Assign To</th>
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
      </div>
    </div>
  </main>
@endsection
@section('js')
<script type="text/javascript">
    var users = $('#task').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('task') }}",
            data: function(d) {
                d.search = $('input[type="search"]').val()
            }
        },
        columns: [ 
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'priority',
                name: 'priority'
            },
            {
                data: 'deadline',
                name: 'deadline'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'assign_to',
                name: 'assign_to'
            },
            {
                data: 'action',
                name: 'action'
            },
        ],
    });
</script>
@endsection