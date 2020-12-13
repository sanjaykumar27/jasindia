<?php

class StateMaster extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function selectAll()
    {
        // , ROW_NUMBER() OVER(ORDER BY StateID DESC) AS row_num
        $this->db->select('*');
        $this->db->from('m_states');
        $this->db->where('deleted_on', null);
        // $this->db->order_by('StateID','DESC');
        $data = $this->db->get();
        $num = $data->num_rows();
        if ($num > 0)
        {
            $result = $data->result_array();
            if (isset($result))
            {
                return $result;
            } else
            {
                return '';
            }
        }
    }

    function createState($param)
    {
        $this->db->insert('m_states', $param);
        $id = $this->db->insert_id();
        return $id;
    }

    function checkStateExists($state_name, $state_id)
    {
        $this->db->select('state_id');
        $this->db->from('m_states');
        $this->db->where('state_name', $state_name);
        if($state_id){
            $this->db->where('state_id !=', $state_id);
        }
        $data = $this->db->get();
        $num = $data->num_rows();
        if ($num > 0)
        {
            $result = $data->result_array();
            if (isset($result))
            {
                return $result;
            } else
            {
                return '';
            }
        }
    }

    function GetStateName($state_id)
    {
        $this->db->select('state_id, state_name');
        $this->db->from('m_states');
        $this->db->where('state_id', $state_id);
        $query = $this->db->get();
        if (count($query->result()) > 0)
        {
            return $query->row();
        }
    }
    
    function updateState($param, $state_id)
    {
        $this->db->where('state_id', $state_id);
        $this->db->update('m_states', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

}
