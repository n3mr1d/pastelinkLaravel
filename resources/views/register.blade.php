<x-html doc="{{ $doc }}" css="{{ $css }}" class="register bg-dark text-light ">
<div class="d-flex justify-content-center align-items-center" style="min-height:80vh ;">

<div class="w-100" style="max-width: 400px;">
    @if(session('message') || $errors->any())
    <x-alert status="{{ session('status') }}">
        {{ session('message') }}
        @if($errors->any())
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </x-alert>
@endif
            <form action="{{ route('register') }}" method="post" class="p-4 d-flex flex-column rounded shadow bg-dark text-light">
        <h1 class="mb-4 text-center ">Register</h1>
        @csrf
        <div class="mb-3">
            <label class="form-label text-light" for="username">Username:</label>
            <input class="form-control bg-secondary text-light border-0" type="text" id="username" name="username" placeholder="Username" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-light" for="password">Password</label>
            <input type="password" class="form-control bg-secondary text-light border-0" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="mb-3">
            <label class="form-label text-light" for="email">Gmail <span class="text-muted small">( for reset password)</span></label>
            <input type="email" class="form-control bg-secondary text-light border-0" id="email" name="email" placeholder="Email">
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
</div>
</div>
</x-html>