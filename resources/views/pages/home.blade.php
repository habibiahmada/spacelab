<x-guest-layout :title="$title" :description="$description">
    @vite('resources/css/home-animations.css')
    @vite('resources/js/home-interactions.js')
<!-- HERO -->
<section class="pt-14 min-h-screen flex items-center">
  <div class="max-w-7xl mx-auto px-6 w-full">
    <div class="grid lg:grid-cols-[1.5fr_1fr] gap-0 items-stretch" style="min-height:calc(100vh - 56px)">
      <!-- Left -->
      <div class="flex flex-col justify-center py-16 lg:py-24 lg:pr-16">
        <div class="flex items-center gap-2 mb-8">
          <div class="w-2 h-2 bg-green-500"></div>
          <span class="text-[11px] font-semibold tracking-[0.2em] uppercase" style="color:var(--muted-foreground)">Platform Manajemen Sekolah</span>
        </div>
        <h1 class="hero-title mb-6">
          Kelola Sekolah,<br/>
          <span style="color:var(--primary)">Tanpa Ribet.</span>
        </h1>
        <p class="text-base leading-relaxed mb-10 max-w-[420px]" style="color:var(--muted-foreground)">
          Jadwal otomatis, deteksi konflik instan, monitoring real-time. Satu platform untuk semua kebutuhan administrasi sekolah.
        </p>
        <div class="flex flex-wrap gap-3 mb-12">
          <a href="/login" class="group inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold transition-opacity hover:opacity-90" style="background-color:var(--primary);color:var(--primary-foreground)">
            Mulai Sekarang
            <svg xmlns="http://www.w3.org/2000/svg" class="i4 gh-tx" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
          </a>
          <a href="{{ route('views.index') }}" class="inline-flex items-center gap-2 px-6 py-3 border text-sm font-semibold transition-colors hover:opacity-80" style="border-color:var(--border)">Lihat Fitur</a>
        </div>
        <!-- Stats -->
        <div class="flex gap-0 border-t" style="border-color:var(--border)">
          <div class="flex-1 py-5 pr-6">
            <div class="text-2xl font-bold">70%</div>
            <div class="text-[11px] uppercase tracking-wide mt-1" style="color:var(--muted-foreground)">Lebih Cepat</div>
          </div>
          <div class="flex-1 py-5 pl-6 border-l" style="border-color:var(--border)">
            <div class="text-2xl font-bold">0</div>
            <div class="text-[11px] uppercase tracking-wide mt-1" style="color:var(--muted-foreground)">Konflik Jadwal</div>
          </div>
          <div class="flex-1 py-5 pl-6 border-l" style="border-color:var(--border)">
            <div class="text-2xl font-bold">24/7</div>
            <div class="text-[11px] uppercase tracking-wide mt-1" style="color:var(--muted-foreground)">Akses Sistem</div>
          </div>
        </div>
      </div>
      <!-- Right: dashboard image -->
      <div class="hidden lg:flex items-center border-l p-12 pt-0" style="background-color:color-mix(in srgb,var(--secondary) 30%,transparent);border-color:var(--border)">
        <div class="w-full">
          <img src="{{ asset('assets/images/pages/neskar-ats.webp') }}" alt="SpaceLab Dashboard" class="w-full border shadow-lg" style="border-color:var(--border)" onerror="this.style.display='none'" />
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MARQUEE -->
<div class="py-3 overflow-hidden" style="background-color:var(--primary)">
  <div class="animate-marquee flex items-center gap-8 text-[11px] font-bold tracking-[0.15em] uppercase whitespace-nowrap" style="color:var(--primary-foreground)">
    <!-- 3 copies for seamless loop -->
    <span class="flex items-center gap-8 shrink-0">
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Jadwal Otomatis</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Deteksi Konflik</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Monitoring Real-time</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Laporan Analitik</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Multi Peran</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Keamanan Terjamin</span>
    </span>
    <span class="flex items-center gap-8 shrink-0">
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Jadwal Otomatis</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Deteksi Konflik</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Monitoring Real-time</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Laporan Analitik</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Multi Peran</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Keamanan Terjamin</span>
    </span>
    <span class="flex items-center gap-8 shrink-0">
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Jadwal Otomatis</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Deteksi Konflik</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Monitoring Real-time</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Laporan Analitik</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Multi Peran</span>
      <span class="flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" class="i3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14"/></svg>Keamanan Terjamin</span>
    </span>
  </div>
