<?php

class Manufacturer_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function selectAll($limit, $offset, $search, $count)
    {
        $this->db->select('*');
        $this->db->from('m_manufacturer');
        $this->db->where('deleted_on', null);
        $this->db->join('m_company_type', 'm_company_type.company_type_id = m_manufacturer.manufacturer_type', 'left');
        if ($search)
        {
            $keyword = $search['keyword'];
            if ($keyword)
            {
                $this->db->where("manufacturer_name LIKE '%$keyword%'");
                $this->db->or_where("manufacturer_address LIKE '%$keyword%'");
                $this->db->or_where("manufacturer_website LIKE '%$keyword%'");
                $this->db->or_where("manufacturer_email LIKE '%$keyword%'");
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

    function checkManufacturerExists($manufacturer_name,$manufacturer_id)
    {
        $this->db->select('manufacturer_id');
        $this->db->from('m_manufacturer');
        $this->db->where('manufacturer_name', $manufacturer_name);
        if($manufacturer_id){
           $this->db->where('manufacturer_id !=',$manufacturer_id); 
            
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
    
    function GetManufacturerName($manufacturer_id)
    {
        $this->db->select('manufacturer_id, manufacturer_type, manufacturer_name, manufacturer_address, manufacturer_email, manufacturer_website');
        $this->db->from('m_manufacturer');
        $this->db->where('manufacturer_id', $manufacturer_id);
        $query = $this->db->get();
        if (count($query->result()) > 0)
        {
            return $query->row();
        }
    }
    
    function updateManufacturer($param, $manufacturer_id)
    {
        $this->db->where('manufacturer_id', $manufacturer_id);
        $this->db->update('m_manufacturer', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    function getAllManufacturer()
    {
        $this->db->select('manufacturer_id, manufacturer_name');
        $this->db->from('m_manufacturer');
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
