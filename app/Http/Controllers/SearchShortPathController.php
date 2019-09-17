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

        if($from == $to)
        {
            $path [] = $stationFrom->name;
            return $path;
        }
        if($stationFrom->branch_id == $stationTo->branch_id)
        {
            $branch = $stationFrom->branch;
            $stationsBranch = $branch->stations;
            if($stationFrom->id > $stationTo->id)
            {
                $betweenFromTo = $stationsBranch->whereBetween('id', [$stationTo->id, $stationFrom->id]);

            }
            else
            {
                $betweenFromTo = $stationsBranch->whereBetween('id', [$stationFrom->id, $stationTo->id]);
            }
            foreach($betweenFromTo as $station)
            {
                $path [] = $station->name;
            }

            return $path;
        }

        $branch__from_id = $stationFrom->branch_id;
        $branch_to_id = $stationTo->branch_id;

        $intersectionsStationFrom = $stationFrom->intersections;
        $intersectionsStationTo = $stationTo->intersections;
        dd($intersectionsStationFrom, $intersectionsStationTo->first()->stations);

        dd($path);
    }
}
