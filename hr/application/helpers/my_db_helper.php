<?php

/**
 * Get option value
 * @param  string $name Option name
 * @return mixed
 */
function get_option($name)
{
    $CI =& get_instance();
    $CI->load->database();
    $result = $CI->db->get_where('options', array(
        'name' => $name
    ))->row();
    if(empty($result)){
       $result = (object)array(
         'value' => ''
       );
    }
    return $result->value;
}

function get_orderID($id)
{
   return $order_id = INVOICE_PRE + $id;
}

function get_encode($id)
{
    $CI =& get_instance();
    return str_replace(array('+', '/', '='), array('-', '_', '~'), $CI->encrypt->encode($id));
}

function get_decode($id)
{
    $CI =& get_instance();
    return $CI->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
}