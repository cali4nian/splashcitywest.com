@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#f26a0a] text-start text-base font-semibold text-[#0b2340] bg-[#fff3e7] focus:outline-none focus:text-[#0b2340] focus:bg-[#fde8d4] focus:border-[#d97706] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-[#64748b] hover:text-[#0d2a4a] hover:bg-[#f8efe4] hover:border-[#f4c9a5] focus:outline-none focus:text-[#0d2a4a] focus:bg-[#f8efe4] focus:border-[#f4c9a5] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
