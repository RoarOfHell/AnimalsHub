let removeImages = [];

async function saveChangePetAd(){
    const petImage = document.querySelector('.animal-photo');
    const name = document.querySelector('#name');
    const description = document.querySelector('#description');
    const typePet = document.querySelector('#type');
    const breed = document.querySelector('#breed');
    const age = document.querySelector('#age');
    const price = document.querySelector('#price');

    const mainPhoto = document.querySelector('#main-photo');
    const photos = document.querySelector('#additional-photos');
    const adTp = document.getElementById('ad-type');

    let errorList = [];

    if(validateName(name.value) != ""){
        errorList.push(validateName(name.value));
    }
    if(validateDescription(description.value) != ""){
        errorList.push(validateDescription(description.value));
    }
    if(validatePetType(typePet.value) != ""){
        errorList.push(validatePetType(typePet.value));
    }
    if(validateBreed(breed.value) != ""){
        errorList.push(validateBreed(breed.value));
    }
    if(validateAge(age.value) != ""){
        errorList.push(validateAge(age.value));
    }
    if(validatePrice(price.value) != ""){
        errorList.push(validatePrice(price.value));
    }
    if(mainPhoto.value != "" && mainPhoto.value != null){
        removeImages.push(petImage.src);
    }



    if(errorList.length > 0){
        showAlertErrors(errorList);
    }
    else{
        const selectedPhotos = Array.from(photos.files);
        const selectedPhoto = Array.from(mainPhoto.files)[0];
        let result = await sendChange(adTp.value, name.value, description.value, typePet.value, breed.value, age.value, price.value, selectedPhoto, selectedPhotos, removeImages);
        console.log(result);
    }
}

function onInputName(input){
    
}

function onInputDescription(input){

}

function onInputTypePet(input){

}

function onInputBreed(input){

}

function onInputAge(input){

}

function onInputPrice(input){

}

function showAlertErrors(errors){
    let error = "";
    errors.forEach(it => error += it + "\n");
    alert(error);
}

function onRemoveCard(element){
    let divElement = element.parentElement;
    let backgroundImage = getComputedStyle(divElement).backgroundImage;
    let imageUrl = backgroundImage.match(/url\(['"]?([^'"]+)['"]?\)/)[1];

    removeImages.push(imageUrl);

    divElement.remove();
}

async function sendChange(adType, name, description, typePet, breed, age, price, mainPhoto, morePhoto, removeImagesLocal){
    const petId = document.querySelector("#petId").innerHTML;
    
    let fromData = new FormData();

    if(session == null) return "error";

    fromData.append('login', session["Login"]);
    fromData.append('pass', session["Password"]);
    fromData.append('isRedirection', "qwerty");
    fromData.append('token', "feVTjcfvmVELBWWm44cDJdFfb3FG6JHd");
    fromData.append('adType', adType);
    fromData.append('petId', petId);
    fromData.append('petNickname', name);
    fromData.append('petDescription', description);
    fromData.append('petType', typePet);
    fromData.append('petBreed', breed);
    fromData.append('petAge', age);
    fromData.append('petPrice', price);
    fromData.append('file', mainPhoto);
    morePhoto.forEach(file => fromData.append('files[]', file));
    fromData.append('removeImages', JSON.stringify(removeImagesLocal));


    let responce = await fetch("https://animalshub.ru/php/EditPetCard.php", {method: 'POST', body: fromData});

    if(responce.ok){
        window.location.href = "profile";
    }
    else{
        return "error 2";
    }

}

