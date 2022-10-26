@props(['listing'])


<x-card>
    <div class="flex">
        <img
            class="hidden w-48 mr-6 md:block"
            src="{{$listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-image.png')}}"
            {{-- AKO IMA logo u listingu onda asset helper storage concat na path iz baze else path od slike za no image --}}
            alt=""
        />
        <div>
            <h3 class="text-2xl">
                <a href="/listings/{{$listing->id}}">
                    {{$listing->title}}
                </a>
                {{-- {{$listing['title']}} mos i ovu sintaksu, a--}}
            </h3>

            <div class="text-xl font-bold mb-4">
                {{$listing->company}}
            </div>

            <x-listing-tags :tagsCsv="$listing->tags" /> {{-- ovde varijablu tagsCsv definiso i iskoristio sve iz listing tags sa datim data --}}
            {{-- TA VARIJABLA SE MORA U TAJ FAJL UNIJETI UZ PROPS HELPER @props('tagsCsv') --}}
                    
            <div class="text-lg mt-4">
                <i class="fa-solid fa-location-dot"></i>
                {{$listing->location}}
            </div>
        </div>
    </div>
</x-card>