</div>

<!-- PROBLEM -->
<section id="masalah" class="py-24 px-6 border-b" style="border-color:var(--border)">
  <div class="max-w-[1400px] mx-auto">
    <div class="grid lg:grid-cols-[1fr_2fr] gap-16">
      <div>
        <span class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3 block" style="color:var(--primary)">Masalah</span>
        <h2 class="text-3xl lg:text-4xl font-bold leading-tight">Kenapa Sekolah Butuh SpaceLab?</h2>
      </div>
      <div class="grid md:grid-cols-3 gap-0">
        <div class="p-6 border-t md:border-t-0" style="border-color:var(--border)">
          <div class="text-[40px] font-bold mb-4" style="color:var(--border)">01</div>
          <svg xmlns="http://www.w3.org/2000/svg" class="i5 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--destructive)"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
          <h3 class="font-semibold text-lg mb-2">Konflik Jadwal</h3>
          <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Guru mengajar di dua kelas sekaligus, ruangan terpakai ganda karena penjadwalan manual.</p>
        </div>
        <div class="p-6 md:border-l border-t md:border-t-0" style="border-color:var(--border)">
          <div class="text-[40px] font-bold mb-4" style="color:var(--border)">02</div>
          <svg xmlns="http://www.w3.org/2000/svg" class="i5 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--destructive)"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
          <h3 class="font-semibold text-lg mb-2">Proses Lama</h3>
          <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Penyusunan jadwal memakan waktu berhari-hari dengan revisi berkali-kali.</p>
        </div>
        <div class="p-6 md:border-l border-t md:border-t-0" style="border-color:var(--border)">
          <div class="text-[40px] font-bold mb-4" style="color:var(--border)">03</div>
          <svg xmlns="http://www.w3.org/2000/svg" class="i5 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--destructive)"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
          <h3 class="font-semibold text-lg mb-2">Data Tidak Terintegrasi</h3>
          <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Data tersebar di berbagai file Excel, sulit dilacak dan tidak ada sinkronisasi.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SOLUTIONS -->
