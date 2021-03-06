<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Arsip_zip
 * @category    Drivers
 */

// -----------------------------------------------------------------------------

class Arsip_zip extends CI_Driver
{
    private $_zip;

    private $_flags = array();

    /**
     * Default class constructor
     */
    public function __construct()
    {
        if (!class_exists('ZipArchive'))
        {
            set_message('error', 'Zip feature is unavailable.');
        }

        $this->_zip = new ZipArchive;
        $this->_flags = array(
            'overwrite' => ZipArchive::OVERWRITE,
            'create'    => ZipArchive::CREATE,
            'excl'      => ZipArchive::EXCL,
            'checkcons' => ZipArchive::CHECKCONS
            );

        log_message('debug', "#Arsip_driver: Zip Class Initialized");
    }

    public function _open($file_path, $flag = null)
    {
        if (!is_null($flag) and isset($this->_flags[$flag]))
        {
            $flag = $this->_flags[$flag];
        }

        return $this->_zip->open($file_path, $flag);
    }

    public function _read()
    {
        $ret = array();

        for ($i = 0; $i < $this->_zip->numFiles ; $i++)
        {
            $content = $this->_zip->statIndex($i);

            $ret[$i]['name']    = $content['name'];
            $ret[$i]['type']    = get_ext($content['name']);
            $ret[$i]['size']    = format_size($content['size']);
            $ret[$i]['crc']     = $content['crc'];
            $ret[$i]['csize']   = $content['comp_size'];
            $ret[$i]['mtime']   = $content['mtime'];
            $ret[$i]['cmethod'] = $content['comp_method'];
        }

        return $ret;
    }

    public function _extract($dir_path, $file_names = array())
    {
        if (!empty($file_names))
        {
            $this->_zip->extractTo($dir_path, $file_names);
        }
        else
        {
            $this->_zip->extractTo($dir_path);
        }
    }

    public function _create($file_path)
    {
        return $this->_open($file_path, 'create');
    }

    public function _close()
    {
        $this->_zip->close();
    }
}

/* End of file Arsip_zip.php */
/* Location: ./bootigniter/libraries/Arsip/drivers/Arsip_zip.php */
