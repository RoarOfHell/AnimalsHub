
let uploadImageID = 1;
let newImageUrl = null;
let defaultSizeImageX = 1;
let defaultSizeImageY = 1;

let isDragging = false;

let cropBoxWidth = 128;
let cropBoxHeight =128;
let imageLeft = 0;
let imageTop = 0;


function cropShowed() {

    const fileDropArea = document.getElementById('file-drop-area');
    const fileInput = document.getElementById('file-input');
    const crop_box = document.getElementById('crop-box');
    const container = document.getElementById('container');
    const imageShowDefault = document.getElementById('image-cropping');

    crop_box.onmousedown = function(event) {
        isDragging = true;
        let shiftX = event.clientX - crop_box.getBoundingClientRect().left;
        let shiftY = event.clientY - crop_box.getBoundingClientRect().top;
    
        crop_box.style.position = 'absolute';
        crop_box.style.zIndex = 1000;
        document.body.append(crop_box);
    
        moveAt(event.pageX, event.pageY);
    
        function moveAt(pageX, pageY) {
            let newLeft = pageX - shiftX;
            let newTop = pageY - shiftY;
    
            // Получаем границы container относительно окна просмотра
            const containerRect = container.getBoundingClientRect();
    
            // Проверяем, чтобы crop_box не выходил за границы container
            if (newLeft < containerRect.left) {
                newLeft = containerRect.left;
            }
            if (newTop < containerRect.top) {
                newTop = containerRect.top;
            }
            if (newLeft + crop_box.offsetWidth > containerRect.right) {
                newLeft = containerRect.right - crop_box.offsetWidth;
            }
            if (newTop + crop_box.offsetHeight > containerRect.bottom) {
                newTop = containerRect.bottom - crop_box.offsetHeight;
            }
    
    
    
            crop_box.style.left = newLeft + 'px';
            crop_box.style.top = newTop + 'px';
            
            // Получаем размеры изображения
            const imageWidth = imageShowDefault.width; // замените на получение ширины вашего изображения
            const imageHeight = imageShowDefault.height; // замените на получение высоты вашего изображения
    
            const imageMultiplyWidth = defaultSizeImageX / imageShowDefault.width; //и
            const imageMultiplyHeight = defaultSizeImageY / imageShowDefault.height; //и
    
            // Вычисляем размеры crop_box относительно изображения
            cropBoxWidth = crop_box.offsetWidth * imageMultiplyWidth;
            cropBoxHeight = crop_box.offsetHeight * imageMultiplyHeight;
            imageLeft = ((newLeft - containerRect.left) / containerRect.width * imageWidth) * imageMultiplyWidth;
            imageTop = ((newTop - containerRect.top) / containerRect.height * imageHeight) * imageMultiplyHeight;
        }
        
        function onMouseMove(event) {
            if (!isDragging) return;
            moveAt(event.pageX, event.pageY);
        }
    
        document.addEventListener('mousemove', onMouseMove);
    
        crop_box.onmouseup = function() {
            isDragging = false;
            document.removeEventListener('mousemove', onMouseMove);
            crop_box.onmouseup = null;
            imageCropRealTime(imageLeft, imageTop, cropBoxWidth, cropBoxHeight);
        };
    };
    
    container.addEventListener('mouseleave', function() {
        isDragging = false;
        imageCropRealTime(imageLeft, imageTop, cropBoxWidth, cropBoxHeight);
    });
     crop_box.ondragstart = function(event) {
        event.preventDefault();
      };
    
    fileDropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileDropArea.classList.add('active');
    });
    
    fileDropArea.addEventListener('dragleave', () => {
        fileDropArea.classList.remove('active');
    });
    
    fileDropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        fileDropArea.classList.remove('active');
        const file = e.dataTransfer.files[0];
        handleFile(file);
    });
    
    fileDropArea.addEventListener('click', () => {
        fileInput.click();
    });
    
    
    fileInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        handleFile(file);
    });
    
    crop_box.addEventListener('dragstart', (event) => {

        event.dataTransfer.setData("text/plain", "This text may be dragged");
    });
}



function handleFile(file) {
    if (file) {
    // Здесь вы можете обработать выбранный файл
   // console.log(`Выбран файл: ${file.name}`);
    goToCropImage(file);
    } else {
    alert('Выберите файл снова.');
    }
}

function goToCropImage(file){
    const imagePicker = document.getElementById('file-drop-area');
    const imageCroppper = document.getElementById('image-crop-box');
    const imageShowDefault = document.getElementById('image-cropping');
    const imageShowCropped = document.getElementById('image-cropped');

    const fileName = file.name;

    const image = new Image();

    image.onload = function() {
        // Получите размеры изображения
        defaultSizeImageX = this.width;
        defaultSizeImageY = this.height;

      };

    if (/\.(jpg|jpeg|png|gif)$/i.test(fileName)) {
        const imageURL = URL.createObjectURL(file);
        image.src = URL.createObjectURL(file);

        imageShowDefault.src = imageURL;
        imageShowCropped.src = imageURL;

    }


    imagePicker.style.visibility = 'collapse';
    imageCroppper.style.visibility = 'visible';

    
}

function imageCropRealTime(left, top, width, height) {
    var sourceImage = document.getElementById('image-cropping');
    var outputImage = document.getElementById('image-cropped');
    // Создаем новый холст для обрезки изображения
    const croppedCanvas = document.createElement('canvas');
    const ctx = croppedCanvas.getContext('2d');

    // Устанавливаем размеры холста равными размерам области вырезания
    croppedCanvas.width = width;
    croppedCanvas.height = height;

    // Рисуем вырезанную область из исходного изображения на холсте
    ctx.drawImage(sourceImage, left, top, width, height, 0, 0, width, height);

    // Устанавливаем результат как исходное изображение для outputImage
    outputImage.src = croppedCanvas.toDataURL('image/png');
    newImageUrl = croppedCanvas.toDataURL('image/png');
    
}

function setSizeCrop(){
    const cropSize = document.getElementById('size-crop-box');
    const  cropBox = document.getElementById('crop-box');

    cropBox.style.width = (128 * cropSize.value) + 'px';
    cropBox.style.height = (128 * cropSize.value) + 'px';
}

function setSizeImage(){
    const imageSize = document.getElementById('size-image-box');
    const  containerBox = document.getElementById('container');

    containerBox.style.width = imageSize.value + '%';
}

async function saveNewImage(){
    const newImg = document.getElementById('new-image');

    if(newImg != null){
        newImg.src = newImageUrl ? newImageUrl : "";
    }

    if(uploadImageID == 2){
        uploadImageFromProfile();
    }
}

async function uploadImageFromProfile(){
    if(newImageUrl != null){
        const formData = new FormData();

        formData.append('login', session.Login);
        formData.append('pass', session.Password);
        formData.append('token', token);
        formData.append('file', dataURLtoBlob(newImageUrl), 'avatar.jpeg');



        const response = await fetch("https://animalshub.ru/php/UploadImage.php", {
            method: "POST",
            body: formData
        });

        if(response.ok){
            const result = await response.text();
            if(result == "completed"){
                location.reload();
            }
            console.log(result);
        }
    }
}