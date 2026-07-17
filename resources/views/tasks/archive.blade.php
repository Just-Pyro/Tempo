@extends('layout.app')

@section('content')
    <x-wholepagewrapper class="bg-[#f9fafb]">
        <x-sidebar />
        <x-taskcontentwrapper class="flex flex-col gap-5">
            <div class="flex items-center">
                <h1 class="text-2xl font-medium">Archives</h1>
            </div>

            <div class="gap-6">
                <p>Filter by month</p>
                <select name="filter_month" id="filter_month" class="px-4 py-2 rounded-lg border border-stone-300">
                    <option value="all">All months</option>
                    @foreach ($months as $item)
                        <option value="{{ $item->value }}">{{ $item->month_name }} {{ $item->year }}</option>
                    @endforeach
                </select>
            </div>
    
            <x-datatable id="archive-table" />
        </x-taskcontentwrapper>
    </x-wholepagewrapper>
@endsection