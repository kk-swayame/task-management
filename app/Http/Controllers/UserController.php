<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;




class UserController extends Controller
{

    public function dashboard(){
        $total_task = Task::where('flag', 0)->count();
        $completed_task = Task::where('flag', 0)->where('status', 'Completed')->count();
        $pending_task = Task::where('flag', 0)->where('status', 'Pending')->count();
        $overdue_task = Task::where('flag', 0)->where('deadline', '<', date('Y-m-d'))->where('status', '!=', 'Completed')->count();
        return view('admin_dashboard', compact('total_task', 'completed_task', 'pending_task', 'overdue_task'));
    }
    public function index(Request $request)
    {
        if(auth()->user()->role == 'employ'){
            return redirect()->back()->with("danger", "You Don't have permission to access this page");
        }
        if (request()->ajax()) {
            $users = User::where('flag', 0)->orderBy('created_at', 'desc')->get();
            $new_users = new Collection;
           
            foreach ($users as $user) {
                if (!empty($user)) {
                    $new_users->push([
                        'id' => $user->id,
                        'name'=>$user->name,
                        'email' => $user->email,
                        'role'=>$user->role,
                    ]);
                }
            }

            // dd($new_users);
      
            return Datatables::of($new_users)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            if (Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            if (Str::contains(Str::lower($row['email']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            if (Str::contains(Str::lower($row['role']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            return false;
                        });
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    if(auth()->user()->role == 'admin') 
                    {
                        $actionBtn = $actionBtn . '<a href="' . url('users/edit', $row['id']) . '" class="icon1" title="Edit Details"><i class="fa-solid fa-pencil"></i></a>';
                    }
                    if(auth()->user()->role == 'admin') 
                    {
                    $actionBtn = $actionBtn . ' <a href="' . url('users/show', $row['id']) . '" class="icon1" title="Show Details"><i class="fa-solid fa-eye"></i></a>';
                    }
                    if(auth()->user()->role == 'admin') 
                    {
                    $actionBtn = $actionBtn . ' <a href="' . url('users/delete', $row['id']) . '" class="icon1" title="Delete Details"><i class="fa-solid fa-trash delete"></i></a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('users.index');
    }

    public function create(){
        if(auth()->user()->role == 'employ'){
            return "you dont have permission to access this page";
        }
        return view('users.create');
    }

    public function store(Request $request){
        if(auth()->user()->role == 'employ'){
            return "you dont have permission to access this page";
        }
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'], 
            'role' => ['required']
        ], [
            'name.required'                  => 'Name is required',
            'name.string'                    => 'Name must be a string',
            'email.required'                 => 'Email is required',
            'email.string'                   => 'Email must be a string',
            'email.email'                    => 'Email is not valid',
            'password.required'              => 'Password is required',
            'role'                           => 'Role is required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        return redirect('users')->with('success', 'User created successfully');
    }

    public function edit($id){
        if(auth()->user()->role == 'employ'){
            return "you dont have permission to access this page";
        }
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    public function view($id){
        if(auth()->user()->role == 'employ'){
            return "you dont have permission to access this page";
        }
        $user = User::find($id);
        return view('users.view', compact('user'));
    }

    public function update($id,Request $request){
        if(auth()->user()->role == 'employ'){
            return "you dont have permission to access this page";
        }
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'role' => ['required']
        ], [
            'name.required'                  => 'Name is required',
            'name.string'                    => 'Name must be a string',
            'email.required'                 => 'Email is required',
            'email.string'                   => 'Email must be a string',
            'email.email'                    => 'Email is not valid',
            'role'                           => 'Role is required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        return redirect('users')->with('success', 'User Updated successfully');
    }

    public function delete($id){
        if(auth()->user()->role == 'employ'){
            return "you dont have permission to access this page";
        }
        $user = User::find($id);
        $user->flag = 1;
        $user->save();
        return redirect('users')->with('success', 'User Deleted successfully');
    }
}
