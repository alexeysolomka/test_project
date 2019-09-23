<?php

namespace App\Http\Controllers;

use App\Station;
use Illuminate\Http\Request;

class SearchShortPathController extends Controller
{
    public function index()
    {
        $stations = Station::all();

        return view('underground.search_path', compact('stations'));
    }

    public function search(Request $request)
    {
        $from = $request->from;
        $to = $request->to;

        $stationFrom = Station::find($from);
        $stationTo = Station::find($to);

        $routes = [];
        $visitedStations = [];

        $this->calculateRoutes(null, $stationFrom->id, $stationTo->id, $visitedStations, $routes);

        if(count($routes) > 0)
        {
            $shortestRoute = min($routes);

            foreach($shortestRoute as $route)
            {
                echo $route . '->';
            }
        }
    }

    private function calculateRoutes($previousStationId, $currentStationId, $destinationStationId, & $visitedStationsIds, & $routes)
    {
        $currentStation = Station::find($currentStationId);
        $destinationStation = Station::find($destinationStationId);
        if ($currentStation->id == $destinationStation->id) {
            $this->persistRoute($destinationStation, $visitedStationsIds, $routes);
        } else {
            $stations = [];
            if(isset($currentStation->next))
            {
                $stationNext = Station::find($currentStation->next);
                array_push($stations, $stationNext);
            }
            $prevStations = Station::where('next', $currentStation->id)->get();
            if($prevStations->isNotEmpty())
            {
                array_push($stations, $prevStations->first());
            }
            if (isset($currentStation->intersections)) {
                foreach ($currentStation->intersections as $intersection) {
                    foreach ($intersection->stations as $intersectionStation) {
                        if($intersectionStation->id == $currentStation->id)
                        {
                            continue;
                        }
                        array_push($stations, $intersectionStation);
                    }
                }
            }
            if (!empty($stations)) {
                if (!in_array($currentStation->id, $visitedStationsIds)) {
                    array_push($visitedStationsIds, $currentStation->id);

                    foreach($stations as $nextStation)
                    {
                        if($previousStationId != null && $previousStationId == $nextStation->id)
                        {
                            continue;
                        }
                        $this->calculateRoutes($currentStation->id, $nextStation->id, $destinationStationId, $visitedStationsIds, $routes);
                    }
                    array_pop($visitedStationsIds);
                }
            }
        }
    }

    private function persistRoute($destinationStation, & $visitedStationIds, & $routes)
    {
        if (!$visitedStationIds) {
//            echo "No need to travel. You are already where you wanted to be :)";
        } else {
            $arrayOfStations = [];
            for($i = 0; $i <= count($visitedStationIds) - 1; $i++)
            {
                array_push($arrayOfStations, Station::find($visitedStationIds[$i])->name);
            }
            array_push($arrayOfStations, $destinationStation->name);
            array_push($routes, $arrayOfStations);
        }
    }
}
