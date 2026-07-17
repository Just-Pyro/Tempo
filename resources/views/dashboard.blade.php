@extends('layout.app')

@section('content')
    <x-wholepagewrapper>
        <x-sidebar />
        <x-contentwrapper class="flex-col !justify-start p-5 gap-6">
            <div class="dash-header flex items-center justify-between w-full">
                <h3 class="font-bold text-2xl">Dashboard</h3>
                <p class="text-stone-700 font-medium text-sm">{{ now()->format("l, F j, Y") }}</p>
            </div>

            <div class="flex w-full justify-between gap-4">
                <div class="status-card flex-1 border border-gray-300 flex flex-col bg-white rounded-lg px-5 py-4 gap-1">
                    <p class="status-label text-xs text-gray-700">Total tasks</p>
                    <p class="status-count text-2xl font-medium">{{ $totalTasks }}</p>
                </div>

                @foreach ($status as $index => $item)
                    <div class="flex-1 status-card border border-gray-300 flex flex-col bg-white rounded-lg px-5 py-4 gap-1">
                        <p class="status-label text-xs text-gray-700">{{ ucfirst(str_replace('_', ' ', $index)) }}</p>
                        <p class="status-count {{ $index }} text-2xl font-medium">{{ $item }}</p>
                    </div>
                @endforeach
            </div>

            <div class="flex flex-col gap-2 w-full">
                <h3 class="text-stone-600 font-medium">TODAY'S TASKS</h3>

                @forelse ($tasks as $task)
                    <a href="{{ route('tasks.edit', $task->id) }}">
                        <div class="border border-gray-300 rounded-lg p-3 bg-white flex gap-4 items-center justify-between task-card">
                            <div class="flex gap-4 items-center">
                                <div class="status-color {{ $task->status }} w-3 h-3 rounded-full">
                                </div>
                                <div class="task-name font-medium text-sm">
                                    {{ $task->name }}
                                </div>
                            </div>
    
                            <div class="flex gap-4 items-center">
                                <div class="task-etc text-gray-700 text-sm">
                                    {{ $task->etc }}
                                </div>
                                <div class="task-status {{ $task->status }} rounded-full px-2 py-1 font-medium">
                                    {{ ucwords(str_replace('_', ' ', $task->status)) }}
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="w-full text-stone-500 italic text-lg text-center">
                        No Tasks for Today.
                    </div>
                @endforelse
            </div>
        </x-contentwrapper>
    </x-wholepagewrapper>
@endsection