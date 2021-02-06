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
        $this->db->select('m_insurer_description.description_id,m_insurer_description.insurer_name,m_insurer_description.registored_address, m_insurer_description.website, m_insurer_description.email');
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
        $this->db->select('insurer_name, description_id, registored_address, website, email');
        $this->db->from('m_insurer_description');
        $this->db->where('description_id', $description_id);
        $query = $this->db->get();
        if (count($query->result()) > 0)
        {
            return $query->row();
        }
    }
}
