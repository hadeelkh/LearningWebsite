<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Video;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::orderby('id', 'desc')->paginate(20);
        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.videos.create');
    }

    
    public function store(Request $request)
    {
        $rules=[
            'title' => 'required|min:10|max:100',
            'link' => 'required|url',
            'course_id' => 'required|integer',
        ];

        $this->validate($request, $rules);

        $Video = Video::create($request->all());

        if($Video){
            return redirect('/admin/videos')->withStatus('Video successfully created.');
        } else{
            return redirect('/admin/videos/create')->withStatus('something wrong happened, Try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    
    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

   
    public function update(Request $request, Video $video)
    {
        $rules=[
            'title' => 'required|min:10|max:100',
            'link' => 'required|url',
            'course_id' => 'required|integer',
        ];

        $this->validate($request, $rules);
        if($video->update($request->all())){
            return redirect('/admin/videos')->withStatus('Video successfully updated.');
        } else{
            return redirect('/admin/videos'.$video->id.'/edit')->withStatus('something wrong happened, Try again.');
        }
        
    }

    
    public function destroy(Video $video)
    {
        $video->delete();
        return redirect('/admin/videos')->withStatus('video successfuly deleted');
    }
}
