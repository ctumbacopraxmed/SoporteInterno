<!DOCTYPE html>
<html lang="es" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="<?php echo RUTA_WEB; ?>/assets/images/logos/favicon.png" />
    <title><?php echo NOMBRE; ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="<?php echo RUTA_WEB; ?>/assets/css/style.css">
</head>

<body class="h-full bg-gray-50 transition-colors duration-300">
    <div class="flex h-screen">
        <div id="sidebar-overlay" class=""></div>
        <!-- Sophisticated Sidebar -->
        <div id="sidebar" class="w-72 bg-white shadow-premium border-r border-gray-200 select-none">
            <div class="flex flex-col h-full">
                <!-- Logo and Close Button Section -->
                <div class="p-6 border-b border-gray-200 flex justify-between items-center h-[85px]">
                    <div>
                        <a href="<?php echo RUTA_WEB; ?>/Dashboard" class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-cyan-800 rounded-xl flex items-center justify-center">
                                <i data-lucide="MonitorCog" class="w-6 h-6 text-white"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-display font-bold text-cyan-800"><?= NOMBRE ?></h1>
                                <p class="text-sm font-body text-gray-500">Ecuasanitas S.A.</p>
                            </div>
                        </a>
                    </div>
                    <button id="sidebar-close" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto py-6 px-4 custom-scrollbar">
                    <ul class="space-y-2">
                        <li>
                            <a href="<?php echo RUTA_WEB; ?>/Dashboard" class="<?= $this->clase == 'Dashboard' ? ACTIVE : INACTIVE ?>">
                                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo RUTA_WEB; ?>/Servidores" class="<?= $this->clase == 'Servidores' ? ACTIVE : INACTIVE ?>">
                                <i data-lucide="Server" class="w-5 h-5"></i>
                                <span>Servidores</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="<?= $this->clase == 'Aplicaciones' ? ACTIVE : INACTIVE ?>">
                                <i data-lucide="AppWindow" class="w-5 h-5"></i>
                                <span>Aplicaciones</span>
                            </a>
                        </li>
                        <li>
                            <button class="flex items-center justify-between w-full px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium transition-all duration-200 dropdown-toggle">
                                <div class="flex items-center space-x-3">
                                    <i data-lucide="Settings" class="w-5 h-5"></i>
                                    <span>Configuración</span>
                                </div>
                                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200"></i>
                            </button>
                            <ul class="mt-1 space-y-1 hidden">
                                <li>
                                    <a href="#" class="px-4 py-2 rounded-lg text-gray-600  hover:bg-gray-50  hover:text-gray-900  transition-all duration-200 flex items-center space-x-3">
                                        <i data-lucide="UserLock" class="w-5 h-5 text-gray-600 "></i>
                                        <span>Usuarios</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="px-4 py-2 rounded-lg text-gray-600  hover:bg-gray-50  hover:text-gray-900  transition-all duration-200 flex items-center space-x-3">
                                        <i data-lucide="SquareTerminal" class="w-5 h-5 text-gray-600 "></i>
                                        <span>Comandos</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>

                <!-- User Profile -->
                <div class="border-t border-gray-200  h-20 flex items-center p-4">
                    <div class="flex items-center space-x-3 p-3 rounded-xl bg-gray-50  w-full">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-sm"><?= $_SESSION['ctini'] ?></span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-display font-semibold text-gray-900 "><?= $_SESSION['ctname'] ?></p>
                            <p class="text-xs font-body text-gray-500 ">Analista de Sistemas</p>
                        </div>
                        <a href="<?php echo RUTA_WEB; ?>/Logout"><i data-lucide="log-out" class="w-4 h-4 text-gray-400"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white  shadow-sm border-b border-gray-200  px-4 sm:px-6 py-4 h-[85px] select-none">
                <div class="flex items-center justify-between flex-wrap gap-4 header-content">
                    <div class="flex items-center flex-1 min-w-0">
                        <!-- Hamburger Menu Button (visible on mobile/tablet) -->
                        <button id="sidebar-toggle" class="hamburger-btn mr-3 p-2 rounded-lg hover:bg-gray-100 ">
                            <i data-lucide="menu" class="w-5 h-5 "></i>
                        </button>
                        <div class="min-w-0">
                            <h2 class="text-xl sm:text-2xl font-display font-bold text-gray-900  truncate"><?= $this->clase ?></h2>
                            <p class="text-xs sm:text-sm font-body text-gray-500  mt-1 truncate"><?= $this->description ?? '' ?></p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 sm:space-x-3 header-actions flex-shrink-0">
                        <!-- Notification Dropdown -->
                        <div class="relative">
                            <button id="notification-btn" class="relative p-2 text-gray-400 hover:text-gray-600  transition-colors">
                                <i data-lucide="bell" class="w-5 h-5"></i>
                                <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                            </button>

                            <!-- Notification Dropdown Menu -->
                            <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white  rounded-2xl shadow-lg border border-gray-200  z-50 py-2 glass-effect">
                                <div class="px-4 py-2 border-b border-gray-200  flex justify-between items-center">
                                    <h3 class="font-display font-semibold text-gray-900 ">Notificaciones</h3>
                                    <button class="text-xs text-primary-600 hover:text-primary-700   font-medium">Marcar todas como leidas</button>
                                </div>
                                <div class="max-h-96 overflow-y-auto custom-scrollbar">
                                    <div class="px-4 py-3 hover:bg-gray-50  cursor-pointer">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                                <i data-lucide="calendar" class="w-5 h-5 text-white"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900  truncate">New appointment scheduled</p>
                                                <p class="text-xs text-gray-500  mt-1">John Smith booked an appointment for tomorrow at 10:00 AM</p>
                                                <p class="text-xs text-gray-400  mt-1">2 minutes ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="relative">
                            <button id="settings-btn" class="p-2 text-gray-400 hover:text-gray-600  transition-colors">
                                <i data-lucide="settings" class="w-5 h-5"></i>
                            </button>

                            <!-- Settings Dropdown Menu -->
                            <div id="settings-dropdown" class="hidden absolute right-0 mt-2 w-64 bg-white  rounded-2xl shadow-lg border border-gray-200  z-50 py-2 glass-effect">
                                <div class="px-4 py-2 border-b border-gray-200 ">
                                    <h3 class="font-display font-semibold text-gray-900 ">Ajustes</h3>
                                </div>
                                <div class="py-2">
                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700  hover:bg-gray-50 ">
                                        <i data-lucide="user" class="w-4 h-4 mr-3"></i>
                                        Mi Perfil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Search Bar (hidden by default) -->
                <div id="mobile-search-container" class="hidden bg-white absolute left-0 w-full right-0 px-4 pb-2 top-[75px] z-[999]">
                    <div class="relative">
                        <input type="search" placeholder="Search..."
                            class="w-full px-4 py-2 pl-10 pr-4 border border-gray-200  rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent font-body bg-white  text-gray-900  focus:outline-none">
                        <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3 top-3"></i>
                    </div>
                </div>

            </header>

            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-50 ">