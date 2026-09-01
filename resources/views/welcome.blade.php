<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Kasir Gudang') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-white">
    <main class="mx-auto flex min-h-screen max-w-7xl flex-col justify-between gap-12 px-6 py-8 lg:px-12">
        <nav class="flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-xl font-bold tracking-tight">KASIR<span class="text-amber-400">GUDANG SHUBHI</span></a>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="rounded border border-slate-600 px-4 py-2 text-sm hover:border-amber-400">Masuk</a>
                @if(Route::has('register'))
                    <a href="{{ route('register') }}" class="rounded bg-amber-400 px-4 py-2 text-sm font-semibold text-slate-950 hover:bg-amber-300">Buat akun</a>
                @endif
            </div>
        </nav>

        <section class="grid items-center gap-12 lg:grid-cols-[1.1fr_.9fr]">
            <div class="space-y-7">
                <p class="text-sm font-semibold uppercase tracking-[.25em] text-amber-400">Sistem penjualan terintegrasi</p>
                <h1 class="max-w-3xl text-5xl font-bold leading-tight tracking-tight md:text-7xl">Penjualan lancar, stok tetap terkendali.</h1>
                <p class="max-w-xl text-lg leading-8 text-slate-300">Kelola transaksi kasir, produk, gudang, dan pergerakan stok dari satu tempat.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('login') }}" class="rounded bg-amber-400 px-6 py-3 font-semibold text-slate-950 hover:bg-amber-300">Mulai bekerja</a>
                    <a href="{{ route('register') }}" class="rounded border border-slate-600 px-6 py-3 font-semibold hover:border-white">Daftar pengguna</a>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="rounded-2xl border border-slate-700 bg-slate-900 p-6"><p class="text-4xl font-bold text-amber-400">01</p><h2 class="mt-10 text-xl font-semibold">Kasir</h2><p class="mt-2 text-sm text-slate-400">Transaksi cepat dengan perhitungan kembalian otomatis.</p></div>
                <div class="mt-10 rounded-2xl border border-slate-700 bg-slate-900 p-6"><p class="text-4xl font-bold text-emerald-400">02</p><h2 class="mt-10 text-xl font-semibold">Stok</h2><p class="mt-2 text-sm text-slate-400">Pantau stok dan restock di setiap gudang.</p></div>
                <div class="rounded-2xl border border-slate-700 bg-slate-900 p-6"><p class="text-4xl font-bold text-sky-400">03</p><h2 class="mt-10 text-xl font-semibold">Kontrol</h2><p class="mt-2 text-sm text-slate-400">Data penjualan dan inventaris tersimpan rapi.</p></div>
                <div class="mt-10 rounded-2xl border border-slate-700 bg-slate-900 p-6"><p class="text-4xl font-bold text-rose-400">04</p><h2 class="mt-10 text-xl font-semibold">Terhubung</h2><p class="mt-2 text-sm text-slate-400">Satu sumber data untuk operasional harian.</p></div>
            </div>
        </section>

        <footer class="border-t border-slate-800 pt-5 text-sm text-slate-500">{{ config('app.name', 'Kasir Gudang') }} &middot; Sistem kasir dan gudang</footer>
    </main>
</body>
</html>
