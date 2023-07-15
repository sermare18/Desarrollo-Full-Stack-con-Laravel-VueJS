<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;


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

        return redirect()->route('resumes.index')->with('alert', [
            'type' => 'primary',
            'message' => "Resume $resume->title created successfully"
        ]);;
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
            // 'title' => Rule::unique('resumes')->where(function($query) use ($resume) {
            //     return $query->where('user_id', $resume->user->id);
            // })->ignore($resume->id)
            'title' => Rule::unique('resumes')
                ->where(fn($query) => $query->where('user_id', $resume->user->id))
                ->ignore($resume->id)
        ]);
        
        if(array_key_exists('picture', $data)) {
            // $picture será un objeto de tipo UploadedFile y tendrá un método llamado store()
            // Almacenamos la imagen en la carpeta pictures que se encuentra dentro de la carpeta storage/app/public y está conectada mediante enlace simbólico a public/storage
            // Para crear el enlace simbólico se ha utilizado el comando 'php artisan storage:link'
            $picture = $data['picture']->store('pictures', 'public');
            Image::make(public_path("storage/$picture"))->fit(800, 800)->save();
            // Guardamos en el campo picture de data la ruta de la imagen en nuestro servidor
            $data['picture'] = $picture;
        }

        // Después de la validación de los datos actualizamos el currículum
        $resume->update($data);

        // Redirigimos a resumes.index he introducimos en la sesión información sobre la alerta que debe mostrar
        return redirect()->route('resumes.index')->with('alert', [
            'type' => 'success',
            'message' => "Resume $resume->title updated successfully"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resume $resume)
    {
        //
    }
}