<section class="py-24 px-6 border-b" style="background-color:color-mix(in srgb,var(--secondary) 30%,transparent);border-color:var(--border)">
  <div class="max-w-[1400px] mx-auto">
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-16">
      <div>
        <span class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3 block" style="color:var(--primary)">Solusi</span>
        <h2 class="text-3xl lg:text-4xl font-bold">SpaceLab Menjawab Semua</h2>
      </div>
      <p class="text-sm max-w-md" style="color:var(--muted-foreground)">Sistem yang mengotomasi dan menyederhanakan seluruh proses manajemen akademik sekolah Anda.</p>
    </div>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-0 border" style="border-color:var(--border)">
      <div class="p-8 transition-colors hover:bg-[var(--card)]">
        <span class="text-[11px] font-bold tracking-[0.15em] mb-6 block" style="color:var(--primary)">01</span>
        <h3 class="font-semibold text-lg mb-3">Deteksi Konflik Otomatis</h3>
        <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Sistem otomatis mendeteksi dan mencegah bentrokan jadwal sebelum disimpan.</p>
      </div>
      <div class="p-8 lg:border-l border-t lg:border-t-0 transition-colors hover:bg-[var(--card)]" style="border-color:var(--border)">
        <span class="text-[11px] font-bold tracking-[0.15em] mb-6 block" style="color:var(--primary)">02</span>
        <h3 class="font-semibold text-lg mb-3">Penjadwalan Cepat</h3>
        <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Buat dan edit jadwal dalam hitungan menit dengan antarmuka yang intuitif.</p>
      </div>
      <div class="p-8 lg:border-l border-t lg:border-t-0 transition-colors hover:bg-[var(--card)]" style="border-color:var(--border)">
        <span class="text-[11px] font-bold tracking-[0.15em] mb-6 block" style="color:var(--primary)">03</span>
        <h3 class="font-semibold text-lg mb-3">Platform Terintegrasi</h3>
        <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Semua data tersimpan dalam satu sistem yang aman dan mudah diakses.</p>
      </div>
      <div class="p-8 lg:border-l border-t lg:border-t-0 transition-colors hover:bg-[var(--card)]" style="border-color:var(--border)">
        <span class="text-[11px] font-bold tracking-[0.15em] mb-6 block" style="color:var(--primary)">04</span>
        <h3 class="font-semibold text-lg mb-3">Monitoring Real-time</h3>
        <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Pantau penggunaan ruangan dan aktivitas sekolah melalui dashboard informatif.</p>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section id="fitur" class="py-24 px-6 border-b" style="border-color:var(--border)">
  <div class="max-w-[1400px] mx-auto">
    <div class="text-center mb-16">
      <span class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3 block" style="color:var(--primary)">Fitur</span>
      <h2 class="text-3xl lg:text-4xl font-bold">Fitur Lengkap untuk Sekolah Modern</h2>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-0 border" style="border-color:var(--border)">
      <!-- F1 -->
      <div class="group p-8 transition-colors hover:opacity-90" style="border-color:var(--border)">
        <div class="flex items-center justify-between mb-6">
          <svg xmlns="http://www.w3.org/2000/svg" class="i5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
        </div>
        <h3 class="font-semibold text-base mb-2">Manajemen Jadwal</h3>
        <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Buat dan kelola jadwal dengan antarmuka intuitif dan deteksi konflik otomatis.</p>
      </div>
      <!-- F2 -->
      <div class="group p-8 sm:border-l border-t sm:border-t-0 transition-colors hover:opacity-90" style="border-color:var(--border)">
        <div class="flex items-center justify-between mb-6">
          <svg xmlns="http://www.w3.org/2000/svg" class="i5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" /></svg>
        </div>
        <h3 class="font-semibold text-base mb-2">Monitoring Ruangan</h3>
        <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Pantau ketersediaan ruangan secara real-time dan optimalkan penggunaan.</p>
      </div>
      <!-- F3 -->
      <div class="group p-8 lg:border-l border-t lg:border-t-0 transition-colors hover:opacity-90" style="border-color:var(--border)">
        <div class="flex items-center justify-between mb-6">
          <svg xmlns="http://www.w3.org/2000/svg" class="i5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
        </div>
        <h3 class="font-semibold text-base mb-2">Data Guru & Siswa</h3>
        <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Kelola data lengkap dalam satu sistem dengan kontrol akses berbasis peran.</p>
      </div>
      <!-- F4 -->
      <div class="group p-8 border-t transition-colors hover:opacity-90" style="border-color:var(--border)">
        <div class="flex items-center justify-between mb-6">
          <svg xmlns="http://www.w3.org/2000/svg" class="i5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" /></svg>
        </div>
        <h3 class="font-semibold text-base mb-2">Laporan & Analitik</h3>
        <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Akses laporan komprehensif dengan visualisasi data yang mudah dipahami.</p>
      </div>
      <!-- F5 -->
      <div class="group p-8 lg:border-l border-t transition-colors hover:opacity-90" style="border-color:var(--border)">
        <div class="flex items-center justify-between mb-6">
          <svg xmlns="http://www.w3.org/2000/svg" class="i5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" /></svg>
        </div>
        <h3 class="font-semibold text-base mb-2">Notifikasi Otomatis</h3>
        <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Terima pemberitahuan langsung untuk perubahan jadwal dan informasi penting.</p>
      </div>
      <!-- F6 -->
      <div class="group p-8 lg:border-l border-t transition-colors hover:opacity-90" style="border-color:var(--border)">
        <div class="flex items-center justify-between mb-6">
          <svg xmlns="http://www.w3.org/2000/svg" class="i5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
        </div>
        <h3 class="font-semibold text-base mb-2">Keamanan Data</h3>
        <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Data terlindungi dengan enkripsi modern dan backup otomatis.</p>
      </div>
    </div>
  </div>
</section>

