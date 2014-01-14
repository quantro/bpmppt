<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter core library that used on all of my projects
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst.  It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 *
 * @package     Baka_pack
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * BAKA Printing Class
 *
 * @subpackage  Libraries
 * @category    Printing
 */
class Printee
{
    /**
     * Codeigniter superobject
     *
     * @var  mixed
     */
    protected static $_ci;

    private $_printer;
    
    private $_host;

    private $_port;

    private $_print_type;

    private $_dim_x;
    private $_dim_y;
    private $_auto_size;

    /**
     * Default class constructor
     */
    public function __construct()
    {
        self::$_ci =& get_instance();

        $this->initialize();

        log_message('debug', "#Baka_pack: Printee Class Initialized");
    }

    
}

/* End of file Printee.php */
/* Location: ./application/libraries/baka_pack/Printee.php */