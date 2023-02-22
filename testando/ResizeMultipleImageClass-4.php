<?php

/*
Classe para redimensionar várias imagens de uma pasta e mostrar na página php 8.2 ao mesmo tempo sem salvar as imagens redimensionadas e mostrar num arquivo HTML com 5 imagens
Abaixo está um exemplo de uma classe que pode ser usada para redimensionar imagens em PHP 8.2 sem salvar as imagens redimensionadas e mostrá-las em uma página HTML:
*/
<?php

class ImageResizer
{
    protected $folder;
    protected $images;
    protected $limit;

    public function __construct($folder, $limit = 5)
    {
        $this->folder = $folder;
        $this->limit = $limit;
        $this->images = $this->getImages();
    }

    protected function getImages()
    {
        $images = [];
        if ($handle = opendir($this->folder)) {
            $i = 0;
            while (false !== ($entry = readdir($handle)) && $i < $this->limit) {
                if ($entry != "." && $entry != "..") {
                    $images[] = $entry;
                    $i++;
                }
            }
            closedir($handle);
        }

        return $images;
    }

    public function resizeAndShowImages()
    {
        echo "<div style='display: flex; flex-wrap: wrap;'>";
        foreach ($this->images as $image) {
            list($width, $height) = getimagesize($this->folder . "/" . $image);
            $ratio = $width / $height;
            $new_width = 200;
            $new_height = 200 / $ratio;
            $image_resized = imagecreatetruecolor($new_width, $new_height);
            $image_original = imagecreatefromjpeg($this->folder . "/" . $image);
            imagecopyresampled($image_resized, $image_original, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            ob_start();
            imagejpeg($image_resized);
            $image_binary = ob_get_contents();
            ob_end_clean();
            echo "<div style='margin: 10px;'><img src='data:image/jpeg;base64," . base64_encode($image_binary) . "' alt='{$image}'></div>";
        }
        echo "</div>";
    }
}

$imageResizer = new ImageResizer("images", 5);
$imageResizer->resizeAndShowImages();

/*
Este exemplo usa a função getimagesize para obter as dimensões da imagem, 
a função imagecreatetruecolor para criar uma imagem vazia com as novas dimensões, 
a função imagecreatefromjpeg para carregar a imagem original a partir do arquivo, 
a função imagecopyresampled para redimensionar a imagem original para a imagem vazia, 
e a função imagejpeg para gerar a imagem redimensionada em formato JPEG na saída. 
Em seguida, usamos a função base64_encode para codificar a imagem como uma string base
*/
