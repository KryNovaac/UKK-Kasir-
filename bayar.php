<?php
session_start();

$totalPembayaran = $_SESSION['total_pembayaran']; 
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stylez.css">
</head>
<body>
    <header>
    </header>
    <center>
  <div class="m1">
    <div class="form-value">
      <form action="nota.php" method="post" class="form-container">
        <h2 class="text">Pembayaran</h2>
        <div class="inputbox">
          <input type="number" name="bayar" id="nilai" required>
          <label for="">Masukan</label>
        </div>
        
        <a class="total"> Total yang harus dibayarkan : <?php echo $totalPembayaran?></a>
        <button type="submit">Bayar</button>
        <a class="kirim" href="index.php">Kembali</a>
        
      </form>
      </div>
    </div>
  </div>
  </center>
</body>
</html>