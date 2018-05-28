@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    
                        Player
                        
                        
                        
                        <link rel="stylesheet" href="main.css"/>
	<script src="{{$dir}}debugout.js"></script>
	<script src="{{$dir}}options.js"></script>
                        
                        
                        
                        
                       <div class="debugInfo" id="fpscounter">0 FPS</div>
	<div class="debugInfo" id="updatefpscounter">0 update cycles</div>
	<div class="debugInfo" id="taskfpscounter">0 tasks per second</div>
	<div class="debugInfo" id="updateQueue">updateQueue: </div>
	<div class="debugInfo" id="versionLabel1"></div>
	<div class="debugInfo" id="versionLabel2"></div>
	<a class="debugInfo" id="logFileLink" href="#" onclick="downloadLogFile()">log file</a>
	
	<div id="screen-div">
		<div id="root-div"></div>
		<div id="layer-div"></div>
	</div>
	
	<a id="showDebugInfo" href="#">show debug panel</a>
	
 	<script>
		var debugout = new debugout();
		debugout.log("logger (debugout.js) initialized");
		
		function downloadLogFile(){
			debugout.downloadLog();
		}
		
		window.onerror = function (errorMsg, url, lineNumber, column, errorObj) {
			debugout.log('Error: ' + errorMsg + ' Script: ' + url + ' Line: ' + lineNumber
			+ ' Column: ' + column + ' StackTrace: ' +  errorObj);
		}
		
		/*function dumpObject (obj) {
			var output, property;
			for (property in obj) {
				output += property + ': ' + obj[property] + '; ';
			}
			debugout.log(output);
		}*/
		
		//only Chrome supports this:
		window.addEventListener('unhandledrejection', function(event) {
			debugout.log('Unhandled rejection in promise. Reason: ');
			debugout.log(event.reason.message || event.reason);
			debugout.log(event.reason.stack);
		});
		
	</script>
	
    <script src="{{$dir}}vendors.js"></script>
	<script src="{{$data}}"></script>
    <script src="{{$dir}}main.js"></script> 
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
