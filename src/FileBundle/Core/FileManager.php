<?php

namespace FileBundle\Core;

use CoreBundle\CoreBundle;
use Symfony\Component\Filesystem\Filesystem;

class FileManager
{
    public static $fileSystem = null;

    public static function rootDir()
    {
        return CoreBundle::parameter("kernel.root_dir")."/../web";
    }

    public static function uploadFolderDir()
    {
        $rootDir = static::rootDir();
        $fileDir = $rootDir . "/files";
        if(!is_dir($fileDir)){
            self::getFileSystem()->mkdir($fileDir, 755);
        }
        return $fileDir;
    }

    /*
     * public://file.txt == files/file.txt
     * param $url
     */
    public static function webDir($url)
    {
        return str_replace('public://','files',$url);
    }


    /*
     * return Filesystem
     */
    public    function getFileSystem()
    {
        if(static::$fileSystem == null){
            static::$fileSystem = new Filesystem();
        }
     return static::$fileSystem;
    }
}