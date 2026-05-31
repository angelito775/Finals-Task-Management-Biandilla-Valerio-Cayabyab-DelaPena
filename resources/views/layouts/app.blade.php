<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ config('app.name', 'Task Management System') }}</title>
        <link rel="icon" href="{{ asset('checklist.ico') }}" type="image/x-icon">
        @vite(['resources/css/app.css'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
        <div class="min-h-screen flex flex-col">
            <header class="bg-white border-b border-slate-200 sticky top-0 z-20 shadow-sm">
                <div class="max-w-7xl mx-auto px-6 py-4 flex items-center gap-4">
                    <div class="bg-indigo-100 p-3 rounded-2xl text-indigo-600 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 11l3 3L22 4" />
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold text-slate-900">TaskFlow</h1>
                        <p class="text-xs text-slate-500">Productivity Dashboard</p>
                    </div>
                </div>
            </header>

            <main class="flex-1 max-w-7xl w-full mx-auto px-6 py-8">
                @yield('content')
            </main>
        </div>
    </body>
</html>