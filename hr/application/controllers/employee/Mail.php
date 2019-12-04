<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mail extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        // only login users can access Account controller
        $this->verify_login();
        $user = $this->ion_auth->user()->row();
        if($user->type != 'user'){
            redirect('auth/login');
        }

        $this->mTitle = TITLE;
        $this->load->model('global_model');
        $this->load->library('form_builder');
    }


    function index()
    {
        $this->mTitle .= lang('mail_list');
        $this->render('mail/inbox');
    }

    public function inboxList(){
        $this->global_model->table = 'inbox';
        $list = $this->global_model->get_inbox_datatables();


        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {
            $time = strtotime($item->date);
            $no++;
            $row = array();
            $row[] = '<label class="css-input css-checkbox css-checkbox-primary"><input type="checkbox" name="id[]" value="'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id.'*'.'inbox')).'"><span></span></label>';

            if($item->rating) {
                $row[] = '<a onclick="changeStatusMail(this)" id="' . str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) . '" href="javascript:;">
                      <i class="fa fa-star text-yellow"></i></a>';
            }else{
                $row[] = '<a onclick="changeStatusMail(this)" id="' . str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)) . '" href="javascript:;">
                      <i class="fa fa-star-o text-yellow"></i></a>';
            }
            $row[] = '<a href="'.base_url('employee/mail/viewEmail').'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)).'">'.$item->sender_name.'</a>';
            if($item->reading){
                $row[] = $item->subject .' - '. substr(strip_tags($item->msg),0,20).'...';
            }else{
                $row[] = '<strong>'.$item->subject.'</strong> - '. substr(strip_tags($item->msg),0,20).'...';
            }

            if(json_decode($item->attachment)){
                $row[] = '<i class="fa fa-paperclip"></i>';
            }else{
                $row[] = '';
            }

            $row[] = $this->humanTiming($time).' ago';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->global_model->count_inbox(),
            "recordsFiltered" => $this->global_model->count_filtered_inbox(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }




    function humanTiming ($time)
    {

        $time = time() - $time; // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }

    }

    function change_status()
    {
        $id = $this->input->post('id');
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));

        if($id){

            $rating = $this->db->get_where('inbox', array(
                'id' => $id
            ))->row()->rating;

            if($rating){
                $data['rating'] = 0;
            }else{
                $data['rating'] = 1;
            }
            $this->db->where('id', $id);
            $this->db->update('inbox', $data);
        }
    }

    function composeMail()
    {
        $departments = $this->db->order_by('department', 'asc')->get('department')->result();
        $admin = $this->db->get('admin_users')->result();

        foreach($admin as $item)
        {
            $employee['admin'][] = (object)array(
                'id' => $item->id.'*A',
                'name' => $item->first_name.' '.$item->last_name ,
            );

        }

        foreach($departments as $item)
        {
            $result =  $this->db->get_where('employee', array(
                'department' => $item->id,
                'termination' => 1
            ))->result();

            foreach($result as $v_employee){
                $employee[$item->department][] = (object)array(
                    'id' => $v_employee->id.'*E',
                    'name' => $v_employee->first_name.' '.$v_employee->last_name ,
                );
            }

        }
        $this->mViewData['employee'] = $employee;
        $this->mTitle .= lang('compose_new_message');
        $this->render('mail/compose');
    }

    function get_employee_by_department($id)
    {
        $department_id = $this->input->post('department_id');
        if($department_id == 'admin'){
            $employees = $this->db->get('admin_users')->result();
        }else{
            $employees = $this->db->get_where('employee', array('department' => $department_id ))->result();
        }

        if ($employees) {
            foreach ($employees as $item) {
                $HTML.="<option value='" . $item->id . "'>" . $item->first_name.' '.$item->last_name . "</option>";
            }
        }
        echo $HTML;
    }

    function sendEmail()
    {

        // $this->form_validation->set_rules('department', lang('select_department'), 'required');
        $this->form_validation->set_rules('employee_id[]', lang('employee'), 'required');
        $this->form_validation->set_rules('subject', lang('subject'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('msg', lang('message'), 'trim|required|xss_clean');


        if ($this->form_validation->run() == TRUE) {

            $attachment_id = mt_rand().'-'.date("Ymd-his");
            $sender = $this->ion_auth->user()->row();
            //inbox
            $to_employees    = $this->input->post('employee_id');
            $type            = $sender->type;
            $type            == 'admin' ? $data['from_type'] = 'admin': $data['from_type'] = 'employee';

            //get employee name
            $employee = $this->db->get_where('employee', array(
                'id' => $this->ion_auth->user()->row()->employee_id
            ))->row();

            $data['sender_name'] = $employee->first_name.' '.$employee->last_name ;

            $data['subject'] = $this->input->post('subject');
            $data['msg'] = $this->input->post('msg');
            $data['from_emp_id'] = $this->ion_auth->user()->row()->employee_id;
            $data['cc'] = json_encode($to_employees);
            $data['attachment_id'] = $attachment_id;

            $path = ATTACHMENT;
            mkdir_if_not_exist($path);
            $files = upload_attachment();
            $files = json_decode($files);
            $data['attachment'] = json_encode($files->success);

            foreach($to_employees as $to_id){
                $result = explode("*", $to_id);
                $data['to_emp_id'] = $result[0];
                $result[1]      == 'A' ? $data['to_type'] = 'admin': $data['to_type'] = 'employee';
                $this->db->insert('inbox', $data);
            }

            //outbox
            $outbox['from_emp_id'] = $this->ion_auth->user()->row()->employee_id;
            $outbox['from_type'] = $data['from_type'];
            $outbox['cc'] = json_encode($to_employees);
            $outbox['subject'] = $this->input->post('subject');
            $outbox['msg'] = $this->input->post('msg');
            $outbox['attachment'] = json_encode($files->success);
            $outbox['attachment_id'] = $attachment_id;

            $this->db->insert('outbox', $outbox);

            $this->message->custom_success_msg('employee/mail/sentItem','Your Messages has benn send Successfully');
        } else {
            $error = validation_errors();;
            $this->message->custom_error_msg('employee/mail/composeMail', $error);
        }
    }

    function viewEmail($id = null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));

        $result = $this->db->get_where('inbox', array(
            'id' => $id
        ))->row();
        $result == TRUE || $this->message->norecord_found('employee/mail');

        $this->db->set('reading', 1, FALSE)->where('id', $id)->update('inbox');

        $this->mViewData['mail'] =  $result;
        $this->mViewData['type'] =  'inbox';
        $this->mTitle .= lang('read_mail');
        $this->render('mail/view_email');
    }

    function downloadFile($id =null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));
        if($id){
            $this->load->helper('download');

            $result = explode("*", $id);

            $msg = $this->db->get_where('inbox', array(
                'id' => $result[0]
            ))->row();

            $attachment = json_decode($msg->attachment);
            $fileName = explode("@@@", $attachment[$result[1]]->file_name);

            $file = base_url().ATTACHMENT.'/'.$attachment[$result[1]]->file_name;
            $data =  file_get_contents($file);
            force_download($fileName[1], $data);
        }

    }

    function forwardMail($id)
    {
        $id =  $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));

        $mailType = explode("*", $id);

        if($mailType[1] == 'inbox'){
            $mail = $this->db->get_where('inbox', array(
                'id' => $id[0]
            ))->row();
        }else{
            $mail = $this->db->get_where('outbox', array(
                'id' => $id[0]
            ))->row();
        }
        $mail == TRUE || $this->message->norecord_found('employee/mail');

        $this->mViewData['mail'] = $mail;
        $departments = $this->db->order_by('department', 'asc')->get('department')->result();
        $admin = $this->db->get('admin_users')->result();

        foreach($admin as $item)
        {
            $employee['admin'][] = (object)array(
                'id' => $item->id.'*A',
                'name' => $item->first_name.' '.$item->last_name ,
            );

        }

        foreach($departments as $item)
        {
            $result =  $this->db->get_where('employee', array(
                'department' => $item->id
            ))->result();

            foreach($result as $v_employee){
                $employee[$item->department][] = (object)array(
                    'id' => $v_employee->id.'*E',
                    'name' => $v_employee->first_name.' '.$v_employee->last_name ,
                );
            }

        }
        $this->mViewData['emailType'] = $mailType[1];
        $this->mViewData['employee'] = $employee;
        $this->render('mail/compose');
    }


    //Sent Main Box Start ============================================>>

    function sentItem()
    {
        $this->mTitle .= lang('sent_item_list');
        $this->render('mail/sent_mail');
    }

    public function sentBoxList(){
        $this->global_model->table = 'outbox';
        $list = $this->global_model->get_sentitem_datatables();


        $data = array();
        $no = $_POST['start'];
        foreach ($list as $item) {

            $cc =  json_decode($item->cc);

            $to_email = array();
            foreach( $cc as $to){
                $result =  explode("*", $to);
                if($result[1] == 'A')
                {
                    $employee = $this->db->get_where('admin_users', array(
                        'id' => $result[0]
                    ))->row();

                    $to_email []= $employee->first_name;

                }else
                {
                    $employee = $this->db->get_where('employee', array(
                        'id' => $result[0]
                    ))->row();
                    $to_email []= $employee->first_name;
                }

            }

            $to = array_slice($to_email, 0, 2);

            $time = strtotime($item->date);
            $no++;
            $row = array();
            $row[] = '<label class="css-input css-checkbox css-checkbox-primary"><input type="checkbox" name="id[]" value="'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id.'*'.'sentItem')).'"><span></span></label>';


            $row[] = '<a href="'.base_url('employee/mail/viewSentEmail').'/'.str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($item->id)).'">'.'To: '.implode(", ",$to).'</a>';
            $row[] = $item->subject .' - '. substr(strip_tags($item->msg),0,20).'...';

            if(json_decode($item->attachment)){
                $row[] = '<i class="fa fa-paperclip"></i>';
            }else{
                $row[] = '';
            }

            $row[] = $this->humanTiming($time).' ago';
            $data[] = $row;
        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->global_model->count_sentItem(),
            "recordsFiltered" => $this->global_model->count_filtered_sentitem(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function viewSentEmail($id = null)
    {
        $id = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $id));

        $result = $this->db->get_where('outbox', array(
            'id' => $id
        ))->row();
        $result == TRUE || $this->message->norecord_found('employee/mail/sentItem');


        $this->mViewData['mail'] =  $result;
        $this->mViewData['type'] =  'sentEmail';
        $this->mTitle .= lang('read_mail');
        $this->render('mail/view_email');
    }

    //Sent Main Box End ==============================================>>


    function deleteMails()
    {
        $id = $this->input->post('id');

        if (!empty($id)) {
            foreach ($id as $item) {
                $mailId = $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $item));

                $result = explode("*", $mailId);

                if ($result[1] == 'inbox') {
                    $tablePrimary = 'inbox';
                    $tableSecondary = 'outbox';
                    $url = 'employee/mail';
                } else {
                    $tablePrimary = 'outbox';
                    $tableSecondary = 'inbox';
                    $url = 'employee/mail/sentItem';
                }

                $mailDetails = $this->db->get_where($tablePrimary, array(
                    'id' => $result[0]
                ))->row();

                $hasAttachmentInbox = $this->db->get_where($tablePrimary, array(
                    'attachment_id' => $mailDetails->attachment_id,
                    'id !=' => $result[0]
                ))->row();

                $hasAttachmentSentItem = $this->db->get_where($tableSecondary, array(
                    'attachment_id' => $mailDetails->attachment_id,
                ))->row();

                if ($hasAttachmentInbox || $hasAttachmentSentItem) {
                    $this->db->delete($tablePrimary, array('id' => $result[0]));
                } else {
                    $attachmentFiles = json_decode($mailDetails->attachment);
                    if (count($attachmentFiles)) {
                        foreach ($attachmentFiles as $item) {
                            $file = base_url() . ATTACHMENT . $item->file_name;
                            unlink($file);
                        }
                    }
                    $this->db->delete($tablePrimary, array('id' => $result[0]));
                }
            }
            $this->message->delete_success($url);
        } else {
            $url = $this->input->post('url');
            $this->message->norecord_found($url);
        }
    }

}