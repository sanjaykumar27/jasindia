<?php

class InsuranceExclusion_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	function checkInsuranceExclusionExist($exclusion_category, $exclusion_id)
	{
		$this->db->select('exclusion_id');
        $this->db->from('m_insurance_exclusion');
        $this->db->where('exclusion_category', $exclusion_category);
        if ($exclusion_id)
        {
            $this->db->where('exclusion_id !=', $exclusion_id);
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
        $this->db->select('m_insurance_exclusion.exclusion_id,m_insurance_exclusion.exclusion_category');
        $this->db->from('m_insurance_exclusion');
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("m_insurance_exclusion.exclusion_category LIKE '%$keyword%'");
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

    function updateInsuranceExclusion($param, $exclusion_id)
    {
        $this->db->where('exclusion_id', $exclusion_id);
        $this->db->update('m_insurance_exclusion', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    function GetInsuranceExclusionDetails($exclusion_id)
    {
        $this->db->select('exclusion_category, exclusion_id');
        $this->db->from('m_insurance_exclusion');
        $this->db->where('exclusion_id', $exclusion_id);
        $query = $this->db->get();
        if (count($query->result()) > 0)
        {
            return $query->row();
        }
    }

    function selectAllDescriptions($exclusion_id)
    {
        $this->db->select('m_insurance_exclusion_heading.exclusion_heading_id,m_insurance_exclusion_heading.exclusion_heading,m_insurance_exclusion_heading.exclusion_category_id,m_insurance_exclusion_heading.exclusion_explaination');
        $this->db->from('m_insurance_exclusion_heading');
        $this->db->where('m_insurance_exclusion_heading.exclusion_category_id', $exclusion_id);
        $query = $this->db->get();
        if (count($query->result()) > 0)
        {
            return $query->result();
        }
    }

    function getExclustionDetails($exclusion_mapping_id)
    {
        $this->db->select('m_insurance_exclusion_heading.exclusion_heading_id,m_insurance_exclusion_heading.exclusion_heading,m_insurance_exclusion_heading.exclusion_category_id,m_insurance_exclusion_heading.exclusion_explaination,m_insurance_exclusion.exclusion_category');
        $this->db->from('m_insurance_exclusion_heading');
        $this->db->join('m_insurance_exclusion', 'm_insurance_exclusion.exclusion_id = m_insurance_exclusion_heading.exclusion_category_id', 'left');
        $this->db->where('m_insurance_exclusion_heading.exclusion_heading_id', $exclusion_mapping_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return array();
    }

    function updateExclustionMapping($param, $mapping_id)
    {
        $this->db->where('exclusion_heading_id', $mapping_id);
        $this->db->update('m_insurance_exclusion_heading', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    function selectAllCategories()
    {
        $this->db->select('m_insurance_exclusion.exclusion_id, m_insurance_exclusion.exclusion_category');
        $this->db->from('m_insurance_exclusion');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return array();
    }

}
