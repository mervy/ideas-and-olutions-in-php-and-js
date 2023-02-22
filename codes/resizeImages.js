const uploadImage = document.getElementById('uploadImage');
const showImage = document.getElementById('showImage');
const canvas = document.getElementById('canvas');
const targetWidthInput = document.getElementById('targetWidth');
const targetHeightInput = document.getElementById('targetHeight');

document.querySelector('form').addEventListener('submit', function(event) {
  event.preventDefault();

  const targetWidth = parseInt(targetWidthInput.value);
  const targetHeight = parseInt(targetHeightInput.value);

  if (isNaN(targetWidth) || isNaN(targetHeight)) {
    alert('Please enter valid values for width and height.');
    return;
  }
  
  // Seta height pra 200px ao submeter o form
  showImage.style.height = '200px';

  const reader = new FileReader();
  reader.onload = function(event) {
    const img = new Image();
    img.onload = function() {
      const scaleFactor = Math.min(targetWidth / img.width, targetHeight / img.height);
      const newWidth = img.width * scaleFactor;
      const newHeight = img.height * scaleFactor;
      const offsetX = (targetWidth - newWidth) / 2;
      const offsetY = (targetHeight - newHeight) / 2;

      canvas.width = targetWidth;
      canvas.height = targetHeight;

      const ctx = canvas.getContext('2d');
      ctx.fillStyle = 'black'; //Pode mudar a cor se quiser
      ctx.fillRect(0, 0, targetWidth, targetHeight);
      ctx.drawImage(img, offsetX, offsetY, newWidth, newHeight);

      const canvasImage = canvas.toDataURL();
      showImage.setAttribute('src', event.target.result);
      canvas.setAttribute('src', canvasImage);
    }
    img.src = event.target.result;
  }
  reader.readAsDataURL(uploadImage.files[0]);
});
