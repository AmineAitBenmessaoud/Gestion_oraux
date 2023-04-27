<body>
<div id="page-container">
<div class="bar">
      <?php  if (isset($_SESSION['username'])) : ?>
      <p style="text-align: left;">Bonjour <strong><?php echo $_SESSION['username']; ?></strong></p><p style="text-align: right;"><a href="index.php?logout='1'">logout</a></p><p><a href="pass.php" style="text-align: right;">Changer le password</a></p>
      <?php endif ?>
      </div>