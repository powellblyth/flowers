<div {{ $attributes->merge(['class' => 'py-4 max-w-7xl mx-auto sm:px-6 lg:px-8']) }}>
    <div class="bg-green-700 overflow-hidden shadow-sm sm:rounded-lg w-full">
        <div class="text-white font-bold p-6 border-b border-gray-200 w-full">
            {{ $slot }}
        </div>
    </div>
</div>
