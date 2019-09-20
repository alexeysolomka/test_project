<?php

namespace App\Http\Controllers;

use App\Station;
use Illuminate\Http\Request;

class SearchShortPathController extends Controller
{
    private $paths = [];
    private $path;

    public function index()
    {
        $stations = Station::all();

        return view('underground.search_path', compact('stations'));
    }

    public function search(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $path = [];

        $stationFrom = Station::find($from);
        $stationTo = Station::find($to);

        $routes = [];
        $stations = Station::all();
        $visited = [];
        $this->calculateRoutes(null, $stationFrom->id, $stationTo->id, $visited);
        if(count($this->paths) > 0)
        {
            return min($this->paths);
        }
        else
        {
            return "No need to travel. You are already where you wanted to be :)";
        }
    }

    private function calculateRoutes($previousStation, $currentStation, $destinationStation, $visitedStations = [])
    {
        $startId = $currentStation;
        $endId = $destinationStation;
        if($currentStation > $destinationStation)
        {
            $startId = $destinationStation;
            $endId = $currentStation;
        }
        $previousStation = Station::find($previousStation);
        $currentStation = Station::find($startId);
        $destinationStation = Station::find($endId);

        if ($currentStation->id == $destinationStation->id) {
            return $this->printRoute($destinationStation, $visitedStations);
        } else {
            if (isset($currentStation->next)) {
                if (!in_array($currentStation->name, $visitedStations)) {
                    array_push($visitedStations, $currentStation->name);

                    if ($currentStation->intersections->isNotEmpty()) {
                        foreach ($currentStation->intersections as $intersection) {
                            if (isset($previousStation)) {
                                $stations = $intersection->stations->where('id', '<>', $previousStation->id);
                            } else {
                                $stations = $intersection->stations;
                            }

                            foreach ($stations as $station) {
                                $this->calculateRoutes($station->id, $station->next, $destinationStation->id, $visitedStations);
                            }
                        }
                    } else {
                        $this->calculateRoutes($currentStation->id, $currentStation->next, $destinationStation->id, $visitedStations);
                    }
                    array_pop($visitedStations);
                }
            }
        }
    }

    private function printRoute($destinationStation, $visitedStations)
    {
        if (!$visitedStations) {
            echo "No need to travel. You are already where you wanted to be :)";
        } else {
            array_push($visitedStations, $destinationStation->name);
            array_push($this->paths, $visitedStations);
            return $this->paths;
        }
    }
}
