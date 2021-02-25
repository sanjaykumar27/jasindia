<?php

class TireManufacturer_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }

    function selectAll($limit, $offset, $search, $count)
    {
        $this->db->select('*');
        $this->db->from('m_tire_manufacturer');
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("manufacturer_name LIKE '%$keyword%'");
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
