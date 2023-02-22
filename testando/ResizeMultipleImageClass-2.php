<?php

/*
Classe para redimensionar várias imagens e mostrar na página php 8.2 ao mesmo tempo sem salvar as imagens redimensionadas e mostrar num arquivo HTML com 10 imagens
Aqui está um exemplo de uma classe de redimensionamento de imagens em PHP 8.2 que não salva as imagens redimensionadas, mas exibe-as em uma página HTML com 10 imagens:
*/

<?php

class ImageResizer
{
    private $images;

    public function __construct(array $images)
    {
        $this->images = $images;
    }

    public function resize($width, $height)
    {
        $resizedImages = [];

        foreach ($this->images as $image) {
            $src = imagecreatefromstring(file_get_contents($image));
            $dst = imagecreatetruecolor($width, $height);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, imagesx($src), imagesy($src));
            ob_start();
            imagejpeg($dst);
            $resizedImages[] = ob_get_clean();
        }

        return $resizedImages;
    }
}

$images = [
    'image1.jpg',
    'image2.jpg',
    'image3.jpg',
    'image4.jpg',
    'image5.jpg',
    'image6.jpg',
    'image7.jpg',
    'image8.jpg',
    'image9.jpg',
    'image10.jpg',
];

$resizer = new ImageResizer($images);
$resizedImages = $resizer->resize(100, 100);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Redimensionamento de imagens</title>
</head>
<body>
    <h1>Redimensionamento de imagens</h1>
    <?php foreach ($resizedImages as $resizedImage) : ?>
        <img src="data:image/jpeg;base64,<?php echo base64_encode($resizedImage); ?>" alt="Resized Image">
    <?php endforeach; ?>
</body>
</html>


/*
Este exemplo usa a função file_get_contents para ler o conteúdo de cada imagem
 e a função imagecreatefromstring para criar uma imagem a partir desse conteúdo. 
 Em seguida, a classe usa a função imagecopyresampled para redimensionar a imagem 
 e a função ob_start e ob_get_clean para obter o conteúdo da imagem redimensionada em formato binário.

No arquivo HTML, o conteúdo da imagem é exibido como uma tag img com 
o atributo src contendo o conteúdo da imagem codificado em base64.
*/