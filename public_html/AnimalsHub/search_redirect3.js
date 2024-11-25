function searchInMainSheet() {
    const searchInput = document.getElementById('search-input');

    const searchTerm = searchInput.value;
    const redirectUrl = 'https://animalshub.ru?search=' + encodeURIComponent(searchTerm);

    window.location.href = redirectUrl;
}

function selectFilter() {
    window.location.href = 'https://animalshub.ru';
}