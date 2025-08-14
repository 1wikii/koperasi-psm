@extends('layouts.layout')

@section('title')
    <title>Tentang Kami</title>
@endsection

@section('main')

    <div class="bg-gray-50 font-sans">
        <div class="min-h-screen">
            <!-- Hero Section -->
            <section class="bg-white py-16 px-4">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                        Selamat Datang di<br>
                        Perusahaan Kami
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                        Kami adalah penyedia solusi terbaik untuk kebutuhan Anda.
                    </p>
                    <button
                        class="bg-white border-2 border-gray-300 hover:border-gray-400 text-gray-700 font-medium py-3 px-8 rounded-lg transition-colors duration-200">
                        Hubungi Kami
                    </button>
                </div>
            </section>

            <!-- Description Section -->
            <section class="bg-gray-100 py-16 px-4">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-gray-200 rounded-lg p-12 text-center">
                        <p class="text-gray-700 text-lg leading-relaxed mb-8">
                            Kami berkomitmen untuk memberikan kualitas layanan terbaik kepada semua klien kami.
                        </p>

                        <!-- Loading dots -->
                        <div class="flex justify-center space-x-2">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse" style="animation-delay: 0.2s;">
                            </div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse" style="animation-delay: 0.4s;">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Vision and Mission Section -->
            <section class="bg-white py-16 px-4">
                <div class="max-w-6xl mx-auto">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                            Visi dan Misi
                        </h2>
                        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                            Misi kami adalah untuk menyediakan solusi inovatif.
                        </p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8 mt-16">
                        <!-- Vision Card -->
                        <div class="bg-gray-100 rounded-lg p-8">
                            <div class="flex items-start space-x-4">
                                <div class="bg-gray-300 rounded-lg p-4 flex-shrink-0">
                                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Visi</h3>
                                    <p class="text-gray-600 leading-relaxed">
                                        Menjadi pemimpin dalam industri ini.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Mission Card -->
                        <div class="bg-gray-100 rounded-lg p-8">
                            <div class="flex items-start space-x-4">
                                <div class="bg-gray-300 rounded-lg p-4 flex-shrink-0">
                                    <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Misi</h3>
                                    <p class="text-gray-600 leading-relaxed">
                                        Memberikan layanan yang berkualitas tinggi kepada pelanggan kami.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection