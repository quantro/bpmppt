<table width="100%" class="bordered">
	<thead>
		<tr>
			<th>No.</th>
			<th>Nomor Seri</th>
			<th>Jenis Perusahaan</th>
			<th>Nomor TDP</th>
			<th>Nama Perusahaan</th>
			<th>Alamat Perusahaan</th>
			<th>Penanggung Jawab</th>
			<th>Status</th>
			<th>Keg. Pokok Usaha</th>
			<th>KBLI</th>
			<th>Pembaruan Ke</th>
			<th>Baru/Daftar Ulang</th>
			<th>Tanggal Dikeluarkan</th>
			<th>Berlaku s.d. Tanggal</th>
		</tr>
		<tr class="align-center">
			<td>1</td>
			<td>2</td>
			<td>3</td>
			<td>4</td>
			<td>5</td>
			<td>6</td>
			<td>7</td>
			<td>8</td>
			<td>9</td>
			<td>10</td>
			<td>11</td>
			<td>12</td>
			<td>13</td>
			<td>14</td>
		</tr>
	</thead>
	<tbody>
	<?php if ( $results ) : $i = 1; foreach( $results as $row ) : ?>
		<tr id="baris-<?php echo $row->id ?>" style="text-transform: uppercase;">
			<td class="align-center"><?php echo $i ?></td>
			<td class="align-center"><?php echo $row->no_agenda ?></td>
			<td class="align-left"><?php echo $row->usaha_jenis ?></td>
			<td class="align-center"><?php echo $row->no_agenda ?></td>
			<td class="align-left"><?php echo $row->usaha_nama ?></td>
			<td class="align-left"><?php echo $row->usaha_alamat ?></td>
			<td class="align-left"><?php echo $row->pemohon_nama ?></td>
			<td class="align-left"><?php echo $row->usaha_status ?></td>
			<td class="align-left"><?php echo $row->usaha_kegiatan_pokok ?></td>
			<td class="align-center"><?php echo $row->usaha_kegiatan_kbli ?></td>
			<td class="align-center"><?php echo $row->pembaruan_ke ?></td>
			<td class="align-left"><?php echo $row->pengajuan_jenis ?></td>
			<td class="align-center"><?php echo bdate( 'd F Y', $row->created_on ) ?></td>
			<td class="align-center"><?php echo bdate( 'd F Y', $row->created_on ) ?></td>
		</tr>
	<?php $i++; endforeach; else : ?>
		<tr>
			<td colspan="14"><h1 style="text-align: center;">NIHIL</h1></td>
		</tr>
	<?php endif ?>
	</tbody>
</table>