<!-- ROLES -->
<section id="peran" class="py-24 px-6 border-b" style="background-color:color-mix(in srgb,var(--secondary) 30%,transparent);border-color:var(--border)">
  <div class="max-w-[1400px] mx-auto">
    <div class="grid lg:grid-cols-[1fr_2fr] gap-16">
      <div>
        <span class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3 block" style="color:var(--primary)">Akses Berbasis Peran</span>
        <h2 class="text-3xl lg:text-4xl font-bold leading-tight mb-4">Untuk Semua Peran di Sekolah</h2>
        <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Setiap pengguna mendapatkan antarmuka dan fitur yang disesuaikan dengan kebutuhan spesifik peran mereka.</p>
      </div>
      <div class="grid md:grid-cols-2 gap-0 border" style="border-color:var(--border)">
        <div class="p-6 transition-colors hover:bg-[var(--card)]">
          <svg xmlns="http://www.w3.org/2000/svg" class="i5 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
          <h3 class="font-semibold text-base mb-2">Kepala Sekolah</h3>
          <p class="text-sm leading-relaxed mb-4" style="color:var(--muted-foreground)">Dashboard komprehensif untuk monitoring operasional dan laporan statistik.</p>
          <div class="flex flex-wrap gap-1.5">
            <span class="text-[10px] font-semibold tracking-wide uppercase px-2 py-1" style="background-color:color-mix(in srgb,var(--primary) 10%,transparent);color:var(--primary)">Dashboard</span>
            <span class="text-[10px] font-semibold tracking-wide uppercase px-2 py-1" style="background-color:color-mix(in srgb,var(--primary) 10%,transparent);color:var(--primary)">Laporan</span>
          </div>
        </div>
        <div class="p-6 md:border-l transition-colors hover:bg-[var(--card)]" style="border-color:var(--border)">
          <svg xmlns="http://www.w3.org/2000/svg" class="i5 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" /></svg>
          <h3 class="font-semibold text-base mb-2">Wakil Kepala / Kurikulum</h3>
          <p class="text-sm leading-relaxed mb-4" style="color:var(--muted-foreground)">Kelola jadwal dengan mudah dan pastikan tidak ada konflik.</p>
          <div class="flex flex-wrap gap-1.5">
            <span class="text-[10px] font-semibold tracking-wide uppercase px-2 py-1" style="background-color:color-mix(in srgb,var(--primary) 10%,transparent);color:var(--primary)">Penjadwalan</span>
            <span class="text-[10px] font-semibold tracking-wide uppercase px-2 py-1" style="background-color:color-mix(in srgb,var(--primary) 10%,transparent);color:var(--primary)">Alokasi</span>
          </div>
        </div>
        <div class="p-6 border-t transition-colors hover:bg-[var(--card)]" style="border-color:var(--border)">
          <svg xmlns="http://www.w3.org/2000/svg" class="i5 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
          <h3 class="font-semibold text-base mb-2">Staff Tata Usaha</h3>
          <p class="text-sm leading-relaxed mb-4" style="color:var(--muted-foreground)">Kelola data guru, siswa, dan kelas dengan efisien.</p>
          <div class="flex flex-wrap gap-1.5">
            <span class="text-[10px] font-semibold tracking-wide uppercase px-2 py-1" style="background-color:color-mix(in srgb,var(--primary) 10%,transparent);color:var(--primary)">Data Management</span>
            <span class="text-[10px] font-semibold tracking-wide uppercase px-2 py-1" style="background-color:color-mix(in srgb,var(--primary) 10%,transparent);color:var(--primary)">Import/Export</span>
          </div>
        </div>
        <div class="p-6 md:border-l border-t transition-colors hover:bg-[var(--card)]" style="border-color:var(--border)">
          <svg xmlns="http://www.w3.org/2000/svg" class="i5 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
          <h3 class="font-semibold text-base mb-2">Guru</h3>
          <p class="text-sm leading-relaxed mb-4" style="color:var(--muted-foreground)">Lihat jadwal mengajar dan akses informasi real-time dari perangkat apapun.</p>
          <div class="flex flex-wrap gap-1.5">
            <span class="text-[10px] font-semibold tracking-wide uppercase px-2 py-1" style="background-color:color-mix(in srgb,var(--primary) 10%,transparent);color:var(--primary)">Jadwal</span>
            <span class="text-[10px] font-semibold tracking-wide uppercase px-2 py-1" style="background-color:color-mix(in srgb,var(--primary) 10%,transparent);color:var(--primary)">Mobile</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section id="cara-kerja" class="py-24 px-6 border-b" style="border-color:var(--border)">
  <div class="max-w-[900px] mx-auto">
    <div class="text-center mb-16">
      <span class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3 block" style="color:var(--primary)">Cara Kerja</span>
      <h2 class="text-3xl lg:text-4xl font-bold">Tiga Langkah Sederhana</h2>
    </div>
    <div class="flex gap-8 py-8">
      <span class="text-[48px] font-bold leading-none w-20 shrink-0" style="color:var(--border)">01</span>
      <div class="pt-2">
        <h3 class="font-semibold text-xl mb-2">Input Data</h3>
        <p class="text-sm leading-relaxed max-w-lg" style="color:var(--muted-foreground)">Masukkan data guru, siswa, dan ruangan. Import massal dari Excel untuk setup cepat.</p>
      </div>
    </div>
    <div class="flex gap-8 py-8 border-t" style="border-color:var(--border)">
      <span class="text-[48px] font-bold leading-none w-20 shrink-0" style="color:var(--border)">02</span>
      <div class="pt-2">
        <h3 class="font-semibold text-xl mb-2">Susun Jadwal</h3>
        <p class="text-sm leading-relaxed max-w-lg" style="color:var(--muted-foreground)">Buat jadwal dengan antarmuka intuitif. Sistem otomatis deteksi dan cegah konflik.</p>
      </div>
    </div>
    <div class="flex gap-8 py-8 border-t" style="border-color:var(--border)">
      <span class="text-[48px] font-bold leading-none w-20 shrink-0" style="color:var(--border)">03</span>
      <div class="pt-2">
        <h3 class="font-semibold text-xl mb-2">Monitor & Laporan</h3>
        <p class="text-sm leading-relaxed max-w-lg" style="color:var(--muted-foreground)">Pantau aktivitas real-time, terima notifikasi otomatis, dan akses laporan kapan saja.</p>
      </div>
    </div>
  </div>
