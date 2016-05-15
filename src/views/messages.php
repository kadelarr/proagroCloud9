<?php
if (isset($_SESSION["message"])) {
    $message = $_SESSION["message"];
?>
  <div class="menssage">
    <a href="#" onclick="closeMessage(this.parentNode)">x</a>
    <p id="content-menssage">
      <?php echo $message; ?>
    </p>
  </div>
<?php
    unset($_SESSION["message"]);
  }
?>
