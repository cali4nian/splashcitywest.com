<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-xl border border-rose-700 bg-rose-700 px-4 py-2 text-xs font-bold uppercase tracking-[0.12em] text-white shadow-sm transition duration-150 ease-in-out hover:bg-rose-800 active:bg-rose-900 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
