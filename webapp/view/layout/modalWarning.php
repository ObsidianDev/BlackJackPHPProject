<?php
  use ArmoredCore\WebObjects\Data;
 
  if(Data::get('userNotFound') == null && Data::get('userexists') == null) 
    echo "<div class='modal fade hiding' id='modalLogin' tabindex='-1' role='dialog' aria-hidden='true'>"; 
  else 
    echo "<div class='modal fade showing' id='modalLogin' tabindex='-1' role='dialog' aria-hidden='true'>"; 
?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Warning !</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h1 id="msgWarning"></h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>