<?php
/**
 * @package     BPMPPT App v0.1.6 (http://creasico.github.com/bpmppt)
 * @author      Fery Wardiyanto (ferywardiyanto@gmail.com)
 * @copyright   Copyright (c) 2013-2015 BPMPPT Kab. Pekalongan, Fery Wardiyanto
 * @license     MIT (https://github.com/creasico/bpmppt/blob/master/LICENSE)
 * @subpackage  Bpmppt_TestCase
 * @category    Unit Test
 */

// -----------------------------------------------------------------------------

abstract class Bpmppt_TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Reference to CodeIgniter
     *
     * @var resource
     */
	protected static $CI;

    public static function setUpBeforeClass()
    {
        static::$CI =& get_instance();
    }
}
