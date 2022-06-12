<div {{ $attributes->merge(['class' => 'py-4 max-w-7xl mx-auto sm:px-6 lg:px-8']) }}>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full">
        <div class="p-6 bg-white border-b border-gray-200 w-full">
            {{ $slot }}
        </div>
    </div>
</div>
