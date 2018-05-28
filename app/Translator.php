<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Description of Translator
 *
 * @author gan
 */
class Translator {
    
    protected $converterPath = '../mwxcompiler';
    
    public function translate($logo_code){
        $currentDir = getcwd();
        chdir($this->getConverterDir());
        $command = escapeshellcmd('python3 api_speed_test.py '.$logo_code);
        $output;
        $result;
        //print $command;
        exec($command ,$output ,$result);
        //dump($output);
        //dd($result);
        chdir($currentDir);
        return $output[0];
    }
    
    public function getConverterDir(){
        return base_path().DIRECTORY_SEPARATOR.$this->converterPath;
    }
}
