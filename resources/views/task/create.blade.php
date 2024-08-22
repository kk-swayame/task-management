@extends('layouts.main')

@section('title', 'Task Create')

@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="container-fluid py-4">
     
     
      <div class="row mb-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Create Task</h6>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
                <form action="{{ url('task/store') }}" method="POST" enctype="multipart/form-data">
						    @csrf
                 
                <div class="row p-4">
                    <div class="mb-3 col-md-4">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{ old('title') }}">
                        @error('title')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="{{ old('description') }}">
                        @error('description')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="priority" class="form-label">Priority</label>
                        <select name="priority" id="priority" class="form-control">
                            <option value="">-- Select Priority --</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : ''}}>High</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : ''}}>Medium</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : ''}}>Low</option>
                        </select>
                        @error('priority')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" class="form-control" id="deadline" name="deadline" value="{{ old('deadline') }}">
                        @error('deadline')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">-- Select Status --</option>
                            <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : ''}}>Pending</option>
                            <option value="In Progress" {{ old('status') == 'In Progress' ? 'selected' : ''}}>In Progress</option>
                            <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : ''}}>Completed</option>
                        </select>
                        @error('status')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="document" class="form-label">Document</label>
                        <input type="file" class="form-control" id="document" name="document" value="{{ old('document') }}">
                        @error('document')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @if (auth()->user()->role != 'employ')                    
                    <div class="mb-3 col-md-4">
                        <label for="assign_to" class="form-label">Assign To</label>
                        <select name="assign_to" id="assign_to" class="form-control">
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                              <option value="{{ $user->id }}" {{ old('assign_to') == $user->id ? 'selected' : ''}}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('assign_to')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @endif

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                    </div>
                </div>
            </form>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection