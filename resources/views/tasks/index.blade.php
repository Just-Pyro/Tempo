@extends('layout.app')

@section('content')
    <x-wholepagewrapper class="bg-[#f9fafb]">
        <x-sidebar />
        <x-taskcontentwrapper class="flex flex-col gap-5">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-medium">Tasks</h1>
                <a href="{{ route('tasks.create') }}" class="primary-btn"><i class="fa-solid fa-plus"></i> New Task</a>
            </div>
    
            <div class="bg-white rounded-2xl border border-stone-300">
                <table id="tasks-table" class="table-auto border-y !border-stone-300">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Date</th>
                            <th>ETC</th>
                            <th>ATC</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-taskcontentwrapper>
    </x-wholepagewrapper>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#tasks-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tasks.datatable') }}",
                pagingType: "simple_numbers",
                columns: [
                    { data: "name", name: "name"},
                    { data: "date_schedule", name: "date_schedule", searchable: false},
                    { data: "etc", name: "etc", searchable: false},
                    { data: "atc", name: "atc", searchable: false},
                    { data: "status", name: "status"},
                    { data: "action", name: "action", orderable: false, searchable: false},
                ],
                language: {
                    lengthMenu: "Show _MENU_ entries",
                    zeroRecords: "No matching tasks found",
                    paginate: {
                        next: "Next",
                        previous: "Previous"
                    }
                },
                initComplete: function () {
                    $('.dt-column-order').each(function() {
                        $(this).html(
                            '<i class="fa-solid fa-chevron-up dt-sort-asc-icon"></i>' +
                            '<i class="fa-solid fa-chevron-down dt-sort-desc-icon"></i>'
                        );
                    });
                }
            });

            console.log('db version: ', $.fn.dataTable.version);
        });
    </script>
@endpush