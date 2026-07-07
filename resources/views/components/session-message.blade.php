@props(['status', 'title', 'message'])

@php
    $borderColor = ['success' => 'border-green-300', 'warning' => 'border-yellow-300', 'error' => 'border-red-300'];
    $bgColor = ['success' => 'bg-green-100', 'warning' => 'bg-yellow-100', 'error' => 'bg-red-100'];
    $icon = ['success' => 'fa-check' , 'warning' => 'fa-triangle-exclamation', 'error' => 'fa-xmark'];
    $iconBgColor = ['success' => 'bg-green-200', 'warning' => 'bg-yellow-200', 'error' => 'bg-red-200'];
    $textColor = ['success' => 'text-green-700', 'warning' => 'text-yellow-700', 'error' => 'text-red-700'];
@endphp

<div class="toast absolute top-3 right-3 shadow-xl border {{ $borderColor[$status] }} rounded-lg {{ $bgColor[$status] }} flex p-4 gap-2 {{ $textColor[$status] }}">
    <div class="text-xs">
        <div class="w-6 h-6 rounded-full flex items-center justify-center {{ $iconBgColor[$status] }}">
            <i class="fa-solid {{ $icon[$status] }}"></i>
        </div>
    </div>
    <div>
        <h3 class="font-bold text-sm">{{ $title }}</h3>
        <p class="font-medium text-xs">{{ $message }}</p>
    </div>
    <div class="text-sm text-gray-300 hover:text-gray-400">
        <div class="cursor-pointer toast-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </div>
</div>