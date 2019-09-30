<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Metro;
use App\Station;
use Illuminate\Http\Request;

class SearchShortPathController extends Controller
{
    public function index()
    {
        $metros = Metro::all();

        return view('underground.select_city', compact('metros'));
    }

    public function searchStations(Request $request)
    {
        $location = $request->get('location');
        $branches_ids = Branch::where('metro_id', $location)->pluck('id');
        $stations = Station::whereIn('branch_id', $branches_ids)->get();

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
            echo "No need to travel. You are already where you wanted to be :)";
        } else {
            $arrayOfStations = [];
            for($i = 0; $i <= count($visitedStationIds) - 1; $i++)
            {
                $station = Station::find($visitedStationIds[$i]);
                $station_name = '';
                $destination_name = "<span style=background:cyan;>$destinationStation->name</span>";
                switch($station->branch->metro->location)
                {
                    case 'Kharkiv' : {
                        $station_name = "<span style=background:cyan;>$station->name</span>";
                        break;
                    }
                    case 'KharkivBus' : {
                        $station_name = "<mark>$station->name</mark>";
                        break;
                    }
                    default: {
                        $station_name = $station->name;
                    }
                }
                array_push($arrayOfStations, $station_name);
            }
            array_push($arrayOfStations, $destination_name);
            array_push($routes, $arrayOfStations);
        }
    }
}
