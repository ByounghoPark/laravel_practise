<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Product;
use App\Rules\Uppercase;
use App\Http\Requests\CreateValidationRequest;

class CarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' =>['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::all();

        return view('cars.index', [
            'cars' => $cars
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {
        //methods we can use on request
        // guessExtension()
        //$test = $request->file('image')->guessExtension(); // jpg
        // getMimeType
        //$test = $request->file('image')->getMimeType(); // image/jpeg
        // store()
        //asStore()
        // storePublicly()
        //move()
        //getClientOriginalName()
        //$test = $request->file('image')->getClientOriginalName();
        // getClientMimeType()
        //$test = $request->file('image')->getClientMimeType();
        // guessClientExtension()
        //$test = $request->file('image')->guessClientExtension();
        // getSize()
        //$test = $request->file('image')->getSize();
        // getError()
        //$test = $request->file('image')->getError();
        // isValid()
        //$test = $request->file('image')->isValid();
        //dd($test);

        $request->validate([
            'name' => 'required',
            'founded' => 'required|integer|min:0|max:2022',
            'description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:4048'
        ]);

        // if it is valid, it will proceed,
        // if it is not valid, throw a ValidationException

        $newImageName = time() . '-' . $request->name . '.' . $request->image->extension();
        //dd($newImageName);

        // public 폴더에 images란 폴더가 있어야 한다. 없으면 만들자.
        $request->image->move(public_path('images'), $newImageName);

        $car = Car::create([
            'name' => $request->input('name'),
            'founded' => $request->input('founded'),
            'description' => $request->input('description'),
            'image_path' => $newImageName,
            'user_id' => auth()->user()->id,
        ]);

        return redirect('/cars');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::find($id);

        $products = Product::find($id);

        print_r($products);

        return view('cars.show')->with('car', $car);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Car::find($id);

        return view('cars.edit')->with('car', $car);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateValidationRequest $request, $id)
    {
        $request->validated();

        $car = Car::where('id', $id)
            ->update([
            'name' => $request->input('name'),
            'founded' => $request->input('founded'),
            'description' => $request->input('description')
        ]);

        return redirect('/cars');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        $car->delete();
        return redirect('/cars');
    }
}
