@props([
    'name','options','checked'=>false,'label'=>false
])


@foreach ($options as $value=>$text)
    <div class="col-sm-10">
        <div class="form-check">
            <input type="radio" class="form-check-input" name="{{ $name }}"  value="{{ $value }}"
            @checked(old($name,$checked)==$value)>
            <label class="form-check-label">
                {{ $text }}
            </label>
        </div>
    </div>
@endforeach

@error($name)
    <div class="text-danger" style="width: 450px">{{ $message }}</div>
@enderror
