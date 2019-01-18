<?php

class Musers extends CI_Model {
    
    function __construct(){
        parent::__construct();
    }

    /**
     * Function to insert data
     * @table
     * @data
     * Return true or false
     */
    public function insertData($table,$data){
        $res = $this->db->insert($table, $data);
        
    }

    /**
     * Function to updata data
     * @table
     * @id_label
     * @id
     * @data
     * Return true or false
     */
    public function UpdateData($table,$id_label,$id,$data){
        $this->db->where($id_label,$id);
        $res = $this->db->update($table, $data);
    }

    /**
     * Function to select data
     * @table
     * Return data list
     */

    function getData($table){
        return $this->db->get($table)->result();
    }
    /**
     * Function to select row by @id
     * @table
     * @table
     * @id_label
     * @id
     * Return row data
     */
    public function getDataById($table,$id_label,$id)
    {
        $this->db->where($id_label,$id);
        $row = $this->db->get($table);
        return $row->row();
    }

    /**
     * Return list organisation by type
     */
    function getOrganisation(){
        $this->db->select('*')
            ->from('organisation o')
            ->join('type_organisation t','o.id_type_organisation = t.id_type_organisation');
        return $this->db->get()->result();
    }

    /**
     * @id
     * Return list type_organisation
     */
    public function getOrganisationById($id)
    {
        $this->db->select('*')
            ->from('organisation o')
            ->join('type_orgamisation t','o.id_type_organisation = t.id_type_organisation')
            ->where('id_organisation',$id);
        return $this->db->get()->row();
    }

}
?>
