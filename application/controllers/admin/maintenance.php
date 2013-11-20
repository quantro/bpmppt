<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends BAKA_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->baka_theme->add_navbar( 'admin_sidebar', 'nav-tabs nav-stacked nav-tabs-right', 'side' );
		$this->app_main->admin_navbar( 'admin_sidebar', 'side' );

		$this->baka_theme->set_title('System Maintenance');
	}

	public function index()
	{
		$this->backstore();
	}

	public function dbbackup()
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Backup Database');;

		$fields[]	= array(
			'name'	=> 'backup-all',
			'type'	=> 'static',
			'label'	=> 'Database driver',
			'std'	=> $this->db->dbdriver );

		$fields[]	= array(
			'name'	=> 'backup-all',
			'type'	=> 'static',
			'label'	=> 'Host info',
			'std'	=> $this->db->conn_id->host_info );

		$fields[]	= array(
			'name'	=> 'backup-all',
			'type'	=> 'static',
			'label'	=> 'Server info',
			'std'	=> $this->db->conn_id->server_info.' Version. '.$this->db->conn_id->server_version );

		$fields[]	= array(
			'name'	=> 'backup-all',
			'type'	=> 'checkbox',
			'label'	=> 'Backup semua tabel',
			'option'=> array('semua' => 'Semua'),
			'validation'=>'required' );

		$buttons[]= array(
			'name'	=> 'do-backup',
			'type'	=> 'submit',
			'label'	=> 'backup_btn',
			'class'	=> 'btn-primary pull-right' );

		$backup		= $this->baka_form->add_form( current_url(), 'backup' )
									   ->add_fields( $fields )
									   ->add_buttons( $buttons );

		if ( $backup->validate_submition() )
		{
			$this->load->library('Baka_pack/baka_dbutil');

			$data = $backup->submited_data();

			if ( $this->baka_dbutil->backup() )
			{
				$this->session->set_flashdata('success', $this->baka_lib->messages());
			}
			else
			{
				$this->session->set_flashdata('error', $this->baka_lib->errors());
			}
			
			redirect( current_url() );
		}

		$this->data['panel_body'] = $backup->render();

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	public function dbrestore()
	{
		$this->data['panel_title']	= $this->baka_theme->set_title('Restore Database');;

		$fields[]	= array(
			'name'	=> 'restore-from-file',
			'type'	=> 'upload',
			'label'	=> 'Restore dari berkas',
			'desc'	=> 'Pilih berkas yang akan digunakan untuk me-restore database, berkas yg diperbolehkan antara lain: <i>.zip</i> dan <i>.sql</i>' );

		$buttons[]= array(
			'name'	=> 'do-restore',
			'type'	=> 'submit',
			'label'	=> 'restore_btn',
			'class'	=> 'btn-primary pull-right' );

		$restore	= $this->baka_form->add_form_multipart( current_url(), 'restore' )
									  ->add_fields( $fields )
									  ->add_buttons( $buttons );

		if ( $restore->validate_submition() )
		{
			$this->load->library('Baka_pack/baka_dbutil');

			if ( $this->baka_dbutil->restore_upload('restore-from-file') )
			{
				$this->session->set_flashdata('success', $this->baka_lib->messages());
			}
			else
			{
				$this->session->set_flashdata('error', $this->baka_lib->errors());
			}

			redirect( current_url() );
		}

		$this->data['panel_body'] = $restore->render();

		$this->baka_theme->load('pages/panel_form', $this->data);
	}

	public function syslogs( $file = '' )
	{
		$this->data['panel_title'] = $this->baka_theme->set_title('Aktifitas sistem');

		$this->baka_theme->add_navbar( 'log_sidebar', 'nav-tabs nav-stacked nav-tabs-left', 'panel' );

		$latest = '';

		$log_path = config_item('log_path');

		foreach (directory_map($log_path) as $log)
		{
			if ( $log != 'index.html')
			{
				$log	= strtolower(str_replace(EXT, '', $log));
				$label	= 'Tanggal '.format_date(str_replace('log-', '', $log));

				$latest = 'admin/maintenance/syslogs/'.$log;

				$this->baka_theme->add_navmenu( 'log_sidebar', $log, 'link', 'admin/maintenance/syslogs/'.$log, $label, array(), 'panel' );
			}
		}

		if ( $file != '' )
		{
			if ( !$this->load->is_loaded('file') )
				$this->load->helper('file');
			
			$this->data['panel_title'] .= ' Tanggal '.format_date(str_replace('log-', '', $file));

			foreach ( file( $log_path.$file.EXT, FILE_IGNORE_NEW_LINES ) as $log_line )
			{
				if ( strlen($log_line) > 0 AND !is_null($log_line) AND $log_line != '' )
				{
					$state = explode(' - ', $log_line);

					if ( isset($state[1]) )
					{
						$date = explode(' --> ', $state[1]);

						$line[format_datetime($date[0])][] = array(
							'state'	=> $state[0],
							'msg'	=> $date[1] );
					}
				}
			}

			$this->data['panel_body'] = $line;
			// $this->data['panel_body'] = read_file( $log_path.$file.EXT );
		}
		else
		{
			if ( $latest != '' )
				redirect( $latest );
		}

		$this->baka_theme->load('pages/syslogs', $this->data);
	}
}

/* End of file maintenance.php */
/* Location: ./application/controllers/admin/maintenance.php */