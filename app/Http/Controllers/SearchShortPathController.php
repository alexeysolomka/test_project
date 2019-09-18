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

        $routes[] = $this->searchRoutes($stationFrom->id, $stationTo->id);
        dd($routes);
    }


    private function searchRoutes($start, $end, $routes = [])
    {
        $startId = $start;
        $endId = $end;
        if($start < $end)
        {
            $start = Station::find($startId);
            $end = Station::find($endId);
        }
        else
        {
            $start = Station::find($endId);
            $end = Station::find($startId);
        }

        $routes[] = $start;
        $end_branch_id = $end->branch_id;

        if($start->id == $end->id)
        {
            return $routes;
        }

        if($start->branch_id == $end_branch_id)
        {
            return $this->searchRoutes($start->next, $end->id, $routes);
        }

        if(isset($start->next))
        {
            if($start->intersections->isEmpty())
            {
                return $this->searchRoutes($start->next, $end->id, $routes);
            }
            else
            {
                foreach($start->intersections as $intersection)
                {
                    foreach($intersection->stations as $station)
                    {
                        if($station->branch_id == $end_branch_id)
                        {
                            $stations = Station::where('branch_id', $end_branch_id)->get();
                            foreach($stations as $item)
                            {
                                $routes[] = $item;
                                if($item->id == $end->id)
                                {
                                    return $routes;
                                }
                            }
                        }
                    }
                }
                return $this->searchRoutes($start->next, $end->id, $routes);
            }
        }

        return $routes;
    }
}
