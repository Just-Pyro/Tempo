@props(['class' => ''])

<div class="relative w-dvw h-dvh flex {{ $class }}">
    {{ $slot }}

    @if (session('status'))
        <x-session-message :status="session('status')" :title="session('title')" :message="session('message')" />
    @endif
</div>

<script>
    $(function() {
        setTimeout(() => {
            $('.toast').fadeOut(400, function() {
                $(this).remove();
            });
        }, 3000);

        $(document).on('click', '.toast-close', function() {
            console.log("toast-close clicked");
            $(this).closest('.toast').fadeOut(400, function() {
                $(this).remove();
            });
        });
    });
</script>