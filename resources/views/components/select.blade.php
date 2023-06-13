@props(['disabled' => false, 'options' => [], 'selected' => null, 'hasBlank'=>false, 'blankLabel'=>'Select...'])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
    @if($hasBlank)
        <option value="">{{$blankLabel}}</option>
    @endif
    @foreach ($options as $key => $option)
        <option @if($selected === $key)selected="selected" @endif value="{{$key}}">{{$option}}</option>
    @endforeach
</select>
