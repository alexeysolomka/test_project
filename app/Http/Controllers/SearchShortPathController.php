<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Intersection;
use App\Metro;
use App\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchShortPathController extends Controller
{
    public function index()
    {
        // $metros = Metro::all();
        $stations = Station::whereIn('branch_id', [1,2,3])->orderBy('id', 'ASC')->get();

        return view('underground.search_path', compact('stations'));
    }

    public function getStations()
    {
        $branches = Branch::with(array('stations' => function ($query) {
            $query->select('branch_id', DB::raw("ST_AsGeoJSON(point) as point"));
        }))
        ->get();

        $stations = DB::table('stations')
        ->select('name', 'branch_id', DB::raw("ST_AsGeoJSON(point) as point"))
        ->get();

        return response()->json([
            'stations' => $stations,
            'branches' => $branches
        ], 201);
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

        $allStations = Station::with('intersections')->select('id', 'branch_id', 'name', 'next', 'travel_time', DB::raw("ST_AsGeoJSON(point) as point"))->get();
        $allIntersections = Intersection::with('stations')->get();

        $collectionOfStations = collect($allStations);

        $collectionOfIntersections = collect($allIntersections);

        $routes = [];
        $visitedStations = [];

        $this->calcucateRoutes(null, $from, $to, $collectionOfStations, $collectionOfIntersections, $visitedStations, $routes);

        $minRoute = $this->minTimeRoute($routes);

        return response()->json([
            'minRoute' => $minRoute
        ], 201);
    }

    private function calcucateRoutes($previousStationId, $currentStationId, $destinationStationId, $allStations, $collectionOfIntersections, &$visitedStations, &$routes)
    {
        $currentStation = $allStations->first(function ($station) use ($currentStationId) {
            return $station->id == $currentStationId;
        });
        $destinationStation = $allStations->first(function ($station) use ($destinationStationId) {
            return $station->id == $destinationStationId;
        });

        if ($currentStation->id == $destinationStation->id) {
            $this->persistRoute($destinationStation, $visitedStations, $routes);
        } else {
            $stations = [];
            if (isset($currentStation->next)) {
                $stationNext = $allStations->first(function ($station) use ($currentStation) {
                    return $station->id == $currentStation->next;
                });
                array_push($stations, $stationNext);
            }
            $prevStations = $allStations->where('next', $currentStation->id);
            if ($prevStations->isNotEmpty()) {
                array_push($stations, $prevStations->first());
            }
            $intersections = $currentStation->intersections;
            if ($intersections->isNotEmpty()) {
                foreach ($intersections as $intersection) {
                    $intersection = $collectionOfIntersections->first(function ($collectionIntersection) use ($intersection) {
                        return $collectionIntersection->id == $intersection->id;
                    });
                    $intersectionStations = $intersection->stations;
                    foreach ($intersectionStations as $intersectionStation) {
                        if ($intersectionStation->id == $currentStation->id) {
                            continue;
                        }
                        array_push($stations, $intersectionStation);
                    }
                }
            }
            if (!empty($stations)) {
                if (!in_array($currentStation, $visitedStations)) {
                    array_push($visitedStations, $currentStation);

                    foreach ($stations as $nextStation) {
                        if ($previousStationId != null && $previousStationId == $nextStation->id) {
                            continue;
                        }
                        if (count($routes) > 1) {
                            $minRoute = $this->minTimeRoute($routes);
                            if ($this->travelTime($visitedStations) >= $this->travelTime($minRoute)) {
                                continue;
                            }
                        }
                        $this->calcucateRoutes($currentStation->id, $nextStation->id, $destinationStationId, $allStations, $collectionOfIntersections, $visitedStations, $routes);
                    }
                    array_pop($visitedStations);
                }
            }
        }
    }

    private function travelTime($route)
    {
        $travelTime = 0;
        foreach($route as $route)
        {
            $travelTime += $route->travel_time;
        }

        return $travelTime;
    }

    private function minTimeRoute($routes)
    {
        $minTimeRoute = $routes[0];
        $sizeRoutes = count($routes);

        for($i = 0; $i < $sizeRoutes; $i++)
        {
            if($this->travelTime($routes[$i]) < $this->travelTime($minTimeRoute))
            {
                $minTimeRoute = $routes[$i];
            }
        }

        return $minTimeRoute;
    }

    private function persistRoute($destinationStationName, &$visitedStations, &$routes)
    {
        if (!$visitedStations) {
            echo "No need to travel. You are already where you wanted to be :)";
        } else {
            $arrayOfStations = array();
            $size = count($visitedStations);
            for ($i = 0; $i < $size; $i++) {
                array_push($arrayOfStations, $visitedStations[$i]);
            }
            array_push($arrayOfStations, $destinationStationName);
            array_push($routes, $arrayOfStations);
        }
    }
}
