<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResumeController extends Controller
{
    public function __construct() 
    {
        // Establecemos un middleware de autentificación a todas las rutas de ResumeController
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resumes = auth()->user()->resumes;
        return view('resumes.index', compact('resumes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = 'test 12345';
        // ['data' => $data] es la sintaxis de objetos en php, si pasamos un objeto como segundo parámetro de la función view, este objeto estará disponible en la vista resumes.create
        return view('resumes.create', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        // Verificamos si ya existe un resume con el mismo title para un mismo usuario (Validación manual)
        $resume = $user->resumes()->where('title', $request->title)->first();
        if ($resume) {
            return back()
                ->withErrors(['title' => 'You already have a resume with this title'])
                ->withInput(['title' => $request->title]);
        }
        $resume = $user->resumes()->create([
            'title' => $request['title'],
            'name' => $user->name,
            'email' => $user->email,

        ]);

        return redirect()->route('resumes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Resume $resume)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Resume $resume)
    {
        // $resume = auth()->user()->resumes()->where('id', $request->resume)->first();
        // Otra forma
        // $resume = Resume::where('id', $request->resume)->first();
        // Otra forma
        // dd($resume);
        return view('resumes.edit', compact('resume'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resume $resume)
    {
        // Validación automática
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'website' => 'nullable|url',
            'picture' => 'nullable|image',
            'about' => 'nullable|string',
            'title' => Rule::unique('resumes')->where(function($query) use ($resume) {
                return $query->where('user_id', $resume->user->id);
            })->ignore($resume->id)
        ]);

        dd($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resume $resume)
    {
        //
    }
}
