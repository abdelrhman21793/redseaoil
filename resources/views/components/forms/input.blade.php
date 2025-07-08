@props([
    'type'=>'text','name','value'=>false,'label'=>false,'placeholder'=>false,'class'=>false,'wire'=>false
])
@if($label)
    <label class="form-label">{{ $label }}</label>
@endif
    <input type="{{ $type }}" name="{{ $name }}" class="form-control {{ $class }}" placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}" $wire>
@error($name)
        <div class="text-danger" style="width: 450px">{{ $message }}</div>
@enderror
