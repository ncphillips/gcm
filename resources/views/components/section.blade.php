@props(['class' => '', 'first' => false])
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 {{ $class }} {{ $first ? 'pt-6' : '' }}">
    {{ $slot }}
</section>