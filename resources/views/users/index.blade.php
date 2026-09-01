@extends('layouts.app')
@section('content')
<div class="max-w-5xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6"><div><p class="text-sm uppercase tracking-wider text-slate-500">Administrasi akses</p><h1 class="text-2xl font-bold">Pengguna & Role</h1></div></div>
    @include('components.flash')
    <div class="bg-white shadow-sm overflow-x-auto"><table class="w-full text-left"><thead class="bg-slate-100"><tr><th class="p-4">Nama</th><th class="p-4">Email</th><th class="p-4">Role</th><th class="p-4">Simpan</th></tr></thead><tbody>@foreach($users as $user)<tr class="border-t"><td class="p-4 font-medium">{{ $user->name }}</td><td class="p-4 text-slate-600">{{ $user->email }}</td><td class="p-4"><form class="flex items-center gap-3" method="POST" action="{{ route('users.update', $user) }}">@csrf @method('PATCH')<select name="role" class="border p-2" @disabled($user->is(auth()->user()))>@foreach(\App\Models\User::ROLES as $role)<option value="{{ $role }}" @selected($user->role === $role)>{{ ucfirst($role) }}</option>@endforeach</select>@if($user->is(auth()->user()))<span class="text-xs text-slate-500">Akun aktif</span>@endif</td><td class="p-4"><button class="bg-slate-900 text-white px-3 py-2" @disabled($user->is(auth()->user()))>Simpan</button></form></td></tr>@endforeach</tbody></table></div>{{ $users->links() }}
</div>
@endsection
