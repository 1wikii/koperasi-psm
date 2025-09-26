@props(['slug', 'name', 'image', 'price', 'slug'])
<a href="{{ route('products.show', ['slug' => $slug]) }}" class="flex flex-col cursor-pointer">
    <img src="{{ asset($image) }}" alt="{{ $name }}" class="w-full object-cover rounded-md mb-2">
    <h3 class="text-md leading-snug line-clamp-2">{{ $name }}</h3>
    <p class="font-bold">Rp.{{ number_format($price, 0, ',', '.') }}</p>
</a>