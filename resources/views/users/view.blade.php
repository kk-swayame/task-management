@extends('layouts.main')

@section('title', 'View User')

@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="container-fluid py-4">
     
     
      <div class="row mb-4">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>View Users</h6>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="row p-4">
                    <div class="mb-3 col-md-4">
                        <label for="name" class="form-label">User Name</label>
                        <input type="text" class="form-control" id="name" disabled name="name" placeholder="Enter User Name" value="{{ $user->name }}">
                        @error('name')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" disabled name="email" placeholder="Enter Email Address" value="{{ $user->email }}">
                        @error('email')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" disabled id="password" name="password" placeholder="Enter Password" value="{{ old('password') }}">
                        @error('password')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="role" class="form-label">Select Role</label>
                        <select name="role" id="role" class="form-control" disabled>
                            <option value="">-- Select Role --</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : ''}}>Admin</option>
                            <option value="manager" {{ $user->role == 'manager' ? 'selected' : ''}}>Manager</option>
                            <option value="employ" {{ $user->role == 'employ' ? 'selected' : ''}}>Employ</option>
                        </select>
                        @error('role')
                          <span class="text-danger">{{ $message }}</span>
                        @enderror
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