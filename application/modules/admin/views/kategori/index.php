<div class="row">
    <div class="col-md-12">
        <div class="card card-success card-outline">
            <div class="card-body box-profile">
                <table id="kategorisurat" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Kategori Surat</th>
                            <th>Pengguna</th>
                            <th>Prodi</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kategori_surat as $kategori) :

                            if ($kategori['klien'] == 'm') {
                                $klien = 'Mahasiswa';
                            } elseif ($kategori['klien'] == 'd') {
                                $klien = 'Dosen';
                            } elseif ($kategori['klien'] == 'p') {
                                $klien = 'Pascasarjana';
                            } elseif ($kategori['klien'] == 'j') {
                                $klien = 'Program Studi';
                            }

                            if ($kategori['prodi'] == 0) {
                                $prodi = 'Semua';
                            } else {
                                $prodi =  getProdibyId($kategori['prodi'])['prodi'];
                            }
                            echo "<tr>";
                            echo "<td>" . $kategori['kategori_surat'] . "</td>";
                            echo "<td>" . $klien . "</td>";
                            echo "<td>" . $prodi . "</td>";
                            echo "<td class='text-center'><a class='btn btn-info btn-sm' href='" . base_url('admin/kategorisurat/edit/' . $kategori['id']) . "'><i class='fas fa-pencil-alt'></i> Edit</a></td>";
                            echo "</tr>";
                        endforeach;
                        ?>

                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>