<?php

use App\Station;
use App\Intersection;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allStations = Station::with('intersections')->select('id', 'branch_id', 'name', 'next', 'travel_time', DB::raw("ST_AsGeoJSON(point) as point"))->get();
        $allIntersections = Intersection::with('stations')->get();

        $collectionOfStations = collect($allStations);
        $collectionOfIntersections = collect($allIntersections);

        $stationIds = $collectionOfStations->pluck('id');
        $min = $stationIds->min();
        $max = $stationIds->max();
        $from = rand($min, $max);

        $stationIds = $collectionOfStations->where('id', '!=', $from)->pluck('id');
        $min = $stationIds->min();
        $max = $stationIds->max();
        $to = rand($min, $max);

        $routes = [];
        $visitedStations = [];

        $this->calcucateRoutes(null, $from, $to, $collectionOfStations, $collectionOfIntersections, $visitedStations, $routes);
        $route = [];

        if (count($routes) >= 1) {
            foreach ($this->minTimeRoute($routes) as $r) {
                $route[] = $r->name;
            }
        }
        $route = json_encode($route);

        $dateNow = Carbon::now();
        $date = $dateNow->addDay(rand(1, 6));
        $date = date_parse_from_format('Y-m-d h:i:s', $date);

        $sigma = 7.5 * 60 * 60;
        $normal = 8 * 60 * 60;
        $start = 7.5 * 60 * 60;
        $end = 9 * 60 * 60;
        
        while($start < $end)
        {
            $numerator = pow($start - $normal, 2);
            $denumerator = 2 * pow($sigma, 2);
            $result = (1 / $sigma * sqrt(2 * M_PI)) * exp(-($numerator / $denumerator));
            $start += 600;
            $time = ($start / 60 / 60) + ($result * 60 * 60);
            $time = sprintf('%02d:%02d', (int) $time, fmod($time, 1) * 60);
            $time = explode(':', $time);
            $dateTime = Carbon::create($date['year'], $date['month'], $date['day'], $time[0], $time[1]);
            DB::table('passengers')
            ->insert([
                [
                    'from_id' => $from,
                    'to_id' => $to,
                    'route' => $route,
                    'date' => $dateTime
                ]
            ]);
        }

        $sigma = 15.5 * 60 * 60;
        $normal = 16 * 60 * 60;
        $start = 15.5 * 60 * 60;
        $end = 17 * 60 * 60;
        
        while($start < $end)
        {
            $numerator = pow($start - $normal, 2);
            $denumerator = 2 * pow($sigma, 2);
            $result = (1 / $sigma * sqrt(2 * M_PI)) * exp(-($numerator / $denumerator));
            $start += 600;
            $time = ($start / 60 / 60) + ($result * 60 * 60);
            $time = sprintf('%02d:%02d', (int) $time, fmod($time, 1) * 60);
            $time = explode(':', $time);
            $dateTime = Carbon::create($date['year'], $date['month'], $date['day'], $time[0], $time[1]);
            DB::table('passengers')
            ->insert([
                [
                    'from_id' => $from,
                    'to_id' => $to,
                    'route' => $route,
                    'date' => $dateTime
                ]
            ]);
        }
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
                        //this check is necessary in order not to go on routes that are greater than the minimum
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

    /**
     * Found travel time for route
     */
    private function travelTime($route)
    {
        $travelTime = 0;
        foreach ($route as $route) {
            $travelTime += $route->travel_time;
        }

        return $travelTime;
    }

    /**
     * Search min route by travel time
     */
    private function minTimeRoute($routes)
    {
        $minTimeRoute = $routes[0];
        $sizeRoutes = count($routes);

        for ($i = 0; $i < $sizeRoutes; $i++) {
            if ($this->travelTime($routes[$i]) < $this->travelTime($minTimeRoute)) {
                $minTimeRoute = $routes[$i];
            }
        }

        return $minTimeRoute;
    }

    /**
     * Store founded routes
     */
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
