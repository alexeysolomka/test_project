<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStationRequest;
use App\Http\Requests\UpdateStationRequest;
use App\Repositories\BranchRepository;
use App\Repositories\StationRepository;
use App\Station;

class StationController extends Controller
{
    /**
     * @var StationRepository $stationRepository
     */
    private $stationRepository;
    /**
     * @var BranchRepository $branchRepository
     */
    private $branchRepository;

    public function __construct()
    {
        $this->middleware('auth');
        $this->stationRepository = app(StationRepository::class);
        $this->branchRepository = app(BranchRepository::class);
    }

    public function index()
    {
        $stations = $this->stationRepository->getAll();

        return view('underground.station.index', compact('stations'));
    }

    public function create()
    {
        $station = new Station;
        $stations = $this->stationRepository->getStationsForSelect();
        $stations[""] = 'The ultimate';
        $branches = $this->branchRepository->getAll();

        return view('underground.station.create', compact('station', 'stations', 'branches'));
    }

    public function store(CreateStationRequest $request)
    {
        $createData = $request->all();
        $station = $this->stationRepository->create($createData);

        if($station)
        {
            return back()->with('status', 'Station successful created.');
        }

        return back()->with('error', 'Error to create station.');
    }

    public function edit($id)
    {
        $station = Station::find($id);
        $stations = $this->stationRepository->getStationsForSelect()->where('id', '!=', $id)->pluck('name', 'id');
        $stations[""] = 'The ultimate';
        $branches = $this->branchRepository->getAll();

        return view('underground.station.edit', compact('station', 'branches', 'stations'));
    }

    public function update(UpdateStationRequest $request, $id)
    {
        $updateData = $request->all();
        $station = $this->stationRepository->update($id, $updateData);

        if($station)
        {
            return back()->with('status', 'Station succesful updated.');
        }

        return back()->with('error', 'Error to update station.');
    }

    public function delete($id)
    {
        $station = Station::find($id);

        if($station->delete())
        {
            return back()->with('status', 'Station successful deleted.');
        }

        return back()->with('error', 'Error to delete station');
    }
}
