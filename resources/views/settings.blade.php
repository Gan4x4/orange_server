@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Compiler</div>

                <div class="panel-body">
                    {!! $compiler !!}
                    <form action="{{ route('settings.update.compiler') }}" method="POST">
                        {{ csrf_field() }}
                        <button>Update</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
