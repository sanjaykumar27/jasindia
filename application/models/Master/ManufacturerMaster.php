<?php

class ManufacturerMaster extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function selectAll()
    {
        // , ROW_NUMBER() OVER(ORDER BY CompanyID DESC) AS row_num
        $this->db->select('*');
        $this->db->from('m_vehicle_manufacturer');
        $this->db->where('deleted_on', null);
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

    function createManufacturer($param)
    {
        $this->db->insert('m_vehicle_manufacturer', $param);
        $id = $this->db->insert_id();
        return $id;
    }

    function checkManufacturerExists($manufacturer_name,$manufacturer_id)
    {
        $this->db->select('manufacturer_id');
        $this->db->from('m_vehicle_manufacturer');
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
        $this->db->select('manufacturer_id, manufacturer_name, manufacturer_address, manufacturer_email, manufacturer_website');
        $this->db->from('m_vehicle_manufacturer');
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
        $this->db->update('m_vehicle_manufacturer', $param);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

}
