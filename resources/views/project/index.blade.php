@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Projects</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul>
                    @foreach($projects as $project)
                        <li>
                            <h3>
                                <a href="{{ route('play_project',$project->id) }}">{{ $project->name }}</a>
                            </h3>
                            <a href="{{ route('download_mwx',$project->id) }}">mwx</a>
                            <a href="{{ route('download_js',$project->id) }}">js</a>
                            <a href="{{ route('projects.show',$project->id) }}">log</a>
                            
                            <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button>Delete</button>
                            </form>
                            
                            
                        </li>
                    @endforeach
                    </ul>
                    <hr>
                    <h4>Upload new project</h4>
                    {!! Form::open(['route' => 'projects.store','files'=>true]) !!}
                        {!! Form::file('file') !!}
                        {!! Form::submit('Upload') !!}
                    {!! Form::close() !!}
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
