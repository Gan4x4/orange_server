<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Converter;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $projects = $user->projects;
        return view('project.index',[
            'projects'=>$projects,
        ]);
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
        
        $user = Auth::user();
        $file = $request->file('file');
        //dd($file);
        $destDir = storage_path('app/projects');
        $destFile = tempnam($destDir, 'upload');
        //dump($destFile);
        if (! $file->move($destDir,pathinfo($destFile,PATHINFO_BASENAME)) || ! file_exists($destFile)){
            throw new \Exception('File not moved to '.$destFile);
        }
        chmod($destFile,0644);
        $project = new Project(); 
        $project->user_id = $user->id;
        $project->name = $file->getClientOriginalName();
        $project->filename = $file->getClientOriginalName();
        $project->original = $destFile;
        $project->save();
        
        
        $destJsFile = tempnam($destDir, 'converted');
        
        $wrapper = new Converter($destFile);
        $wrapper->convert($destJsFile);
        
        if ($wrapper->checkResult() ){
            $project->compiled = $destJsFile;
            $project->log = $wrapper->output2string();
            $project->save();
            return redirect()->route('projects.index');
        }
        else{
            print $wrapper->output2html(true);    
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
        $project = Project::findOrFail($id);
        return view('project.show',[
            'project'=>$project
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect()->route('projects.index');
    }
    
    
    public function downloadOriginal($id){
        $project = Project::findOrFail($id);
        return response()->file($project->original,[
            'Content-Disposition'=>'attachment; filename="'.$project->filename.'"']);
    }
    
    public function downloadCompiled($id){
        $project = Project::findOrFail($id);
        return response()->file($project->compiled,['Content-Type'=>'application/javascript']);
    }
    
    public function play($id){
        $project = Project::findOrFail($id);
        return view('player',[
            'project'=>$project,
            'dir'=>'/player/',
            'data'=>route('download_js',$id)
        ]);
    }
    
}
