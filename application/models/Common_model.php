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

    function getLogs()
    {
        $this->db->select('audit_log.page,audit_log.record,audit_log.created_on,users.first_name,users.last_name');
        $this->db->from('audit_log');
        $this->db->join('users', 'users.id = audit_log.created_by', 'left');
        $this->db->order_by("log_id", "desc");
        $this->db->limit(20);
        $query = $this->db->get();
        if (count($query->result()) > 0)
        {
            return $query->result();
        }
    }

}

