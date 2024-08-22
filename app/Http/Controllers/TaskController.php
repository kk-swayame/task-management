<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $tasks = Task::where('flag', 0)->with('assign')->orderBy('created_at', 'desc')->get();
            $new_tasks = new Collection;
           
            foreach ($tasks as $task) {
                if (!empty($task)) {
                    $new_tasks->push([
                        'id'    => $task->id,
                        'title'  =>$task->title,
                        'priority' => $task->priority,
                        'deadline'  =>$task->deadline,
                        'status'  =>$task->status,
                        'assign_to'  =>$task->assign->name,
                    ]);
                }
            }
      
            return Datatables::of($new_tasks)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            if (Str::contains(Str::lower($row['title']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            if (Str::contains(Str::lower($row['priority']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            if (Str::contains(Str::lower($row['status']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            if (Str::contains(Str::lower($row['assign_to']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            return false;
                        });
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $actionBtn = $actionBtn . '<a href="' . url('task/edit', $row['id']) . '" class="icon1" title="Edit Details"><i class="fa-solid fa-pencil"></i></a>';
                    $actionBtn = $actionBtn . ' <a href="' . url('task/show', $row['id']) . '" class="icon1" title="Show Details"><i class="fa-solid fa-eye"></i></a>';
                    $actionBtn = $actionBtn . ' <a href="' . url('task/delete', $row['id']) . '" class="icon1" title="Delete Details"><i class="fa-solid fa-trash delete"></i></a>';
                    
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('task.index');
    }

    public function MyTask(Request $request)
    {
        if (request()->ajax()) {
            $tasks = Task::where('flag', 0)->where('assignee_to', auth()->user()->id)->with('assign')->orderBy('created_at', 'desc')->get();
            $new_tasks = new Collection;
           
            foreach ($tasks as $task) {
                if (!empty($task)) {
                    $new_tasks->push([
                        'id'    => $task->id,
                        'title'  =>$task->title,
                        'priority' => $task->priority,
                        'deadline'  =>$task->deadline,
                        'status'  =>$task->status,
                        'assign_to'  =>$task->assign->name,
                    ]);
                }
            }
      
            return Datatables::of($new_tasks)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            if (Str::contains(Str::lower($row['title']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            if (Str::contains(Str::lower($row['priority']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            if (Str::contains(Str::lower($row['status']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            if (Str::contains(Str::lower($row['assign_to']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            return false;
                        });
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '';
                    $actionBtn = $actionBtn . '<a href="' . url('task/edit', $row['id']) . '" class="icon1" title="Edit Details"><i class="fa-solid fa-pencil"></i></a>';
                    $actionBtn = $actionBtn . ' <a href="' . url('task/show', $row['id']) . '" class="icon1" title="Show Details"><i class="fa-solid fa-eye"></i></a>';
                    $actionBtn = $actionBtn . ' <a href="' . url('task/delete', $row['id']) . '" class="icon1" title="Delete Details"><i class="fa-solid fa-trash delete"></i></a>';
                    
                    return $actionBtn;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('task.mytask');
    }

    public function create(){
        $users = User::where('flag', 0)->get();
        return view('task.create', compact('users'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
            'priority' => 'required',
            'deadline' => 'required',
            'status' => 'required',
        ], [
            'title.required'          => 'Title is required',
            "description.required"    => 'Description is required',
            'priority.required'       => 'Priority is required',
            'deadline.required'       => 'Deadline is required',
            'status.required'         => 'Status is required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->deadline = $request->deadline;
        $task->status = $request->status;
        $task->assignee_to = $request->assign_to;
        if(auth()->user()->role == 'employ'){
            $task->assignee_to = auth()->user()->id;
        }
        if ($request->hasFile('document')) {
            $fileNameString1 = (string) Str::uuid();
            $extension1 = $request->document->getClientOriginalExtension();
            $file1 = $request->file('document');
            $full_image_name1 = $fileNameString1 . "." . $extension1;
            $path1 = Storage::putFileAs('public/images/', $file1, $full_image_name1);
            $task->document = $full_image_name1;
        };
        $task->user_id = auth()->user()->id;
        $task->save();
        if(auth()->user()->role != 'employ'){
            return redirect('task')->with('succcess', 'Task created successfully');
        }
        return redirect('task/my-task')->with('succcess', 'Task created successfully');
    }

    public function edit($id){
        $task = Task::find($id);
        $users = User::where('flag', 0)->get();
        return view('task.edit', compact('task', 'users'));
    }

    public function view($id){
        $task = Task::find($id);
        $users = User::where('flag', 0)->get();
        return view('task.view', compact('task', 'users'));
    }

    public function update($id,Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
            'priority' => 'required',
            'deadline' => 'required',
            'status' => 'required',
        ], [
            'title.required'          => 'Title is required',
            "description.required"    => 'Description is required',
            'priority.required'       => 'Priority is required',
            'deadline.required'       => 'Deadline is required',
            'status.required'         => 'Status is required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $task = Task::find($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->deadline = $request->deadline;
        $task->status = $request->status;
        $task->assignee_to = $request->assign_to;
        if(auth()->user()->role == 'employ'){
            $task->assignee_to = auth()->user()->id;
        }
        if ($request->hasFile('document')) {
            $fileNameString1 = (string) Str::uuid();
            $extension1 = $request->document->getClientOriginalExtension();
            $file1 = $request->file('document');
            $full_image_name1 = $fileNameString1 . "." . $extension1;
            $path1 = Storage::putFileAs('public/images/', $file1, $full_image_name1);
            $task->document = $full_image_name1;
        };
        $task->user_id = auth()->user()->id;
        $task->save();
        return redirect('task')->with('success', 'Task Updated successfully');
    }

    public function delete($id){
        $task = Task::find($id);
        $task->flag = 1;
        $task->save();
        return redirect('task')->with('success', 'Task Deleted successfully');
    }
}
