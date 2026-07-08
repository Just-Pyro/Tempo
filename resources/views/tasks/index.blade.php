@extends('layout.app')

@section('content')
    <x-wholepagewrapper class="bg-[#f9fafb]">
        <x-sidebar />
        <div class="flex-1 px-8 py-12 flex flex-col gap-5">
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
        </div>
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
                    { data: "date_schedule", name: "date_schedule"},
                    { data: "etc", name: "etc"},
                    { data: "atc", name: "atc"},
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