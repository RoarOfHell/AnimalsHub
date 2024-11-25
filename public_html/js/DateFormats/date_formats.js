function NormalizeDate(date) {
    // 10 июня 2023

    var inputDate = new Date(date);
    var currentDate = new Date();

    var dateNormalized = `${inputDate.getDate()} ${GetMonthAtId(inputDate.getMonth())} ${inputDate.getFullYear() < currentDate.getFullYear() ? inputDate.getFullYear() : ""}`;

    return dateNormalized;
}

function GetMonthAtId(id){
    var monthNames = [
        "Января", "Февраля", "Марта",
        "Апреля", "Мая", "Июня",
        "Июля", "Августа", "Сентября",
        "Октября", "Ноября", "Декабря"
      ];

      return monthNames[id];
}