<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    
    public function settings()
    {
        
        $currentDir = getcwd();
        //$converter = new Converter();
        chdir(base_path().DIRECTORY_SEPARATOR.'../mwxcompiler');
        $command = escapeshellcmd('git status --branch');
        $output = "";
        $result = "";
        exec($command ,$output ,$result);
        chdir($currentDir);
        //dd($output);
        return view('settings')->with(
                [
                    'compiler'=>implode('<br>',$output)
                ]);
    }
    
    
    public function updateCompiler()
    {
        $currentDir = getcwd();
        chdir(base_path().DIRECTORY_SEPARATOR.'../mwxcompiler');
        $command = escapeshellcmd('git pull');
        $output = "";
        $result = "";
        exec($command ,$output ,$result);
        chdir($currentDir);
        //dump($result);
        //dd($output);
        return view('settings')->with(
                [
                    'compiler'=>implode('<br>',$output)
                ]);
    }
    
    
    
}
