@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#f26a0a] text-sm font-semibold leading-5 text-[#0b2340] focus:outline-none focus:border-[#d97706] transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-[#64748b] hover:text-[#0d2a4a] hover:border-[#f4c9a5] focus:outline-none focus:text-[#0d2a4a] focus:border-[#f4c9a5] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
