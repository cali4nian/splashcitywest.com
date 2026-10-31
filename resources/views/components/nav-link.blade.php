@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center rounded-lg border border-zinc-500 bg-zinc-600 px-3 py-2 text-sm font-semibold leading-5 text-zinc-100 shadow-sm transition duration-150 ease-in-out'
            : 'inline-flex items-center rounded-lg border border-transparent px-3 py-2 text-sm font-medium leading-5 text-slate-600 transition duration-150 ease-in-out hover:border-slate-200 hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:border-slate-200 focus:bg-slate-100 focus:text-slate-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
