@extends('layouts.app', ['title' => __('video Management')])

@section('content')
    @include('admin.users.partials.header', ['title' => __('Preview Video')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Course Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('courses.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row the_course">
                            <div class="col-sm-4">

                                <div class="course-image">
                                    @if($course->photo)
                                        <img src="/images/{{$course->photo->filename}}" class="card-img-top" alt="Course Photo">
                                    @else
                                        <img src="/images/default.jpg" class="card-img-top" alt="Course Photo">
                                    @endif
                                </div>

                            </div>

                            <div class="col-sm">
                                <div class="course-info">
                                    <h3>{{ \Str::limit($course->title,50) }}</h3>

                                    <h5><a href="/admin/tracks/{{$course->track->id}}">{{ $course->track->name}}</a></h5>

                                    <span class="{{ $course->status == 0 ? 'text-success' : 'text-danger'}}">
                                        {{ $course->status == 0 ? 'FREE' : 'PAID'}}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <div class="row align-items-center">
                            <div class="col-8">
                                <h2 class="mb-0">{{ __('Course Videos') }}</h2>
                            </div>
                            <div class="col-4 text-right">
                                <a href="/admin/courses/{{$course->id}}/videos/create" class="btn btn-sm btn-primary">{{ __('New Video') }}</a>
                            </div>
                        </div>
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Video Title') }}</th>
                                    <th scope="col">{{ __('Creation Date') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($course->videos as $video)
                                    <tr>
                                        <td title="{{$video->title}}">
                                            <a href="/admin/videos/{{ $video->id }}"> {{ \Str::limit($video->title, 50) }} </a>
                                        </td>
                                        
                                        <td>{{ $video->created_at->diffForHumans() }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <form action="{{ route('videos.destroy', $video) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        
                                                        <a class="dropdown-item" href="{{ route('videos.edit', $video) }}">{{ __('Edit') }}</a>
                                                        
                                                        <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this video?") }}') ? this.parentElement.submit() : ''">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>    
                                                    
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Quizzes') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="/admin/courses/{{$course->id}}/quizzes/create" class="btn btn-sm btn-primary">{{ __('Add Quiz') }}</a>
                            </div>
                        </div>
                    </div>
                    

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Quiz Name') }}</th>
                                    <th scope="col">{{ __('Questions count') }}</th>
                                    <th scope="col">{{ __('Course Title') }}</th>
                                    <th scope="col">{{ __('Creation Date') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($course->quizzes as $quiz)
                                    <tr>
                                        <td><a href="{{ route('quizzes.show', $quiz) }}">{{ $quiz->name }}</a></td>
                                        <td>{{ count($quiz->questions) }}</td>
                                        <td>
                                            <a href="/admin/courses/{{ $quiz->course->id }}">{{ \Str::limit($quiz->course->title, 30) }}</a>
                                        </td>
                                        <td>{{ $quiz->created_at->diffForHumans() }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    
                                                <form action="{{ route('quizzes.destroy', $quiz) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    
                                                    <a class="dropdown-item" href="{{ route('quizzes.edit', $quiz) }}">{{ __('Edit') }}</a>
                                                    <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this quiz?") }}') ? this.parentElement.submit() : ''">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>    
                                                    
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
@endsection