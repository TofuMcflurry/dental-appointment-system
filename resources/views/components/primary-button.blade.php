<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent 
               rounded-md font-semibold text-xs text-white uppercase tracking-widest 
               hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 
               focus:ring focus:ring-blue-300 disabled:opacity-25 transition'
]) }}>
    <span class="button-text">{{ $slot }}</span>

    <!-- spinner (hidden by default) - will replace the text on submit -->
    <span class="loading-spinner hidden" aria-hidden="true">
        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        <span class="sr-only">Loading</span>
    </span>
</button>
