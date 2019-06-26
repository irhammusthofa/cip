<h3>Hasil Penilaian Topsis</h3>
Berikut adalah Hasil penilaian Juri menggunakan Metode Topsis :<br><br>
<table id="table1" width="100%" style="border: 1px solid">
  <thead>
    <tr>
      <th style="border: 1px solid">No Gugus</th>
      <th style="border: 1px solid">Nama Gugus</th>
      <th style="border: 1px solid">S+</th>
      <th style="border: 1px solid">S-</th>
      <th style="border: 1px solid">RC</th>
      <th style="border: 1px solid">Rangking</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach (@$data['tim'] as $tim) { ?>
      <tr>
        <td style="border: 1px solid"><?= $tim->t_no_gugus ?></td>
        <td style="border: 1px solid"><?= $tim->t_nama_gugus ?></td>
        <td style="border: 1px solid"><?= round($this->m_penilaian->relative_closeness($tim->t_no_gugus,$data['kriteria'],$data['alternatif'])['s_plus'],4) ?></td>
        <td style="border: 1px solid"><?= round($this->m_penilaian->relative_closeness($tim->t_no_gugus,$data['kriteria'],$data['alternatif'])['s_min'],4) ?></td>
        <td style="border: 1px solid"><?= round($this->m_penilaian->relative_closeness($tim->t_no_gugus,$data['kriteria'],$data['alternatif'])['rc'],4) ?></td>
        <td style="border: 1px solid"><?= $this->m_penilaian->rangking($tim->t_no_gugus,$data['kriteria'],$data['alternatif']) ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>

