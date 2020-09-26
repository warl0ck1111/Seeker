<?php
if($_SESSION['user']['suspended'] === 'true') {
    $id = $_SESSION['user']['user_id'];
    header('location: ' . BASE_URL . 'suspended.php?'.$id);
    exit();
}
?>

<?php if (isset($_SESSION['message'])) : ?>
      <div class="message" >
      	<p>
          <?php 
          	echo $_SESSION['message']; 
          	unset($_SESSION['message']);
          ?>
      	</p>
      </div>
<?php endif ?>