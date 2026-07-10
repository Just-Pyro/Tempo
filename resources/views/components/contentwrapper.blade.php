@props(['class' => ''])

<div class="flex-1 flex justify-center items-center bg-gray-100 {{ $class }}">
    {{ $slot }}
</div>