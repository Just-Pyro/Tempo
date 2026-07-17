@props(['id'])

<div class="bg-white rounded-2xl border border-stone-300">
    <table id="{{ $id }}" class="table-auto border-y !border-stone-300">
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