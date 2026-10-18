<?php
$buku = $buku ?? [
    'id' => 0,
    'isbn' => '',
    'judul' => '',
    'penulis' => '',
    'penerbit' => '',
    'tahun_terbit' => 0,
    'stok' => 0,
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
</head>
<body>
    <h2>Edit Buku</h2>
    <?php require __DIR__ . '/pesan.php'; ?>
<a href="index.php?page=buku&action=create">Tambah Buku</a>

    <form method="post" action="index.php?page=buku&action=update">
        <input type="hidden" name="id" value="<?= (int) $buku['id'] ?>">

        <label>ISBN</label><br>
        <input type="text" name="isbn"
               value="<?= htmlspecialchars($buku['isbn']) ?>" required><br><br>

        <label>Judul</label><br>
        <input type="text" name="judul"
               value="<?= htmlspecialchars($buku['judul']) ?>" required><br><br>

        <label>Penulis</label><br>
        <input type="text" name="penulis"
               value="<?= htmlspecialchars($buku['penulis']) ?>" required><br><br>

        <label>Penerbit</label><br>
        <input type="text" name="penerbit"
               value="<?= htmlspecialchars($buku['penerbit']) ?>" required><br><br>

        <label>Tahun Terbit</label><br>
        <input type="number" name="tahun_terbit"
               value="<?= (int) $buku['tahun_terbit'] ?>" required><br><br>

        <label>Stok</label><br>
        <input type="number" name="stok" min="0"
               value="<?= (int) $buku['stok'] ?>" required><br><br>

        <button type="submit">Update</button>
        <a href="index.php?page=buku">Kembali</a>
    </form>
</body>
</html>