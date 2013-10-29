<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usaha_pertambangan extends CI_Model
{
	public $kode = 'IUP';
	public $slug = 'izin_usaha_pertambangan';
	public $nama = 'Izin Usaha Pertambangan';

	public function __construct()
	{
		parent::__construct();

		log_message('debug', "Usaha_pertambangan_model Class Initialized");
	}

	public function form( $data_id = '' )
	{
		$fields = array(
			array(
				'name'	=> $this->slug.'_surat_no',
				'label'	=> 'Nomor &amp; Tanggal Surat',
				'type'	=> 'subfield',
				'fields'=> array(
					array(
						'col'	=> '6',
						'name'	=> 'proses',
						'label'	=> 'Nomor',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $query->surat_no : set_value($this->slug.'_surat_no')),
						'validation'=> 'required' ),
					array(
						'col'	=> '6',
						'name'	=> 'kond',
						'label'	=> 'Tanggal',
						'type'	=> 'text',
						'std'	=> ($data_id != '' ? $query->surat_tgl : set_value($this->slug.'_surat_tgl')),
						'validation'=> 'required' ),
					)
				),
			array(
				'name'	=> $this->slug.'_fieldset_data_pemohon',
				'label'	=> 'Data Pemohon',
				'type'	=> 'fieldset' ),
			array(
				'name'	=> $this->slug.'_pemohon_nama',
				'label'	=> 'Nama lengkap',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_nama : set_value($this->slug.'_pemohon_nama')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_jabatan',
				'label'	=> 'Jabatan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_jabatan : set_value($this->slug.'_pemohon_jabatan')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_usaha',
				'label'	=> 'Perusahaan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->pemohon_usaha : set_value($this->slug.'_pemohon_usaha')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_pemohon_alamat',
				'label'	=> 'Alamat',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->pemohon_alamat : set_value($this->slug.'_pemohon_alamat')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_fieldset_data_lokasi',
				'label'	=> 'Data Lokasi',
				'type'	=> 'fieldset' ),
			array(
				'name'	=> $this->slug.'_lokasi_tujuan',
				'label'	=> 'Tujuan Permohonan',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->lokasi_tujuan : set_value($this->slug.'_lokasi_tujuan')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_lokasi_alamat',
				'label'	=> 'Alamat Lokasi',
				'type'	=> 'textarea',
				'std'	=> ($data_id != '' ? $query->lokasi_alamat : set_value($this->slug.'_lokasi_alamat')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_lokasi_nama',
				'label'	=> 'Luas Area (M<sup>2</sup>)',
				'type'	=> 'number',
				'std'	=> ($data_id != '' ? $query->lokasi_nama : set_value($this->slug.'_lokasi_nama')),
				'validation'=> 'required' ),
			array(
				'name'	=> $this->slug.'_lokasi_area_hijau',
				'label'	=> 'Area terbuka hijau',
				'type'	=> 'text',
				'std'	=> ($data_id != '' ? $query->lokasi_area_hijau : set_value($this->slug.'_lokasi_area_hijau')),
				'validation'=> 'required' ),
			);

		return $fields;
	}

	public function data()
	{
		$post_data['surat_rekomendasi_nomor']		= $this->input->post('surat_rekomendasi_nomor');
		$post_data['surat_rekomendasi_tanggal']		= $this->input->post('surat_rekomendasi_tanggal');
		$post_data['pemohon_nama']					= $this->input->post('pemohon_nama');
		$post_data['pemohon_alamat']				= $this->input->post('pemohon_alamat');
		$post_data['pemohon_propinsi']				= $this->input->post('pemohon_propinsi');
		$post_data['pemohon_kota']					= $this->input->post('pemohon_kota');
		$post_data['pemohon_kecamatan']				= $this->input->post('pemohon_kecamatan');
		$post_data['pemohon_kelurahan']				= $this->input->post('pemohon_kelurahan');
		$post_data['pemohon_rt']					= $this->input->post('pemohon_rt');
		$post_data['pemohon_rw']					= $this->input->post('pemohon_rw');
		$post_data['pemohon_an']					= $this->input->post('pemohon_an');
		$post_data['tambang_jangka_waktu_mulai']	= string_to_date( $this->input->post('tambang_jangka_waktu_mulai') );
		$post_data['tambang_jangka_waktu_selesai']	= string_to_date( $this->input->post('tambang_jangka_waktu_selesai') );
		$post_data['tambang_jenis_bahan']			= $this->input->post('tambang_jenis_bahan');
		$post_data['tambang_luas']					= $this->input->post('tambang_luas');
		$post_data['tambang_alamat']				= $this->input->post('tambang_alamat');
		$post_data['tambang_propinsi']				= $this->input->post('tambang_propinsi');
		$post_data['tambang_kota']					= $this->input->post('tambang_kota');
		$post_data['tambang_kecamatan']				= $this->input->post('tambang_kecamatan');
		$post_data['tambang_kelurahan']				= $this->input->post('tambang_kelurahan');
		$post_data['tambang_rt']					= $this->input->post('tambang_rt');
		$post_data['tambang_rw']					= $this->input->post('tambang_rw');

		// surat_no:
		// surat_tgl:28-10-2013
		// surat_rekomendasi_nomor:
		// surat_rekomendasi_tanggal:28-10-2013
		// pemohon_nama:
		// pemohon_alamat:
		// pemohon_alamat:
		// pemohon_an:
		// tambang_jangka_waktu_mulai:28-10-2013
		// tambang_jangka_waktu_selesai:28-10-2013
		// tambang_jenis_bahan:
		// tambang_luas:
		// tambang_kode:
		// tambang_alamat:
		// tambang_alamat:
		// tambang_koordinat[]:
		// tambang_koordinat[]:
		// tambang_koordinat[]:
		// tambang_koordinat[]:
		// tambang_koordinat[]:
		// tambang_koordinat[]:
		// tambang_koordinat[]:
		// tambang_koordinat[]:
	}
}

/* End of file Izin_usaha_pertambangan.php */
/* Location: ./application/models/app/Izin_usaha_pertambangan.php */