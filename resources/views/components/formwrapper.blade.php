@props(['class' => ''])

<div class="bg-white border border-stone-300 rounded-2xl p-8 {{ $class }}">
    {{ $slot }}
</div>