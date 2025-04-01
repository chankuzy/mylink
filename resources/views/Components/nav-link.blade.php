@props(['active' => false])
<a class="nav-link {{ $active ? 'active' : '' }} flex items-center gap-3 p-3 rounded-xl hover:bg-[#161830] transition-all" {{ $attributes}}>
    {{ $slot }}
</a>