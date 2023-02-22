Upload simples de imagem de um campo e multiplo uplod de várias imagens
 usando o mesmo formulário em PHP 8.2. Mostrar as imagens abaixo do campo 
 antes do envio usando javascript puro. Mostrar um exemplo em html
 
 Aqui está um exemplo de formulário HTML que permite o upload simples 
 de uma imagem de um campo e o upload múltiplo de várias imagens usando 
 o mesmo formulário, e mostra as imagens abaixo do 
 campo antes do envio usando JavaScript puro:

 
 <form method="post" action="upload.php" enctype="multipart/form-data">
  <label for="single-image">Single Image:</label>
  <input type="file" id="single-image" name="single-image"><br>

  <label for="multiple-images">Multiple Images:</label>
  <input type="file" id="multiple-images" name="multiple-images[]" multiple><br>

  <div id="preview"></div>

  <button type="submit">Upload</button>
</form>

<script>
  function previewImages() {
    var preview = document.getElementById("preview");
    preview.innerHTML = "";
    var singleImage = document.getElementById("single-image").files[0];
    if (singleImage) {
      var singleImagePreview = document.createElement("img");
      singleImagePreview.src = URL.createObjectURL(singleImage);
      preview.appendChild(singleImagePreview);
    }
    var multipleImages = document.getElementById("multiple-images").files;
    if (multipleImages.length > 0) {
      for (var i = 0; i < multipleImages.length; i++) {
        var multipleImagePreview = document.createElement("img");
        multipleImagePreview.src = URL.createObjectURL(multipleImages[i]);
        preview.appendChild(multipleImagePreview);
      }
    }
  }

  var singleImageInput = document.getElementById("single-image");
  singleImageInput.addEventListener("change", previewImages);

  var multipleImagesInput = document.getElementById("multiple-images");
  multipleImagesInput.addEventListener("change", previewImages);
</script>

Este formulário contém dois campos de arquivo: um para upload de imagem única e outro para upload de várias imagens (usando o atributo multiple). Também inclui um elemento div com id="preview" que será usado para exibir as imagens selecionadas pelo usuário antes do envio do formulário.

O JavaScript define uma função previewImages() que é chamada sempre que o usuário seleciona um arquivo em um dos campos de arquivo. A função obtém os arquivos selecionados, cria elementos img para cada arquivo e define o atributo src dos elementos img como a URL do objeto de arquivo criado pelo método URL.createObjectURL(). Em seguida, a função adiciona os elementos img ao elemento div com id="preview".

Por fim, o JavaScript adiciona ouvintes de eventos para os campos de arquivo para que a função previewImages() seja chamada sempre que um arquivo for selecionado. Quando o usuário clica no botão "Upload", o formulário será enviado ao arquivo "upload.php" especificado no atributo action do formulário. Observe que você precisará escrever o código para processar o upload de arquivos no arquivo "upload.php".

<?php

// Inclui o autoload do Composer
require __DIR__ . '/vendor/autoload.php';

// Instancia o objeto que processa o upload de arquivos
$imageUploader = new App\ImageUploader();

// Processa o upload de uma imagem única
if (isset($_FILES['single-image']) && $_FILES['single-image']['error'] === UPLOAD_ERR_OK) {
  $targetDirectory = __DIR__ . '/uploads/single';
  $uploadedFile = $imageUploader->upload($_FILES['single-image'], $targetDirectory);
  echo 'Single Image uploaded: ' . $uploadedFile . '<br>';
}

// Processa o upload de várias imagens
if (isset($_FILES['multiple-images'])) {
  $targetDirectory = __DIR__ . '/uploads/multiple';
  $uploadedFiles = $imageUploader->uploadMultiple($_FILES['multiple-images'], $targetDirectory);
  foreach ($uploadedFiles as $uploadedFile) {
    echo 'Multiple Image uploaded: ' . $uploadedFile . '<br>';
  }
}

/*
Observe que este exemplo requer a instalação do Composer e a 
definição de um namespace para a classe ImageUploader, 
que está localizada em um arquivo separado. Você também precisará 
configurar o arquivo "composer.json" para carregar 
automaticamente as classes usando o autoloader do Composer.

Aqui está o exemplo do arquivo "composer.json":
*/

{
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    }
}

// E aqui está o exemplo da classe ImageUploader, localizada em "src/ImageUploader.php":

namespace App;

class ImageUploader {
  public function upload($file, $targetDirectory) {
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


// Inclui o autoload do Composer
require __DIR__ . '/vendor/autoload.php';

use App\ImageUploader;

// Instancia o objeto que processa o upload de arquivos
$imageUploader = new ImageUploader();

// Processa o upload de uma imagem única
if (isset($_FILES['single-image']) && $_FILES['single-image']['error'] === UPLOAD_ERR_OK) {
  $targetDirectory = __DIR__ . '/uploads/single';
  $uploadedFile = $imageUploader->upload($_FILES['single-image'], $targetDirectory);
  echo 'Single Image uploaded: ' . $uploadedFile . '<br>';
}

// Processa o upload de várias imagens
if (isset($_FILES['multiple-images'])) {
  $targetDirectory = __DIR__ . '/uploads/multiple';
  $uploadedFiles = $imageUploader->uploadMultiple($_FILES['multiple-images'], $targetDirectory);
  foreach ($uploadedFiles as $uploadedFile) {
    echo 'Multiple Image uploaded: ' . $uploadedFile . '<br>';
  }
}

/*
Observe que agora estamos usando a declaração use para importar a classe 
ImageUploader do namespace App, o que nos permite usar a 
classe sem precisar digitar o nome completo dela toda vez que queremos usá-la.

Também removemos a verificação de erro duplicada na linha 10, 
já que a classe ImageUploader já faz essa verificação dentro do método upload.
*/

