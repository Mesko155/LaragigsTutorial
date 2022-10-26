@props(['tagsCsv'])
{{-- namjerno [] da bi bio array kroz koji mozemo loopat --}}

@php
    $tags = explode(',', $tagsCsv);
@endphp


<ul class="flex">
    @foreach($tags as $tag)
    <li class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs">
        <a href="/?tag={{$tag}}">
            {{$tag}}
        </a>
        {{-- pored loopa sad se moze kliknuti na zasebni tag i pretrazit po njemu --}}
    </li>
    @endforeach
</ul>






{{-- staro, uzmemo samo jedan da loopamo
<ul class="flex">
    <li
        class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs"
    >
        <a href="#">Laravel</a>
    </li>
    <li
        class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs"
    >
        <a href="#">API</a>
    </li>
    <li
        class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs"
    >
        <a href="#">Backend</a>
    </li>
    <li
        class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs"
    >
        <a href="#">Vue</a>
    </li>
</ul>
 --}}
