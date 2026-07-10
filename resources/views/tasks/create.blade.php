@extends('layout.app')

@section('content')
    <x-wholepagewrapper class="bg-[#f9fafb]">
        <x-sidebar />
        <x-taskcontentwrapper>
            <div class="flex gap-3 items-center">
                <a href="{{ route('tasks') }}" class="primary-btn"><i class="fa-solid fa-arrow-left"></i> Back</a>
                <h1 class="text-2xl font-medium">New task</h1>
            </div>
    
            <x-formwrapper class="mt-8">
                <form action="{{ route('tasks.store') }}" method="POST" class="flex flex-col gap-5">
                    @csrf
                    <div class="flex flex-col">
                        <label for="name" class="form-label">Task name</label>
                        <input type="text" id="name" name="name" class="px-4 py-2 rounded-lg border @error('name') border-red-300 @else border-stone-300 @enderror" placeholder="e.g. Set up project">
                        @error('name')
                            <span class="text-xs text-red-800">{{ $message }}</span>
                        @enderror
                    </div>
    
                    <div class="flex flex-col">
                        <label for="details" class="form-label">Description (optional)</label>
                        <textarea name="details" id="details" rows="4" class="px-4 py-2 rounded-lg border border-stone-300" placeholder="What does this task involve?"></textarea>
                    </div>
    
                    <div class="flex gap-3">
                        <div class="flex-1 flex flex-col">
                            <label for="etc" class="form-label">ETC</label>
                            <select name="etc" id="etc" class="px-4 py-2 rounded-lg border border-stone-300 appearance-none">
                                <option value="0:30">30 min</option>
                                <option value="1:00">1 hr</option>
                                <option value="1:30">1 hr 30 min</option>
                                <option value="2:00">2 hrs</option>
                            </select>
                        </div>
                        <div class="flex-1 flex flex-col">
                            <label for="date_schedule" class="form-label">Date scheduled</label>
                            <input type="date" id="date_schedule" name="date_schedule" class="px-4 py-2 rounded-lg border border-stone-300" value="{{ date('Y-m-d') }}" readonly>
                        </div>
                    </div>
    
                    <hr class="border border-stone-200 mt-5">
    
                    <div class="form-footer flex gap-3">
                        <button class="primary-btn shadow-xs" type="submit">Create task</button>
                        <a href="{{ route('tasks') }}" class="primary-btn shadow-xs">Cancel</a>
                    </div>
                </form>
            </x-formwrapper>
        </x-taskcontentwrapper>
    </x-wholepagewrapper>
@endsection