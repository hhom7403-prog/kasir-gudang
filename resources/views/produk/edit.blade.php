@extends('layouts.app')
@section('content')<div class="max-w-xl mx-auto p-6"><h1 class="text-2xl font-bold mb-5">Edit Produk</h1>@include('components.flash')<form method="POST" action="{{ route('produk.update', $produk) }}" class="space-y-4">@csrf @method('PUT') @include('produk.form')<button class="bg-blue-600 text-white px-4 py-2">Simpan</button></form></div>@endsection
