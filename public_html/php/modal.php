
<div id="modal-message" class="modal-message">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="user-info">
      <img src="<?php echo $userAvatar; ?>" alt="User Avatar" class="user-avatar">
      <h2 class="user-nickname"><?php echo $userName; ?></h2>
    </div>
    <div id="messageForm">
    <label for="message">Сообщение:</label>
      <textarea id="message" name="message" required></textarea>
      
      <button class="btn btn-primary" id="sendMessage">Отправить</button>
    </div>

  </div>
</div>
