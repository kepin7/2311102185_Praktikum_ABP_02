<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inventaris') — Toko Cokomi & Wowo</title>

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .nav-active {
            background-color: #f0fdf4;
            color: #16a34a;
            font-weight: 600;
        }

        .nav-active svg {
            color: #16a34a;
        }

        .badge-green {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-yellow {
            background: #fef9c3;
            color: #a16207;
        }

        .badge-red {
            background: #fee2e2;
            color: #dc2626;
        }
    </style>

    {{-- Stack untuk CSS tambahan dari halaman child --}}
    @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen">

    <div class="flex h-screen overflow-hidden">

        {{-- ── SIDEBAR ────────────────────────────────────────────────────────── --}}
        <aside class="w-64 bg-white border-r border-gray-100 flex flex-col shadow-sm flex-shrink-0">

            {{-- Logo --}}
            <div class="h-16 flex items-center px-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-green-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.4 5.6A2 2 0 007.5 21h9a2 2 0 001.9-2.4L17 13" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 text-sm leading-tight">Toko Cokomi</p>
                        <p class="text-xs text-gray-400">& Mas Wowo</p>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <a href="{{ route('products.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:bg-gray-50 transition
                      {{ request()->routeIs('products.*') ? 'nav-active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                    </svg>
                    Inventaris Produk
                </a>
            </nav>

            {{-- User Info --}}
            <div class="p-4 border-t border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-green-700 font-semibold text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs truncate">
                            @if (Auth::user()->hasRole('admin'))
                                <span class="text-green-600 font-medium">● Admin</span>
                            @elseif(Auth::user()->hasRole('staff'))
                                <span class="text-blue-600 font-medium">● Staff</span>
                            @else
                                <span class="text-purple-600 font-medium">● Customer</span>
                            @endif
                        </p>
                    </div>
                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Logout"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- ── MAIN CONTENT ────────────────────────────────────────────────────── --}}
        <main class="flex-1 flex flex-col overflow-hidden">

            {{-- Top Bar --}}
            <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-6 flex-shrink-0">
                <div>
                    <h1 class="text-lg font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-gray-400">@yield('page-subtitle', 'Sistem Inventaris Toko')</p>
                </div>
            </header>

            {{-- Flash Messages --}}
            <div class="px-6 pt-4">
                @if (session('success'))
                    <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm mb-0"
                        id="flash-success">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                        </svg>
                        {{ session('success') }}
                        <button onclick="document.getElementById('flash-success').remove()"
                            class="ml-auto text-green-400 hover:text-green-600">✕</button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm mb-0"
                        id="flash-error">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" />
                        </svg>
                        {{ session('error') }}
                        <button onclick="document.getElementById('flash-error').remove()"
                            class="ml-auto text-red-400 hover:text-red-600">✕</button>
                    </div>
                @endif
            </div>

            {{-- Page Content --}}
            <div class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Scripts --}}
    <script>
        setTimeout(() => {
            ['flash-success', 'flash-error'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.remove();
            });
        }, 5000);
    </script>

    {{-- Stack untuk JS tambahan dari halaman child --}}
    @stack('scripts')

</body>

</html>
