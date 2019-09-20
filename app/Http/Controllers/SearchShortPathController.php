<?php

namespace App\Http\Controllers;

use App\Station;
use Illuminate\Http\Request;

class SearchShortPathController extends Controller
{
    private $paths;
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
        $routes[] = $this->calculateRoutes(null, $stationFrom->id, $stationTo->id, $visited);
    }

    private function searchRoutes($start, $end, $routes = [])
    {
        $startId = $start;
        $endId = $end;
        if ($start < $end) {
            $startId = $start;
            $endId = $end;
        } else {
            $startId = $end;
            $endId = $start;
        }

        $start = Station::find($startId);
        $end = Station::find($endId);

        $routes[] = $start->name;

        if ($start->id == $end->id) {
            return $routes;
        }

        if (isset($start->next)) {
            if ($start->intersections->isNotEmpty()) {
                foreach ($start->intersections as $intersection) {
                    $stations = $intersection->stations->where('id', '<>', $intersection->station_id);
                    foreach ($stations as $station) {
                        $branch_id = $station->branch_id;
                        $stationsBranch = Station::where('branch_id', $branch_id)->where('id', '>=', $station->id)->get();
                        foreach ($stationsBranch as $stationBranch) {
                            if (!in_array($stationBranch->name, $routes)) {
                                $newRoutes = $this->searchRoutes($stationBranch->id, $end->id, $routes);
                                foreach ($newRoutes as $newRoute) {
                                    array_push($routes, $newRoute);
                                }
                            }
                            return $this->searchRoutes($start->next, $end->id, $routes);
                        }
                    }
                }
            }
            return $this->searchRoutes($start->next, $end->id, $routes);
        }

        return $routes;
    }

    private function calculateRoutes($previousStation, $currentStation, $destinationStation, $visitedStations = [])
    {
        $previousStation = Station::find($previousStation);
        $currentStation = Station::find($currentStation);
        $destinationStation = Station::find($destinationStation);
        if ($currentStation->id == $destinationStation->id) {
            $this->printRoute($destinationStation, $visitedStations);
        } else {
            if (isset($currentStation->next)) {
                if (!in_array($currentStation->name, $visitedStations)) {
                    array_push($visitedStations, $currentStation->name);

                    if($currentStation->intersections->isNotEmpty())
                    {
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
                    }
                    else
                    {
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
            foreach($visitedStations as $station)
            {
                dump($station);
            }
        }
    }
}
