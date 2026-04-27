@props(['tab','error' => false])
<div x-show="tab === '{{ $tab }}'">
    {{ $slot }}

</div>

















