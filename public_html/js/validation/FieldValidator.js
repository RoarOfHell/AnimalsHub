function validateName(name) {
    name = name.trim();

    if (name === "") {
      return "Имя не может быть пустым.";
    }
  
    if (name.length < 2) {
      return "Имя должно содержать минимум 2 символа.";
    }
  
    if (name.length > 50) {
      return "Имя должно содержать не более 50 символов.";
    }
  
    var regex = /^[a-zA-Zа-яА-ЯёЁ\s]+$/;
    if (!regex.test(name)) {
      return "Имя может содержать только буквы и пробелы.";
    }

    return "";
  }

function validatePetType(type) {
  type = type.trim();
  if (type === "") {
    return "Тип животного не может быть пустым.";
  }

  if (type.length < 2) {
    return "Тип животонго должен содержать минимум 2 символа.";
  }

  if (type.length > 50) {
    return "Тип животного должен содержать не более 50 символов.";
  }

  var regex = /^[a-zA-Zа-яА-ЯёЁ\s]+$/;
  if (!regex.test(type)) {
    return "Тип животного может содержать только буквы и пробелы.";
  }
  return "";
  }

function validateBreed(breed) {
    breed = breed.trim();
  
    if (breed === "") {
      return "Порода не может быть пустой.";
    }
  
    if (breed.length < 2 || breed.length > 50) {
      return "Порода должна содержать от 2 до 64 символов.";
    }
  
    // Допустимые символы для породы (буквы, цифры, пробел, дефис)
    var regex = /^[a-zA-Zа-яА-ЯёЁ\s-]+$/;
    if (!regex.test(breed)) {
      return "Порода может содержать только буквы, цифры, пробел и дефис.";
    }
  
    return "";
  }

  function validateDescription(description) {
    description = description.trim();
  
    if (description === "") {
      return "Описание не может быть пустым.";
    }
  
    if (description.length > 1000) {
      return "Описание должно содержать не более 1000 символов.";
    }
  
    return "";
  }

  function validateAge(age) {
    age = age.trim();
  
    if (age === "") {
      return "Возраст не может быть пустым.";
    }
  
    if (isNaN(age)) {
      return "Возраст должен быть числом.";
    }
  
    if (age < 0 || age > 100) {
      return "Возраст должен быть в диапазоне от 0 до 100.";
    }
  
    return "";
  }

  function validatePrice(price) {
    price = price.trim();
  
    if (price === "") {
      return "Цена не может быть пустой.";
    }
  
    if (isNaN(price)) {
      return "Цена должна быть числом.";
    }
  
    if (price < 0) {
      return "Цена должна быть положительным числом.";
    }
  
    return "";
  }

  function validateLogin(login) {
    login = login.trim();
  
    if (login === "") {
      return "Логин не может быть пустым.";
    }
  
    if (login.length < 4 || login.length > 20) {
      return "Логин должен содержать от 4 до 20 символов.";
    }
  
    // Допустимые символы для логина (буквы, цифры, подчеркивание)
    var regex = /^[a-zA-Z0-9_]+$/;
    if (!regex.test(login)) {
      return "Логин может содержать только буквы, цифры и подчеркивание.";
    }
  
    return "";
  }

  function validatePassword(password) {
    if (password === "") {
      return "Пароль не может быть пустым.";
    }
  
    if (password.length < 6) {
      return "Пароль должен содержать минимум 6 символов.";
    }
  
    // Дополнительные правила проверки пароля (например, наличие заглавной буквы, цифры, специального символа)
    // Может быть добавлена дополнительная логика в соответствии с требованиями
  
    return "";
  }

  function validateEmail(email) {
    email = email.trim();
  
    if (email === "") {
      return "Адрес электронной почты не может быть пустым.";
    }
  
    // Проверка формата электронной почты с использованием регулярного выражения
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regex.test(email)) {
      return "Введите корректный адрес электронной почты.";
    }
  
    return "";
  }