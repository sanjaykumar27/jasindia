<?php
class Common_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function SelectAll($tablename)
    {
        $this->db->select('*');
        $this->db->from($tablename);
        $query = $this->db->get();
        if (count($query->result()) > 0)
        {
            return $query->result();
        }
    }

    function CommonInsert($tablename, $param)
    {
        $this->db->insert($tablename, $param);
        $id = $this->db->insert_id();
        return $id;
    }
}