</section>

<!-- BENEFITS + TESTIMONIALS -->
<section class="py-24 px-6 border-b" style="background-color:color-mix(in srgb,var(--secondary) 30%,transparent);border-color:var(--border)">
  <div class="max-w-[1400px] mx-auto">
    <div class="grid lg:grid-cols-2 gap-0 border" style="border-color:var(--border)">
      <!-- Benefits -->
      <div class="p-10 lg:p-14">
        <span class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3 block" style="color:var(--primary)">Manfaat</span>
        <h2 class="text-2xl lg:text-3xl font-bold mb-8">Mengapa Memilih SpaceLab?</h2>
        <div class="space-y-6">
          <div class="flex gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="i4 shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" /></svg>
            <div><h3 class="font-semibold text-sm mb-0.5">Hemat Waktu 70%</h3><p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Penyusunan jadwal yang biasanya berminggu-minggu kini hanya hitungan jam.</p></div>
          </div>
          <div class="flex gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="i4 shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" /></svg>
            <div><h3 class="font-semibold text-sm mb-0.5">Eliminasi Konflik</h3><p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Sistem deteksi otomatis memastikan tidak ada jadwal yang bentrok.</p></div>
          </div>
          <div class="flex gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="i4 shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" /></svg>
            <div><h3 class="font-semibold text-sm mb-0.5">Transparansi Penuh</h3><p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Semua pihak dapat mengakses informasi relevan sesuai peran mereka.</p></div>
          </div>
          <div class="flex gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="i4 shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" /></svg>
            <div><h3 class="font-semibold text-sm mb-0.5">Akses 24/7</h3><p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Platform responsif dapat diakses dari desktop, tablet, atau smartphone.</p></div>
          </div>
        </div>
      </div>
      <!-- Testimonials -->
      <div class="p-10 lg:p-14 border-t lg:border-t-0 lg:border-l" style="border-color:var(--border);background-color:var(--card)">
        <span class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3 block" style="color:var(--primary)">Testimoni</span>
        <h2 class="text-2xl lg:text-3xl font-bold mb-8">Kata Mereka</h2>
        <div class="space-y-0">
          <div class="pb-6 border-b" style="border-color:var(--border)">
            <div class="flex gap-0.5 mb-3">
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
            </div>
            <p class="text-sm leading-relaxed mb-3" style="color:var(--muted-foreground)">"SpaceLab sangat membantu kami mengelola 45 kelas dan 80 guru. Penyusunan jadwal yang dulu 2 minggu, sekarang hanya 2 hari."</p>
            <p class="font-semibold text-sm">Drs. Ahmad Wijaya, M.Pd</p>
            <p class="text-[11px]" style="color:var(--primary)">Kepala Sekolah SMA Negeri 5</p>
          </div>
          <div class="py-6 border-b" style="border-color:var(--border)">
            <div class="flex gap-0.5 mb-3">
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
            </div>
            <p class="text-sm leading-relaxed mb-3" style="color:var(--muted-foreground)">"Efisiensi penggunaan fasilitas meningkat signifikan. Ruang laboratorium yang dulu sering kosong kini terpakai optimal."</p>
            <p class="font-semibold text-sm">Dr. Siti Nurhaliza, S.Pd, M.M</p>
            <p class="text-[11px]" style="color:var(--primary)">Wakil Kepala Sekolah SMK Telkom</p>
          </div>
          <div class="pt-6">
            <div class="flex gap-0.5 mb-3">
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
              <svg class="i3" fill="currentColor" viewBox="0 0 20 20" style="color:var(--primary)"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 0 0 .95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 0 0-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 0 0-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 0 0-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 0 0 .951-.69l1.07-3.292Z"/></svg>
            </div>
            <p class="text-sm leading-relaxed mb-3" style="color:var(--muted-foreground)">"Interface sederhana membuat staff kami yang tidak paham teknologi bisa langsung produktif."</p>
            <p class="font-semibold text-sm">Budi Santoso, S.Kom</p>
            <p class="text-[11px]" style="color:var(--primary)">Koordinator TI SMP Muhammadiyah</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TRUST -->
