@extends('layout.app')

@section('content')
    <x-wholepagewrapper class="bg-[#f9fafb]">
        <x-sidebar />
        <x-taskcontentwrapper class="flex flex-col gap-5">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-medium">Tasks</h1>
                <a href="{{ route('tasks.create') }}" class="primary-btn"><i class="fa-solid fa-plus"></i> New Task</a>
            </div>
    
            <x-datatable id="tasks-table" />
        </x-taskcontentwrapper>
    </x-wholepagewrapper>
@endsection

@push('scripts')
    <script>
        $(function() {
            const tokenValue = $('meta[name="csrf-token"]').attr('content');

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
            
            $(document).on('click', '.archive-btn', function() {
                const taskId = $(this).data('id');

                const form = document.createElement('form');
                form.method = "POST";
                form.action = @json(route('tasks.archive'));

                const formData = new FormData();
                formData.append('_token', tokenValue);
                formData.append('id', taskId);

                for (const [key, value] of formData.entries()) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = key;
                    hiddenInput.value = value;
                    form.appendChild(hiddenInput);
                }

                document.body.appendChild(form);

                form.submit();
            });
        });
    </script>
@endpush