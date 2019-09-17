<?php

namespace App\Http\Controllers;

use App\Intersection;
use App\Station;
use Illuminate\Http\Request;

class SearchShortPathController extends Controller
{
    private $paths;
    private $dist;

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
//        $this->searchPath($stationFrom, $stationTo);
        $this->enumerate($stationFrom, $stationTo);
    }

    private function enumerate($source, $dest)
    {
        array_unshift($this->path, $source);
        $discovered[] = $source;

        if ($source === $dest) {
            $this->paths[] = $this->path;
        } else {
            if (!$this->prev[$source]) {
                return;
            }
            foreach ($this->prev[$source] as $child) {
                if (!in_array($child, $discovered)) {
                    $this->enumerate($child, $dest);
                }
            }
        }

        array_shift($this->path);
        if (($key = array_search($source, $discovered)) !== false) {
            unset($discovered[$key]);
        }
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
