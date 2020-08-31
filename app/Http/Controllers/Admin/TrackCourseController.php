<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Track;
use App\course;
use App\Photo;

class TrackCourseController extends Controller
{
   public function create(Track $track)
    {
        return view('admin.tracks.createcourse', compact('track'));
    }

    
    public function store(Request $request, Track $track)
    {
        $rules=[
            'title' => 'required|min:15|max:150',
            'status' => 'required|integer|in:1,0',
            'link' => 'required|url',
            'track_id' => 'required|integer',
        ];

        $this->validate($request, $rules);

        $course = Course::create($request->all());
          //insert the image
        if($course){

            if($file = $request->file('image')){

                $filename = $file->getClientOriginalName();
                $fileextension = $file->getClientOriginalExtension();
                $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' .$fileextension;

                if($file->move('images', $file_to_store)){
                    Photo::create([
                        'filename' => $file_to_store,
                        'photoable_id' => $course->id,
                        'photoable_type' => 'App\Course',
                    ]);
                }

            }
        }
        return redirect('/admin/tracks/'.$track->id)->withState('Course successfully created');
    }
}