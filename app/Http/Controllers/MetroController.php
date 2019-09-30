<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMetroRequest;
use App\Http\Requests\UpdateMetroRequest;
use App\Metro;
use App\Repositories\MetroRepository;

class MetroController extends Controller
{
    /**
     * @var MetroRepository $metroRepository
     */
    private $metroRepository;

    public function __construct()
    {
        $this->middleware('auth');
        $this->metroRepository = app(MetroRepository::class);
    }

    public function index()
    {
        $metros = $this->metroRepository->getAll();

        return view('underground.metro.index', compact('metros'));
    }

    public function create()
    {
        $metro = new Metro;
        return view('underground.metro.create', compact('metro'));
    }

    public function store(CreateMetroRequest $request)
    {
        $createData = $request->all();
        $metro = $this->metroRepository->create($createData);

        if($metro)
        {
            return back()->with('status', 'Metro successful created.');
        }

        return back()->with('error', 'Error to create metro.');
    }

    public function edit($id)
    {
        $metro = Metro::find($id);

        return view('underground.metro.edit', compact('metro'));
    }

    public function update(UpdateMetroRequest $request, $id)
    {
        $updateData = $request->all();
        $metro = $this->metroRepository->update($id, $updateData);

        if($metro)
        {
            return back()->with('status', 'Metro succesful updated.');
        }

        return back()->with('error', 'Error to update metro.');
    }

    public function delete($id)
    {
        $metro = Metro::find($id);

        if($metro->delete())
        {
            return back()->with('status', 'Metro successful deleted.');
        }

        return back()->with('error', 'Error to delete metro');
    }
}
