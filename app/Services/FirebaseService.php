<?php

namespace App\Services;

use Kreait\Firebase\Database;
use Kreait\Firebase\Storage;

class FirebaseService
{
    protected $database;
    protected $storage;

    public function __construct(Database $database, Storage $storage)
    {
        $this->database = $database;
        $this->storage = $storage;
    }

    public function getCategorias()
    {
        return $this->database->getReference('categoria_negocio')->getValue();
    }

    public function guardarCategoria($data)
    {
        return $this->database->getReference('categoria_negocio')->push($data);
    }

    public function subirImagen($file)
    {
        $bucket = $this->storage->getBucket();
        $bucket->upload(file_get_contents($file->getRealPath()), [
            'name' => $file->getClientOriginalName()
        ]);

        $imageObject = $bucket->object($file->getClientOriginalName());
        return $imageObject->signedUrl(new \DateTime('+1 hour'));
    }
}
