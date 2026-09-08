<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* Smooth transition */
        html {
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        /* Custom dark mode improvements for table */
        [data-bs-theme="dark"] .table {
            --bs-table-bg: transparent;
            --bs-table-hover-bg: rgba(255, 255, 255, 0.04);
        }

        [data-bs-theme="dark"] .card {
            background-color: #1e1e2d;
            border-color: #2b2b40 !important;
        }

        [data-bs-theme="dark"] .bg-light {
            background-color: #151521 !important;
        }

        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .input-group-text {
            background-color: #151521;
            border-color: #2b2b40;
            color: #e0e0e0;
        }

        [data-bs-theme="dark"] .form-control:focus {
            background-color: #151521;
            border-color: #667eea;
            color: #fff;
        }
    </style>
</head>

<body>
    {{-- Theme Toggle Button (top right) --}}
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <button id="theme-toggle"
            class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center"
            style="width: 42px; height: 42px;" title="Toggle Dark/Light Mode">
            {{-- Sun Icon (shown in dark mode) --}}
            <svg id="icon-sun" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                viewBox="0 0 16 16" style="display: none;">
                <path
                    d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
            </svg>

            {{-- Moon Icon (shown in light mode) --}}
            <svg id="icon-moon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                viewBox="0 0 16 16">
                <path
                    d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
            </svg>
        </button>
    </div>

    {{ $slot }}

    @livewireScripts

    <script>
        // Theme Toggle Logic
        const html = document.documentElement;
        const toggleBtn = document.getElementById('theme-toggle');
        const iconSun = document.getElementById('icon-sun');
        const iconMoon = document.getElementById('icon-moon');

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', savedTheme);
        updateIcons(savedTheme);

        toggleBtn.addEventListener('click', () => {
            const current = html.getAttribute('data-bs-theme');
            const next = current === 'light' ? 'dark' : 'light';

            html.setAttribute('data-bs-theme', next);
            localStorage.setItem('theme', next);
            updateIcons(next);
        });

        function updateIcons(theme) {
            if (theme === 'dark') {
                iconSun.style.display = 'block';
                iconMoon.style.display = 'none';
            } else {
                iconSun.style.display = 'none';
                iconMoon.style.display = 'block';
            }
        }
    </script>
</body>

</html>