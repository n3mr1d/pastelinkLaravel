<x-html doc="{{ $doc }}" css="{{ $css }}" class="text-light">
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
            <form action="{{ route('login') }}" method="post" class="p-4 d-flex flex-column rounded shadow bg-dark text-light">
                @csrf
                <h1 class="mb-4 text-center">Login Page</h1>
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control bg-secondary text-light border-0" id="username" name="username" required autofocus autocomplete="username" value="{{ old('username') }}">
                    @error('username')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control bg-secondary text-light border-0" id="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</x-html>