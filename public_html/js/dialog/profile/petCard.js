function closeDialog(){
  const bg_dialog = document.querySelector('#background-dialog');
  const fw_dialog = document.querySelector('#forward-dialog');


  bg_dialog.classList.remove('dialog-bg-active');
  fw_dialog.classList.remove('dialog-fw-active');
  setTimeout(function() {

    bg_dialog.remove();
  }, 100);
  
}
