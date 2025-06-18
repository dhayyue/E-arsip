<!-- create-archive-modal.php -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Arsip Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="post">
                    <div class="row g-3">
                        <?php
            $fields = [
              'Pencipta_Arsip', 'Nomor_Arsip', 'Unit_Pengelola', 'Uraian_Informasi',
              'Kode_Klasifikasi', 'Jumlah', 'Media', 'Kategori_Arsip',
              'Tingkat_Perkembangan_Arsip', 'Tanggal_Diterima', 'Lokasi_Simpan',
              'Kurun_Waktu', 'inaktif', 'Keterangan'
            ];

            foreach ($fields as $field) {
              $type = ($field === 'Tanggal_Diterima') ? 'date' : 'text';
              echo '<div class="col-md-6">';
              echo "<input name=\"$field\" type=\"$type\" placeholder=\"" . str_replace('_', ' ', $field) . "\" class=\"form-control\" required>";
              echo '</div>';
            }
            ?>
                    </div>

                    <div class="mt-3 text-end">
                        <button type="submit" name="create" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>