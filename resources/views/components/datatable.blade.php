@props(['id', 'page' => null])

<div class="bg-white rounded-2xl border border-stone-300">
    <table id="{{ $id }}" class="table-auto border-y !border-stone-300">
        <thead>
            <tr>
                <th>Task</th>
                <th>Date</th>
                <th>ETC</th>
                <th>ATC</th>
                @if (!$page)
                    <th>Status</th>
                    <th>Actions</th>
                @else
                    <th>Archived on</th>
                @endif
            </tr>
        </thead>
    </table>
</div>