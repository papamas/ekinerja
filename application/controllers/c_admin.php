<?php

class C_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("M_database");
    }

    public function jabatan() {
        $this->load->view('admin/v_jabatan');
    }

    public function uker() {
        $this->load->view('admin/v_uker');
    }

    public function pangkat() {
        $this->load->view('admin/v_pangkat');
    }

    public function user() {
        $this->load->view('admin/v_user');
    }

    public function admin() {
        $this->load->view('admin/v_admin');
    }

    public function operator() {
        $this->load->view('admin/v_operator');
    }

    public function kuantitas() {
        $this->load->view('admin/v_kuantitas');
    }

    public function tambah_jabatan() {
        $this->load->view('admin/v_tambah_jabatan');
    }

    public function tambah_uker() {
        $this->load->view('admin/v_tambah_uker');
    }

    public function tambah_admin() {
        $this->load->view('admin/v_tambah_admin');
    }

    public function tambah_operator() {
        $this->load->view('admin/v_tambah_operator');
    }

    public function tambah_kuantitas() {
        $this->load->view('admin/v_tambah_kuantitas');
    }

    public function tambah_pangkat() {
        $this->load->view('admin/v_tambah_pangkat');
    }

    public function pengaturan() {
        $x['atur'] = $this->db->get('dc_parameter_bulan')->row_array();
        $this->load->view('admin/v_pengaturan', $x);
    }

    public function aksi_pengaturan() {
        $cek = $this->input->post('cek');
        $cek2 = $this->input->post('cek2');
        $data = array('parameter_bulan' => $cek,'parameter_approve' => $cek2);
        $cek_data = $this->db->from('dc_parameter_bulan')->count_all_results();
        if ($cek_data == 0) {
            $proses = $this->db->insert('dc_parameter_bulan', $data);
        } else {
            $proses = $this->db->update('dc_parameter_bulan', $data);
        }
        if ($proses) {
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil diproses';
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Data gagal diproses';
        }
        $this->j($a);
    }

    public function tambah_user() {
        $data['jabatan'] = $this->db->get('dd_jabatan')->result_array();
        $data['pangkat'] = $this->db->get('dd_ruang_pangkat')->result_array();
        $data['uker'] = $this->db->get('dd_uker')->result_array();
        $data['jenis'] = 'tambah';
        $this->load->view('admin/v_tambah_user', $data);
    }

    public function ubah_jabatan($id) {
        $x['jabatan'] = $this->db->where('id_dd_jabatan', $id)->get('dd_jabatan')->row_array();
        $this->load->view('admin/v_tambah_jabatan', $x);
    }

    public function ubah_uker($id) {
        $x['uker'] = $this->db->where('id_dd_uker', $id)->get('dd_uker')->row_array();
        $this->load->view('admin/v_tambah_uker', $x);
    }

    public function ubah_admin($id) {
        $x['user'] = $this->db->where('id_dd_user', $id)->get('dd_user')->row_array();
        $this->load->view('admin/v_tambah_admin', $x);
    }

    public function ubah_operator($id) {
        $x['user'] = $this->db->where('id_dd_user', $id)->get('dd_user')->row_array();
        $this->load->view('admin/v_tambah_operator', $x);
    }

    public function ubah_kuantitas($id) {
        $x['kuantitas'] = $this->db->where('id_dd_kuantitas', $id)->get('dd_kuantitas')->row_array();
        $this->load->view('admin/v_tambah_kuantitas', $x);
    }

    public function ubah_pangkat($id) {
        $x['pangkat'] = $this->db->where('id_dd_ruang_pangkat', $id)->get('dd_ruang_pangkat')->row_array();
        $this->load->view('admin/v_tambah_pangkat', $x);
    }

    public function ubah_user($id) {
        $x['jabatan'] = $this->db->get('dd_jabatan')->result_array();
        $x['pangkat'] = $this->db->get('dd_ruang_pangkat')->result_array();
        $x['uker'] = $this->db->get('dd_uker')->result_array();
        $x['user'] = $this->db->where('id_dd_user', $id)->get('dd_user')->row_array();
        $x['jenis'] = 'ubah';
        $this->load->view('admin/v_tambah_user', $x);
    }

    public function detail_user($id) {
        $x['jabatan'] = $this->db->get('dd_jabatan')->result_array();
        $x['pangkat'] = $this->db->get('dd_ruang_pangkat')->result_array();
        $x['uker'] = $this->db->get('dd_uker')->result_array();
        $x['user'] = $this->db->where('id_dd_user', $id)->get('dd_user')->row_array();
        $x['jenis'] = 'detail';
        $this->load->view('admin/v_tambah_user', $x);
    }

    public function aksi_jabatan() {
        $p = json_decode(file_get_contents('php://input'));

        if ($p->id_dd_jabatan == '') {
            unset($p->id_dd_jabatan);
            $p->tunjangan = str_replace(",", "", $p->tunjangan);
            $cek = $this->M_database->tambah_data('dd_jabatan', $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil ditambah';
        } else {
            $p->tunjangan = str_replace(",", "", $p->tunjangan);
            $cek = $this->M_database->ubah_data('dd_jabatan', 'id_dd_jabatan', $p->id_dd_jabatan, $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil diubah';
        }

        if ($cek) {

            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Data gagal ditambah';
            $this->j($a);
        }
    }

    public function aksi_uker() {
        $p = json_decode(file_get_contents('php://input'));

        if ($p->id_dd_uker == '') {
            unset($p->id_dd_uker);
            $cek = $this->M_database->tambah_data('dd_uker', $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil ditambah';
        } else {
            $cek = $this->M_database->ubah_data('dd_uker', 'id_dd_uker', $p->id_dd_uker, $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil diubah';
        }

        if ($cek) {

            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Data gagal ditambah';
            $this->j($a);
        }
    }

    public function aksi_kuantitas() {
        $p = json_decode(file_get_contents('php://input'));
        if ($p->id_dd_kuantitas == '') {
            unset($p->id_dd_kuantitas);
            $cek = $this->M_database->tambah_data('dd_kuantitas', $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil ditambah';
        } else {
            $cek = $this->M_database->ubah_data('dd_kuantitas', 'id_dd_kuantitas', $p->id_dd_kuantitas, $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil diubah';
        }

        if ($cek) {

            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Data gagal ditambah';
            $this->j($a);
        }
    }

    public function aksi_admin() {
        $p = json_decode(file_get_contents('php://input'));
        if ($p->id_dd_user == '') {
            unset($p->id_dd_user);
            $p->jabatan = 0;
            $p->nama = "Administrator";
            $p->nip = "999";
            $p->password = base64_encode($p->password);
            $cek = $this->M_database->tambah_data('dd_user', $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil ditambah';
        } else {
            $p->jabatan = 0;
            $p->password = base64_encode($p->password);
            $cek = $this->M_database->ubah_data('dd_user', 'id_dd_user', $p->id_dd_user, $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil diubah';
        }

        if ($cek) {

            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Data gagal ditambah';
            $this->j($a);
        }
    }

    public function aksi_operator() {
        $p = json_decode(file_get_contents('php://input'));
        if ($p->id_dd_user == '') {
            unset($p->id_dd_user);
            $p->jabatan = 3;
            $p->nama = "Operator";
            $p->nip = "0000";
            $p->password = base64_encode($p->password);
            $cek = $this->M_database->tambah_data('dd_user', $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil ditambah';
        } else {
            $p->jabatan = 3;
            $p->password = base64_encode($p->password);
            $cek = $this->M_database->ubah_data('dd_user', 'id_dd_user', $p->id_dd_user, $p);
            $a['status'] = 1;

            $a['ket'] = 'Data berhasil diubah';
        }

        if ($cek) {

            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Data gagal ditambah';
            $this->j($a);
        }
    }

    public function aksi_pangkat() {
        $p = json_decode(file_get_contents('php://input'));

        if ($p->id_dd_ruang_pangkat == '') {
            unset($p->id_dd_ruang_pangkat);
            $cek = $this->M_database->tambah_data('dd_ruang_pangkat', $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil ditambah';
        } else {
            $cek = $this->M_database->ubah_data('dd_ruang_pangkat', 'id_dd_ruang_pangkat', $p->id_dd_ruang_pangkat, $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil diubah';
        }

        if ($cek) {

            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Data gagal ditambah';
            $this->j($a);
        }
    }

    public function aksi_user() {
        $p = json_decode(file_get_contents('php://input'));

        if ($p->id_dd_user == '') {
            $p->password = base64_encode($p->password);
            unset($p->id_dd_user);
            $cek = $this->M_database->tambah_data('dd_user', $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil ditambah';
        } else {
            $p->password = base64_encode($p->password);
            $cek = $this->M_database->ubah_data('dd_user', 'id_dd_user', $p->id_dd_user, $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil diubah';
        }

        if ($cek) {

            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Data gagal ditambah';
            $this->j($a);
        }
    }

    public function dt_jabatan() {
        $this->benchmark->mark('a');

        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        if (!($this->input->get('jabatan'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('jabatan');
        }
        if (!($this->input->get('sort'))) {
            $sort = "a.nama_jabatan";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }
//        $par_where[] = array('where' => 'a.nama_jabatan', 'value' => $txt);
        $par_join[] = array();
        $group_by = 'a.nama_jabatan';
        $sel = 'a.*';
        $data = $this->M_database->list_data($select = $sel, $table = 'dd_jabatan a', $par_join = array(), $par_where = array(), $cari = 'a.nama_jabatan', $txt, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data($table = 'dd_jabatan a', $par_join = array(), $par_where = array(), $cari, $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_jabatan(' . $hsl['id_dd_jabatan'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_jabatan(' . $hsl['id_dd_jabatan'] . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'nama_jabatan' => $hsl['nama_jabatan'],
                'tunjangan' => number_format($hsl['tunjangan'])
            );

            $no++;
        }

        if (empty($cek)) {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => 0, 'rows' => array(), 'lama' => $lama);
        } else {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => $ttl, 'lama' => $lama, 'rows' => $cek);
        }
        echo json_encode($output);
    }

    public function dt_uker() {
        $this->benchmark->mark('a');

        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        if (!($this->input->get('uker'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('uker');
        }
        if (!($this->input->get('sort'))) {
            $sort = "a.nama_uker";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }
//        $par_where[] = array('where' => 'a.nama_jabatan', 'value' => $txt);
        $par_join[] = array();
        $group_by = 'a.nama_uker';
        $sel = 'a.*';
        $data = $this->M_database->list_data($select = $sel, $table = 'dd_uker a', $par_join = array(), $par_where = array(), $cari = 'a.nama_uker', $txt, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data($table = 'dd_uker a', $par_join = array(), $par_where = array(), $cari, $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_uker(' . $hsl['id_dd_uker'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_uker(' . $hsl['id_dd_uker'] . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'nama_uker' => $hsl['nama_uker']
            );

            $no++;
        }

        if (empty($cek)) {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => 0, 'rows' => array(), 'lama' => $lama);
        } else {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => $ttl, 'lama' => $lama, 'rows' => $cek);
        }
        echo json_encode($output);
    }

    public function dt_kuantitas() {
        $this->benchmark->mark('a');

        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        if (!($this->input->get('kuantitas'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('kuantitas');
        }
        if (!($this->input->get('sort'))) {
            $sort = "a.satuan_kuantitas";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }
//        $par_where[] = array('where' => 'a.nama_jabatan', 'value' => $txt);
        $par_join[] = array();
        $group_by = 'a.satuan_kuantitas';
        $sel = 'a.*';
        $data = $this->M_database->list_data($select = $sel, $table = 'dd_kuantitas a', $par_join = array(), $par_where = array(), $cari = 'a.satuan_kuantitas', $txt, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data($table = 'dd_kuantitas a', $par_join = array(), $par_where = array(), $cari, $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_kuantitas(' . $hsl['id_dd_kuantitas'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_kuantitas(' . $hsl['id_dd_kuantitas'] . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'satuan_kuantitas' => $hsl['satuan_kuantitas']
            );

            $no++;
        }

        if (empty($cek)) {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => 0, 'rows' => array(), 'lama' => $lama);
        } else {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => $ttl, 'lama' => $lama, 'rows' => $cek);
        }
        echo json_encode($output);
    }

    public function dt_pangkat() {
        $this->benchmark->mark('a');

        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        if (!($this->input->get('ruang'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('ruang');
        }
        if (!($this->input->get('pangkat'))) {
            $txt2 = "";
        } else {
            $txt2 = $this->input->get('pangkat');
        }
        if (!($this->input->get('sort'))) {
            $sort = "a.golongan_ruang";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }
//        $par_where[] = array('where' => 'a.nama_jabatan', 'value' => $txt);
        $par_join[] = array();
        $group_by = 'a.golongan_ruang';
        $sel = 'a.*';
        $data = $this->M_database->list_data_2($select = $sel, $table = 'dd_ruang_pangkat a', $par_join = array(), $par_where = array(), $cari = 'a.golongan_ruang', $txt, $cari2 = 'a.pangkat', $txt2, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data_2($table = 'dd_ruang_pangkat a', $par_join = array(), $par_where = array(), $cari = 'a.golongan_ruang', $txt, $cari2 = 'a.pangkat', $txt2, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_pangkat(' . $hsl['id_dd_ruang_pangkat'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_pangkat(' . $hsl['id_dd_ruang_pangkat'] . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'golongan_ruang' => $hsl['golongan_ruang'],
                'pangkat' => $hsl['pangkat']
            );

            $no++;
        }

        if (empty($cek)) {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => 0, 'rows' => array(), 'lama' => $lama);
        } else {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => $ttl, 'lama' => $lama, 'rows' => $cek);
        }
        echo json_encode($output);
    }

    public function dt_admin() {
        $this->benchmark->mark('a');

        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        if (!($this->input->get('username'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('username');
        }

        if (!($this->input->get('sort'))) {
            $sort = "a.username";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }
        $par_where[] = array('where' => 'a.jabatan', 'value' => 0);
        $par_join[] = array();
        $group_by = 'a.username';
        $sel = 'a.*';
        $data = $this->M_database->list_data($select = $sel, $table = 'dd_user a', $par_join = array(), $par_where, $cari = 'a.username', $txt, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data($table = 'dd_user a', $par_join = array(), $par_where, $cari = 'a.username', $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_admin(' . $hsl['id_dd_user'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_admin(' . $hsl['id_dd_user'] . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'username' => $hsl['username'],
                'password' => base64_decode($hsl['password'])
            );

            $no++;
        }

        if (empty($cek)) {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => 0, 'rows' => array(), 'lama' => $lama);
        } else {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => $ttl, 'lama' => $lama, 'rows' => $cek);
        }
        echo json_encode($output);
    }

    public function dt_operator() {
        $this->benchmark->mark('a');

        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        if (!($this->input->get('username'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('username');
        }

        if (!($this->input->get('sort'))) {
            $sort = "a.username";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }
        $par_where[] = array('where' => 'a.jabatan', 'value' => 3);
        $par_join[] = array();
        $group_by = 'a.username';
        $sel = 'a.*';
        $data = $this->M_database->list_data($select = $sel, $table = 'dd_user a', $par_join = array(), $par_where, $cari = 'a.username', $txt, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data($table = 'dd_user a', $par_join = array(), $par_where, $cari = 'a.username', $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_operator(' . $hsl['id_dd_user'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_operator(' . $hsl['id_dd_user'] . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'username' => $hsl['username'],
                'password' => base64_decode($hsl['password'])
            );

            $no++;
        }

        if (empty($cek)) {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => 0, 'rows' => array(), 'lama' => $lama);
        } else {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => $ttl, 'lama' => $lama, 'rows' => $cek);
        }
        echo json_encode($output);
    }

    public function dt_user() {
        $this->benchmark->mark('a');

        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        if (!($this->input->get('nip'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('nip');
        }
        if (!($this->input->get('nama'))) {
            $txt2 = "";
        } else {
            $txt2 = $this->input->get('nama');
        }
        if (!($this->input->get('sort'))) {
            $sort = "a.nip";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }
//        $par_where[] = array('where' => 'a.nama_jabatan', 'value' => $txt);
        $par_join[] = array('table' => 'dd_jabatan b', 'type' => 'LEFT', 'on' => 'b.id_dd_jabatan=a.jabatan');
        $group_by = 'a.nip';
        $sel = 'a.*,b.nama_jabatan';
        $data = $this->M_database->list_data_2($select = $sel, $table = 'dd_user a', $par_join, $par_where = array(), $cari = 'a.nip', $txt, $cari2 = 'a.nama', $txt2, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data_2($table = 'dd_user a', $par_join = array(), $par_where = array(), $cari = 'a.nip', $txt, $cari2 = 'a.nama', $txt2, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_user(' . $hsl['id_dd_user'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_detail = '<a href="javascript:void(0)" onclick="detail_user(' . $hsl['id_dd_user'] . ')">
<i class="fa fa-search text-primary"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_user(' . $hsl['id_dd_user'] . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $cek[] = array(
                'no' => $no,
                'link_detail' => $link_detail,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'nip' => $hsl['nip'],
                'nama' => $hsl['nama'],
                'jabatan' => $hsl['nama_jabatan'],
                'username' => $hsl['username'],
                'password' => base64_decode($hsl['password'])
            );

            $no++;
        }

        if (empty($cek)) {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => 0, 'rows' => array(), 'lama' => $lama);
        } else {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => $ttl, 'lama' => $lama, 'rows' => $cek);
        }
        echo json_encode($output);
    }

    public function hapus_jabatan() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('dd_jabatan', 'id_dd_jabatan', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_uker() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('dd_uker', 'id_dd_uker', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_pangkat() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('dd_ruang_pangkat', 'id_dd_ruang_pangkat', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_user() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('dd_user', 'id_dd_user', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_kuantitas() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('dd_kuantitas', 'id_dd_kuantitas', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_admin() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('dd_user', 'id_dd_user', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_operator() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('dd_user', 'id_dd_user', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function upload_user() {
        $this->load->view('admin/v_upload');
    }

    public function proses_upload_user() {
        $this->db->trans_begin();
        $this->benchmark->mark('a');
        $this->load->model('M_database');
        $file = $_FILES['file_upload']['tmp_name'];
        $temporary = explode(".", $_FILES["file_upload"]["name"]);
        $file_extension = end($temporary);

        $this->load->library("excel");
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array('memoryCacheSize' => '8MB');
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        if ($file_extension == "xls") {
            $objReader = new PHPExcel_Reader_Excel5();
        } else {
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        }
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($file);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();

        $i = 0;
        $data_masuk = 0;
        for ($row = 3; $row <= $highestRow; ++$row) {
            if (strlen($objWorksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue()) > 0) {
                $dt['nama'] = $objWorksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue();
                $dt['nip'] = $objWorksheet->getCellByColumnAndRow(2, $row)->getCalculatedValue();
                $dt['username'] = $objWorksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue();
                $dt['password'] = base64_encode($objWorksheet->getCellByColumnAndRow(4, $row)->getCalculatedValue());
                if (!$this->db->insert('dd_user', $dt)) {
                    $a['status'] = 0;
                    $a['ket'] = 'Insert Data Error pada baris ke - ' . ($i + 4);
                    $a['detail'] = $this->db->error();
                    $this->j($a);
                    die();
                } else {
                    $a['status'] = 1;
                    $a['ket'] = 'Insert Data Berhasil';
                    $i++;
                    $data_masuk++;
                }
            }
        }
        $total = $i;
        $a['dt_masuk'] = $data_masuk;

        $objPHPExcel->disconnectWorksheets();
        unset($objPHPExcel);
        $this->benchmark->mark('b');
        $lama = $this->benchmark->elapsed_time('a', 'b');
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        $a['lama'] = $lama;
        $a['total'] = $total;

        $this->j($a);
    }

    public function rekap_tunjangan() {
        $x['tahun'] = $this->db->query("SELECT distinct year(awal_periode_skp)tahun FROM opmt_tahunan_skp")->result_array();
        $x['unit'] = $this->db->get('dd_uker')->result_array();
        $this->load->view('admin/v_rekap_tunjangan', $x);
    }

    public function lihat_rekap_tunjangan() {
        $thn = $this->input->post('thn');
        $bln = $this->input->post('bln');
        $unit = $this->input->post('uker');
        $nip = $this->input->post('nip');
        if ($nip !== "") {
            $par_sql = " AND b.nip LIKE '%{$nip}%";
        } else {
            $par_sql = "";
        }
        $qTotal = $this->db->query("SELECT count(*) ttl FROM opmt_absensi a
INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user AND b.unit_kerja={$unit}
INNER JOIN dd_jabatan c on b.jabatan=c.id_dd_jabatan
LEFT JOIN opmt_persentase_pengurang  d on d.id_dd_user=a.id_dd_user AND d.tahun=a.tahun AND d.bulan=a.bulan
LEFT JOIN opmt_bulanan_skp e on e.tahun =a.tahun AND e.bulan=a.bulan AND e.id_dd_user=a.id_dd_user
WHERE a.tahun={$thn} AND a.bulan={$bln} {$par_sql}")->row_array();
        $x['total'] = $total = $qTotal['ttl'];
        $limit = 10;
        $x['total_hal'] = $total_hal = ceil($total / $limit); //lastpage.
        $page = $this->input->post('page');
        if ($page) {
            $start = ($page - 1) * $limit; //first item to display on this page
        } else {
            $start = 0;
        }
        if ($page == 1) {
            $page = 0; //if no page var is given, default to 1.
        }
        $x['page'] = $page;
        $x['total_page'] = $total_hal;
        $x['prev'] = $prev = $page - 1; //previous page is current page - 1
        $x['next'] = $next = $page == $total_hal ? $page : $page + 1; //next page is current page + 1

        $q = "SELECT * FROM opmt_absensi a
INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user AND b.unit_kerja={$unit}
INNER JOIN dd_jabatan c on b.jabatan=c.id_dd_jabatan
LEFT JOIN opmt_persentase_pengurang  d on d.id_dd_user=a.id_dd_user AND d.tahun=a.tahun AND d.bulan=a.bulan
LEFT JOIN opmt_bulanan_skp e on e.tahun =a.tahun AND e.bulan=a.bulan AND e.id_dd_user=a.id_dd_user
WHERE a.tahun={$thn} AND a.bulan={$bln} {$par_sql} LIMIT $start ,$limit ";
        $x['tunjangan'] = $this->db->query($q)->result_array();
        $this->load->view('admin/v_lihat_tunjangan', $x);
    }

    public function dt_rekap_tunjangan() {
        $this->benchmark->mark('a');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $thn = $this->input->get('thn');
        $bln = $this->input->get('bln');
        $unit = $this->input->get('uker');
        $nip = $this->input->get('nip');
        if ($nip !== "") {
            $par_sql = " AND b.nip LIKE '%{$nip}%";
        } else {
            $par_sql = "";
        }

        $id_user = $this->session->userdata('id_user');
        $tunjangan = $this->db->query("SELECT * FROM opmt_absensi a
INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user AND b.unit_kerja={$unit}
INNER JOIN dd_jabatan c on b.jabatan=c.id_dd_jabatan
LEFT JOIN opmt_persentase_pengurang  d on d.id_dd_user=a.id_dd_user AND d.tahun=a.tahun AND d.bulan=a.bulan
LEFT JOIN opmt_bulanan_skp e on e.tahun =a.tahun AND e.bulan=a.bulan AND e.id_dd_user=a.id_dd_user
WHERE a.tahun={$thn} AND a.bulan={$bln} {$par_sql} LIMIT {$offset},{$limit}
")->result_array();
        $ttl_data = $this->db->query("SELECT count(*) ttl FROM opmt_absensi a
INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user AND b.unit_kerja={$unit}
INNER JOIN dd_jabatan c on b.jabatan=c.id_dd_jabatan
LEFT JOIN opmt_persentase_pengurang  d on d.id_dd_user=a.id_dd_user AND d.tahun=a.tahun AND d.bulan=a.bulan
LEFT JOIN opmt_bulanan_skp e on e.tahun =a.tahun AND e.bulan=a.bulan AND e.id_dd_user=a.id_dd_user
WHERE a.tahun={$thn} AND a.bulan={$bln} {$par_sql}")->row_array();
        $ttl = $ttl_data['ttl'];
        $no = $offset + 1;
        foreach ($tunjangan as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_kreatifitas(' . $hsl['id_opmt_kreatifitas_skp'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_kreatifitas(' . $hsl['id_opmt_kreatifitas_skp'] . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'tanggal' => date('d M Y', strtotime($hsl['tanggal'])),
                'kreatifitas' => $hsl['kreatifitas'],
                'kuantitas' => $hsl['target_kuantitas'] . ' ' . $hsl['satuan_kuantitas'],
            );

            $no++;
        }

        if (empty($cek)) {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => 0, 'rows' => array(), 'lama' => $lama);
        } else {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => $ttl, 'lama' => $lama, 'rows' => $cek);
        }
        echo json_encode($output);
    }

    public function j($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}
