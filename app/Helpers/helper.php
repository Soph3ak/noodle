<?php

if(!function_exists('myGlobalFunction')){
    function myGlobalFunction(){
        return 'Here is my global function';
    }
}

if(!function_exists('getImgUrl')){
    function getImgUrl($fileName){
        return '/files/' . $fileName;
    }
}






