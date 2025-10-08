<x-guest-layout :title="$title" :description="$description">
    <div>
        <section class="py-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="inline-block px-3 py-1 bg-slate-100 dark:bg-slate-800 rounded-full text-xs font-medium">Modern School Management</div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">All-in-One Academic<br/>Schedule & Facility Management</h1>
                    <p class="text-lg text-slate-600 dark:text-slate-300 max-w-xl">Streamline your institution with intelligent room monitoring, conflict-free scheduling, and real-time facility management.</p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 mt-6">
                    <a href="/register" class="px-6 py-3 bg-primary dark:text-white rounded-md inline-block text-center">Get Started</a>
                    <a href="#demo" class="px-6 py-3 border rounded-md inline-block text-center">Watch Demo</a>
                </div>

                <div class="mt-8 flex space-x-8">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-accent">1000+</div>
                        <div class="text-sm text-slate-500 dark:text-slate-400">Schools</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-accent">99.9%</div>
                        <div class="text-sm text-slate-500 dark:text-slate-400">Uptime</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-accent">24/7</div>
                        <div class="text-sm text-slate-500 dark:text-slate-400">Support</div>
                    </div>
                </div>
            </div>

            <div class="relative float-animation">
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary/30 to-accent/30 blur-2xl opacity-30"></div>
                <div class="relative bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg">
                    <!-- simple dashboard preview -->
                    <div class="mb-4">
                        <div class="flex items-center justify-between text-sm text-slate-500 dark:text-slate-300">
                            <span>Room A-101</span>
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs">Available</span>
                        </div>
                    </div>
                    <div class="h-2 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden mb-4">
                        <div class="h-full bg-gradient-to-r from-primary to-accent w-3/4"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="text-center p-3 bg-slate-50 dark:bg-slate-900 rounded-md">
                            <div class="text-2xl font-bold text-accent">32</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">Students</div>
                        </div>
                        <div class="text-center p-3 bg-slate-50 dark:bg-slate-900 rounded-md">
                            <div class="text-2xl font-bold text-purple-400">Math</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">Subject</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURES -->
        <section id="features" class="py-16 px-4 sm:px-6 lg:px-8 bg-slate-50 dark:bg-transparent">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold">Powerful Features</h2>
                    <p class="text-slate-600 dark:text-slate-300 mt-2">Everything you need to manage your academic facilities</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="p-6 bg-white dark:bg-slate-800 rounded-xl">
                        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center mb-4">
                            <!-- calendar icon -->
                            <x-heroicon-o-calendar class="w-6 h-6" />
                        </div>
                        <h3 class="font-semibold mb-2">Smart Scheduling</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Automatic conflict detection and resolution. Never double-book a room or teacher again.</p>
                    </div>

                    <div class="p-6 bg-white dark:bg-slate-800 rounded-xl">
                        <div class="w-12 h-12 bg-accent/10 rounded-lg flex items-center justify-center mb-4">
                            <!-- eye icon -->
                            <x-heroicon-o-eye class="w-6 h-6 text-accent" />
                        </div>
                        <h3 class="font-semibold mb-2">Real-Time Monitoring</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Track room occupancy in real-time with IoT integration or manual check-ins.</p>
                    </div>

                    <div class="p-6 bg-white dark:bg-slate-800 rounded-xl">
                        <div class="w-12 h-12 bg-purple-500/10 rounded-lg flex items-center justify-center mb-4">
                            <!-- chart icon -->
                            <div class="w-6 h-6 text-purple-400"><x-heroicon-o-chart-bar /></div>
                        </div>
                        <h3 class="font-semibold mb-2">Analytics & Reports</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Comprehensive utilization reports and insights for data-driven decisions.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center bg-slate-50 dark:bg-slate-800 p-10 rounded-2xl">
                <h2 class="text-2xl md:text-3xl font-bold">Ready to Transform Your School?</h2>
                <p class="text-slate-600 dark:text-slate-300 mt-3">Join hundreds of institutions already using SpaceLab to streamline their operations</p>
                <div class="mt-6 flex justify-center gap-4">
                    <a href="/register" class="px-5 py-3 bg-primary dark:text-white rounded-md">Get Started</a>
                    <a href="#contact" class="px-5 py-3 border rounded-md">Schedule a Demo</a>
                </div>
            </div>
        </section>
    </div>
</x-guest-layout>