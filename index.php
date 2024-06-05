<?php
session_start();

class Barang {
    public $nama;
    public $harga;
    public $jumlah;

    public function __construct($nama, $harga, $jumlah) {
        $this->nama = $nama;
        $this->harga = $harga;
        $this->jumlah = $jumlah;
    }

    public function getTotal() {
        return $this->harga * $this->jumlah;
    }
}

class Keranjang {
    public $items = array();

    public function tambahBarang(Barang $barang) {
        $found = false;
        foreach ($this->items as $index => $item) {
            if ($item->nama === $barang->nama && $item->harga === $barang->harga) {
                $this->items[$index]->jumlah += $barang->jumlah;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $this->items[] = $barang;
        }
    }

    public function hapusBarang($index) {
        if (isset($this->items[$index])) {
            unset($this->items[$index]);
        }
    }

    public function hitungTotal() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }

    public function hitungJumlahBarang() {
        $jumlahBarang = 0;
        foreach ($this->items as $item) {
            $jumlahBarang += $item->jumlah;
        }
        return $jumlahBarang;
    }
}

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = new Keranjang();
}

if (isset($_POST['submit']) && isset($_POST['nama']) && isset($_POST['jumlah']) && isset($_POST['harga'])) {
    $nama = $_POST['nama'];
    $jumlah = (int)$_POST['jumlah'];
    $harga = (int)$_POST['harga'];
    $barang = new Barang($nama, $harga, $jumlah);
    $_SESSION['keranjang']->tambahBarang($barang);
}

if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $index = (int)$_GET['hapus'];
    $_SESSION['keranjang']->hapusBarang($index);
}

$jumlahBarang = $_SESSION['keranjang']->hitungJumlahBarang(); 
$total = $_SESSION['keranjang']->hitungTotal();
$_SESSION['total_pembayaran'] = $total;
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>By:Rey</title>
  <link rel="stylesheet" href="styla.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header>
</header>
<center>
<div class="a1">
    <h1>Masukan Data Barang</h1>
    <form action="index.php" method="post">
        <div class="formone">
            
        <div class="inputbox">
            <input type="text" id="nama" name="nama" required><br>
            <label for="">Nama Barang</label>
    </div>
        <div class="inputbox">
            <input type="number" id="jumlah" name="jumlah" required min="1"><br>
            <label for="">Jumlah Barang</label><br>
    </div>
        <div class="inputbox">
            <input type="number" id="harga" name="harga" required min="1"><br>
            <label for="">Harga Barang</label><br>
    </div>

        </div>
        <div class="tombolk">
            
            <button type="submit" name="submit">Tambahkan <i class="fa-solid fa-cart-shopping"></i></button>
       
        <?php
if($total >= 1) {
    echo "<a class='kirim' href='bayar.php'>Buy</a>";
}
?>

        </div>
    </form>
    


    <h2>Keranjang Belanja</h2>
    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        </thead><tbody>
<?php
$total = $_SESSION['keranjang']->hitungTotal();
foreach ($_SESSION['keranjang']->items as $index => $item) {
    echo "<tr>";
    echo "<td><a class='nomer'>" . ($index + 1) . "</a></td>"; // Menambahkan nomor urut
    echo "<td>" . $item->nama . "</td>";
    echo "<td>" . $item->jumlah . "</td>";
    echo "<td>" . $item->harga . "</td>";
    echo "<td>" . $item->getTotal() . "</td>";
    echo "<td><a class='del' href='index.php?hapus=$index'>Hapus</a></td>";
    echo "</tr>";
}
?>
</tbody>
<tfoot>
    <tr>
        <td colspan="3"><strong>Jumlah Keseluruhan Barang</strong></td>
        <td><?php echo $jumlahBarang; ?></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3"><strong>Jumlah Total</strong></td>
        <td><?php echo $total; ?></td>
        <td></td>
    </tr>
</tfoot>

    </table>
</div>
</center>
</body>
</html>
