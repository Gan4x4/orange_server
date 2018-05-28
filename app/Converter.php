<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

class Convertere extends Translator{
    
    private $file = null;
    //private $converterPath = '../mwxcompiler';
    public $output = [];
    private $result = -1; // Not executed
    //public $destinationDir = '../jswebplayer-export/build';
    public $destinationFile = null;
    public $resultFileName = 'data.js';
            
    public function __construct($file) {
        if ( ! file_exists($file) ){
            throw new Exception('File not exist : '.$file);
        }
        $this->file = $file;
    }
    
    /*
     * To call libreoffice from python script we must have libreoffice dir in 
     * current user (www-data) home directory
     * Detailed explanation here:
     * https://stackoverflow.com/questions/10169042/unable-to-run-oowriter-as-web-user
     */
    function convert($dest){
        $currentDir = getcwd();
        $this->destinationFile = $dest;
        
        chdir($this->getConverterDir());
        //dump($this->file);
        $command = escapeshellcmd('python3 parser.py '.$this->file.' --destfile '.$dest );
        //$output = shell_exec($command); - work but not return result
        exec($command ,$this->output ,$this->result);
        chdir($currentDir);
        
    }
    
   
    /*
    public static function getConverterDirectory(){
        return base_path().DIRECTORY_SEPARATOR.self::converterPath;
    }
    */
    /*
    public function getConverterDir(){
        return base_path().DIRECTORY_SEPARATOR.$this->converterPath;
    }
    */
    public function checkIsFileCreated(){
        $convertedFile = $this->getConvertedFile();
        return file_exists($convertedFile);
        
        /*
        if (!file_exists($convertedFile)){
            throw new Exception('Converted file not found : '.$convertedFile);
        }
         * 
         */
    }
    
    function getConvertedFile(){
         return self::converterPath.DIRECTORY_SEPARATOR.$this->resultFileName;
    }
    
    function getConvertedFileLink($name){
         return "<a href='/jswebplayer/".$this->resultFileName."' class='btn btn-default' >$name</a>";
    }

    function checkResult(){
        //var_dump($this->result);
        return $this->result == 0;
    }
    
    function output2html($open = false){
        $out = 'EXIT_CODE = '.$this->result."<br>";
        foreach($this->output as $line){
            $out .= $line."<br>";
        }
        $collapse = $open ?  'show' : '' ;
        $block =   '
                    <div class="collapse '.$collapse.'" id="collapseExample">
                        <div class="card card-body">'.$out.'</div>
                    </div>';
        
        return $block;
    }
    
    function output2string(){
        return implode("\n",$this->output);
    }
    
    function logButton(){
        $block =   '<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Show conversion log
                        </button>';
        return $block;
    }
    
    
    function moveConvertedFile(){
        $dest = $this->destinationDir.DIRECTORY_SEPARATOR.$this->resultFileName;
        if (! rename($this->getConvertedFile(),$dest)){
            throw new Exception('Error on move converted file to webplayer dir : '.$dest);
        }
    }

    function redirect(){
        return '<a class="btn btn-success" role="button" href="/jswebplayer/index.html">Open project</a>';
    }
    
    
}