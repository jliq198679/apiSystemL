<?php
/**
 * Created by PhpStorm.
 * User: albert
 * Date: 9/03/21
 * Time: 11:24
 */

namespace App\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Exception;

class StoreFile
{
    private $nameDisk;

    public function __construct($nameDisk=null)
    {
        $this->nameDisk = $nameDisk;
    }

    public function setNameDisk($nameDisk)
    {
        $this->nameDisk = $nameDisk;
    }

    /**
     * @param Request $file
     * @return mixed
     */
    public function save($file)
    {
        try {
            if(!empty($file) && is_file($file))
            {
                $file_name_persist = Storage::disk($this->nameDisk)->putFile('', $file);
                if(empty($file_name_persist))
                    throw new Exception('Error. Repuesta null al persistir el fichero', 400);
                return $file_name_persist;
            }
            else
                throw new Exception('Error. Fichero a subir incorrecto', 400);
        }
        catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Save en disk by content file and name file
     * @param $nameFile
     * @param $content
     * @return null
     */
    public function saveByContentFile($nameFile, $content)
    {
        try {
            if(!empty($content))
            {
                $isOk = Storage::disk($this->nameDisk)->put($nameFile, $content);
                if($isOk)
                    return $nameFile;
                else
                    throw new Exception('Error. Repuesta null al persistir el fichero con su contenido', 400);
            }
            else
                throw new Exception('Error. No existe el contenido del fichero para subirlo al server',400);
        }
        catch (\Exception $e)
        {
            return $e;
        }
    }

    /**
     *
     * @param $file_name
     * @return \Exception|string
     */
    public function getUrlFile($file_name = null)
    {
        try {
            if(!empty($file_name))
            {
                if (Storage::disk($this->nameDisk)->exists($file_name))
                {
                    $url = Storage::disk($this->nameDisk)->url($file_name);
                    return $url;
                }
                else
                    throw new Exception('Error. Incorrecto retornar url de fichero que no existe');
            }
            else
                throw new Exception('Error. Incorrecto retornar url de fichero vacio');
        }
        catch(\Exception $exception)
        {
            return $exception;
        }
    }

}
