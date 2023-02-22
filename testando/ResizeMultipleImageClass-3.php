<?php

/*
Classe para redimensionar várias imagens de uma pasta e mostrar na página php 8.2 
ao mesmo tempo sem salvar as imagens redimensionadas e mostrar num arquivo HTML com 5 imagens

Abaixo segue um exemplo de uma classe que pode ser usada para redimensionar várias
 imagens de uma pasta sem salvar as imagens redimensionadas e mostrar num arquivo HTML com 5 imagens:
*/

class ImageResize
{
    public function resizeImagesFromFolder($folder, $max_width, $max_height)
    {
        $images = array_slice(scandir($folder), 2); // pega apenas os arquivos da pasta, ignorando "." e ".."
        $resized_images = [];
        foreach ($images as $image) {
            $path = $folder . '/' . $image;
            if (exif_imagetype($path)) { // verifica se é uma imagem
                list($width, $height) = getimagesize($path);
                if ($width > $max_width || $height > $max_height) {
                    // redimensiona a imagem
                    $new_width = $max_width;
                    $new_height = ($height / $width) * $new_width;
                    if ($new_height > $max_height) {
                        $new_height = $max_height;
                        $new_width = ($width / $height) * $new_height;
                    }
                    // cria uma nova imagem com o redimensionamento
                    $new_image = imagecreatetruecolor($new_width, $new_height);
                    $source = imagecreatefromjpeg($path);
                    imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    ob_start();
                    imagejpeg($new_image);
                    $resized_images[] = ob_get_contents();
                    ob_end_clean();
                    imagedestroy($new_image);
                } else {
                    // imagem não precisa ser redimensionada
                    $resized_images[] = file_get_contents($path);
                }
            }
        }
        return $resized_images;
    }
}
 
 //Este é o arquivo HTML que mostra as 5 primeiras imagens redimensionadas:
 <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Redimensionamento de Imagens</title>
</head>
<body>
    <h1>Redimensionamento de Imagens</h1>
    <?php
    require 'ImageResize.php';
    $folder = 'images';
    $max_width = 300;
    $max_height = 200;
    $image_resize = new ImageResize();
    $resized_images = $image_resize->resizeImagesFromFolder($folder, $max_width, $max_height);
    $counter = 0;
    foreach ($resized_images as $resized_image) {
        if ($counter == 5) {
            break;
        }
        echo '<img src="data:image/jpeg;base64,'
		
		
