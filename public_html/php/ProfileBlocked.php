<?php 

if($isCurrentSession) echo '<div class="peview-block horizontal-box m-4" style="height: 300px">
<div class="d-flex h-100 w-100 vertical-align-center horizontal-align-center" style="color: red;">Вы были заблокированы</div>
</div>';
else echo '<div class="peview-block horizontal-box m-4" style="height: 300px">
<div class="d-flex h-100 w-100 vertical-align-center horizontal-align-center" style="color: red;">Данный пользователь был заблокирован</div>
</div>';
?>

