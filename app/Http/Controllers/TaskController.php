<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    public function dataTable(Request $request)
    {
        
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
