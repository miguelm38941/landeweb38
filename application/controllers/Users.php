<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth','form_validation','lg','email'));
        $this->load->helper(array('url','language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->model('Musers');
        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('auth', 'refresh');
        }
    }

    /**
     * @Return view type_organisation
     */
    public function typeorganisation(){
        //list the type organisation
        $this->data['types'] = $this->Musers->getData('type_organisation');
        // var_dump($this->data['users'][$k]);die();
        $this->_render_page('organisation/type_organisation', $this->data);
    }

    /**
     * @Return view organisation
     */
    public function organisation(){
        //list the organisation
        $this->data['data'] = $this->Musers->getOrganisation();
        //var_dump($this->data['data']);die();
        $this->_render_page('organisation/organisation', $this->data);
    }

    // edit a type organisation
    public function edit_type_organisation($id){

        $user = $this->Musers->getDataById('type_organisation','id_type_organisation',$id);

        $this->_render_page('organisation/edit_type_organisation', $user);
    }

    // edit an organisation
    public function edit_organisation($id){

        $this->data['data'] = $this->Musers->getDataById('organisation','id_organisation',$id);
        $this->data['types'] = $this->Musers->getData('type_organisation');
        $this->load->view('organisation/edit_organisation',$this->data);
    }


    public function UpdateTypeOrganisation(){
        $id = $this->input->post('id');
        $data = array(
            'name'=> $this->input->post('name'),
            'description'=> $this->input->post('description')
        );
        $this->Musers->UpdateData('type_organisation', 'id_type_organisation',$id,$data);
        redirect('backend/typeorganisation');
    }

    public function UpdateOrganisation(){
        $id = $this->input->post('id');
        $data = array(
            'titre'=> $this->input->post('titre'),
            'ville'=> $this->input->post('ville'),
            'adresse'=> $this->input->post('adresse'),
            'email'=> $this->input->post('email'),
            'telephone'=> $this->input->post('telephone'),
            'designation'=> $this->input->post('designation'),
            'id_type_organisation'=> $this->input->post('type'),
        );
        $this->Musers->UpdateData('organisation','id_organisation',$id,$data);
        redirect('backend/organisation');
    }

    public function insertTypeOrganisation(){
        if ($_POST){
            $data = array(
                'name'=> $this->input->post('name'),
                'description'=> $this->input->post('description')
            );
            $this->Musers->insertData('type_organisation', $data);
            redirect('backend/typeorganisation');
        }else{
            $this->load->view('organisation/save_type_organisation');
        }

    }
    public function insertOrganisation(){

        if ($_POST){
            $data = array(
                'titre'=> $this->input->post('titre'),
                'ville'=> $this->input->post('ville'),
                'adresse'=> $this->input->post('adresse'),
                'email'=> $this->input->post('email'),
                'telephone'=> $this->input->post('telephone'),
                'designation'=> $this->input->post('designation'),
                'id_type_organisation'=> $this->input->post('type'),
            );
            $this->Musers->insertData('organisation', $data);
            redirect('backend/organisation');
        }else{
            $this->data['types'] = $this->Musers->getData('type_organisation');
            $this->load->view('organisation/save_organisation',$this->data);
        }

    }


    /**
     * Début Functions empruntées
     */
    public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
    {

        $this->viewdata = (empty($data)) ? $this->data: $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
    }

    public function _valid_csrf_nonce(){
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    /**
     * Fin Functions empruntées
     */
}
