<?php
class BukuController
{
    public function __construct(private Buku $model) {}

    public function index(): void
    {
        $daftarBuku = $this->model->getAll();
        require __DIR__ . '/../views/buku/index.php';
    }

    public function create(): void
    {
        require __DIR__ . '/../views/buku/create.php';
    }

    public function store(): void
    {
        $data = $this->validateInput($_POST, 'index.php?page=buku&action=create');

        try {
            $this->model->insert($data);
            $this->flash('sukses', 'Buku berhasil ditambahkan.');
        } catch (PDOException $e) {
            $this->flash('gagal', $this->pesanDatabase($e));
        }

        header('Location: index.php?page=buku');
        exit;
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $buku = $this->model->findById($id);

        if (!$buku) {
            http_response_code(404);
            exit('Data buku tidak ditemukan.');
        }

        require __DIR__ . '/../views/buku/edit.php';
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $data = $this->validateInput($_POST, 'index.php?page=buku&action=edit&id=' . $id);

        try {
            $this->model->update($id, $data);
            $this->flash('sukses', 'Data buku berhasil diperbarui.');
        } catch (PDOException $e) {
            $this->flash('gagal', $this->pesanDatabase($e));
        }

        header('Location: index.php?page=buku');
        exit;
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $this->model->delete($id);
            $this->flash('sukses', 'Buku berhasil dihapus.');
        } catch (PDOException $e) {
            $this->flash('gagal', 'Gagal menghapus buku.');
        }

        header('Location: index.php?page=buku');
        exit;
    }

    private function validateInput(array $input, string $kembali): array
    {
        $data = [
            'isbn'         => trim($input['isbn'] ?? ''),
            'judul'        => trim($input['judul'] ?? ''),
            'penulis'      => trim($input['penulis'] ?? ''),
            'penerbit'     => trim($input['penerbit'] ?? ''),
            'tahun_terbit' => trim($input['tahun_terbit'] ?? ''),
            'stok'         => trim($input['stok'] ?? '')
        ];

        foreach ($data as $nilai) {
            if ($nilai === '') {
                $this->flash('gagal', 'Semua field wajib diisi.');
                header('Location: ' . $kembali);
                exit;
            }
        }

        if (!ctype_digit($data['tahun_terbit']) || !ctype_digit($data['stok'])) {
            $this->flash('gagal', 'Tahun terbit dan stok harus berupa angka.');
            header('Location: ' . $kembali);
            exit;
        }

        return $data;
    }

    private function flash(string $tipe, string $teks): void
    {
        $_SESSION['pesan'] = ['tipe' => $tipe, 'teks' => $teks];
    }

    private function pesanDatabase(PDOException $e): string
    {
        if ($e->getCode() === '23000') {
            return 'ISBN sudah terdaftar. Gunakan ISBN yang berbeda.';
        }
        return 'Terjadi kesalahan pada database.';
    }
}
?>