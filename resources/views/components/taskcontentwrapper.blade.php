@props(['class' => ''])

<div class="flex-1 px-8 py-12 overflow-x-hidden overflow-y-auto {{ $class }}">
    {{ $slot }}
</div>