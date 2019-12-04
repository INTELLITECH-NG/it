<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Library to import data from .csv files
 */
class Data_importer {

    function __construct()
    {
        include (APPPATH.'third_party'.'/'.'PhpExcel'.'/'.'PHPExcel'.'/'.'IOFactory.php');
    }



    /**
	 * Import data from .csv file to a single table.
	 * Reference: http://csv.thephpleague.com/
	 * 
	 * Sample usage:
	 * 	$fields = array('name', 'email', 'age', 'active');
	 *  $this->load->library('data_importer');
	 *  $this->data_importer->csv_import('data.csv', 'users', $fields, TRUE);
	 */
	public function csv_import($file, $table, $fields, $clear_table = FALSE, $delimiter = ',', $skip_header = TRUE)
	{
		$CI =& get_instance();
		$CI->load->database();

		// prepend file path with project directory
		$reader = League\Csv\Reader::createFromPath(FCPATH.$file);
		$reader->setDelimiter($delimiter);

		// (optional) skip header row
		if ($skip_header)
			$reader->setOffset(1);

		// prepare array to be imported
		$data = array();
		$count_fields = count($fields);
		$query_result = $reader->query();
		foreach ($query_result as $idx => $row)
		{
			// skip empty rows
			if ( !empty($row[0]) )
			{
				$temp = array();
				for ($i=0; $i<$count_fields; $i++)
				{
					$name = $fields[$i];
					$value = $row[$i];
					$temp[$name] = $value;
				}
				$data[] = $temp;
			}
		}

		// (optional) empty existing table
		if ($clear_table)
			$CI->db->truncate($table);

		// confirm import (return number of records inserted)
		return $CI->db->insert_batch($table, $data);
	}

	/**
	 * Import data from Excel file to a single table.
	 * Reference: https://phpexcel.codeplex.com/
	 *
	 * TODO: complete feature
	 */

    //===========================================================
    // Product CSV Import
    //===========================================================

    public function product_excel_import($file)
    {
        $CI =& get_instance();
        $CI->load->database();

        // prepend file path with project directory
        $excel = PHPExcel_IOFactory::load($file);
        foreach ($excel->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestRow();
            for($row=2; $row<=$highestRow; $row++)
            {
                $name           = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $sku            = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $category_id    = (int)$worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $sales_cost     = (float)$worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $sales_info     = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $buying_cost    = (float)$worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $buying_info    = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                $tax_id         = (int)$worksheet->getCellByColumnAndRow(7, $row)->getValue();
                $inventory      = (int)$worksheet->getCellByColumnAndRow(8, $row)->getValue();
                $type           = $worksheet->getCellByColumnAndRow(9, $row)->getValue();

                $data[] = array(
                    'name'              => $name,
                    'sku'               => $sku,
                    'category_id'       => $category_id,
                    'sales_cost'        => $sales_cost,
                    'sales_info'        => $sales_info,
                    'buying_cost'       => $buying_cost,
                    'buying_info'       => $buying_info,
                    'tax_id'            => $tax_id,
                    'inventory'         => $inventory,
                    'type'              => $type,
                );

            }
        }

        $CI->db->trans_start();
        $CI->db->insert_batch('product', $data);
        $CI->db->trans_complete();

        if ($CI->db->trans_status() === FALSE)
        {
            $CI->message->custom_error_msg('admin/product/importProduct', lang('failed_to_import_data'));
        }else{
            $CI->message->custom_success_msg('admin/product/importProduct', lang('import_data_successfully'));
        }
    }

	//===========================================================
    // Customer CSV Import
    //===========================================================

	public function customer_excel_import($file)
	{
        $CI =& get_instance();
        $CI->load->database();

		// prepend file path with project directory
		$excel = PHPExcel_IOFactory::load($file);
		foreach ($excel->getWorksheetIterator() as $worksheet)
		{
            $highestRow = $worksheet->getHighestRow();
            for($row=2; $row<=$highestRow; $row++)
            {
                $name           = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $company_name   = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $phone          = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $fax            = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $email          = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $website        = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $b_address      = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                $s_address      = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                $note           = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

                $data[] = array(
                      'name'            => $name,
                      'company_name'    => $company_name,
                      'phone'           => $phone,
                      'fax'             => $fax,
                      'email'           => $email,
                      'website'         => $website,
                      'b_address'       => $b_address,
                      's_address'       => $s_address,
                      'note'            => $note,
                );

            }
		}

        $CI->db->trans_start();
        $CI->db->insert_batch('customer', $data);
        $CI->db->trans_complete();

        if ($CI->db->trans_status() === FALSE)
        {
            $CI->message->custom_error_msg('admin/trader/importCustomer', lang('failed_to_import_data'));
        }else{
            $CI->message->custom_success_msg('admin/trader/importCustomer', lang('import_data_successfully'));
        }
	}

    //===========================================================
    // Vendor CSV Import
    //===========================================================

