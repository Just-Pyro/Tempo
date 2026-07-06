
@props(['pageName' => 'No Page Name', 'link' => '#'])

@php
    $page = request()->route()->getName();

    $isActive = false;

    if (strtolower($page) == strtolower($pageName)) $isActive = true;

    $isLogout = strtolower($pageName) == "log out";
@endphp

<div class="@if($isActive) active @endif group page-tab-wrapper text-stone-500 hover:text-white hover:bg-[#1e1e1e] rounded-lg px-5 py-3 flex items-center gap-4 @if($isLogout) mt-auto @endif">
    <div class="page-tab-icon text-stone-500 @if($isLogout) group-hover:text-red-500 @else group-hover:text-accent @endif flex items-center text-lg">
        {{ $slot }}
    </div>

    @if ($isLogout)
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button class="m-0 p-0" type="submit">{{ $pageName }}</button>
        </form>
    @else
        <p class="m-0 p-0">{{ $pageName }}</p>
    @endif
</div>