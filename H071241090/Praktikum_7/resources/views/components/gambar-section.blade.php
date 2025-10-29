<div class="text-center mb-12">
    <img src="{{ asset($src) }}" alt="{{ $caption ?? 'Gambar' }}" 
         class="rounded-xl shadow w-full h-56 object-cover">
    @if(isset($caption))
        <p class="text-gray-700 italic">{{ $caption }}</p>
    @endif
</div>
