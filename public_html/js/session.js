let session = null;

fetch("https://animalshub.ru/php/getSessionValue.php?value=user&token=feVTjcfvmVELBWWm44cDJdFfb3FG6JHd")
  .then(response => {
    if (response.ok) {
      return response.json(); // Parse response body as JSON
    } else {
      throw new Error("Error: " + response.status);
    }
  })
  .then(data => {
    session = data; // Assign the JSON data to the variable
    console.log(session); // Do something with the data
  })
  .catch(error => {
    console.error(error);
  });

  async function getDataSession(value, token) {
    let responce = await fetch("https://animalshub.ru/php/getSessionValue.php?value=" + value + "&token=" + token);
    if(responce.ok){
        let data = await responce.json();
        return data;
    }
    else return "error";
}

