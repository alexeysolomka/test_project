<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Intersection;
use App\Metro;
use App\Station;
use Illuminate\Http\Request;

class SearchShortPathController extends Controller
{
    public function index()
    {
        // $metros = Metro::all();
        $stations = Station::all();

        return view('underground.search_path', compact('stations'));
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

        $allStations = Station::with('intersections')->get();
        $allIntersections = Intersection::with('stations')->get();

        $collectionOfStations = collect($allStations);
        $collectionOfBranches = collect();
        foreach ($collectionOfStations->unique('branch_id') as $station) {
            $collectionOfBranches->push([
                'branch_id' => $station->branch_id,
                'color' => $this->randomColor()
            ]);
        }

        $collectionOfIntersections = collect($allIntersections);

        $routes = [];
        $visitedStations = [];

        $this->calcucateRoutes(null, $from, $to, $collectionOfStations, $collectionOfIntersections, $visitedStations, $routes);

        $minRoute = $this->minTimeRoute($routes);
        foreach($routes as $route)
        {
            if($minRoute != $route)
            {
                $this->printRoute($route, $collectionOfBranches);
            }   
        }

        echo '<hr> Min Route:';

        $this->printRoute($minRoute, $collectionOfBranches);
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

    private function printRoute($route, $branches)
    {
        $travelTimeRoute = 0;
        foreach($route as $route)
        {
            $travelTimeRoute += $route->travel_time;
            $branch_id = $route->branch_id;
            $branch = $branches->first(function ($branch) use ($branch_id) {
                return $branch['branch_id'] == $branch_id;
            });
            $station = "<span style='background: #{$branch['color']};'>{$route->name}</span>";

            echo $station . '-';
        }
        echo '<br>' . round($travelTimeRoute / 60, 2) . ' minutes' . '<br>';
    }

    private function randomColorPart()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    private function randomColor()
    {
        return $this->randomColorPart() . $this->randomColorPart() . $this->randomColorPart();
    }
}
