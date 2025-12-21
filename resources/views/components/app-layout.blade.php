@props(['title', 'rightSidebar' => true])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('components.head')
</head>

<body class="bg-brand-dark text-slate-300 font-sans antialiased selection:bg-brand-accent selection:text-brand-dark">
    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 pt-6 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

            @include('components.left-sidebar')

            <main class="col-span-1 md:col-span-9 {{ $rightSidebar ? 'lg:col-span-7' : 'lg:col-span-10' }} space-y-4">
                {{ $slot }}
            </main>

            @if ($rightSidebar)
                @include('components.right-sidebar')
            @endif

        </div>
    </div>

    @include('components.bottom')
</body>

</html>
