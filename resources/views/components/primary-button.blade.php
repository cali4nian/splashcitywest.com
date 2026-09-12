<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-xl border border-cyan-700 bg-cyan-700 px-4 py-2 text-xs font-bold uppercase tracking-[0.12em] text-white shadow-sm transition hover:bg-cyan-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 active:bg-cyan-900']) }}>
    {{ $slot }}
</button>
