<?php

/*
Classe para redimensionar várias imagens e mostrar na página php 8.2 ao mesmo tempo com uma página index com HTML mostrando 20 fotos redimensionadas

Aqui está uma implementação de uma classe para redimensionar imagens e mostrá-las na página, usando PHP 8.2:
*/
<?php
class ImageResizer {
    private $imagesDirectory;
    private $resizedDirectory;
    private $width;
    private $height;

    public function __construct(string $imagesDirectory, string $resizedDirectory, int $width, int $height) {
        $this->imagesDirectory = $imagesDirectory;
        $this->resizedDirectory = $resizedDirectory;
        $this->width = $width;
        $this->height = $height;
    }

    public function resize() {
        $images = scandir($this->imagesDirectory);

        foreach ($images as $image) {
            if ($image === '.' || $image === '..') {
                continue;
            }

            $originalImage = imagecreatefromjpeg($this->imagesDirectory . '/' . $image);
            $resizedImage = imagecreatetruecolor($this->width, $this->height);
            imagecopyresampled($resizedImage, $originalImage, 0, 0, 0, 0, $this->width, $this->height, imagesx($originalImage), imagesy($originalImage));
            imagejpeg($resizedImage, $this->resizedDirectory . '/' . $image, 100);
            imagedestroy($originalImage);
            imagedestroy($resizedImage);
        }
    }

    public function showResizedImages() {
        $images = scandir($this->resizedDirectory);
        $html = '<div class="images">';

        foreach ($images as $image) {
            if ($image === '.' || $image === '..') {
                continue;
            }

            $html .= '<img src="' . $this->resizedDirectory . '/' . $image . '" alt="Resized Image">';
        }

        $html .= '</div>';

        return $html;
    }
}


// E aqui está um exemplo de uso da classe:

<?php
require_once 'ImageResizer.php';

$imageResizer = new ImageResizer('images', 'resized', 200, 200);
$imageResizer->resize();

$html = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Resized Images</title>
        <style>
            .images {
                display: flex;
                flex-wrap: wrap;
            }

            .images img {
                width: 20%;
                margin: 1%;
            }
        </style>
    </head>
    <body>';

$html .= $imageResizer->showResizedImages();

$html .= '</body>
</html>';

echo $html;
