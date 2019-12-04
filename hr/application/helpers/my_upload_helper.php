<?php

function upload_product_photo()
{
    if (isset($_FILES['p_image']['name']) && $_FILES['p_image']['name'] != '') {

        $CI =& get_instance();
        $CI->load->database();
        $config['upload_path'] = UPLOAD_PRODUCT;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '2024';

        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);

        if (!$CI->upload->do_upload('p_image')) {
            $error = $CI->upload->display_errors();
            return json_encode(array(false, $error));
            // uploading failed. $error will holds the errors.
        } else {
            $fdata = $CI->upload->data();
            return json_encode(array(true, $fdata['file_name']));
            // uploading successfull, now do your further actions
        }
    }
    return false;

}


function upload_bill()
{
    if (isset($_FILES['bill']['name']) && $_FILES['bill']['name'] != '') {
        $CI =& get_instance();
        $CI->load->database();
        $config['upload_path'] = UPLOAD_BILL;
        $config['allowed_types'] = '*';
        $config['max_size'] = '2024';

        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);

        if ($CI->upload->do_upload('bill')) {
            $fdata = $CI->upload->data();
            return $fdata['file_name'];
        }
    }
    return false;

}


function handel_upload_logo()
{
    if (isset($_FILES['company_logo']['name']) && $_FILES['company_logo']['name'] != '') {

        $CI =& get_instance();
        $CI->load->database();
        $config['upload_path'] = UPLOAD_LOGO;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '2024';

        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);

        if (!$CI->upload->do_upload('company_logo')) {
            $error = $CI->upload->display_errors();
            $CI->message->custom_error_msg('admin/settings?tab=company',$error);
            return false;
            // uploading failed. $error will holds the errors.
        } else {
            $fdata = $CI->upload->data();
            $CI->db->where('name', 'company_logo');
            $CI->db->update('options', array(
                'value' => $fdata['file_name']
            ));

            // uploading successfull, now do your further actions
        }
    }
    return false;

}

function handel_upload_login_logo()
{
    if (isset($_FILES['login_logo']['name']) && $_FILES['login_logo']['name'] != '') {

        $CI =& get_instance();
        $CI->load->database();
        $config['upload_path'] = UPLOAD_LOGO;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '2024';

        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);

        if (!$CI->upload->do_upload('login_logo')) {
            $error = $CI->upload->display_errors();
            $CI->message->custom_error_msg('admin/settings?tab=company',$error);
            return false;
            // uploading failed. $error will holds the errors.
        } else {
            $fdata = $CI->upload->data();
            $CI->db->where('name', 'login_logo');
            $CI->db->update('options', array(
                'value' => $fdata['file_name']
            ));

            // uploading successfull, now do your further actions
        }
    }
    return false;

}

function handel_upload_icon()
{
    if (isset($_FILES['icon']['name']) && $_FILES['icon']['name'] != '') {

        $CI =& get_instance();
        $CI->load->database();
        $config['upload_path'] = UPLOAD_LOGO;
        $config['allowed_types'] = 'ico|png';
        $config['max_size'] = '2024';

        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);

        if (!$CI->upload->do_upload('icon')) {
            $error = $CI->upload->display_errors();
            $CI->message->custom_error_msg('admin/settings?tab=company',$error);
            return false;
            // uploading failed. $error will holds the errors.
        } else {
            $fdata = $CI->upload->data();
            $CI->db->where('name', 'icon');
            $CI->db->update('options', array(
                'value' => $fdata['file_name']
            ));

            // uploading successfull, now do your further actions
        }
    }
    return false;

}

function handel_upload_invoice_logo()
{
    if (isset($_FILES['invoice_logo']['name']) && $_FILES['invoice_logo']['name'] != '') {

        $CI =& get_instance();
        $CI->load->database();
        $config['upload_path'] = UPLOAD_LOGO; //were u want to upload
        $config['allowed_types'] = 'gif|jpg|jpeg|png'; // file type
        $config['max_size'] = '2024'; //size of this file

        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);

        if (!$CI->upload->do_upload('invoice_logo')) {
            $error = $CI->upload->display_errors();
            $CI->message->custom_error_msg('admin/settings?tab=invoice',$error);
            return false;
            // uploading failed. $error will holds the errors.
        } else {
            $fdata = $CI->upload->data();
            $CI->db->where('name', 'invoice_logo');
            $CI->db->update('options', array(
                'value' => $fdata['file_name']
            ));

        }
    }
    return false;

}

function upload_employee_photo($employee_id = null, $id = null)
{

    if (isset($_FILES['employee_photo']['name']) && $_FILES['employee_photo']['name'] != '') {

        $CI =& get_instance();
        $config['upload_path'] = UPLOAD_EMPLOYEE.$employee_id;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '2024';

        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);

        if (!$CI->upload->do_upload('employee_photo')) {
            $error = $CI->upload->display_errors();
            $CI->message->custom_error_msg('admin/employee/employeeDetails/'. str_replace(array('+', '/', '='), array('-', '_', '~'), $CI->encrypt->encode($id))  ,$error);
            return false;
            // uploading failed. $error will holds the errors.
        } else {
            $fdata = $CI->upload->data();
            return $fdata['file_name'];

            // uploading successfull, now do your further actions
        }
    }
    return false;

}


function upload_employee_file($employee_id, $type, $id = null)
{
    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {

        $CI =& get_instance();

        $config['upload_path'] = UPLOAD_EMPLOYEE.$employee_id;
        $config['allowed_types'] = $type;
        $config['max_size'] = '2024';

        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);

        if (!$CI->upload->do_upload('file')) {
            $error = $CI->upload->display_errors();
            $CI->message->custom_error_msg('admin/employee/employeeDetails/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $CI->encrypt->encode($id)),$error);
            return false;
            // uploading failed. $error will holds the errors.
        } else {
            $fdata = $CI->upload->data();
            return $fdata['file_name'];

            // uploading successfull, now do your further actions
        }
    }
    return false;

}


function upload_attachment()
{
    if (isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != '') {

        $CI =& get_instance();
        $CI->load->database();
        $config['upload_path'] = ATTACHMENT;
        $config['allowed_types'] = '*';
        $config['max_size'] = '9024';

        $CI->load->library('upload', $config);
//        $CI->upload->initialize($config);

        $files           = $_FILES;
        $filesCount = count($_FILES['attachment']['name']);

        for($i = 0; $i < $filesCount; $i++){
            $fileName = date("Y-m-d").time().'@@@'.$files['attachment']['name'][$i];
            $_FILES['attachment']['name'] = $fileName;
            $_FILES['attachment']['type'] = $files['attachment']['type'][$i];
            $_FILES['attachment']['tmp_name'] = $files['attachment']['tmp_name'][$i];
            $_FILES['attachment']['error'] = $files['attachment']['error'][$i];
            $_FILES['attachment']['size'] = $files['attachment']['size'][$i];

            $CI->upload->initialize($config);

            if(!$CI->upload->do_upload('attachment')){
                $error[$i] = '<strong>'.$files['attachment']['name'][$i].'</strong> '.$CI->upload->display_errors();
            }else{
                $fileData = $CI->upload->data();
                $uploadData[$i]['file_name'] = $fileData['file_name'];
                $uploadData[$i]['file_ext'] = $fileData['file_ext'];
                $uploadData[$i]['file_size'] = $fileData['file_size'];
            }
        }

        if(empty($error))
            $error =0;

        $data = array(
            'success' =>$uploadData,
            'error' =>$error
        );

        return json_encode($data);


    }
    return false;

}

