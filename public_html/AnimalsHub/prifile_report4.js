const reportBlocks = document.querySelectorAll('.report-block');
const sendReportButton = document.getElementById('sendReportButton');
const middleName = document.getElementById('first-name').value;
const userId = document.getElementById('trader-id').textContent
const traderCardsContainer = document.getElementById('trader-cards');
const searchInpt = document.getElementById("search-input");

let filter = 'Тип';

searchInpt.addEventListener("input", handleSearch);

function selectFilter(value) {
    filter = value;
}

let selectedReport = null
let trader_animals = [];

getTraderPets(userId.substring(8));

reportBlocks.forEach(function (reportBlock) {
    reportBlock.addEventListener('click', function () {
        if (selectedReport) {
            selectedReport.classList.remove('selected');
        }
        selectedReport = this;
        selectedReport.classList.add('selected');
    });
})

function getTraderPets(Id) {
    let formData = new FormData();
    formData.append('userid', Id);
    formData.append('token', token);

    fetch('https://api.animalshub.ru/GetAllPets.php', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            if (data != null) {
                let mass = [];
                mass = data.Pets;

                let iterator = 0;

                for (var i = 0; i < mass.length; i++) {
                    if (mass[i].User.Id === Id) {
                        trader_animals[iterator] = mass[i];
                        iterator = iterator + 1;
                    }
                }

                generateTraderCards(trader_animals);
            }
        })
        .catch(error => {
            console.log("Ошибка: " + error);
        });
}

function handleSearch() {
    const searchText = searchInpt.value.trim().toLowerCase();
    let filteredPets = [];

    if (searchText.length === 0) {
        traderCardsContainer.innerHTML = "";
        generateTraderCards(trader_animals);
    } else {
        if (filter === 'Тип') {
            filteredPets = trader_animals.filter(pet => {
                return pet.petType.toLowerCase().startsWith(searchText);
            });
        } else if (filter === 'Возраст') {
            filteredPets = trader_animals.filter(pet => {
                return pet.age.toLowerCase().startsWith(searchText);
            });
        } else if (filter === 'Имя') {
            filteredPets = trader_animals.filter(pet => {
                return pet.petNickname.toLowerCase().startsWith(searchText);
            });
        } else if (filter === 'Порода') {
            filteredPets = trader_animals.filter(pet => {
                return pet.breed.toLowerCase().startsWith(searchText);
            });
        }

        traderCardsContainer.innerHTML = "";
        generateTraderCards(filteredPets);
    }
}

function generateTraderCards(arrayWithPets) {
    for (let i = 0; i < arrayWithPets.length; i++) {
        const cardHTML = createCardHTML(arrayWithPets[i], 'default');
        traderCardsContainer.insertAdjacentHTML("beforeend", cardHTML);
    }
}

function createCardHTML(pet) {
    if (pet.adType === 'Потеряшка') {
        return `
              <div id="${pet.Id}-favorite" class="animal-card">
                <img src="${pet.imageUrl}" alt="Animal Photo" class="animal-photo">
                <p class="animal-name">${pet.petNickname}</p>
                <div class="animal-details">
                  <p>Тип: ${pet.petType}</p>
                  <p>Порода: ${pet.breed}</p>
                  <p>Возраст: ${pet.age}</p>
                </div>
                <div class="animal-price">${pet.petPrice} руб</div>
                <div class="animal-buttons">
                  <button class="animal-button go-to-animal" onclick="goToAnimalPage(${pet.Id})" style="width: auto;">&#10132;</button>
                </div>
                <div class="ribbon">Потерян</div>
              </div>
            `;
    } else if (pet.adType === 'Продажа') {
        return `
              <div id="${pet.Id}-favorite" class="animal-card">
                <img src="${pet.imageUrl}" alt="Animal Photo" class="animal-photo">
                <p class="animal-name">${pet.petNickname}</p>
                <div class="animal-details">
                  <p>Тип: ${pet.petType}</p>
                  <p>Порода: ${pet.breed}</p>
                  <p>Возраст: ${pet.age}</p>
                </div>
                <div class="animal-price">${pet.petPrice} руб</div>
                <div class="animal-buttons">
                  <button class="animal-button go-to-animal" onclick="goToAnimalPage(${pet.Id})" style="width: auto;">&#10132;</button>
                </div>
              </div>
            `;
    } else {
        return `
              <div id="${pet.Id}-favorite" class="animal-card">
                <img src="${pet.imageUrl}" alt="Animal Photo" class="animal-photo">
                <p class="animal-name">${pet.petNickname}</p>
                <div class="animal-details">
                  <p>Тип: ${pet.petType}</p>
                  <p>Порода: ${pet.breed}</p>
                  <p>Возраст: ${pet.age}</p>
                </div>
                <div class="animal-price">Бесплатно</div>
                <div class="animal-buttons">
                  <button class="animal-button go-to-animal" onclick="goToAnimalPage(${pet.Id})" style="width: auto;">&#10132;</button>
                </div>
              </div>
            `;
    }
}

function goToAnimalPage(pet) {
    window.location.href = 'animal?Id=' + pet;
}

function GetDate() {
    var currentDate = new Date()
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1;
    var year = currentDate.getFullYear()
    var hours = currentDate.getHours();
    var minutes = currentDate.getMinutes();
    var seconds = currentDate.getSeconds()
    day = (day < 10) ? '0' + day : day;
    month = (month < 10) ? '0' + month : month;
    hours = (hours < 10) ? '0' + hours : hours;
    minutes = (minutes < 10) ? '0' + minutes : minutes;
    seconds = (seconds < 10) ? '0' + seconds : seconds
    var formattedDateTime = day + '-' + month + '-' + year + ' ' + hours + ':' + minutes + ':' + seconds
    return formattedDateTime;
}

async function sendReport() {
    if (selectedReport == null) {
        alert('Выберите причину жалобы!');
        return;
    }

    let responceSession = await getDataSession("user", token)

    if (responceSession != "error") {
        let responceReport = await getReportResult(responceSession);

        if (responceReport == "complited") {
            alert('Репорт на пользователя ' + middleName + " отправлен!");
            location.reload();
        }
        else {
            alert("Произошла не предвиденная ошибка! ");
            console.log(responceReport.text());
        }
    }
}

async function getDataSession(value, token) {
    let responce = await fetch("https://animalshub.ru/php/getSessionValue.php?value=" + value + "&token=" + token);
    if (responce.ok) {
        return responce.json();
    }
    else return "error";
}


async function getReportResult(responceSession) {
    let formData = new FormData();

    const report = selectedReport.getAttribute('data-report');

    formData.append('token', token);
    formData.append('userid', userId.replace('GFH ID:', ''));
    formData.append('typereport', report);
    formData.append('reportdescription', 'Репорт был отправлен пользователем с GFHID: ' + responceSession['Id'] + ' дата:' + GetDate() + ' по мск')
    let responceReport = await fetch("https://api.animalshub.ru/ReportUser.php", { method: 'POST', body: formData })

    if (responceReport.ok) {
        return responceReport.text();
    }
    else {
        return "error";
    }
}

sendReportButton.addEventListener('click', sendReport)

document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('reportModal');
    modal.addEventListener('show.bs.modal', function () {
        if (selectedReport) {
            var previousSelectedReport = document.querySelector('.report-block.selected');
            if (previousSelectedReport) {
                previousSelectedReport.classList.remove('selected');
            }
            selectedReport = null;
        }
    });
})

document.getElementById('messageButton').addEventListener('click', function () {
    window.location.href = '../chat';
});