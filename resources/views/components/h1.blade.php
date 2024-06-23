@props(['class'])

<h1 class="text-4xl font-bold {{ $class }}">
    {{ $slot }}
</h1>