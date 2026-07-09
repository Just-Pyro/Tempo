@extends('layout.app')

@section('content')
    <x-wholepagewrapper class="bg-[#f9fafb]">
        <x-sidebar />
        <div class="flex-1 px-8 py-12 overflow-x-hidden overflow-y-auto">
            <div class="flex gap-3 items-center">
                <a href="{{ route('tasks') }}" class="primary-btn"><i class="fa-solid fa-arrow-left"></i> Back</a>
                <h1 class="text-2xl font-medium">Edit task</h1>
            </div>

            <x-formwrapper class="mt-8">
                <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="flex flex-col gap-5">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col">
                        <label for="name" class="form-label">Task name</label>
                        <input type="text" id="name" name="name" class="px-4 py-2 rounded-lg border @error('name') border-red-300 @else border-stone-300 @enderror" placeholder="e.g. Set up project" value="{{ $task->name }}" readonly>
                        @error('name')
                            <span class="text-xs text-red-800">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col">
                        <label for="details" class="form-label">Description (optional)</label>
                        <textarea name="details" id="details" rows="4" class="px-4 py-2 rounded-lg border border-stone-300" placeholder="What does this task involve?" readonly>{{ $task->details ?? '' }}</textarea>
                    </div>

                    <div class="flex gap-3">
                        <div class="flex-1 flex flex-col">
                            @php
                                $time = substr($task->etc, 0, 5);
                            @endphp
                            <label for="etc" class="form-label">ETC</label>
                            <select name="etc" id="etc" class="px-4 py-2 rounded-lg border border-stone-300 appearance-none pointer-events-none">
                                <option value="0:30" @if($time == '0:30') selected @endif>30 min</option>
                                <option value="1:00" @if($time == '1:00') selected @endif>1 hr</option>
                                <option value="1:30" @if($time == '1:30') selected @endif>1 hr 30 min</option>
                                <option value="2:00" @if($time == '2:00') selected @endif>2 hrs</option>
                            </select>
                        </div>
                        <div class="flex-1 flex flex-col">
                            @php
                                $dateScheduled = date('Y-m-d', strtotime($task->date_schedule));
                            @endphp
                            <label for="date_schedule" class="form-label">Date scheduled</label>
                            <input type="date" id="date_schedule" name="date_schedule" class="px-4 py-2 rounded-lg border border-stone-300" value="{{ $dateScheduled }}" readonly>
                        </div>
                    </div>

                    <div class="flex-1 flex flex-col">
                        @php
                            $isPending = $task->status == 'pending';
                            $isInProgress = $task->status == 'in_progress';
                        @endphp
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="px-4 py-2 rounded-lg border border-stone-300 appearance-none">
                            @if (!$isInProgress && $isPending)
                                <option value="pending" selected @if($isPending) hidden @endif>Pending</option>
                            @endif
                            <option value="in_progress" @if($isInProgress) hidden @endif>In Progress</option>
                            @if (!$isPending)
                                <option value="completed">Completed</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-footer flex gap-3">
                        <button class="primary-btn shadow-xs" type="submit">Save changes</button>
                        <a href="{{ route('tasks') }}" class="primary-btn shadow-xs">Cancel</a>
                    </div>
                </form>
            </x-formwrapper>
        </div>
    </x-wholepagewrapper>
@endsection