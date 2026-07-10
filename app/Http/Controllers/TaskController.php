<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function tasks()
    {
        return view('tasks.index');
    }

    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'etc' => 'required',
            'date_schedule' => 'required',
        ], [
            'name.required' => 'The Task name field is required.'
        ]);

        try {
            Task::create([
                'user_id' => Auth::id(),
                'name' => $request->name,
                'details' => $request->details,
                'etc' => $request->etc,
                'date_schedule' => $request->date_schedule,
                'status' => 'pending',
            ]);
    
            return redirect()->back()->with(['status' => 'success', 'title' => 'Task Created!', 'message' => 'Your task has been successfully created.']);
        } catch (\Throwable $th) {
            Log::error('Task Creation Failed: ' . $th->getMessage());

            return redirect()->back()->with(['status' => 'error', 'title' => 'Something went wrong', 'message' => $th->getMessage()]);
        }

    }

    public function dataTable()
    {
        $user = Auth::user();

        $tasks = Task::where('user_id', $user->id);
        return DataTables::of($tasks)
            ->editColumn('date_schedule', function ($task) {
                $date = Carbon::parse($task->date_schedule)
                    ->format('F j, Y');
                return $date;
            })
            ->editColumn('etc', function ($task) {
                return $this->formatDurationFromTime($task->etc);
            })
            ->editColumn('atc', function($task) {
                if (!$task->atc) return '—';

                return $this->formatDurationFromTime($task->atc);
            })
            ->editColumn('status', function($task) {
                $colorsByStatus = [
                    'pending' => [
                        'text-color' => '#b45309',
                        'bg-color' => '#fef3c7',
                    ],
                    'in_progress' => [
                        'text-color' => '#1d4ed8',
                        'bg-color' => '#dbeafe',
                    ],
                    'completed' => [
                        'text-color' => '#15803d',
                        'bg-color' => '#dcfce7',
                    ],
                    'missed' => [
                        'text-color' => '#b91c1c',
                        'bg-color' => '#fee2e2',
                    ],
                ];

                $schedIsPast = Carbon::parse($task->date_schedule)->isPast();

                $finalStatus = ($schedIsPast && $task->status != 'completed') ? 'missed' : $task->status;

                $status = ucfirst(str_replace('_', ' ', $finalStatus));
                $colors = $colorsByStatus[$finalStatus];

                return sprintf('<span style="color: %s; background-color: %s; " class="task-status">%s</span>',
                    $colors['text-color'],
                    $colors['bg-color'],
                    $status);
            })
            ->addColumn('action', function ($task) {
                return '<div>
                    <a href="'. route('tasks.edit', $task->id) .'">
                        <div class="task-actions"><i class="fa fa-edit"></i></div>
                    </a>
                    <a href="#">
                        <div class="task-actions"><i class="fa fa-trash"></i></div>
                    </a>
                </div>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function formatDurationFromTime(string $time)
    {
        $interval = CarbonInterval::createFromFormat('H:i:s', $time);

        $hours = $interval->hours;
        $minutes = $interval->minutes;

        if ($hours > 0 && $minutes > 0) {
            return $hours . 'hr' . ($hours > 1 ? 's' : '') . ' ' . $minutes . ' min';
        } elseif ($hours > 0) {
            return $hours . 'hr' . ($hours > 1 ? 's' : '');
        } else {
            return $minutes . ' min';
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::find($id);
        
        if (Carbon::parse($task->date_schedule)->isPast() && $task->status != 'completed') {
            $task->status = 'missed';
            $task->save();
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required'
        ]);
        
        $task = Task::findOrFail($id);

        $task->status = $request->status;
            
        if ($request->status == 'completed') {
            $timeStart = Carbon::parse($task->updated_at);
            $timeEnd = now();

            $diffInSeconds = $timeEnd->diffInSeconds($timeStart);

            $task->atc = gmdate('H:i:s', $diffInSeconds);
        }

        $task->save();

        return redirect()->back()->with(['status' => 'success', 'title' => 'Task Updated!', 'message' => 'Your task has been successfully updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
