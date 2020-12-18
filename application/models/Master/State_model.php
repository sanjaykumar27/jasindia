<?php

class State_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function selectAll($limit, $offset, $search, $count)
    {
        $this->db->select('*');
        $this->db->from('m_states');
        $this->db->where('deleted_on', null);
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("state_name LIKE '%$keyword%'");
               
            }
        }
        if ($count)
        {
            return $this->db->count_all_results();
        } else
        {
            $this->db->limit($limit, $offset);
            $query = $this->db->get();

            if ($query->num_rows() > 0)
            {
                return $query->result();
            }
        }
        return array();
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
        if ($state_id)
        {
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
    
    function selectAllDistricts($state_id)
    {
        $this->db->select('*');
        $this->db->from('m_districts');
        $this->db->where('deleted_on', null);
        $this->db->where('state_id', $state_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return array();
    }
        
    function createDistrict($param)
    {
        $this->db->insert('m_districts', $param);
        $id = $this->db->insert_id();
        return $id;
    }
    
    function checkDistrictExists($district_name, $district_id)
    {
        $this->db->select('district_id');
        $this->db->from('m_districts');
        $this->db->where('district_name', $district_name);
        if ($district_id)
        {
            $this->db->where('district_id !=', $district_id);
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

}
