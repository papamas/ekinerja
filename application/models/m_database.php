<?php
class M_database extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Ambil 1 Data biasanya digunakan untuk edit
    public function get_single_data_q($q) {
        return $this->db->query($q)->row_array();
    }

    public function get_data_q($q) {

        return $this->db->query($q)->result_array();
    }

    public function get_data_list($table, $sort, $order) {

        return $this->db->from($table)->order_by($sort, $order)->get()->result_array();
    }

    public function get_single_data($table, $where, $id) {

        return $this->db->from($table)->where($where, $id)->get()->row_array();
    }

    public function get_data($table, $where, $id) {
        return $this->db->from($table)->where($where, $id)->get()->result_array();
    }

    public function get_data2($select, $table, $par_where, $par_join) {
        $this->db->select($select);
        $this->db->from($table);
        $cek_where = count($par_where);
        if ($cek_where > 0) {
            for ($i = 0; $i < $cek_where; $i++) {
                $this->db->where($par_where[$i]['where'], $par_where[$i]['value']);
            }
        }
        $cek_join = count($par_join);
        if ($cek_join > 0) {
            for ($i = 0; $i < $cek_join; $i++) {
                $this->db->join($par_join[$i]['table'], $par_join[$i]['on'], $par_join[$i]['type']);
            }
        }
        return $this->db->get()->result_array();
    }

    public function tambah_data($table, $data) {
        $tambah = $this->db->insert($table, $data);
        if ($tambah) {
            return $this->db->insert_id();
        }
    }

    public function ubah_data($table, $where, $id, $data) {

        $this->db->where($where, $id);
        return $this->db->update($table, $data);
    }

    public function hapus_data($table, $where, $id) {

        $this->db->where($where, $id);
        return $this->db->delete($table);
    }

    public function query_no_return($q) {

        return $this->db->query($q);
    }

    public function list_data($select, $table, $par_join, $par_where, $cari, $txt, $limit, $offset, $sort, $order, $group_by) {

        // Periksa apa ada select per kolom
        if ($select !== '') {
            $this->db->select($select);
        }
        $this->db->from($table);
        // Cek ada data yang dijoin atau tidak ?
        $cek_join = count($par_join);
        if ($cek_join > 0) {
            for ($i = 0; $i < $cek_join; $i++) {
                $this->db->join($par_join[$i]['table'], $par_join[$i]['on'], $par_join[$i]['type']);
            }
        }
        // Cek ada kondisi atau tidak ?
        $cek_where = count($par_where);
        if ($cek_where > 0) {
            for ($i = 0; $i < $cek_where; $i++) {
                $this->db->where($par_where[$i]['where'], $par_where[$i]['value']);
            }
        }

        if ($txt !== "") {
            $this->db->LIKE('upper(' . $cari . ')', strtoupper($txt));
        }

        if ($group_by !== "") {
            $this->db->group_by($group_by);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by($sort, $order);
        return $this->db->get()->result_array();
    }

    public function ttl_data($table, $par_join, $par_where, $cari, $txt, $group_by) {
//	$par_join=array();
        $group_by = '';
        $this->db->from($table);
        // Cek ada data yang dijoin atau tidak ?
        $cek_join = count($par_join);
        if ($cek_join > 0) {
            for ($i = 0; $i < $cek_join; $i++) {
                $this->db->join($par_join[$i]['table'], $par_join[$i]['on'], $par_join[$i]['type']);
            }
        }
        $cek_where = count($par_where);
        if ($cek_where > 0) {
            for ($i = 0; $i < $cek_where; $i++) {
                $this->db->where($par_where[$i]['where'], $par_where[$i]['value']);
            }
        }
        if ($txt !== "") {
            $this->db->LIKE('upper(' . $cari . ')', strtoupper($txt));
        }
        if ($group_by !== "") {
            $this->db->group_by($group_by);
        }
        return $this->db->count_all_results();
    }

    public function list_data_2($select, $table, $par_join, $par_where, $cari, $txt, $cari2, $txt2, $limit, $offset, $sort, $order, $group_by) {

        // Periksa apa ada select per kolom
        if ($select !== '') {
            $this->db->select($select);
        }
        $this->db->from($table);
        // Cek ada data yang dijoin atau tidak ?
        $cek_join = count($par_join);
        if ($cek_join > 0) {
            for ($i = 0; $i < $cek_join; $i++) {
                $this->db->join($par_join[$i]['table'], $par_join[$i]['on'], $par_join[$i]['type']);
            }
        }
        // Cek ada kondisi atau tidak ?
        $cek_where = count($par_where);
        if ($cek_where > 0) {
            for ($i = 0; $i < $cek_where; $i++) {
                $this->db->where($par_where[$i]['where'], $par_where[$i]['value']);
            }
        }

        if ($txt !== "") {
            $this->db->LIKE('upper(' . $cari . ')', strtoupper($txt));
        }
        if ($txt2 !== "") {
            $this->db->LIKE('upper(' . $cari2 . ')', strtoupper($txt2));
        }

        if ($group_by !== "") {
            $this->db->group_by($group_by);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by($sort, $order);
        return $this->db->get()->result_array();
    }

    public function ttl_data_2($table, $par_join, $par_where, $cari, $txt, $cari2, $txt2, $group_by) {
        $par_join = array();
        $group_by = '';
        $this->db->from($table);
        // Cek ada data yang dijoin atau tidak ?
        $cek_join = count($par_join);
        if ($cek_join > 0) {
            for ($i = 0; $i < $cek_join; $i++) {
                $this->db->join($par_join[$i]['table'], $par_join[$i]['on'], $par_join[$i]['type']);
            }
        }
        $cek_where = count($par_where);
        if ($cek_where > 0) {
            for ($i = 0; $i < $cek_where; $i++) {
                $this->db->where($par_where[$i]['where'], $par_where[$i]['value']);
            }
        }
        if ($txt !== "") {
            $this->db->LIKE('upper(' . $cari . ')', strtoupper($txt));
        }
        if ($txt2 !== "") {
            $this->db->LIKE('upper(' . $cari2 . ')', strtoupper($txt2));
        }
        if ($group_by !== "") {
            $this->db->group_by($group_by);
        }
        return $this->db->count_all_results();
    }

    public function ttl_data2($table, $par_join, $par_where, $cari, $txt, $group_by) {

        $group_by = '';
        $this->db->from($table);
        // Cek ada data yang dijoin atau tidak ?
        $cek_join = count($par_join);
        if ($cek_join > 0) {
            for ($i = 0; $i < $cek_join; $i++) {
                $this->db->join($par_join[$i]['table'], $par_join[$i]['on'], $par_join[$i]['type']);
            }
        }
        $cek_where = count($par_where);
        if ($cek_where > 0) {
            for ($i = 0; $i < $cek_where; $i++) {
                $this->db->where($par_where[$i]['where'], $par_where[$i]['value']);
            }
        }
        if ($txt !== "") {
            $this->db->LIKE('upper(' . $cari . ')', strtoupper($txt));
        }
        if ($group_by !== "") {
            $this->db->group_by($group_by);
        }
        return $this->db->count_all_results();
    }

    public function get_sertifikat($nama, $jabatan) {
        $this->db->select("id_dd_sertifikat as id,nip,nama,concat(no_sertifikat,'-',keterangan) as label,rtrim(nama) as value");
        $this->db->from('dd_sertifikat');
        $this->db->where('id_dd_jabatan', $jabatan);
        $this->db->like('no_sertifikat', $nama);
        $this->db->order_by('value', 'ASC');
        $get = $this->db->get();
        return $get->result();
    }

    public function get_nip($nip) {

        $get = $this->db->query("SELECT `id_dd_user` AS id, `nip`, `nama`, CONCAT(nip, '-', nama) AS label, RTRIM(nama) AS value
FROM (`dd_user`)
WHERE unit_kerja >0 AND `nip` LIKE '%{$nip}%'
ORDER BY `value` ASC");
        return $get->result();
    }

}
