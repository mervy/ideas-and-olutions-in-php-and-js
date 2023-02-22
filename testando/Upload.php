<?php
/**
Classe pra Upload de uma imagem em uma pasta e no mesmo formulário Upload de várias imagens pra outra pasta php 8.2
Aqui está um exemplo de classe de upload de imagem que pode ser usada para fazer upload de uma imagem em uma pasta específica e também para fazer upload de várias imagens em outra pasta:
*/

<?php

class UploadImage
{
    public $uploaded = [];
    public $destination;
    public $maxSize = 512000;
    public $permittedTypes = [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/gif'
    ];
    public $message;
    public $messages = [
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.'
    ];

    public function __construct($path)
    {
        if (!is_dir($path) || !is_writable($path)) {
            throw new \Exception("$path must be a valid, writable directory.");
        }

        $this->destination = $path;
    }

    public function upload($fieldName)
    {
        $uploaded = $_FILES[$fieldName];

        if (!$this->checkFile($uploaded)) {
            return false;
        }

        $filename = pathinfo($uploaded['name'], PATHINFO_FILENAME);
        $extension = pathinfo($uploaded['name'], PATHINFO_EXTENSION);
        $basename = $filename . '_' . uniqid() . '.' . $extension;
        $this->uploaded[] = $basename;

        $destination = $this->destination . '/' . $basename;

        if (!move_uploaded_file($uploaded['tmp_name'], $destination)) {
            $this->message = $this->messages[7];
            return false;
        }

        return true;
    }

    public function uploadMultiple($fieldName)
    {
        $uploaded = current($_FILES[$fieldName]['tmp_name']);
        $count = count($uploaded);
        for ($i = 0; $i < $count; $i++) {
            if (!$this->checkFile(current($_FILES[$fieldName]))) {
                return false;
            }

            $filename = pathinfo(current($_FILES[$fieldName]['name']), PATHINFO_FILENAME);
            $extension = pathinfo(current($_FILES[$fieldName]['name']), PATHINFO_EXTENSION);
            $basename = $filename . '_' . uniqid() . '.' . $extension;
            $this->uploaded[] = $basename;

            $destination = $this->destination . '/' . $basename;

            if (!move_uploaded_file(current($_FILES[$fieldName][
??
