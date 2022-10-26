{{-- 
@extends('layout')
@section('content')
--}}

<x-layout>

<?php
/*
OVAKO BI IZGLEDALO U .php skripti

<h1><?php echo $heading; ?></h1>

<?php foreach($listings as $listing): ?>
    <h2><?php echo $listing['title']; ?></h2>
    <p><?php echo $listing['description']; ?></p>
<?php endforeach ?>

A U BLADEU je ovo sve nakon i koristi directives
*/
?>

@include('partials._hero')
@include('partials._search')
{{-- ovo search nije otislo u layout da ne bi na svakoj stranici bilo vec samo na home i pojedinacnim listinzima --}}


{{-- <h1>{{ $heading }}</h1>  --}}
<div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
{{-- umjesto ovog headinga gore ide div iz htmla sto je on dao --}}

{{-- OVO MOZE UMJESTO UNLESSA
@if(count($listings) == 0)
    <p>NO LISTINGS FOUND!</p>
@endif
 --}}

@unless(count($listings) == 0) <!-- wrappas u unless foreach -->

@foreach($listings as $listing)
{{-- <h2>
    <a href="listings/{{$listing['id']}}">
        {{$listing['title']}}
    </a>
</h2>
<p>
    {{$listing['description']}}
</p> --}}
{{-- umjesto ovog gore stavimo html koji ce se vrtit --}}




{{-- !!!!!!!!!!! IZVADIO KOD DA PREBACIM U komponente --}}
<x-listing-card :listing="$listing" />   {{-- <x-listing-card listing="hello world" /> AKO PASSAS STRING MOZE BEZ DVOTACKE, ali zbog varijable treba dvotacka--}}
{{-- pod navodnike $listing jer je varijable iz ove skripte, ili mozda jer hocemo da pretvorimo u string values iz tog arraya u string NEZZ FKT jer je u listing-card stavljen pod array --}}




@endforeach

@else
<p>NO LISTINGS FOUND!</p>
@endunless

</div>

<div class="mt-6 p-4">
    {{$listings->links()}}
    {{-- pagination linkovi --}}
</div>

<!-- ZA ZAPAMTIT -->
{{-- @php
    $test = 1;
@endphp

{{$test}} --}}

</x-layout>