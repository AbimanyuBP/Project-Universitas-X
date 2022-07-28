<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_model extends CI_Model
{

    public $id;
    public $nama;
    public $is_device;
    public $kondisi;
    public $jumlah;
    public $rows;
    public $row;

    public $labels = [];

    public function __construct()
    {
        parent::__construct();
        $this->labels = $this->_attributeLabels();

        $this->load->database();
    }

    public function _attributeLabels()
    {
        return [
            'id' => 'ID: ',
            'nama' => 'Nama: ',
            'is_device' => 'Apakah Device: ',
            'kondisi' => 'Kondisi: ',
            'jumlah' => 'Jumlah: ',
        ];
    }

    public function get_row($kode)
    {
        $sql = sprintf("SELECT * FROM inventori WHERE id='%s'", $kode);

        $query = $this->db->query($sql);
        $this->row = $query->row();
    }

    public function get_rows()
    {
        $sql = "SELECT * FROM inventori ORDER BY id";

        $query = $this->db->query($sql);
        $rows = array();
        foreach ($query->result() as $row) {
            $rows[] = $row;
        }

        $this->rows = $rows;
    }

    public function insert()
    {
        $sql = sprintf(
            "INSERT INTO inventori(nama, is_device, kondisi, jumlah) VALUES('%s', '%s','%s','%d')",
            $this->nama,
            $this->is_device,
            $this->kondisi,
            $this->jumlah
        );

        $this->db->query($sql);
    }
 
    public function update()
    {
        $sql = sprintf("UPDATE inventori SET nama='%s', is_device='%s', kondisi='%s', jumlah='%d' WHERE id='%s' ",
                $this->nama,
                $this->is_device,
                $this->kondisi,
                $this->jumlah,
                $this->id //this doesnt hold current selected id
                );
        $this->db->query($sql);
    }

    public function delete($kode)
    {
        $sql = sprintf("DELETE FROM inventori WHERE id='%s'", $kode);
        $this->db->query($sql);
    }
    
    public function countBarang()
    {
        //hitung jumlah barang yang terdaftar di database
        $this->db->where('is_device =', 'no');
        $query = $this->db->get('inventori');
        $countbarang = $query->num_rows();
        return $countbarang;
    }

    public function countDevice()
    {
        //hitung jumlah device yang terdaftar di database
        $this->db->where('is_device =', 'yes');
        $query = $this->db->get('inventori');
        $countdevice = $query->num_rows();
        return $countdevice;;
    }

    public function countOn()
    {
        //Buat hitung berapa banyak device yang on buat dashboard
        $this->db->where('kondisi =', 'on');
        $query = $this->db->get('inventori');
        $counton = $query->num_rows();
        return $counton;
    }

    public function countOff()
    {
        //Buat hitung berapa banyak device yang off buat dashboard
        $this->db->where('kondisi =', 'off');
        $query = $this->db->get('inventori');
        $countoff = $query->num_rows();
        return $countoff;
    }

    public function tampil_data()
    {
        return $this->db->get('inventori');
    }

    public function get_device()
    {
        $query = $this->db->query("SELECT COUNT(is_device) FROM inventori WHERE 'kondisi = on'");

        $hasil[] = $query;


        return $query;
    }



    // public function getTestData() {
    //     $query = $this->db->get( inventori')->results();
    //     return $query;
    // }
}
