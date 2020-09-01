<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Course;
use App\Photo;

class courseController extends Controller
{

    public function index()
    {
        $courses = Course::orderby('id', 'desc')->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    
    public function create()
    {
        return view('admin.courses.create');
    }

    
    public function store(Request $request)
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
        return redirect('/admin/courses')->withStatus('Course successfully created');

    }

    
    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    
    public function update(Request $request, Course $course)
    {
      $rules=[
            'title' => 'required|min:15|max:150',
            'status' => 'required|integer|in:1,0',
            'link' => 'required|url',
            'track_id' => 'required|integer',
        ];

        $this->validate($request, $rules);

        $course->update($request->all());
          //insert the image
        

        if($file = $request->file('image')){

            $filename = $file->getClientOriginalName();
            $fileextension = $file->getClientOriginalExtension();
            $file_to_store = time() . '_' . explode('.', $filename)[0] . '_.' .$fileextension;

            if($file->move('images', $file_to_store)){
                if($course->photo){

                    // delete old photo from server
                    $filename = $course->photo->filename;
                    unlink('images/'.$filename);
                    // save the new image
                    $photo = $course->photo;
                    $photo->filename = $file_to_store;
                    $photo->save();
                }
                else {
                    Photo::create([
                        'filename' => $file_to_store,
                        'photoable_id' => $course->id,
                        'photoable_type' => 'App\Course',
                    ]);

                }
                
            }

        }
        
        return redirect('/admin/courses')->withStatus('Course successfully updated');  
    }

    
    public function destroy(Course $course)
    {
        if($course->photo){
            $filename = $course->photo->filename;
            // delete course photo from server
            unlink('images/'.$filename);
            // delete course server from database
            $course->photo->delete();
        }
        
        
        $course->delete();
        return redirect('/admin/courses')->withStatus('course successfuly deleted');
    }
}