<section class="py-24 px-6 border-b" style="border-color:var(--border)">
  <div class="max-w-[1400px] mx-auto">
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-16">
      <div>
        <span class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3 block" style="color:var(--primary)">Keamanan</span>
        <h2 class="text-3xl lg:text-4xl font-bold">Sistem Terpercaya</h2>
      </div>
      <p class="text-sm max-w-md" style="color:var(--muted-foreground)">Keamanan dan reliabilitas adalah fondasi utama platform SpaceLab.</p>
    </div>
    <div class="grid md:grid-cols-3 gap-0 border" style="border-color:var(--border)">
      <div class="p-8 text-center transition-colors hover:opacity-80">
        <svg xmlns="http://www.w3.org/2000/svg" class="i6 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
        <h3 class="font-semibold text-base mb-2">Keamanan Terjamin</h3>
        <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Data terenkripsi dan backup otomatis untuk melindungi informasi sekolah.</p>
      </div>
      <div class="p-8 text-center md:border-l border-t md:border-t-0 transition-colors hover:opacity-80" style="border-color:var(--border)">
        <svg xmlns="http://www.w3.org/2000/svg" class="i6 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
        <h3 class="font-semibold text-base mb-2">Uptime 99.9%</h3>
        <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Infrastruktur handal memastikan sistem selalu dapat diakses.</p>
      </div>
      <div class="p-8 text-center md:border-l border-t md:border-t-0 transition-colors hover:opacity-80" style="border-color:var(--border)">
        <svg xmlns="http://www.w3.org/2000/svg" class="i6 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--primary)"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" /></svg>
        <h3 class="font-semibold text-base mb-2">Dukungan Responsif</h3>
        <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Tim support siap membantu dengan pelatihan dan troubleshooting.</p>
      </div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section id="faq" class="py-24 px-6 border-b" style="background-color:color-mix(in srgb,var(--secondary) 30%,transparent);border-color:var(--border)">
  <div class="max-w-[800px] mx-auto">
    <div class="text-center mb-16">
      <span class="text-[11px] font-semibold tracking-[0.2em] uppercase mb-3 block" style="color:var(--primary)">FAQ</span>
      <h2 class="text-3xl lg:text-4xl font-bold">Pertanyaan Umum</h2>
    </div>
    <div class="border" style="border-color:var(--border)">
      <div>
        <button onclick="toggleFaq(0)" class="w-full flex items-center justify-between p-5 text-left transition-opacity hover:opacity-80">
          <h3 class="font-semibold text-sm pr-4">Apakah SpaceLab cocok untuk semua jenis sekolah?</h3>
          <svg xmlns="http://www.w3.org/2000/svg" class="i4 shrink-0 faq-chevron" id="chevron-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--muted-foreground)"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
        </button>
        <div class="faq-body" id="faq-0">
          <div class="px-5 pb-5">
            <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Ya, SpaceLab dirancang untuk semua jenjang pendidikan mulai dari SD, SMP, SMA, hingga SMK. Sistem dapat disesuaikan dengan kebutuhan spesifik setiap institusi.</p>
          </div>
        </div>
      </div>
      <div class="border-t" style="border-color:var(--border)">
        <button onclick="toggleFaq(1)" class="w-full flex items-center justify-between p-5 text-left transition-opacity hover:opacity-80">
          <h3 class="font-semibold text-sm pr-4">Bagaimana sistem mendeteksi konflik jadwal?</h3>
          <svg xmlns="http://www.w3.org/2000/svg" class="i4 shrink-0 faq-chevron" id="chevron-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--muted-foreground)"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
        </button>
        <div class="faq-body" id="faq-1">
          <div class="px-5 pb-5">
            <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Sistem secara otomatis memeriksa ketersediaan guru, ruangan, dan kelas saat jadwal dibuat. Jika terdeteksi konflik, sistem akan memberikan peringatan.</p>
          </div>
        </div>
      </div>
      <div class="border-t" style="border-color:var(--border)">
        <button onclick="toggleFaq(2)" class="w-full flex items-center justify-between p-5 text-left transition-opacity hover:opacity-80">
          <h3 class="font-semibold text-sm pr-4">Berapa lama waktu implementasi?</h3>
          <svg xmlns="http://www.w3.org/2000/svg" class="i4 shrink-0 faq-chevron" id="chevron-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--muted-foreground)"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
        </button>
        <div class="faq-body" id="faq-2">
          <div class="px-5 pb-5">
            <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Implementasi awal biasanya 1-2 minggu, termasuk setup sistem, migrasi data, and pelatihan pengguna.</p>
          </div>
        </div>
      </div>
      <div class="border-t" style="border-color:var(--border)">
        <button onclick="toggleFaq(3)" class="w-full flex items-center justify-between p-5 text-left transition-opacity hover:opacity-80">
          <h3 class="font-semibold text-sm pr-4">Apakah data sekolah aman?</h3>
          <svg xmlns="http://www.w3.org/2000/svg" class="i4 shrink-0 faq-chevron" id="chevron-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--muted-foreground)"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
        </button>
        <div class="faq-body" id="faq-3">
          <div class="px-5 pb-5">
            <p class="text-sm leading-relaxed" style="color:var(--muted-foreground)">Sangat aman. Kami menggunakan enkripsi data, autentikasi berlapis, dan backup otomatis harian sesuai standar industri.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="py-32 px-6 relative overflow-hidden" style="background-color:var(--primary)">
  <div class="absolute inset-0 opacity-10" style="background-image:repeating-linear-gradient(90deg,transparent,transparent 99px,currentColor 99px,currentColor 100px),repeating-linear-gradient(0deg,transparent,transparent 99px,currentColor 99px,currentColor 100px)"></div>
  <div class="max-w-[700px] mx-auto text-center relative">
    <h2 class="text-3xl lg:text-5xl font-bold mb-6 leading-tight" style="color:var(--primary-foreground)">Siap Transformasi Sekolah Anda?</h2>
    <p class="text-base mb-10 max-w-md mx-auto" style="color:color-mix(in srgb,var(--primary-foreground) 70%,transparent)">Bergabunglah dengan ratusan sekolah yang telah merasakan efisiensi manajemen dengan SpaceLab.</p>
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
      <a href="/login" class="group inline-flex items-center justify-center gap-2 px-8 py-3.5 text-sm font-semibold transition-opacity hover:opacity-90" style="background-color:var(--background);color:var(--foreground)">
        Masuk ke Sistem
        <svg xmlns="http://www.w3.org/2000/svg" class="i4 gh-tx" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
      </a>
      <a href="#fitur" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 border-2 text-sm font-semibold transition-colors" style="border-color:color-mix(in srgb,var(--primary-foreground) 40%,transparent);color:var(--primary-foreground)">Pelajari Fitur</a>
    </div>
  </div>
</section>
</x-guest-layout>
