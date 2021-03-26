<?php

class ExclusionMapping_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function getAllHeadings($category_id)
    {
        $this->db->select('exclusion_heading_id,exclusion_heading');
        $this->db->from('m_insurance_exclusion_heading');
        $this->db->where('exclusion_category_id',$category_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        return array();
    }

    function selectAll($limit, $offset, $search, $count)
    {
        $this->db->select('m_insurer_description.insurer_name,m_vehicle_segment.segment_name,m_insurance_exclusion.exclusion_category,m_insurance_exclusion_heading.exclusion_heading,m_insurer_exclusion_mapping.mapping_id');
        $this->db->from('m_insurer_exclusion_mapping');
        $this->db->join('m_insurer_description', 'm_insurer_description.description_id = m_insurer_exclusion_mapping.insurer_id', 'left');
        $this->db->join('m_vehicle_segment', 'm_vehicle_segment.segment_id = m_insurer_exclusion_mapping.vehicle_segment_id', 'left');
        $this->db->join('m_insurance_exclusion', 'm_insurance_exclusion.exclusion_id = m_insurer_exclusion_mapping.insurer_category_id', 'left');
        $this->db->join('m_insurance_exclusion_heading', 'm_insurance_exclusion_heading.exclusion_heading_id = m_insurer_exclusion_mapping.heading_id', 'left');
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("m_insurer_description.insurer_name LIKE '%$keyword%'");
                $this->db->or_where("m_vehicle_segment.segment_name LIKE '%$keyword%'");
                $this->db->or_where("m_insurance_exclusion.exclusion_category LIKE '%$keyword%'");
                $this->db->or_where("m_insurance_exclusion_heading.exclusion_heading LIKE '%$keyword%'");
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
}
