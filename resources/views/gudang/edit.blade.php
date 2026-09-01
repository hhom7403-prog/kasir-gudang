@extends('layouts.app')
@section('content')<div class="max-w-xl mx-auto p-6"><h1 class="text-2xl font-bold mb-5">Edit Gudang</h1>@include('components.flash')<form method="POST" action="{{ route('gudang.update', $gudang) }}" class="space-y-4">@csrf @method('PUT') @include('gudang.form')<button class="bg-blue-600 text-white px-4 py-2">Simpan</button></form></div>@endsection
