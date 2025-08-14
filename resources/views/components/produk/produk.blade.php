@props(['id', 'title', 'image', 'price'])
<div class="flex flex-col cursor-pointer">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full object-cover rounded-md mb-2">
    <h3 class="text-md leading-snug line-clamp-2">{{ $title }}</h3>
    <p class="font-bold">Rp.{{ number_format($price, 0, ',', '.') }}</p>

    <!-- <a href="{{ route('home', $id) }}"
        class="mt-2 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors duration-200">
        Lihat Detail
    </a> -->
</div>