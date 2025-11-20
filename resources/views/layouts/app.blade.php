<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FinanceFlow - Manajemen Keuangan')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Sidebar animation */
        #sidebar {
            transition: margin-left 0.3s ease-in-out;
        }
        #sidebar.hidden-mobile {
            margin-left: -16rem;
        }
        @media (min-width: 1024px) {
            #sidebar.hidden-mobile {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white shadow-lg flex-shrink-0 lg:relative absolute h-full z-40">
            <div class="p-6 border-b">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">FinanceFlow</h1>
                        <p class="text-xs text-gray-500">Manajemen Keuangan</p>
                    </div>
                </div>
            </div>

            <nav class="p-4">
                <p class="text-xs font-semibold text-gray-400 uppercase mb-3 px-3">Menu Utama</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }} transition">
                            <i class="fas fa-home w-5"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('transactions.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('transactions.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }} transition">
                            <i class="fas fa-exchange-alt w-5"></i>
                            <span class="font-medium">Transaksi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('budgets.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('budgets.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }} transition">
                            <i class="fas fa-wallet w-5"></i>
                            <span class="font-medium">Anggaran</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('reports.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }} transition">
                            <i class="fas fa-file-alt w-5"></i>
                            <span class="font-medium">Laporan</span>
                        </a>
                    </li>
                </ul>

                @if(auth()->user()->role->value === 'admin')
                <p class="text-xs font-semibold text-gray-400 uppercase mb-3 px-3 mt-6">Admin</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }} transition">
                            <i class="fas fa-chart-bar w-5"></i>
                            <span class="font-medium">Admin Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }} transition">
                            <i class="fas fa-users-cog w-5"></i>
                            <span class="font-medium">User Management</span>
                        </a>
                    </li>
                </ul>
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b">
                <div class="flex items-center justify-between px-8 py-4">
                    <div class="flex items-center space-x-4">
                        <button id="hamburgerBtn" class="text-gray-500 hover:text-gray-700 lg:hidden">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                            <p class="text-sm text-gray-500">@yield('page-subtitle', 'Ringkasan keuangan Anda bulan ini')</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bell text-xl"></i>
                        </button>
                        <div class="relative">
                            <button id="userMenuBtn" class="flex items-center space-x-3 cursor-pointer focus:outline-none">
                                <div class="text-right hidden sm:block">
                                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role->value) }}</p>
                                </div>
                                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                                </div>
                            </button>
                            <!-- Dropdown Menu -->
                            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-2 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-user mr-2"></i> Profil
                                </a>
                                <a href="{{ route('settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-cog mr-2"></i> Pengaturan
                                </a>
                                <hr class="my-2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebarOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"></div>

    <script>
        // Hamburger menu toggle
        const sidebar = document.getElementById('sidebar');
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('hidden-mobile');
            sidebarOverlay.classList.toggle('hidden');
        }

        if (hamburgerBtn) {
            hamburgerBtn.addEventListener('click', toggleSidebar);
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', toggleSidebar);
        }

        // Default: hide sidebar on mobile
        if (window.innerWidth < 1024) {
            sidebar.classList.add('hidden-mobile');
        }

        // User dropdown menu toggle
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userDropdown = document.getElementById('userDropdown');

        if (userMenuBtn && userDropdown) {
            userMenuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
