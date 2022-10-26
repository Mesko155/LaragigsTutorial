<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //get and show all listings                 DEFINISANA VARIJABLA $LISTINGS plural
    public function index() {
        // dd(request()->tag); //sa ovim uzimam dd query value pod tag
        return view('listings.index', [
            // 'listings' => Listing::all() //ovaj nije sortiran ko ovaj dole
            // 'listings' => Listing::latest()->get() //ovaj je sortiran, al ovaj dole dodatne ima stvari
            'listings' => Listing::latest() //latest() doda u query ORDER BY created_at DESC;
            ->filter(request(['tag', 'search'])) //isfiltrira
            // ->get() umjesto geta stavit paginate
            ->paginate(4)
            //imas i simplePaginate() samo next i previous
        ]);
    }

    //show single listing                       DEFINISANA VARIJABLA $LISTING singular
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //show create form
    public function create() {
        return view('listings.create');
    }

    //store filled form
    public function store(Request $request) {
        // dd($request->file('logo')); //svasta kaze o fileu
        // dd($request->all()); //povuces sve u trenutnom requestu K/V popunjenih polja
        $polja = $request->validate([ //validate, pa stavimo array i stavi pravila za svako polje
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            //kad imas vise pravila mos stavit u array
            //Roleklasa::uniquemetoda(koja tabela, koja kolona)
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $polja['logo'] = $request->file('logo')->store('logos', 'public'); //odma mozemo storat cak i dok assignas
            //btw ovo logos napravi folder sa tim imenom
            //drugi arguement public valjda da zna dje iako je default stavljen public
        }

        $polja['user_id'] = auth()->id();

        Listing::create($polja);

        // Session::flash('message', 'Listing Created!'); mozda se i ovako moze flashmess
        //ali ispod je na redirect spojeno
        return redirect('/')->with('message', 'Listing created successfully!');
        //ovo samo ispali message, treba napravit i componentu pa negdje u viewu ubacit
        //mozes napraviti neke za success, za error, itd
    }

    //show edit form
    public function edit(Listing $listing) { //nije dovoljno da bude Listing model, npr (Listing $kurac). mora se referirat na normalnu varijablu koja je nedje definisana
        // dd($listing);
        return view('listings.edit', ['listing' => $listing]); //vratice view(viewpath, data unesen ce biti listing od $listing gore navedenog sa osobnostima modela Listing; koji extenda Model klasu)
    }

    //update filled form
    public function update(Request $request, Listing $listing) {
        //make sure logged in user is owner
        //ovo za svaki slucaj 
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized action srce moje');
        }

        $polja = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
        
        if($request->hasFile('logo')) {
            $polja['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Listing::create($polja); umjesto ovog treba nam current listing
        //pa koristimo varijablu i regular method umjesto static method
        $listing->update($polja);
        
        return back()->with('message', 'Listing updated successfully!');
    }

    //delete listing
    public function destroy(Listing $listing) {
        //make sure logged in user is owner
        //ovo za svaki slucaj 
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized action srce moje');
        }

        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully!!!!!!!');
    }

    //manage funkcija
    public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]); //nez sto mi kaze undefined method, ali sve radi uredno
        //varijablu koju ces moc koristit u tom viewu ovde definisemo
    }
    
}


