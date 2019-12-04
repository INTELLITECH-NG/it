<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asset extends Admin_Controller
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

    function addAsset($id = null)
    {
        $this->mTitle .= lang('add_asset');
        $this->mViewData['asset'] = $this->db->get_where('assets', array('id' => $id ))->row();
        $this->render('depreciation/add_asset');
    }

    function assetsList()
    {
        $crud = new grocery_CRUD();

        $crud->columns('name','purchase_year','cost','lifespan', 'salvage_value','depreciation','actions');
        $crud->order_by('id','desc');

        $crud->display_as('name', lang('name'));
        $crud->display_as('purchase_year', lang('purchase_year'));
        $crud->display_as('cost', lang('cost'));
        $crud->display_as('lifespan', lang('lifespan'));
        $crud->display_as('salvage_value', lang('salvage_value'));
        $crud->display_as('depreciation', lang('depreciation'));
        $crud->display_as('actions', lang('actions'));
//        $crud->required_fields('name','purchase_year','cost','lifespan', 'salvage_value');
//        $crud->fields('name','purchase_year','cost','lifespan', 'salvage_value');

        $crud->set_table('assets');

        $crud->callback_column('actions',array($this,'_callback_action_more'));
        $crud->callback_column('depreciation',array($this,'_callback_action_depreciation'));

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();
        $this->mViewData['crud'] = $crud->render();
        $this->mViewData['title'] = 'Add Asset';

        $this->mTitle .= 'Add Asset';
        $this->render('depreciation/crud');
    }

    function _callback_action_more($value, $row){
        return '
            <div class="btn-group dropdown">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                '. lang('actions').'                                  <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right">
                              
                                <li> <a href="asset/addAsset/' . $row->id . '"><i class="fa fa-edit"></i>'. lang('edit').' </a> </li>
                    
                                <li><a onclick="return confirm(\'Are you sure want to cancel this order ?\');" href="asset/deleteAsset/' . $row->id . '"><i class="fa fa-trash-o text-danger"></i>'. lang('delete').' </a> </li>
                            </ul>
                        </div>
        ';
    }

    function _callback_action_depreciation($value, $row)
    {
        return '<a href="asset/viewDepreciation/' . $row->id . '" class="btn btn-default">'. lang('view_depreciation').'</a>';
    }


    function save_asset()
    {
        $this->form_validation->set_rules('name', lang('asset_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('purchase_year', lang('purchase_year'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('cost', lang('cost'), 'trim|numeric|required|xss_clean');
        $this->form_validation->set_rules('lifespan', lang('lifespan'), 'trim|numeric|required|xss_clean');
        $this->form_validation->set_rules('salvage_value', lang('salvage_value'), 'trim|numeric|required|xss_clean');


        if ($this->form_validation->run() == TRUE) {

            $id = $this->input->post('id');

            $data['name'] = $this->input->post('name');
            $data['purchase_year'] = $this->input->post('purchase_year');
            $data['cost'] = $this->input->post('cost');
            $data['lifespan'] = $this->input->post('lifespan');
            $data['salvage_value'] = $this->input->post('salvage_value');

            if(!empty($id)){
                //update
                $this->db->where('id', $id);
                $this->db->update('assets', $data);
                $this->_saveDepreciation($id);
            }else{
                //insert
                $this->db->insert('assets', $data);
                $id = $this->db->insert_id();

                $this->_saveDepreciation($id);
            }
            $this->message->save_success('admin/asset/assetsList');
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('admin/asset/addAsset',$error);
        }
    }

    function _saveDepreciation($id)
    {
        $asset = $this->db->get_where('assets', array('id' => $id ))->row();
        $year =  date("Y", strtotime($asset->purchase_year));
        if(!empty($asset->lifespan))
        {
            $lifeSpan=0;
            for($i=1; $i<=$asset->lifespan; $i++)
            {
                $lifeSpan += $i;
            }

            //$beginingValue = 0;
            $depreciableCost = $asset->cost - $asset->salvage_value;
            $lastEndValue = 0;

            $i = $asset->lifespan;
            $count = 0;
            for($i; $i >= 1; $i--)
            {
                $depriciationRate       = number_format(($i/$lifeSpan * 100), 2, '.', '');
                $depriciationExpense    = number_format(($depreciableCost * $depriciationRate /100), 2, '.', '');
                $accumulated            = number_format(($depriciationRate * $depriciationExpense /100), 2, '.', '');

                if($asset->lifespan === $i)
                {
                    $dep_year = $year;
                    $beginingValue  = $asset->cost;
                    $bookValue      = number_format(($beginingValue - $depriciationExpense), 2, '.', '');
                    $lastEndValue   = $bookValue;
                }else{
                    $dep_year = $year+$count;
                    $beginingValue = $lastEndValue;
                    $bookValue      = number_format(($beginingValue - $depriciationExpense), 2, '.', '');
                    $lastEndValue   = $bookValue;
                }


                $data[] = array(
                    'asset_id'                  => $id,
                    'year'                      => $dep_year,
                    'beginning_value'           => $beginingValue,
                    'depreciate_cost'           => $depreciableCost,
                    'depreciate_rate'           => $depriciationRate,
                    'depreciation_expense'      => $depriciationExpense,
                    'accumulated'               => $accumulated,
                    'ending_value'              => $bookValue,
                );
                $count++;
            }
        }

        //delete
        $this->db->delete('depreciation', array('asset_id' => $id));
        //save
        $this->db->insert_batch('depreciation', $data);

    }

    function viewDepreciation($id =  null)
    {
        $asset = $this->db->get_where('assets', array('id' => $id ))->row();
        $year =  date("Y", strtotime($asset->purchase_year));
        if(!empty($asset->lifespan))
        {
            $lifeSpan=0;
            for($i=1; $i<=$asset->lifespan; $i++)
            {
                $lifeSpan += $i;
            }

            //$beginingValue = 0;
            $depreciableCost = $asset->cost - $asset->salvage_value;
            $lastEndValue = 0;

            $i = $asset->lifespan;
            $count = 0;
            for($i; $i >= 1; $i--)
            {
                $depriciationRate       = number_format(($i/$lifeSpan * 100), 2, '.', '');
                $depriciationExpense    = number_format(($depreciableCost * $depriciationRate /100), 2, '.', '');
                $accumulated            = number_format(($depriciationRate * $depriciationExpense /100), 2, '.', '');

                if($asset->lifespan === $i)
                {
                    $dep_year = $year;
                    $beginingValue  = $asset->cost;
                    $bookValue      = number_format(($beginingValue - $depriciationExpense), 2, '.', '');
                    $lastEndValue   = $bookValue;
                }else{
                    $dep_year = $year+$count;
                    $beginingValue = $lastEndValue;
                    $bookValue      = number_format(($beginingValue - $depriciationExpense), 2, '.', '');
                    $lastEndValue   = $bookValue;
                }


                $data[$i] = array(
                    'year'                      => $dep_year,
                    'beginning_value'           => $beginingValue,
                    'depreciate_cost'           => $depreciableCost,
                    'depreciate_rate'           => $depriciationRate,
                    'depreciation_expense'      => $depriciationExpense,
                    'accumulated'               => $accumulated,
                    'ending_value'              => $bookValue,
                );
                $count++;

                if($dep_year == date("Y"))
                    break;
            }



        }


        $this->mTitle .= lang('view_depreciation');
        $this->mViewData['depreciation'] = $data;
        $this->render('depreciation/depreciation');
    }

    function receivedMemberFees($id = null)
    {
        $this->mViewData['members'] = $this->db->get('member')->result();
        $this->mViewData['member_id'] = $id;
        $this->mTitle= 'Member Fees';
        $this->render('member/member_fees');
    }

    function receivedFees()
    {
        $id      = $this->input->post('id');
        $data['member_id']      = $this->input->post('member_id');
        $data['month']          = $this->input->post('month');
        $data['amount']         = (float)$this->input->post('amount');
        $data['received_by']    = $this->ion_auth->user()->row()->first_name.' '.$this->ion_auth->user()->row()->last_name;

        if($id){
            //update
            $this->db->where('id', $id);
            $this->db->update('member_fees', $data);
        }else{
            $this->db->insert('member_fees', $data);
        }


        $this->message->save_success('admin/member/memberFeesList');
    }

    function memberFeesList()
    {
        $crud = new grocery_CRUD();

        $crud->columns('member_id','month','amount','received_by', 'date_time','actions');
        $crud->order_by('id','desc');
        $crud->display_as('member_id','Member name');
        $crud->display_as('date_time','Received Date');


        $crud->set_table('member_fees');
        $crud->set_relation('member_id','member','name');

        $crud->callback_column('actions',array($this->crud,'_callback_action_received_fees'));

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $this->mViewData['crud'] = $crud->render();
        $this->mViewData['title'] = 'Received Member Payment List ';

        $this->mTitle .= 'Add Member';
        $this->render('crud');
    }

    function viewPayment($id = null)
    {
        $crud = new grocery_CRUD();

        $crud->columns('member_id','month','amount','received_by', 'date_time');
        $crud->order_by('id','desc');
        $crud->display_as('member_id','Member name');
        $crud->display_as('date_time','Received Date');

        $crud->set_table('member_fees');
        $crud->set_relation('member_id','member','name');
        $crud->where('member_id', $id);
        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $this->mViewData['crud'] = $crud->render();
        $this->mViewData['title'] = 'Payment History';

        $this->mTitle .= 'Payment History';
        $this->render('crud');
    }

    function editPayment($id = null)
    {
        $this->mViewData['members'] = $this->db->get('member')->result();
        $this->mViewData['payment'] = $this->db->get_where('member_fees', array( 'id' => $id ))->row();
        $this->mViewData['member_id'] = $this->mViewData['payment']->member_id;
        $this->mTitle= 'Member Fees';
        $this->render('member/member_fees');
    }

    function deletePayment($id = null)
    {
        $this->db->delete('member_fees', array('id' => $id));
        $this->message->delete_success('admin/member/memberFeesList');
    }

    function deleteAsset($id = null)
    {
        //delete
        $this->db->delete('assets', array('id' => $id));
        $this->db->delete('depreciation', array('asset_id' => $id));

        $this->message->delete_success('admin/asset/assetsList');
    }

}