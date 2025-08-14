@extends('layouts.auth-layout')

@section('title')
    <title>Login</title>
@endsection('title')



@section('main')
    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-md">
        <!-- Logo -->
        <div class="flex justify-center items-center text-center mb-6">

            <img src="/logo.svg" alt="logo" width="100" height="100">

        </div>

        <!-- Title -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Halo, Selamat Datang</h1>
            <div class="text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-green-600 hover:underline">Daftar Sekarang</a>
            </div>
        </div>

        <!-- Registration Form -->
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email Field -->
            <div>
                <input type="email" name="email" id="email" placeholder="Masukkan email" value="{{ old('email') }}"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition-all duration-200 @error('email') border-red-500 @enderror"
                    required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <input type="password" name="password" id="password" placeholder="Password"
                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition-all duration-200 @error('password') border-red-500 @enderror"
                    required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Show Password -->
            <div class="flex items-center justify-between">
                <div>
                    <input type="checkbox" id="show-password" class="mr-2" onclick="togglePassword()">
                    <label for="show-password" class="text-sm text-gray-600">Show Password</label>
                </div>
                <div>
                    <a href="#" class="text-green-500 hover:text-green-600">Lupa Password?</a>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02] focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Daftar
                </button>
            </div>
        </form>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <ul class="text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>


    <p class="mt-20 font-bold text-sm text-black">&copy; 2025, Company, Seluruh Hak Cipta Dilindungi Undang-Undang</p>


    <script>
        function togglePassword() {
            var passwordInput = document.getElementById('password');
            var showPasswordCheckbox = document.getElementById('show-password');
            if (showPasswordCheckbox.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
@endsection