<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Track;

class TrackController extends Controller
{
    
    public function index()
    {
        $tracks= Track::orderBy('id','desc')->paginate(20);
        return view('admin.tracks.index', compact('tracks'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' =>'required|min:3|max:50'
        ];

        $this->validate($request, $rules);
        if(Track::create($request->all())){
            return redirect('/admin/tracks')->withStatus('Track successfuly created');
        } else{
            return redirect('/admin/tracks')->withStatus('something wrong, Try again');
        }

            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // show all courses related to this track
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Track $track)
    {
        return view('admin.tracks.edit', compact('track'));
    }

    
    public function update(Request $request, $id)
    {
        $rules = [
            'name' =>'required|min:3|max:50'
        ];
        
        $this->validate($request, $rules);
    }

    
    public function destroy(Track $track)
    {
        $track->delete();
        return redirect('/admin/tracks')->withStatus('Track successfuly deleted');
    }
}