    public function vendor_excel_import($file)
    {
        $CI =& get_instance();
        $CI->load->database();

        // prepend file path with project directory
        $excel = PHPExcel_IOFactory::load($file);
        foreach ($excel->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestRow();
            for($row=2; $row<=$highestRow; $row++)
            {
                $name           = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $company_name   = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $phone          = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $fax            = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $email          = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $website        = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $b_address      = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                $note           = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

                $data[] = array(
                    'name'            => $name,
                    'company_name'    => $company_name,
                    'phone'           => $phone,
                    'fax'             => $fax,
                    'email'           => $email,
                    'website'         => $website,
                    'b_address'       => $b_address,
                    'note'            => $note,
                );

            }
        }

        $CI->db->trans_start();
        $CI->db->insert_batch('vendor', $data);
        $CI->db->trans_complete();

        if ($CI->db->trans_status() === FALSE)
        {
            $CI->message->custom_error_msg('admin/trader/importVendor', lang('failed_to_import_data'));
        }else{
            $CI->message->custom_success_msg('admin/trader/importVendor', lang('import_data_successfully'));
        }
    }

    //===========================================================
    // Employee CSV Import
    //===========================================================

    public function employee_excel_import($file)
    {
        $CI =& get_instance();
        $CI->load->database();

        $prefix = EMPLOYEE_ID_PREFIX;



        // prepend file path with project directory
        $excel = PHPExcel_IOFactory::load($file);
        foreach ($excel->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestRow();
            for($row=2; $row<=$highestRow; $row++)
            {
                $first_name         = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $last_name          = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $marital_status     = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $date_of_birth      = date('Y-m-d', strtotime($worksheet->getCellByColumnAndRow(3, $row)->getValue()));
                $id_number          = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $gender             = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

                $data= array(
                    'first_name'     => $first_name,
                    'last_name'      => $last_name,
                    'marital_status' => $marital_status,
                    'date_of_birth'  => $date_of_birth,
                    'id_number'      => $id_number,
                    'gender'         => $gender,
                );

                $CI->db->trans_start();
                $CI->db->insert('employee', $data);
                $id = $CI->db->insert_id();
                $CI->db->trans_complete();

                if ($CI->db->trans_status() === TRUE){
                    $employee_id = $prefix+$id;
                    $path = UPLOAD_EMPLOYEE.$employee_id;
                    mkdir_if_not_exist($path);

                    $data= array(
                        'employee_id'   => $employee_id,
                    );

                    $CI->db->where('id', $id);
                    $CI->db->update('employee', $data);
                }
            }
        }

        $CI->message->custom_success_msg('admin/employee/importEmployee', lang('import_data_successfully'));
    }

    //===========================================================
    // Employee Attendance Import
    //===========================================================

    public function attendance_excel_import($file)
    {
        $CI =& get_instance();
        $CI->load->database();

        // prepend file path with project directory
        $excel = PHPExcel_IOFactory::load($file);
        foreach ($excel->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestRow();

            for($row=2; $row<=$highestRow; $row++)
            {
                $employee_id        = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $date               = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $attendance_status  = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $in_time            = date("H:i:s", strtotime($worksheet->getCellByColumnAndRow(3, $row)->getValue()));
                $out_time           = date("H:i:s", strtotime($worksheet->getCellByColumnAndRow(4, $row)->getValue()));
                $date               = date('Y-m-d', strtotime($date));
                $id = $employee_id - EMPLOYEE_ID_PREFIX ;

                $result = $CI->db->get_where('employee', array('id' => $id))->row();

                if(empty($result))
                    continue;

                $allowed_status = array(1, 0, 3); //allowed extension
                if(in_array($attendance_status, $allowed_status)){


                    $result = $CI->db->get_where('tbl_attendance', array('employee_id' => $id, 'date' => $date ))->row();

                    if($result){//update
                        $data_update = array(
                            'employee_id'           => $id,
                            'date'                  => $date,
                            'attendance_status'     => $attendance_status,
                            'in_time'               => $in_time,
                            'out_time'              => $out_time,
                        );
                        $CI->db->where('attendance_id', $result->attendance_id);
                        $CI->db->update('tbl_attendance', $data_update);

                    }else{//insert
                        $data[] = array(
                            'employee_id'           => $id,
                            'date'                  => $date,
                            'attendance_status'     => $attendance_status,
                            'in_time'               => $in_time,
                            'out_time'              => $out_time,
                        );
                    }
                }
            }
        }


        $CI->db->trans_start();
        $CI->db->insert_batch('tbl_attendance', $data);
        $CI->db->trans_complete();

        if ($CI->db->trans_status() === FALSE)
        {
            $CI->message->custom_error_msg('admin/employee/importAttendance', lang('failed_to_import_data'));
        }else{
            $CI->message->custom_success_msg('admin/employee/importAttendance', lang('import_data_successfully'));
        }
    }

}