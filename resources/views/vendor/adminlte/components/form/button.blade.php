<button 
    type="{{ $type }}" 
    class="btn btn-{{ $theme }} @isset($classes) {{ $classes }} @endisset" 
    @isset($attributes) 
        @foreach($attributes as $attr => $value) 
        {{ $attr }} = "{{ $value }}"
        @endforeach 
    @endisset
>
    @isset($label) {{ $label }} @endisset 
    @isset($icon) <i class="{{ $icon }}"></i> @endisset
</button>
