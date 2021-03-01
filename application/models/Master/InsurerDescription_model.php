<?php

class InsurerDescription_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	function checkInsurerDescriptionExist($insurer_name, $description_id)
	{
		$this->db->select('description_id');
        $this->db->from('m_insurer_description');
        $this->db->where('insurer_name', $insurer_name);
        if ($description_id)
        {
            $this->db->where('description_id !=', $description_id);
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
	
    function selectAll($limit, $offset, $search, $count)
    {
        $this->db->select('m_insurer_description.description_id,m_insurer_description.insurer_name,m_insurer_description.registored_address, m_insurer_description.website, 
        m_insurer_description.email,m_insurer_description.gst,m_insurer_description.tan');
        $this->db->from('m_insurer_description');
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("m_insurer_description.insurer_name LIKE '%$keyword%'");
                $this->db->or_where("m_insurer_description.registored_address LIKE '%$keyword%'");
                $this->db->or_where("m_insurer_description.website LIKE '%$keyword%'");
                $this->db->or_where("m_insurer_description.email LIKE '%$keyword%'");
                $this->db->or_where("m_insurer_description.gst LIKE '%$keyword%'");
                $this->db->or_where("m_insurer_description.tan LIKE '%$keyword%'");
            }
        }
        if ($count)
        {
            return $this->db->count_all_results();
        }
        else {
            $this->db->limit($limit, $offset);
            $query = $this->db->get();

            if ($query->num_rows() > 0)
            {
                return $query->result();
            }
        }
        return array();
    }

    function updateInsurerDescription($param, $description_id)
    {
        $this->db->where('description_id', $description_id);
        $this->db->update('m_insurer_description', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    function GetInsurerDescriptionDetails($description_id)
    {
        $this->db->select('insurer_name, description_id, registored_address, website, email, gst, tan');
        $this->db->from('m_insurer_description');
        $this->db->where('description_id', $description_id);
        $query = $this->db->get();
        if (count($query->result()) > 0)
        {
            return $query->row();
        }
    }

    function selectAllBranches($insurer_id)
    {
        $this->db->select('m_cities.city_name, m_cities.city_id, m_insurer_branch.insurer_id, m_insurer_branch.branch_code, m_insurer_branch.address, m_insurer_branch.email, m_insurer_branch.branch_id');
        $this->db->from('m_insurer_branch');
        $this->db->join('m_cities', 'm_cities.city_id = m_insurer_branch.city_id', 'left');
        $this->db->where('insurer_id', $insurer_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return array();
    }

    function listAllCities()
    {
        $this->db->select('city_id, city_name');
        $this->db->from('m_cities');
        $this->db->where('deleted_on', null);
        $this->db->order_by('m_cities.city_name');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return array();
    }

    function getBranchDetails($branch_id)
    {
        $this->db->select('*');
        $this->db->from('m_insurer_branch');
        $this->db->where('branch_id', $branch_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return array();
    }

    function updateBranch($param, $branch_id)
    {
        $this->db->where('branch_id', $branch_id);
        $this->db->update('m_insurer_branch', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    function listAllData()
    {
        $this->db->select('description_id,insurer_name');
        $this->db->from('m_insurer_description');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return array();
    }
    
}
