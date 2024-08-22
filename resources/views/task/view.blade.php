@extends('layouts.main')

@section('title', 'Task View')

@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row mb-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>view Task</h6>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="row p-4">
                    <div class="mb-3 col-md-4">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" disabled class="form-control" id="title" name="title" placeholder="Enter Title" value="{{ $task->title }}">
                        @error('title')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" disabled class="form-control" id="description" name="description" placeholder="Enter Description" value="{{ $task->description }}">
                        @error('description')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="priority" class="form-label">Priority</label>
                        <select name="priority" disabled id="priority" class="form-control">
                            <option value="">-- Select Priority --</option>
                            <option value="high" {{ $task->priority == 'high' ? 'selected' : ''}}>High</option>
                            <option value="medium" {{ $task->priority == 'medium' ? 'selected' : ''}}>Medium</option>
                            <option value="low" {{ $task->priority == 'low' ? 'selected' : ''}}>Low</option>
                        </select>
                        @error('priority')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" disabled class="form-control" id="deadline" name="deadline" value="{{ $task->deadline }}">
                        @error('deadline')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" disabled id="status" class="form-control">
                            <option value="">-- Select Status --</option>
                            <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : ''}}>Pending</option>
                            <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : ''}}>In Progress</option>
                            <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : ''}}>Completed</option>
                        </select>
                        @error('status')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="document" class="form-label">Document
                          @if(isset($task->document))
                            <a href="{{ asset('storage/images/'.$task->document) }}" target="_blank">View</a>
                          @endif
                        </label>
                        <input type="file" disabled class="form-control" id="document" name="document" value="{{ old('document') }}">
                        @error('document')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @if (auth()->user()->role != 'employ')
                    <div class="mb-3 col-md-4">
                        <label for="assign_to" class="form-label">Assign To</label>
                        <select name="assign_to" disabled id="assign_to" class="form-control">
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                              <option value="{{ $user->id }}" {{ $task->assignee_to == $user->id ? 'selected' : ''}}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('assign_to')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @endif
                   
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