@extends('layout.app')

@section('content')
    <x-wholepagewrapper class="bg-[#f9fafb]">
        <x-sidebar />
        <x-taskcontentwrapper class="flex flex-col gap-5">
            <div class="flex items-center">
                <h1 class="text-2xl font-medium">Archives</h1>
            </div>

            <div class="gap-6 flex">
                <p>Filter by month</p>
                <select name="filter_month" id="filter_month" class="px-4 py-2 bg-white rounded-lg border border-stone-300 flex-1">
                    <option value="all">All months</option>
                    @foreach ($months as $item)
                        <option value="{{ $item->value }}">{{ $item->month_name }} {{ $item->year }}</option>
                    @endforeach
                </select>
            </div>
    
            <x-datatable id="archive-table" page="archives" />
        </x-taskcontentwrapper>
    </x-wholepagewrapper>
@endsection

@push('scripts')
    <script>
        $(function() {
            const tokenValue = $('meta[name="csrf-token"]').attr('content');

            const archiveTable = $('#archive-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('archive.datatable') }}",
                    data: function (d) {
                        d.yearmonth = $('#filter_month').val();
                    }
                },
                pagingType: "simple_numbers",
                columns: [
                    { data: "name", name: "name"},
                    { data: "date_schedule", name: "date_schedule", searchable: false},
                    { data: "etc", name: "etc", searchable: false},
                    { data: "atc", name: "atc", searchable: false},
                    { data: "archived_date", name: "archived_date", searchable: false},
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
            
            $(document).on('change', '#filter_month', function() {
                archiveTable.ajax.reload();
            });
        });
    </script>
@endpush