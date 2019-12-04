<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_builder');
        $this->load->model('global_model');

        $this->load->model('crud_model', 'crud');
        $this->load->library('grocery_CRUD');

        $this->mTitle = TITLE;
    }

    function productList()
    {
        $this->mTitle .= lang('product_services');
        $this->render('product/product_list');
    }

    public function productTable()
    {

        $this->global_model->table = 'product';
        $this->global_model->column_order = array('p_image','name','sku','sales_cost','buying_cost','inventory','type',null);
        $this->global_model->column_search = array('name','sku','sales_cost','buying_cost','inventory','type');
        $this->global_model->order = array('id' => 'desc');

        $list = $this->global_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            if($item->p_image){
                $row[] = '<img id="blah" src="'. base_url() . UPLOAD_PRODUCT .$item->p_image.'" width="60" height="60" alt="..." style="pointer-events: none"/>';
            }else{
                $row[] = '<img id="blah" src="'. base_url() . IMAGE .'image.png" width="60" height="60" alt="..." style="pointer-events: none"/>';
            }

            $row[] = $item->name;
            $row[] = $item->sku;
            $row[] = $item->sales_cost;
            $row[] = $item->buying_cost;
            $row[] = $item->inventory;
            $row[] = $item->type;

            //add html for action
            $row[] = '<div class="btn-group"><a class="btn btn-xs btn-default" href="'.base_url('admin/product/editProduct/'.$item->id).'"><i class="fa fa-pencil"></i></a>
				  <a class="btn btn-xs btn-danger" href="'.base_url('admin/product/deleteProduct/'.$item->id).'" onClick="return confirm(\'Are you sure you want to delete?\')"><i class="glyphicon glyphicon-trash"></i></a></div>';
            $data[] = $row;
        }
        $this->global_model->render_table($data);
    }

    function deleteProduct($id)
    {
        $this->db->delete('product', array('id' => $id));
        $this->message->delete_success('admin/product/productList');
    }


    function addProductServices()
    {

        $this->mTitle .= lang('product_services');
        $this->render('product/add_product');
    }

    function productType()
    {
        $this->mViewData['form'] = $this->form_builder->create_form('admin/product/save_product',true, array('id'=>'from-product'));
        $this->mViewData['type'] = $this->input->get('type');
        $this->mViewData['title'] = $this->_check_productType($this->mViewData['type']);
        $this->mViewData['categories'] = $this->db->order_by('category', 'asc')->get('product_category')->result();
        $this->mViewData['products'] = $this->db->select("*")
                                        ->from('product')
                                        ->where('type !=', 'Bundle')
                                        ->order_by('id', 'asc')
                                        ->get()
                                        ->result();
        $this->mViewData['tax'] = $this->db->get('tax')->result();

        $this->mTitle .= lang('product_services');
        $this->render('product/add_product');
    }


    function save_category()
    {
        $data['category'] = $this->input->post('category');

        if($data['category']== ''){
            echo json_encode(array('danger', lang('category_field_is_required')));
            return false;
        }

        $this->db->insert('product_category', $data);
        echo json_encode(array('success', lang('your_record_has_been_save_successfully')));
        return true;
    }

    function save_product_category()
    {
        $data['category'] = $this->input->post('category');
        $id =  $this->input->post('product_id');

        if($id){
            $this->db->where('id', $id);
            $this->db->update('product_category', $data);
            $this->message->save_success('admin/product/categoryList');
        }else{
            $this->db->insert('product_category', $data);
            $this->message->save_success('admin/product/categoryList');
        }

    }

    function editProduct($id){
       $this->mViewData['form'] = $this->form_builder->create_form('admin/product/save_product',true, array('id'=>'from-product'));
       $product =  $this->db->get_where('product', array('id' => $id ))->row();

        $this->mViewData['type'] = strtolower($product->type);
        $this->mViewData['title'] = $product->name;
        $this->mViewData['categories'] = $this->db->order_by('category', 'asc')->get('product_category')->result();
        $this->mViewData['products'] = $this->db->select("*")
            ->from('product')
            ->where('type !=', 'Bundle')
            ->order_by('id', 'asc')
            ->get()
            ->result();
        $this->mViewData['tax'] = $this->db->get('tax')->result();
        $this->mViewData['product'] = $product;

        $this->mTitle .= lang('product_services');
        $this->render('product/add_product');


    }

    function deletePimage()
    {
        $id = $this->input->post('id');
        $data['p_image'] = '';
        $this->db->where('id', $id);
        $this->db->update('product', $data);
        echo json_encode(array('success', lang('product_image_deleted_successfully')));
        return true;
    }

    function save_product()
    {
        $type = $this->input->post('type');
        $this->form_validation->set_rules('name', lang('name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('sku', lang('sku'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('category_id', lang('category'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('tax_id', lang('tax'), 'trim|required|xss_clean');
        if($type === 'inventory'){
            $this->form_validation->set_rules('inventory', 'Inventory', 'trim|required|xss_clean');
        }


        if ($this->form_validation->run() == TRUE) {

            $id = $this->input->post('id');
            $this->_check_productType($type);
            $data = $this->input->post();

            if($type === 'bundle') {

                unset($data['product'][0]);
                unset($data['qty'][0]);

                $product = $data['product'];
                $qty = $data['qty'];

                unset($data['product']);
                unset($data['qty']);
                unset($data['id']);

                $total_cost = 0;
                foreach ($product as $key => $item) {
                    $price = $this->db->get_where('product', array('id' => $item))->row()->sales_cost;
                    if($qty[$key] != 0) {
                        $total_cost += $price * $qty[$key];
                    }
                    $bundel[] = array(
                        'product_id' => $item,
                        'qty' => $qty[$key]
                    );
                }

                $data['sales_cost'] = $total_cost;
                $data['bundle'] = json_encode($bundel);
            }

            $file = upload_product_photo();
            $file = json_decode($file);
            if($file[0]===false){
                echo json_encode(array('danger', $file[1]));
                return false;
            }

            if(!empty($file[1])){
                $data['p_image'] = $file[1];
            }

            if(!empty($id)){//update
                $this->db->where('id', $id);
                $this->db->update('product', $data);
            }else{
                $this->db->insert('product', $data);
            }

            echo json_encode(array('success', 'Your Record has been save Successfully'));
            return true;

        } else {
            $error = validation_errors();;
            echo json_encode(array('danger', $error));
            return true;
        }



    }


    function _check_productType($prm){
        switch ($prm) {
            case 'inventory';
                return lang('inventory_product');
                break;
            case 'non-inventory';
                return lang('non-inventory_product');
                break;
            case 'service';
                return lang('service_product');
                break;
            case 'bundle';
                return lang('bundel_product');
                break;
            default;
                $this->message->custom_error_msg('admin/product/productList', lang('Sorry Your Product type is mismatch'));
                break;
        }
    }

    function categoryList( $id = null){

        if($id)
            $this->mViewData['category'] = $this->db->get_where('product_category', array( 'id' => $id ))->row();
        $this->mViewData['categories'] = $this->db->get('product_category')->result();
        $this->mTitle .= lang('category');
        $this->render('product/category_list');
    }

    function deleteCategory($id = null)
    {
        $product = $this->db->get_where('product', array( 'category_id' => $id ))->row();

        if($product){
            $this->message->custom_error_msg('admin/product/categoryList', lang('sorry_you_can_not_delete_used_by_other'));
        }else{
            //delete
            $this->db->delete('product_category', array('id' => $id));
            $this->message->delete_success('admin/product/categoryList');
        }
    }


    //=============================================================
    //  Import Product
    //=============================================================

    function downloadProductSample()
    {
        $this->load->helper('download');
        $file = base_url().SAMPLE_FILE.'/'.'product.csv';
        $data =  file_get_contents($file);
        force_download('product.csv', $data);
    }

    function importProduct(){
        if(isset($_POST["submit"]))
        {
            $tmp = explode(".", $_FILES['import']['name']); // For getting Extension of selected file
            $extension = end($tmp);
            $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
            if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
            {
                $this->load->library('Data_importer');
                $file = $_FILES["import"]["tmp_name"]; // getting temporary source of excel file
                $this->data_importer->product_excel_import($file);
            }else{
                $this->message->custom_error_msg('admin/product/importProduct', lang('failed_to_import_data'));
            }
        }


        $this->mViewData['form'] = $this->form_builder->create_form();

        //Tax
        $this->mViewData['tax'] =$this->db->get('tax')->result();
        $this->mViewData['category'] =$this->db->get('product_category')->result();

        $this->mTitle .= lang('import_data');
        $this->render('import/import_product');
    }

}