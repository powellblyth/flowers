@props(['success'])
@php
if ($success){
    $highlight='bg-green-800';
    $border='border-green-900';
} else {
    $highlight='bg-red-800';
    $border='border-red-900';
}
@endphp

<div {{ $attributes->merge(['class'=>$highlight. ' '.$border." m-1 text-white p-2 rounded-md w-auto inline "]) }}>
    {{ $slot }}
</div>
