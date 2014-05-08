<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Baka Pack
 *
 * My very own Codeigniter Boilerplate Library that used on all of my projects
 *
 * NOTICE OF LICENSE
 *
 * Everyone is permitted to copy and distribute verbatim or modified 
 * copies of this license document, and changing it is allowed as long 
 * as the name is changed.
 *
 *            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE 
 *  TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION 
 *
 * 0. You just DO WHAT THE FUCK YOU WANT TO.
 *
 * @package     Authr
 * @author      Fery Wardiyanto
 * @copyright   Copyright (c) Fery Wardiyanto. (ferywardiyanto@gmail.com)
 * @license     http://www.wtfpl.net
 * @since       Version 0.1
 */

// -----------------------------------------------------------------------------

/**
 * Authr Users Meta Driver
 *
 * @subpackage  Drivers
 * @category    Security
 */
class Authr_users_meta extends CI_Driver
{
    /**
     * Driver class constructor
     */
    public function __construct()
    {
        log_message('debug', "#Authr: Users Meta Driver Initialized");
    }

    // -------------------------------------------------------------------------
    // User metas
    // -------------------------------------------------------------------------

    /**
     * Get user meta by User ID
     *
     * @param   int    $user_id  User ID
     *
     * @return  mixed
     */
    public function fetch( $user_id )
    {
        $query = $this->db->get_where( $this->table['user_meta'], array('user_id' => $user_id) );

        if ( $query->num_rows() > 0 )
            return $query->row();

        return FALSE;
    }

    // -------------------------------------------------------------------------

    public function get( $key, $val )
    {}

    // -------------------------------------------------------------------------

    /**
     * Setup user meta by User ID
     *
     * @param  int     $user_id    User ID
     * @param  array   $meta_data  User Metas
     *
     * @return bool
     */
    public function set( $user_id, $meta_data = array() )
    {
        if ( count( $meta_data ) == 0 )
        {
            $meta_data = get_conf('default_meta_fields');
        }

        $data = array();
        $i    = 0;

        foreach ( $meta_data as $meta_key => $meta_value )
        {
            $data[$i]['user_id']    = $user_id;
            $data[$i]['meta_key']   = $meta_key;
            $data[$i]['meta_value'] = $meta_value;

            $i++;
        }

        return $this->db->insert_batch( $this->table['user_meta'], $data );
    }

    // -------------------------------------------------------------------------

    /**
     * Edit User Meta by User ID
     *
     * @param   int           $user_id     User ID
     * @param   array|string  $meta_key    Meta Data or Meta Key Field name
     * @param   string        $meta_value  Meta Value
     *
     * @return  bool
     */
    public function edit( $user_id, $meta_key, $meta_value = '' )
    {
        if ( is_array( $meta_key ) and strlen( $meta_value ) == 0 )
        {
            $this->db->trans_start();

            foreach ( $meta_key as $key => $value )
            {
                $this->edit_user_meta( $user_id, $key, $value );
            }

            $this->db->trans_complete();
            
            if ( $this->db->trans_status() === FALSE )
            {
                $this->db->trans_rollback();
                return FALSE;
            }

            return TRUE;
        }
        else
        {
            return $this->db->update(
                $this->table['user_meta'],
                array('meta_value' => $meta_value),
                array('user_id' => $user_id, 'meta_key' => $meta_key)
                );
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Clear user meta by User ID
     *
     * @param   int   $user_id  User ID
     *
     * @return  bool
     */
    public function clear( $user_id )
    {
        return $this->db->delete( $this->table['user_meta'], array('user_id' => $user_id) );
    }

    // -------------------------------------------------------------------------

    public function delete( $meta_id )
    {}
}

/* End of file Authr_users_meta.php */
/* Location: ./application/libraries/Authr/driver/Authr_users_meta.php */