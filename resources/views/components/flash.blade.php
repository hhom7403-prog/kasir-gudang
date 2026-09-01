@if(session('success'))<div class="mb-4 bg-green-100 text-green-800 p-3">{{ session('success') }}</div>@endif
@if(session('error'))<div class="mb-4 bg-red-100 text-red-800 p-3">{{ session('error') }}</div>@endif
@if($errors->any())<div class="mb-4 bg-red-100 text-red-800 p-3"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
