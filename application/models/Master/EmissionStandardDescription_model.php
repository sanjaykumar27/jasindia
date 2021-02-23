<?php

class EmissionStandardDescription_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    function selectAll($limit, $offset, $search, $count)
    {
        $this->db->select('m_emmision_standard_description.*,m_emission_standard.emission_name,m_vehicle_segment.segment_name');
        $this->db->from('m_emmision_standard_description');
        $this->db->join('m_emission_standard', 'm_emission_standard.emission_id = m_emmision_standard_description.emission_standard_id', 'left');
        $this->db->join('m_vehicle_segment', 'm_vehicle_segment.segment_id = m_emmision_standard_description.vehicle_segment_id', 'left');
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("m_vehicle_segment.segment_name LIKE '%$keyword%'");
                $this->db->or_where("m_emission_standard.emission_name LIKE '%$keyword%'");
                $this->db->or_where("m_emmision_standard_description.carbon_monoxcide LIKE '%$keyword%'");
                $this->db->or_where("m_emmision_standard_description.carbon_dioxcide LIKE '%$keyword%'");
                $this->db->or_where("m_emmision_standard_description.hydro_carbons LIKE '%$keyword%'");
                $this->db->or_where("m_emmision_standard_description.nitrogen_oxcide LIKE '%$keyword%'");
                $this->db->or_where("m_emmision_standard_description.hc_nox LIKE '%$keyword%'");
                $this->db->or_where("m_emmision_standard_description.particulate_matter LIKE '%$keyword%'");
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
