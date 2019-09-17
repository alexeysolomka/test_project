<?php

namespace App\Http\Controllers;

use App\Intersection;
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
        $path = [];

        $stationFrom = Station::find($from);
        $stationTo = Station::find($to);
        $nextStation = $stationFrom->next;
        $stations = Station::all();

        $stations_ids = [];
        $this->searchPath($stationFrom, $stationTo);
    }

    private function searchPath($start, $to)
    {
        if($start->id == $to->id)
        {
            dd($to);
        }
        if(isset($start->next))
        {
            $next = Station::find($start->next);
            dump($next->name);
            if($start->branch_id == $to->branch_id)
            {
                $next = Station::find($start->next);
                return $this->searchPath($next, $to);
            }
            else
            {
                if($intersections = $start->intersections)
                {
                    foreach($intersections as $intersection)
                    {
                        if($stations = $intersection->stations)
                        {
                            foreach($stations as $station)
                            {
                                if($station->branch_id == $to->branch_id)
                                {
                                    $stations = Station::where('branch_id', $station->branch_id)->get();
                                    foreach($stations as $item)
                                    {
                                        dump($item->name);
                                        if($item->next == $to->id)
                                        {
                                            dd($to);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                return $this->searchPath($next, $to);
            }

        }

        return false;
    }
}
