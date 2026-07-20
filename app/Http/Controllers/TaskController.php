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
        $completed = Task::where("status", "completed")->count();
        $pending = Task::where("status", "pending")->count();
        $missed = Task::where("status", "missed")->count();
        $inProgress = Task::where("status", "in_progress")->count();
        $totalTasks = $completed + $pending + $missed + $inProgress;

        $status = [
            'completed' => $completed,
            'pending' => $pending,
            'missed' => $missed,
            'in_progress' => $inProgress,
        ];

        $tasks = Task::where('date_schedule', date("Y-m-d 00:00:00"))->whereNot('status', 'archived')->get();

        $tasks->each(function($task) {
            $task->etc = $this->formatDurationFromTime($task->etc);
        });

        return view('dashboard', compact('totalTasks', 'status', 'tasks'));
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

        $tasks = Task::where('user_id', $user->id)->whereNot('status', 'archived')->latest();
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

                $schedIsPast = Carbon::parse($task->date_schedule)->isBefore(Carbon::today());

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
                    <a href="javascript:void(0);" class="archive-btn" data-id="' . $task->id .'">
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
        
        if (Carbon::parse($task->date_schedule)->isBefore(Carbon::today()) && $task->status != 'completed') {
            $task->status = 'missed';
            $task->save();
        }

        return view('tasks.edit', compact('task'));
    }

    public function archiveTask(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tasks,id',
        ]);

        $task = Task::find($request->id);

        if ($task) {
            $task->status = 'archived';
            $task->archived_date = Carbon::now();
            $task->save();

            return redirect()->back()->with([
                'status' => 'success',
                'title' => 'Task Archived!',
                'message' => 'This task has been archived!'
            ]);
        } else {
            return redirect()->back()->with([
                'status' => 'error',
                'title' => 'Task Not Found!',
                'message' => 'Your task could not be found in the database!'
            ]);
        }
    }

    public function archiveTable()
    {
        $months = Task::whereNotNull('archived_date')
            ->selectRaw('YEAR(archived_date) as year, MONTH(archived_date) as month')
            ->distinct()
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get()
            ->map(function($item) {
                $item->month_name = Carbon::create()->month($item->month)->format('F');
                $item->value = sprintf('%04d-%02d', $item->year, $item->month);
                return $item;
            });

        return view('tasks.archive', compact('months'));
    }

    public function archiveDataTable(Request $request)
    {
        $user = Auth::user();

        $tasks = Task::where('user_id', $user->id)->where('status', 'archived')->latest();
        
        if ($request->filled('yearmonth') && $request->yearmonth != "all") {
            $tasks->whereLike('archived_date', '%' . $request->yearmonth . '%');
        }
        
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
            ->editColumn('archived_date', function ($task) {
                if (!$task->archived_date) return "—";

                $date = Carbon::parse($task->archived_date)
                    ->format('F j, Y'); 

                return '<span class="archive_date">' . $date . '</span>';
            })
            ->rawColumns(['archived_date'])
            ->make(true);
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
