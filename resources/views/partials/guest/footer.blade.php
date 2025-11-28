<footer class="mt-12 border-t border-slate-200 dark:border-slate-800 dark:bg-slate-950 py-12">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Grid: mobile 1 kolom, md 2 kolom, lg 3 kolom -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start">
      <!-- Brand / Deskripsi -->
      <div class="flex items-start gap-4">
        <div class="w-10 h-10 bg-gradient-to-br from-primary to-accent rounded-md flex-shrink-0"></div>
        <div class="min-w-0">
          <div class="font-semibold text-slate-900 dark:text-slate-100">SpaceLab</div>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400 max-w-xs">
            Platform terpadu untuk mengelola jadwal pelajaran, ruangan, guru, dan siswa secara efisien — tanpa konflik jadwal dan laporan manual.
          </p>
        </div>
      </div>

      <!-- Navigasi / Links -->
      <nav class="flex justify-center md:justify-start items-center">
        <ul class="flex flex-wrap justify-center md:justify-start gap-3 text-sm text-slate-600 dark:text-slate-300">
          <li><a href="#features" class="hover:text-accent transition">Fitur</a></li>
          <li><a href="#how-it-works" class="hover:text-accent transition">Cara Kerja</a></li>
          <li><a href="#benefits" class="hover:text-accent transition">Keunggulan</a></li>
          <li><a href="#faqs" class="hover:text-accent transition">FAQ</a></li>
        </ul>
      </nav>

      <!-- Copyright / Crafted / Sosial -->
      <div class="flex flex-col items-center md:items-end text-center md:text-right gap-4">
        <div class="text-sm text-slate-500 dark:text-slate-400">&copy; {{ date('Y') }} SpaceLab. All rights reserved.</div>

        <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
          <span class="sr-only">Crafted with</span>
          <x-heroicon-s-heart class="w-4 h-4 text-red-800 dark:text-red-200" fill="currentColor" />
          <span>by <a href="https://github.com/habibiahmada" class="underline">Habibi Ahmad Aziz</a></span>
        </div>

        <div class="flex items-center gap-3">
          <a href="#" class="hover:text-accent text-sm" aria-label="Twitter">Twitter</a>
          <a href="#" class="hover:text-accent text-sm" aria-label="LinkedIn">LinkedIn</a>
          <a href="#" class="hover:text-accent text-sm" aria-label="GitHub">GitHub</a>
        </div>
      </div>
    </div>
  </div>
</footer>