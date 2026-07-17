@props(['page' => ''])

<div class="sidebar bg-[#111] h-full w-[265px] flex flex-col p-5 gap-2 @if($page != "") justify-between @endif">
    <x-logo />

    @if ($page != "")
        <div class="flex flex-col gap-5">
            @if ($page == 'register')
                <x-tbeatregister />
            @else
                <x-tbeatlogin />
            @endif
        
            <div>
                <p class="text-gray-500 text-sm">Track your tasks.</p>
                <p class="text-gray-500 text-sm">Own your time.</p>
            </div>
        </div>
    @else
        <a href="{{ route('dashboard') }}">
            <x-pagetab pageName="Dashboard">
                <i class="fa-solid fa-table-columns"></i>
            </x-pagetab>
        </a>
        <a href="{{ route('tasks') }}">
            <x-pagetab pageName="Tasks">
                <i class="fa-solid fa-clipboard-check"></i>
            </x-pagetab>
        </a>

        <a href="{{ route('tasks.archive.list') }}">
            <x-pagetab pageName="Archives">
                <i class="fa-solid fa-box-archive"></i>
            </x-pagetab>
        </a>

        <x-pagetab pageName="Log out">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
        </x-pagetab>
    @endif
</div>
