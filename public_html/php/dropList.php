<!DOCTYPE html>
<html>
<head>
  <title>Поиск с выпадающим списком товаров</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-6">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Введите название товара" id="searchInput">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
          <div class="dropdown-menu" id="dropdownMenu">
            <!-- Здесь можно динамически генерировать список товаров -->
            <a class="dropdown-item" href="#">Товар 1</a>
            <a class="dropdown-item" href="#">Товар 2</a>
            <a class="dropdown-item" href="#">Товар 3</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $('#searchInput').on('input', function() {
    var searchValue = $(this).val().toLowerCase();
    $('#dropdownMenu a').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
    });
  });
});
</script>

</body>
</html>