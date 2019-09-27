<?php

namespace App\Http\Controllers;

use App\Intersection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\IntersectionRepository;
use App\Http\Requests\CreateIntersectionRequest;
use App\Http\Requests\UpdateIntersectionRequest;

class IntersectionController extends Controller
{
    /**
     * @var IntersectionRepository $intersectionRepository
     */
    private $intersectionRepository;

    public function __construct()
    {
        $this->middleware('auth');
        $this->intersectionRepository = app(IntersectionRepository::class);
    }

    public function index()
    {
        $intersections = $this->intersectionRepository->getAll();

        return view('underground.intersection.index', compact('intersections'));
    }

    public function create()
    {
        $intersection = new Intersection;
        return view('underground.intersection.create', compact('intersection'));
    }

    public function store(CreateIntersectionRequest $request)
    {
        $createData = $request->all();
        $intersection = $this->intersectionRepository->create($createData);

        if ($intersection) {
            return back()->with('status', 'Intersection successful created.');
        }

        return back()->with('error', 'Error to create intersection.');
    }

    public function edit($id)
    {
        $intersection = Intersection::find($id);
        $availableStations = $intersection->availableStations();

        return view('underground.intersection.edit', compact('intersection', 'availableStations'));
    }

    public function update(UpdateIntersectionRequest $request, $id)
    {
        $updateData = $request->all();
        $intersection = $this->intersectionRepository->update($id, $updateData);

        if ($intersection) {
            return back()->with('status', 'Intersection succesful updated.');
        }

        return back()->with('error', 'Error to update intersection.');
    }

    public function delete($id)
    {
        $intersection = Intersection::find($id);

        if ($intersection->delete()) {
            return back()->with('status', 'Intersection successful deleted.');
        }

        return back()->with('error', 'Error to delete intersection');
    }

    public function addStationToIntersection($intersection_id, Request $request)
    {
        $intersectionStation = $this->intersectionRepository->addStationToIntersection($intersection_id, $request->get('station_id'));

        if ($intersectionStation) {
            return back()->with('status', 'Station successful added.');
        }

        return back()->with('error', 'Errorr to add station.');
    }

    public function deleteStationFromIntersection($intersection_id, $station_id)
    {
        $result = DB::table('intersection_to_stations')
            ->where('intersection_id', $intersection_id)
            ->where('station_id', $station_id)->delete();

        if ($result) {
            return back()->with('status', 'Station successful deleted from intersection.');
        }

        return back()->with('error', 'Error to delete station from intersection');
    }
}
