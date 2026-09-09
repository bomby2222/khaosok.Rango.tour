<!DOCTYPE html>
<html lang="en" class="dark bg-[#070809] text-zinc-100 selection:bg-emerald-500 selection:text-black">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo $__env->yieldContent('title', 'COMMAND CENTER // RANGO TOUR ADMIN'); ?></title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;600;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono-code { font-family: 'JetBrains Mono', monospace; }
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: #070809; }
        ::-webkit-scrollbar-thumb { background: #1b2e25; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #10b981; }
        .emerald-glow { box-shadow: 0 0 35px -10px rgba(16, 185, 129, 0.4); }
        .emerald-text-glow { text-shadow: 0 0 16px rgba(52, 211, 153, 0.5); }
        .glass-panel {
            background: linear-gradient(135deg, rgba(16, 24, 20, 0.75) 0%, rgba(9, 11, 10, 0.9) 100%);
            backdrop-filter: blur(16px);
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#070809] text-zinc-200 flex min-h-screen antialiased overflow-x-hidden relative" x-data="{ mobileNav: false }">

    <!-- Cyber Background Glow -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-72 sm:w-[500px] h-72 sm:h-[500px] bg-emerald-500/10 rounded-full blur-[100px] sm:blur-[140px]"></div>
        <div class="absolute top-1/3 -right-40 w-60 sm:w-[400px] h-60 sm:h-[400px] bg-teal-500/5 rounded-full blur-[120px]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#10b98108_1px,transparent_1px),linear-gradient(to_bottom,#10b98108_1px,transparent_1px)] bg-[size:3rem_3rem] sm:bg-[size:4rem_4rem] opacity-30"></div>
    </div>

    <!-- Mobile Drawer Overlay Backdrop -->
    <div x-show="mobileNav" 
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileNav = false" 
         x-cloak 
         class="fixed inset-0 bg-black/80 backdrop-blur-sm z-40 lg:hidden">
    </div>

    <!-- RESPONSIVE SIDEBAR -->
    <aside :class="mobileNav ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed lg:static inset-y-0 left-0 w-72 bg-[#0a0c0e]/98 backdrop-blur-2xl border-r border-emerald-500/15 flex flex-col justify-between shrink-0 z-50 transition-transform duration-300 ease-in-out shadow-2xl overflow-y-auto">
        <div>
            <!-- Branding -->
            <div class="h-20 sm:h-24 flex items-center justify-between px-6 border-b border-emerald-500/10">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-3.5">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-900 p-0.5 shadow-lg shadow-emerald-500/30 flex items-center justify-center">
                        <div class="w-full h-full bg-[#090b0d] rounded-[14px] flex items-center justify-center">
                            <span class="text-emerald-400 font-black text-lg emerald-text-glow">R</span>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-lg font-black tracking-tight text-white">RANGO</span>
                            <span class="text-[9px] font-black uppercase tracking-widest bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 px-1.5 py-0.5 rounded">HUB</span>
                        </div>
                        <p class="text-[9px] font-mono-code font-bold uppercase tracking-widest text-emerald-400/80">Command OS</p>
                    </div>
                </a>

                <button @click="mobileNav = false" class="lg:hidden p-2 text-zinc-400 hover:text-white hover:bg-zinc-900 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="px-4 py-5 space-y-6">
                <!-- Section 1: Core Command -->
                <div>
                    <span class="px-3 text-[10px] font-mono-code uppercase font-bold tracking-widest text-zinc-500 block mb-2">// CORE COMMAND</span>
                    <nav class="space-y-1">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" @click="mobileNav = false" 
                           class="flex items-center justify-between px-3.5 py-2.5 sm:py-3 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all duration-200 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-emerald-500 text-neutral-950 font-black shadow-lg shadow-emerald-500/25' : 'text-zinc-400 hover:text-white hover:bg-zinc-900'); ?>">
                            <div class="flex items-center gap-3">
                                <span>📊</span> Dashboard
                            </div>
                        </a>

                        <!-- Live Chat Hub -->
                        <a href="<?php echo e(route('admin.chats.index')); ?>" @click="mobileNav = false" 
                           class="flex items-center justify-between px-3.5 py-2.5 sm:py-3 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all duration-200 <?php echo e(request()->routeIs('admin.chats.*') ? 'bg-emerald-500 text-neutral-950 font-black shadow-lg shadow-emerald-500/25' : 'text-zinc-400 hover:text-white hover:bg-zinc-900'); ?>">
                            <div class="flex items-center gap-3">
                                <span>💬</span> Live Chat Hub
                            </div>
                            <span class="flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[9px] font-mono-code font-bold <?php echo e(request()->routeIs('admin.chats.*') ? 'bg-black text-emerald-400' : 'bg-emerald-500/20 text-emerald-300'); ?>">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> LIVE
                            </span>
                        </a>
                    </nav>
                </div>

                <!-- Section 2: Showcases & Itineraries -->
                <div>
                    <span class="px-3 text-[10px] font-mono-code uppercase font-bold tracking-widest text-zinc-500 block mb-2">// SHOWCASES &amp; ITINERARIES</span>
                    <nav class="space-y-1">
                        <!-- Hero 3-Slides -->
                        <a href="<?php echo e(route('admin.banners.index')); ?>" @click="mobileNav = false" 
                           class="flex items-center justify-between px-3.5 py-2.5 sm:py-3 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all duration-200 <?php echo e(request()->routeIs('admin.banners.*') ? 'bg-emerald-500 text-neutral-950 font-black shadow-lg shadow-emerald-500/25' : 'text-zinc-400 hover:text-white hover:bg-zinc-900'); ?>">
                            <div class="flex items-center gap-3">
                                <span>🖼️</span> Hero Banners
                            </div>
                            <span class="text-[9px] font-mono-code opacity-70 font-semibold">3-Slides</span>
                        </a>

                        <!-- Tour Packages -->
                        <a href="<?php echo e(route('admin.tours.index')); ?>" @click="mobileNav = false" 
                           class="flex items-center justify-between px-3.5 py-2.5 sm:py-3 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all duration-200 <?php echo e(request()->routeIs('admin.tours.*') ? 'bg-emerald-500 text-neutral-950 font-black shadow-lg shadow-emerald-500/25' : 'text-zinc-400 hover:text-white hover:bg-zinc-900'); ?>">
                            <div class="flex items-center gap-3">
                                <span>🧭</span> Tour Packages
                            </div>
                            <span class="text-[9px] font-mono-code opacity-70 font-semibold">Full-Board</span>
                        </a>

                        <!-- 🛶 Welcome to Khao Sok -->
                        <a href="<?php echo e(route('admin.resorts.index')); ?>" @click="mobileNav = false" 
                           class="flex items-center justify-between px-3.5 py-2.5 sm:py-3 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all duration-200 <?php echo e(request()->routeIs('admin.resorts.*') ? 'bg-emerald-500 text-neutral-950 font-black shadow-lg shadow-emerald-500/25' : 'text-zinc-400 hover:text-white hover:bg-zinc-900'); ?>">
                            <div class="flex items-center gap-3">
                                <span>🛶</span> Welcome to Khao Sok
                            </div>
                            <span class="px-1.5 py-0.5 rounded text-[8px] font-mono-code font-bold <?php echo e(request()->routeIs('admin.resorts.*') ? 'bg-black text-emerald-400' : 'bg-emerald-500/15 text-emerald-400'); ?>">
                                10 SLIDES
                            </span>
                        </a>

                        <!-- Best Tours -->
                        <a href="<?php echo e(route('admin.destinations.index')); ?>" @click="mobileNav = false" 
                           class="flex items-center justify-between px-3.5 py-2.5 sm:py-3 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all duration-200 <?php echo e(request()->routeIs('admin.destinations.*') ? 'bg-emerald-500 text-neutral-950 font-black shadow-lg shadow-emerald-500/25' : 'text-zinc-400 hover:text-white hover:bg-zinc-900'); ?>">
                            <div class="flex items-center gap-3">
                                <span>🏝️</span> Best Tours Hub
                            </div>
                            <span class="text-[9px] font-mono-code opacity-70 font-semibold">Landmarks</span>
                        </a>

                        <!-- 🚕 Taxi & Transfers (เพิ่มเมนู 4 โซนและเที่ยวรถย่อย) -->
                        <a href="<?php echo e(route('admin.taxis.index')); ?>" @click="mobileNav = false" 
                           class="flex items-center justify-between px-3.5 py-2.5 sm:py-3 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all duration-200 <?php echo e(request()->routeIs('admin.taxis.*') ? 'bg-emerald-500 text-neutral-950 font-black shadow-lg shadow-emerald-500/25' : 'text-zinc-400 hover:text-white hover:bg-zinc-900'); ?>">
                            <div class="flex items-center gap-3">
                                <span>🚕</span> Taxi &amp; Transfers
                            </div>
                            <span class="px-1.5 py-0.5 rounded text-[8px] font-mono-code font-bold <?php echo e(request()->routeIs('admin.taxis.*') ? 'bg-black text-emerald-400' : 'bg-emerald-500/15 text-emerald-400'); ?>">
                                4 ZONES
                            </span>
                        </a>

                        <!-- 🗺️ Route Maps Builder -->
                        <a href="<?php echo e(route('admin.route-maps.index')); ?>" @click="mobileNav = false" 
                           class="flex items-center justify-between px-3.5 py-2.5 sm:py-3 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all duration-200 <?php echo e(request()->routeIs('admin.route-maps.*') ? 'bg-emerald-500 text-neutral-950 font-black shadow-lg shadow-emerald-500/25' : 'text-zinc-400 hover:text-white hover:bg-zinc-900'); ?>">
                            <div class="flex items-center gap-3">
                                <span>🗺️</span> Route Maps Builder
                            </div>
                            <span class="px-1.5 py-0.5 rounded text-[8px] font-mono-code font-bold <?php echo e(request()->routeIs('admin.route-maps.*') ? 'bg-black text-emerald-400' : 'bg-emerald-500/15 text-emerald-400'); ?>">
                                GPS PATH
                            </span>
                        </a>

                        <!-- Reviews -->
                        <a href="<?php echo e(route('admin.reviews.index')); ?>" @click="mobileNav = false" 
                           class="flex items-center justify-between px-3.5 py-2.5 sm:py-3 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all duration-200 <?php echo e(request()->routeIs('admin.reviews.*') ? 'bg-emerald-500 text-neutral-950 font-black shadow-lg shadow-emerald-500/25' : 'text-zinc-400 hover:text-white hover:bg-zinc-900'); ?>">
                            <div class="flex items-center gap-3">
                                <span>⭐</span> Customer Reviews
                            </div>
                        </a>
                    </nav>
                </div>

                <!-- Section 3: Configuration & System -->
                <div>
                    <span class="px-3 text-[10px] font-mono-code uppercase font-bold tracking-widest text-zinc-500 block mb-2">// CONFIGURATION</span>
                    <nav class="space-y-1">
                        <a href="<?php echo e(route('admin.settings.index')); ?>" @click="mobileNav = false" 
                           class="flex items-center justify-between px-3.5 py-2.5 sm:py-3 rounded-2xl text-xs font-bold uppercase tracking-wider transition-all duration-200 <?php echo e(request()->routeIs('admin.settings.*') ? 'bg-emerald-500 text-neutral-950 font-black shadow-lg shadow-emerald-500/25' : 'text-zinc-400 hover:text-white hover:bg-zinc-900'); ?>">
                            <div class="flex items-center gap-3">
                                <span>⚙️</span> Settings &amp; Video
                            </div>
                            <span class="text-[9px] font-mono-code opacity-70">Social &amp; Popup</span>
                        </a>

                        <a href="<?php echo e(route('route.map')); ?>" target="_blank" 
                           class="flex items-center justify-between px-3.5 py-2.5 sm:py-3 rounded-2xl text-xs font-bold uppercase tracking-wider text-zinc-400 hover:text-white hover:bg-zinc-900 transition">
                            <div class="flex items-center gap-3">
                                <span>🌐</span> Live Route Map
                            </div>
                            <span class="text-xs font-mono-code text-zinc-500">↗</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- User Profile & System Controls -->
        <div class="p-4 border-t border-emerald-500/10 bg-[#07080a] space-y-2.5">
            <form action="<?php echo e(route('admin.flushCache')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" 
                        class="w-full flex items-center justify-between px-4 py-2.5 rounded-2xl bg-zinc-900/80 hover:bg-emerald-500/20 hover:text-emerald-300 text-zinc-400 text-xs font-mono-code transition border border-zinc-800">
                    <span class="flex items-center gap-2">
                        <span>🧹</span> Flush System Cache
                    </span>
                    <span class="text-[10px] text-zinc-600 font-bold">CLEAR</span>
                </button>
            </form>

            <a href="<?php echo e(route('home')); ?>" target="_blank" 
               class="w-full flex items-center justify-between px-4 py-2.5 rounded-2xl bg-zinc-900 hover:bg-zinc-800 text-emerald-400 text-xs font-bold uppercase tracking-wider border border-emerald-500/20 transition">
                <span class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Live Site
                </span>
                <span>↗</span>
            </a>

            <div class="flex items-center justify-between p-2 rounded-2xl bg-black/50 border border-zinc-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-[11px] font-mono-code">AD</div>
                    <span class="text-xs font-bold text-white">Administrator</span>
                </div>
                <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" title="Logout" class="p-1.5 text-zinc-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- MAIN VIEWPORT -->
    <div class="flex-grow flex flex-col min-w-0 z-10 w-full">
        <header class="h-16 sm:h-20 bg-[#0a0c0e]/90 backdrop-blur-xl border-b border-emerald-500/10 px-4 sm:px-8 lg:px-10 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-3 sm:gap-4">
                <button @click="mobileNav = true" class="lg:hidden p-2 rounded-xl bg-zinc-900 border border-emerald-500/30 text-emerald-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <div class="w-2 h-5 sm:h-6 bg-emerald-500 rounded-full emerald-glow hidden sm:block"></div>
                <h1 class="text-sm sm:text-base lg:text-lg font-black uppercase tracking-wider text-white truncate max-w-[200px] sm:max-w-none">
                    <?php echo $__env->yieldContent('header', 'COMMAND OVERVIEW'); ?>
                </h1>
            </div>

            <div class="flex items-center gap-2 bg-zinc-900 border border-emerald-500/20 px-3 py-1.5 rounded-full shrink-0">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span class="text-[10px] sm:text-[11px] font-mono-code font-bold text-emerald-400 uppercase">ONLINE</span>
            </div>
        </header>

        <main class="p-4 sm:p-6 lg:p-10 max-w-[1400px] w-full flex-grow mx-auto">
            <?php if(session('success')): ?>
                <div class="mb-6 p-4 bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 rounded-2xl flex items-center gap-3 text-xs font-bold shadow-lg">
                    <span>✅</span> <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <footer class="px-6 sm:px-10 py-5 border-t border-emerald-500/10 flex flex-col sm:flex-row items-center justify-between text-[10px] sm:text-[11px] font-mono-code text-zinc-500 gap-2 text-center sm:text-left">
            <span>RANGO TOUR OS // LUXURY DARK EMERALD</span>
            <span class="text-emerald-500/80">LATENCY: 0.12ms • SECURED</span>
        </footer>
    </div>

</body>
</html><?php /**PATH C:\xampp\htdocs\rango-tour\resources\views/layouts/admin.blade.php ENDPATH**/ ?>