<?php
if (!empty($_SESSION['pesan'])):
    $pesan = $_SESSION['pesan'];
    unset($_SESSION['pesan']);
?>
<p style="padding:8px; border:1px solid; color:<?= $pesan['tipe'] === 'sukses' ? 'green' : 'red' ?>">
    <?= htmlspecialchars($pesan['teks']) ?>
</p>
<?php endif; ?>