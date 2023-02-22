<?php 

/*
Classe pra Upload de uma imagem em uma pasta e no mesmo formulário Upload de várias imagens pra outra pasta php 8.2
Para fazer o upload de uma imagem para uma pasta, você pode usar a função move_uploaded_file() do PHP. Aqui está um exemplo de classe que faz isso:
*/

class ImageUploader {
  public function uploadSingle($file, $targetDirectory) {
    $targetPath = $targetDirectory . '/' . basename($file['name']);
    move_uploaded_file($file['tmp_name'], $targetPath);
    return $targetPath;
  }

  public function uploadMultiple($files, $targetDirectory) {
    $uploadedFiles = [];
    foreach ($files['tmp_name'] as $index => $tmpName) {
      $targetPath = $targetDirectory . '/' . basename($files['name'][$index]);
      move_uploaded_file($tmpName, $targetPath);
      $uploadedFiles[] = $targetPath;
    }
    return $uploadedFiles;
  }
}


/*
Para usar a classe, você pode instanciá-la e chamar 
seus métodos passando os arquivos e o diretório de destino como parâmetros:
*/
$imageUploader = new ImageUploader();

// Upload de uma imagem
$image = $_FILES['image'];
$targetDirectory = 'caminho/para/diretorio';
$targetPath = $imageUploader->uploadSingle($image, $targetDirectory);

// Upload de várias imagens
$images = $_FILES['images'];
$targetDirectory = 'caminho/para/outro/diretorio';
$uploadedFiles = $imageUploader->uploadMultiple($images, $targetDirectory);


//Observe que os arquivos são passados como um array associativo na variável $_FILES. 
//Para o upload de várias imagens, os arquivos são tratados como matrizes, com um índice para cada arquivo.
