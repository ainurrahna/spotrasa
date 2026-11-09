@php $terisi = (int) round($nilai ?? 0); @endphp
<span class="stars" role="img" aria-label="Rating {{ number_format($nilai ?? 0, 1) }} dari 5">
    @for($i = 1; $i <= 5; $i++)<i class="bi bi-star-fill {{ $i <= $terisi ? 'on' : '' }}"></i>@endfor
</span>