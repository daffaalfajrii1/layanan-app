@props(['id' => ''])

<div class="collapse menu-dropdown" id="{{ $id }}">
    <ul class="nav nav-sm flex-column">
        {{ $slot }}
    </ul>
</div>
