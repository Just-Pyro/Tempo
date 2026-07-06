@extends('layout.app')

@section('content')
    <x-wholepagewrapper class="bg-[#f9fafb]">
        <x-sidebar />
        <div class="flex-1 px-8 py-12">
            <a href="{{ route('tasks.create') }}" class="primary-btn float-end"><i class="fa-solid fa-plus"></i> New Task</a>
            <h1 class="text-2xl font-medium">Tasks</h1>
        </div>
    </x-wholepagewrapper>
@endsection