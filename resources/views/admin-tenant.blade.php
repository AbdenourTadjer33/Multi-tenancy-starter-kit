@use('Illuminate\Support\Facades\Vite')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title inertia>{{ config('app.name') }}</title>

    <script>
        function themeMode() {
            try {
                const root = document.documentElement;

                let e = JSON.parse(localStorage.getItem('color-theme'));

                if (!e) {
                    e = 'system';
                    localStorage.setItem('color-theme', JSON.stringify(e));
                }

                if (e === 'dark' || (e === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    root.classList.add('dark');
                    return;
                }

                root.classList.remove('dark');
            } catch (e) {}
        }

        themeMode();

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => themeMode());
    </script>


    @viteReactRefresh
    {{ Vite::useBuildDirectory('themes/tenant-admin')->withEntryPoints([
        'resources/js/tenant-admin/app.tsx',
        'resources/js/tenant-admin/pages/' . $page['component'] . '.tsx',
        'resources/css/tenant-admin.css',
    ]) }}
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
