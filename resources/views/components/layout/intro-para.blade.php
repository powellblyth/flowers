<div {{ $attributes->merge(['class' => 'py-2 max-w-7xl mx-auto sm:px-6 lg:px-4']) }}>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full">
        <div class="p-4 bg-white border-b border-gray-200 w-full print:p-0">
            {{ $slot }}
        </div>
    </div>
</div>
