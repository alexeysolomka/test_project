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
        foreach($collectionOfStations->unique('branch_id') as $station)
        {
            $collectionOfBranches->push([
                'branch_id' => $station->branch_id,
                'color' => $this->randomColor()
            ]);
        }
        
        $collectionOfIntersections = collect($allIntersections);

        $routes = [];
        $visitedStations = [];

        $this->newCalcucateRoutes(null, $from, $to, $collectionOfStations, $collectionOfBranches, $collectionOfIntersections, $visitedStations, $routes);
        // $this->calculateRoutes(null, $stationFrom->id, $stationTo->id, $visitedStations, $routes);

        if (count($routes) > 0) {
            $shortestRoute = min($routes);
            foreach ($shortestRoute as $route) {
                echo '->' . $route;
            }
        } else {
            return "Route is not found.";
        }
    }

    private function newCalcucateRoutes($previousStationId, $currentStationId, $destinationStationId, $allStations, $collectionOfBranches, $collectionOfIntersections, &$visitedStations, &$routes)
    {
        $currentStation = $allStations->first(function ($station) use ($currentStationId) {
            return $station->id == $currentStationId;
        });
        $destinationStation = $allStations->first(function ($station) use ($destinationStationId) {
            return $station->id == $destinationStationId;
        });

        if ($currentStation->id == $destinationStation->id) {
            $this->newPersistRoute($collectionOfBranches, $destinationStation, $visitedStations, $routes);
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
                        $this->newCalcucateRoutes($currentStation->id, $nextStation->id, $destinationStationId, $allStations, $collectionOfBranches, $collectionOfIntersections, $visitedStations, $routes);
                    }
                    array_pop($visitedStations);
                }
            }
        }
    }

    private function newPersistRoute($branches, $destinationStationName, &$visitedStations, &$routes)
    {
        if (!$visitedStations) {
            echo "No need to travel. You are already where you wanted to be :)";
        } else {
            $arrayOfStations = array();
            $size = count($visitedStations);
            $station = '';
            for ($i = 0; $i < $size; $i++) {
                $branch_id = $visitedStations[$i]->branch_id;
                $branch = $branches->first(function ($branch) use($branch_id) {
                    return $branch['branch_id'] == $branch_id;
                });
                $station = "<span style='background: #{$branch['color']};'>{$visitedStations[$i]->name}</span>";
                array_push($arrayOfStations, $station);
            }
            $branch = $branches->first(function ($branch) use($destinationStationName) {
                return $branch['branch_id'] == $destinationStationName->branch_id;
            });
            $destinationStation = "<span style='background: #{$branch['color']};'>{$destinationStationName->name}</span>";
            array_push($arrayOfStations, $destinationStation);
            array_push($routes, $arrayOfStations);
        }
    }

    private function randomColorPart() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }
    
    private function randomColor() {
        return $this->randomColorPart() . $this->randomColorPart() . $this->randomColorPart();
    }
    

    private function calculateRoutes($previousStationId, $currentStationId, $destinationStationId, &$visitedStationsIds, &$routes)
    {
        $currentStation = Station::find($currentStationId);
        $destinationStation = Station::find($destinationStationId);
        if ($currentStation->id == $destinationStation->id) {
            $this->persistRoute($destinationStation, $visitedStationsIds, $routes);
        } else {
            $stations = [];
            if (isset($currentStation->next)) {
                $stationNext = Station::find($currentStation->next);
                array_push($stations, $stationNext);
            }
            $prevStations = Station::where('next', $currentStation->id)->get();
            if ($prevStations->isNotEmpty()) {
                array_push($stations, $prevStations->first());
            }
            if (isset($currentStation->intersections)) {
                foreach ($currentStation->intersections as $intersection) {
                    foreach ($intersection->stations as $intersectionStation) {
                        if ($intersectionStation->id == $currentStation->id) {
                            continue;
                        }
                        array_push($stations, $intersectionStation);
                    }
                }
            }
            if (!empty($stations)) {
                if (!in_array($currentStation->id, $visitedStationsIds)) {
                    array_push($visitedStationsIds, $currentStation->id);

                    foreach ($stations as $nextStation) {
                        if ($previousStationId != null && $previousStationId == $nextStation->id) {
                            continue;
                        }
                        $this->calculateRoutes($currentStation->id, $nextStation->id, $destinationStationId, $visitedStationsIds, $routes);
                    }
                    array_pop($visitedStationsIds);
                }
            }
        }
    }

    private function persistRoute($destinationStation, &$visitedStationIds, &$routes)
    {
        if (!$visitedStationIds) {
            echo "No need to travel. You are already where you wanted to be :)";
        } else {
            $arrayOfStations = [];
            for ($i = 0; $i <= count($visitedStationIds) - 1; $i++) {
                array_push($arrayOfStations, Station::find($visitedStationIds[$i])->name);
            }
            array_push($arrayOfStations, $destinationStation->name);
            array_push($routes, $arrayOfStations);
        }
    }
}
