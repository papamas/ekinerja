<?php

Class C_main extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("M_database");
    }

    public function index() {
        $pesan = $this->session->flashdata('pesan');
        if ($pesan) {
            $data['pesan'] = $this->session->flashdata('pesan');
        } else {
            $data['pesan'] = 'LOGIN';
        }
        $bulan = (int) date('m') -1;
        $data['pt'] = $this->db->query("select b.nama,b.nip,c.jabatan,a.nilai_skp from opmt_bulanan_skp a
LEFT JOIN dd_user b on a.id_dd_user=b.id_dd_user
left join tbljabatan c on b.jabatan=c.kodejab
 where pegawai_terbaik=1 AND bulan=" . $bulan . " AND tahun=" . date('Y'))->row_array();
        if ($this->session->userdata('username') == '') {
            $this->load->view('v_logon', $data);
        } else {
            $id_user = $this->session->userdata('id_user');
            $data['nama'] = $this->session->userdata('nama');
            $data['nip'] = $this->session->userdata('nip');
            $data['jabatan'] = $this->session->userdata('jabatan');
            $data['nama_uker'] = $this->session->userdata('nama_uker');
            $data['ttl_dsp'] = $this->db->query("select count(*) ttl FROM opmt_disposisi WHERE id_dd_user={$id_user} AND status_disposisi_bawahan is null")->row_array();
            $this->load->view('v_main', $data);
        }
    }

    public function validasi() {
        $this->load->model("M_login");
        $user = $this->input->post('username');
        $pass = $this->input->post('password');
        $cek_tk=$this->cek_rekaptk($user);
        $cek_user=$this->cek_user($user);
        // hapus user yang tidak ada di table rekaptk
        /*
		$this->hapus_dtuser();
        if($cek_tk>0&&$cek_user==0){
            $this->tambah_dtuser($user);
        }
        */
        $validasi = $this->M_login->validasi($user, $pass);
        if ($validasi == 0) {
            //  echo $validasi;
            $this->session->set_flashdata('pesan', 'Username / Password Anda Salah !!!');
            redirect('./');
        } else {

            $usr = $this->M_login->get_data($user, $pass);
            $this->session->set_userdata('id_user', $usr['id_dd_user']);
            $this->session->set_userdata('username', $usr['username']);
            $this->session->set_userdata('nip', $usr['nip']);
            $this->session->set_userdata('nama', $usr['nama']);
            $this->session->set_userdata('kodejab', $usr['kodejab']);
            $this->session->set_userdata('jabatan', $usr['jabatan']);
            $this->session->set_userdata('unit_kerja', $usr['unitkerja']);
            $this->session->set_userdata('nama_uker', $usr['unitkerja']);

            $this->M_login->update_log($user, $pass);
            redirect('./');
        }
    }
    
    public function tambah_dtuser($nip){
        $data_user= $this->db->from('tblrekaptk')->where('nip',$nip)->get()->row_array();
        $data=array(
           "nip"=>$data_user["nip"],
            "nama"=>$data_user["NAMA"],
            "jabatan"=>$data_user["kodejab"],
            "unit_kerja"=>$data_user["kodeunit"],
            "gol_ruang"=>$data_user["kodegol"],
            "username"=>$data_user["nip"],
            "password"=>base64_encode($data_user["nip"])
            );
        $simpan=$this->db->insert("dd_user",$data);
        return $simpan;
    }
    
    public function cek_rekaptk($nip){
    $cek= $this->db->from('tblrekaptk')->where('nip',$nip)->count_all_results();
        return $cek;
    }
    
    public function hapus_dtuser(){
        $q="DELETE FROM dd_user WHERE length(nip)>5 and nip not in(select nip from tblrekaptk)";
        $hapus=$this->db->query($q);
        return $hapus;
    }
    
    public function cek_user($nip){
          $cek= $this->db->from('dd_user')->where('nip',$nip)->count_all_results();
        return $cek;
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('./');
    }

    public function data_jfk() {
        $this->load->view('v_data_jfk');
    }

    public function database() {
        $this->load->view('v_database');
    }

    public function tambah_db($jabatan, $jenis) {
        $data['jabatan'] = $jabatan;
        $data['jenis'] = $jenis;
        $this->load->view('v_tambah_db', $data);
    }

    public function tambah_pegawai($jabatan, $jenis) {
        $data['jabatan'] = $jabatan;
        $data['jenis'] = $jenis;
        $this->load->view('v_tambah_pegawai', $data);
    }

    public function edit_pegawai($id, $jabatan, $jenis) {
        $data['jabatan'] = $jabatan;
        $data['jenis'] = $jenis;
        $data['pegawai'] = $this->db->query("SELECT a.*,b.id_dd_sertifikat,b.no_sertifikat,b.nama as nama_sertifikat,b.nip as nip_sertifikat FROM dd_pegawai a LEFT JOIN dd_sertifikat b on a.id_dd_sertifikat=b.id_dd_sertifikat WHERE id_dd_pegawai={$id}")->row_array();
        $this->load->view('v_tambah_pegawai', $data);
    }

    public function tambah_ak($id, $jabatan, $jenis) {
        $dt_pegawai = $this->M_database->get_single_data('dd_pegawai', 'id_dd_pegawai', $id);
        $data['id_pegawai'] = $id;
        $data['nama'] = $dt_pegawai['nama'];
        $data['nip'] = $dt_pegawai['nip'];
        $data['jabatan'] = $jabatan;
        $data['jenis'] = $jenis;
        $this->load->view('v_tambah_ak', $data);
    }

    public function tambah_sertifikat_pelatihan($id, $jabatan, $jenis) {
        $dt_pegawai = $this->M_database->get_single_data('dd_pegawai', 'id_dd_pegawai', $id);
        $data['id_pegawai'] = $id;
        $data['nama'] = $dt_pegawai['nama'];
        $data['nip'] = $dt_pegawai['nip'];
        $data['jabatan'] = $jabatan;
        $data['jenis'] = $jenis;
        $this->load->view('v_tambah_sertifikat_pelatihan', $data);
    }

    public function get_sertifikat() {
        $jabatan = $this->input->post('jabatan');
        $nama = $this->input->post('q');
        $data = $this->M_database->get_sertifikat($nama, $jabatan);
        echo json_encode($data);
    }

    public function get_pak() {
        $nip = $this->input->post('nip');
        $nama = $this->input->post('q');
        $data = $this->M_database->get_pak($nama, $nip);
        echo json_encode($data);
    }

    public function ubah_db($id, $jabatan, $jenis) {
        $data['jabatan'] = $jabatan;
        $data['jenis'] = $jenis;
        if ($jenis == 'pak') {
            $data['db'] = $this->M_database->get_single_data('dd_pak', 'id_dd_pak', $id);
        } else {
            $data['db'] = $this->M_database->get_single_data('dd_sertifikat', 'id_dd_sertifikat', $id);
        }
        $this->load->view('v_tambah_db', $data);
    }

    public function dt_db() {
        $this->benchmark->mark('a');
        $jabatan = $this->input->get('jabatan');
        $jenis = $this->input->get('jenis');

        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        if (!($this->input->get('search'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('search');
        }
        if (!($this->input->get('sort'))) {
            $sort = "nama";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }

        $par_where[] = array('where' => 'id_dd_jabatan', 'value' => $jabatan);
// $par_join[] = array('table' => 'dd_bank_cabang_master c WITH (nolock)', 'type' => 'LEFT', 'on' => 'c.id_dd_bank_cabang=a.id_dd_bank_cabang AND c.id_dc_wilayah_kerja=a.id_dc_wilayah_kerja');
        if ($jenis == 'pak') {
            $sel = '*';
            $data = $this->M_database->list_data($select = $sel, $table = 'dd_pak', $par_join = array(), $par_where, $cari = 'nama', $txt, $limit, $offset, $sort, $order, $group_by = "");
            $ttl = $this->M_database->ttl_data($table = 'dd_pak', $par_join, $par_where, $cari, $txt, $group_by = "");
        } else {
            $sel = '*';
            $data = $this->M_database->list_data($select = $sel, $table = 'dd_sertifikat', $par_join = array(), $par_where, $cari = 'nama', $txt, $limit, $offset, $sort, $order, $group_by = "");
            $ttl = $this->M_database->ttl_data($table = 'dd_sertifikat', $par_join, $par_where, $cari, $txt, $group_by = "");
        }
        $no = $offset + 1;
        foreach ($data as $hsl) {
            if ($jenis == 'pak') {
                $link_edit = '<a href="javascript:void(0)" onclick="edit_db(' . $hsl['id_dd_pak'] . ')">
<i class="glyphicon glyphicon-pencil"/>
</a>';
                $link_hapus = '<a href="javascript:void(0)" onclick="hapus_db(' . $hsl['id_dd_pak'] . ')">
<i class="glyphicon glyphicon-trash"/>
</a>';

                $cek[] = array(
                    'no' => $no,
                    'link_edit' => $link_edit,
                    'link_hapus' => $link_hapus,
                    'tahun' => $hsl['tahun'],
                    'nama' => $hsl['nama'],
                    'nip' => $hsl['nip'],
                    'no_pak' => $hsl['no_pak'],
                    'keterangan' => $hsl['keterangan']
                );
            } else {
                $link_edit = '<a href="javascript:void(0)" onclick="edit_db(' . $hsl['id_dd_sertifikat'] . ')">
<i class="glyphicon glyphicon-pencil"/>
</a>';
                $link_hapus = '<a href="javascript:void(0)" onclick="hapus_db(' . $hsl['id_dd_sertifikat'] . ')">
<i class="glyphicon glyphicon-trash"/>
</a>';

                if ($hsl['status'] == 1) {
                    $status = 'Aktif JFK';
                } else {
                    $status = 'Belum Aktif';
                }
                $cek[] = array(
                    'no' => $no,
                    'link_edit' => $link_edit,
                    'link_hapus' => $link_hapus,
                    'tahun' => $hsl['tahun'],
                    'nama' => $hsl['nama'],
                    'nip' => $hsl['nip'],
                    'no_sertifikat' => $hsl['no_sertifikat'],
                    'status' => $status,
                    'keterangan' => $hsl['keterangan']
                );
            }


            $no++;
        }
        if (!($cek)) {
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

    public function dt_jfk() {
        $this->benchmark->mark('a');
        $jabatan = $this->input->get('jabatan');
        $jenis = $this->input->get('jenis');

        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        if (!($this->input->get('search'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('search');
        }
        if (!($this->input->get('sort'))) {
            $sort = "a.nama";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }

        $par_where[] = array('where' => 'a.JENIS', 'value' => $jenis);
        $par_join[] = array('table' => 'dd_pegawai b', 'type' => 'LEFT', 'on' => 'a.id_dd_instansi=b.id_dd_instansi');
        $par_join[] = array('table' => 'dd_kebutuhan c', 'type' => 'LEFT', 'on' => 'c.id_dd_instansi=a.id_dd_instansi');
        $group_by = 'a.nama';
        $sel = '
a.id_dd_instansi,a.nama,
count(case when b.id_dd_jabatan=1 then b.id_dd_pegawai else null end)ttl_analis,
count(case when b.id_dd_jabatan=2 then b.id_dd_pegawai else null end)ttl_assesor,
count(case when b.id_dd_jabatan=3 then b.id_dd_pegawai else null end)ttl_auditor,
coalesce(c.kebutuhan_analis,0)kebutuhan_analis,
coalesce(c.kebutuhan_assesor,0)kebutuhan_assesor,
coalesce(c.kebutuhan_auditor,0)kebutuhan_auditor';
        $data = $this->M_database->list_data($select = $sel, $table = 'dd_instansi a', $par_join, $par_where, $cari = 'a.nama', $txt, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data($table = 'dd_instansi a', $par_join, $par_where, $cari, $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $link_input = '<a href="javascript:void(0)" onclick="input_jfk(' . $hsl['id_dd_instansi'] . ')">
<i class="glyphicon glyphicon-pencil"/>
</a>';
            $link_grafik = '<a href="javascript:void(0)" onclick="grafik_jfk(' . $hsl['id_dd_instansi'] . ')">
<i class="glyphicon glyphicon-search"/>
</a>';

            $cek[] = array(
                'no' => $no,
                'link_input' => $link_input,
                'link_grafik' => $link_grafik,
                'nama' => $hsl['nama'],
                'ttl_analis' => $hsl['ttl_analis'],
                'ttl_assesor' => $hsl['ttl_assesor'],
                'ttl_auditor' => $hsl['ttl_auditor'],
                'kebutuhan_analis' => $hsl['kebutuhan_analis'],
                'kebutuhan_assesor' => $hsl['kebutuhan_assesor'],
                'kebutuhan_auditor' => $hsl['kebutuhan_auditor']
            );

            $no++;
        }

        if (!($cek)) {
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

    public function dt_jfk2() {
        $this->benchmark->mark('a');
        $jabatan = $this->input->get('jabatan');
        $instansi = $this->input->get('instansi');
        $nama = $this->input->get('nama');
        $nip = $this->input->get('nip');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        if (!($this->input->get('nama'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('nama');
        }
        if (!($this->input->get('sort'))) {
            $sort = "a.nama";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }
        if ($nip !== '') {
            $par_where[] = array('where' => 'a.nip', 'value' => $nip);
        }
        $par_where[] = array('where' => 'a.id_dd_instansi', 'value' => $instansi);
        $par_where[] = array('where' => 'a.id_dd_jabatan', 'value' => $jabatan);
        $par_join[] = array('table' => 'v_ak b', 'type' => 'LEFT', 'on' => 'a.nip=b.nip');
        $par_join[] = array('table' => 'v_sertifikat_pelatihan c', 'type' => 'LEFT', 'on' => 'a.nip=c.nip');
//        $par_join[] = array('table' => 'dd_kebutuhan c', 'type' => 'LEFT', 'on' => 'c.id_dd_instansi=a.id_dd_instansi');
        $group_by = 'a.nama';
        $sel = '
a.id_dd_pegawai,a.nama,a.nip,a.jumlah_ak,b.ttl as ak_total,c.ttl as jumlah_sertifikat';
        $data = $this->M_database->list_data($select = $sel, $table = 'dd_pegawai a', $par_join, $par_where, $cari = 'a.nama', $txt, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data($table = 'dd_pegawai a', $par_join, $par_where, $cari, $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $link_input = '<a href="javascript:void(0)" onclick="tambah_ak(' . $hsl['id_dd_pegawai'] . ')">
<i class="glyphicon glyphicon-pencil"/>
</a>';
            $link_catatan = '<a href="javascript:void(0)" onclick="catatan_pegawai(' . $hsl['id_dd_pegawai'] . ')">
<i class="glyphicon glyphicon-pencil"/>
</a>';
            $link_history = '<a href="javascript:void(0)" onclick="history_ak(' . $hsl['id_dd_pegawai'] . ')">
<i class="glyphicon glyphicon-pencil"/>
</a>';
            $link_sertifikat = '<a href="javascript:void(0)" onclick="input_sertifikat(' . $hsl['id_dd_pegawai'] . ')">
<i class="glyphicon glyphicon-pencil"/>
</a>';
            $link_edit = '<a href="javascript:void(0)" onclick="edit_pegawai(' . $hsl['id_dd_pegawai'] . ')">
<i class="glyphicon glyphicon-pencil"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_pegawai(' . $hsl['id_dd_pegawai'] . ')">
<i class="glyphicon glyphicon-trash"/>
</a>';
            $ak_total = $hsl['ak_total'] + $hsl['jumlah_ak'];
            if ($ak_total < 200) {
                $jenjang_jabatan = 'Pertama';
            } elseif ($ak_total < 400) {
                $jenjang_jabatan = 'Muda';
            } else {
                $jenjang_jabatan = 'Madya';
            }
            $cek[] = array(
                'no' => $no,
                'link_input' => $link_input,
                'link_history' => $link_history,
                'link_sertifikat' => $link_sertifikat,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'link_catatan' => $link_catatan,
                'nama' => $hsl['nama'],
                'nip' => $hsl['nip'],
                'ak_total' => $ak_total,
                'jenjang_jabatan' => $jenjang_jabatan,
                'jumlah_sertifikat' => $hsl['jumlah_sertifikat']
            );

            $no++;
        }

        if (!($cek)) {
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

    public function dt_sertifikat_pelatihan() {
        $this->benchmark->mark('a');
        $jabatan = $this->input->get('jabatan');
        $nip = $this->input->get('nip');

        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        if (!($this->input->get('search'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('search');
        }
        if (!($this->input->get('sort'))) {
            $sort = "a.no_sertifikat";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }

        $par_where[] = array('where' => 'a.nip', 'value' => $nip);
//        $par_where[] = array('where' => 'a.id_dd_jabatan', 'value' => $jabatan);
//        $par_join[] = array('table' => 'v_ak b', 'type' => 'LEFT', 'on' => 'a.nip=b.nip');
//        $par_join[] = array('table' => 'v_sertifikat_pelatihan c', 'type' => 'LEFT', 'on' => 'a.nip=c.nip');
//        $par_join[] = array('table' => 'dd_kebutuhan c', 'type' => 'LEFT', 'on' => 'c.id_dd_instansi=a.id_dd_instansi');
        $group_by = 'a.no_sertifikat';
        $sel = '*';
        $data = $this->M_database->list_data($select = $sel, $table = 'dd_sertifikat_pelatihan a', $par_join = array(), $par_where, $cari = 'a.no_sertifikat', $txt, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data($table = 'dd_sertifikat_pelatihan a', $par_join = array(), $par_where, $cari, $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="edit_sp(' . $hsl['id_dd_sertifikat_pelatihan'] . ')">
<i class="glyphicon glyphicon-pencil"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_sp(' . $hsl['id_dd_sertifikat_pelatihan'] . ')">
<i class="glyphicon glyphicon-trash"/>
</a>';

            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'no_sertifikat' => $hsl['no_sertifikat'],
                'keterangan' => $hsl['keterangan']
            );

            $no++;
        }

        if (!($cek)) {
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

    public function dt_ak() {
        $this->benchmark->mark('a');
        $jabatan = $this->input->get('jabatan');
        $nip = $this->input->get('nip');

        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        if (!($this->input->get('search'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('search');
        }
        if (!($this->input->get('sort'))) {
            $sort = "b.no_pak";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }

        $par_where[] = array('where' => 'a.nip', 'value' => $nip);
//        $par_where[] = array('where' => 'a.id_dd_jabatan', 'value' => $jabatan);
        $par_join[] = array('table' => 'dd_pak b', 'type' => 'LEFT', 'on' => 'a.id_dd_pak=b.id_dd_pak');
//        $par_join[] = array('table' => 'v_sertifikat_pelatihan c', 'type' => 'LEFT', 'on' => 'a.nip=c.nip');
//        $par_join[] = array('table' => 'dd_kebutuhan c', 'type' => 'LEFT', 'on' => 'c.id_dd_instansi=a.id_dd_instansi');
        $group_by = 'a.ak';
        $sel = '*';
        $data = $this->M_database->list_data($select = $sel, $table = 'dd_ak a', $par_join, $par_where, $cari = 'b.no_pak', $txt, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data($table = 'dd_ak a', $par_join, $par_where, $cari, $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="edit_ak(' . $hsl['id_dd_ak'] . ')">
<i class="glyphicon glyphicon-pencil"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_ak(' . $hsl['id_dd_ak'] . ')">
<i class="glyphicon glyphicon-trash"/>
</a>';

            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'no_pak' => $hsl['no_pak'],
                'ak' => $hsl['ak']
            );

            $no++;
        }

        if (!($cek)) {
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

    public function dt_kebutuhan() {
        $this->benchmark->mark('a');

        $jenis = $this->input->get('jenis');

        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        if (!($this->input->get('instansi'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('instansi');
        }
        if (!($this->input->get('sort'))) {
            $sort = "a.nama";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }

        $par_where[] = array('where' => 'a.jenis', 'value' => $jenis);
//        $par_where[] = array('where' => 'a.id_dd_jabatan', 'value' => $jabatan);
        $par_join[] = array('table' => 'dd_kebutuhan b', 'type' => 'LEFT', 'on' => 'a.id_dd_instansi=b.id_dd_instansi');
        $group_by = 'a.nama';
        $sel = '*';
        $data = $this->M_database->list_data($select = $sel, $table = 'dd_instansi a', $par_join, $par_where, $cari = 'a.nama', $txt, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data($table = 'dd_instansi a', $par_join, $par_where, $cari, $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $cek[] = array(
                'no' => $no,
                'nama' => $hsl['nama'],
                'kebutuhan_analis' => $hsl['kebutuhan_analis'],
                'kebutuhan_assesor' => $hsl['kebutuhan_assesor'],
                'kebutuhan_auditor' => $hsl['kebutuhan_auditor']
            );

            $no++;
        }

        if (!($cek)) {
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

    public function dt_catatan() {
        $this->benchmark->mark('a');

        $jenis = $this->input->get('jenis');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        if (!($this->input->get('instansi'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('instansi');
        }
        if (!($this->input->get('sort'))) {
            $sort = "c.nama";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }

        $par_where[] = array('where' => 'c.JENIS', 'value' => $jenis);

        $par_join[] = array('table' => 'dd_pegawai b', 'type' => 'LEFT', 'on' => 'a.nip=b.nip');
        $par_join[] = array('table' => 'dd_instansi c', 'type' => 'LEFT', 'on' => 'b.id_dd_instansi=c.id_dd_instansi');
        $par_join[] = array('table' => 'dd_jabatan d', 'type' => 'LEFT', 'on' => 'b.id_dd_jabatan=d.id_dd_jabatan');
        $group_by = 'c.nama';
        $sel = 'a.id_dd_catatan,c.nama nama_instansi,b.nama,b.nip,d.nama_jabatan,a.judul,a.catatan,a.flag_status';
        $data = $this->M_database->list_data($select = $sel, $table = 'dd_catatan a', $par_join, $par_where, $cari = 'b.no_pak', $txt, $limit, $offset, $sort, $order, $group_by);

        $ttl = $this->M_database->ttl_data2($table = 'dd_catatan a', $par_join, $par_where, $cari, $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {
            $link_catatan = '<a href="javascript:void(0)" onclick="baca_catatan(' . $hsl['id_dd_catatan'] . ')">
<i class="glyphicon glyphicon-search"/>
</a>';
            if ($hsl['flag_status'] == 0) {
                $status = "Belum Dibaca";
            } else {
                $status = "Dibaca";
            }
            $cek[] = array(
                'no' => $no,
                'nama_instansi' => $hsl['nama_instansi'],
                'nama' => $hsl['nama'],
                'nip' => $hsl['nip'],
                'jabatan' => $hsl['nama_jabatan'],
                'judul' => $hsl['judul'],
                'catatan' => $link_catatan,
                'status' => $status
            );

            $no++;
        }

        if (!($cek)) {
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

    public function proses_edit_db() {
        $p = json_decode(file_get_contents('php://input'));
        $id = $p->id_opmt_temp_input_klaim;
        unset($p->id_opmt_temp_input_klaim);
        try {
            $result = $this->M_database->ubah_data("_temp_opmt_input_klaim", 'id_opmt_temp_input_klaim', $id, $p);
            $a['status'] = 1;
            $a['ket'] = "Data Berhasil Diubah";
        } catch (Exception $exc) {
            $a['status'] = 0;
            $a['ket'] = $exc->getTraceAsString();
        }
        $this->j($a);
        exit;
    }

    public function aksi_tambah_db() {
        $p = json_decode(file_get_contents('php://input'));
        $jenis = $p->jenis_db;
        $jabatan = $p->jabatan_db;
        unset($p->jenis_db);
        unset($p->jabatan_db);
        $p->id_dd_jabatan = $jabatan;
        if ($jenis == 'pak') {
            if ($p->id_dd_pak == '') {
                unset($p->id_dd_pak);
                $cek = $this->M_database->tambah_data('dd_pak', $p);
                $a['status'] = 1;
                $a['ket'] = 'Data berhasil ditambah';
            } else {
                $cek = $this->M_database->ubah_data('dd_pak', 'id_dd_pak', $p->id_dd_pak, $p);
                $a['status'] = 1;
                $a['ket'] = 'Data berhasil diubah';
            }
        } else {
            if ($p->id_dd_sertifikat == '') {
                unset($p->id_dd_sertifikat);
                $cek = $this->M_database->tambah_data('dd_sertifikat', $p);
                $a['status'] = 1;
                $a['ket'] = 'Data berhasil ditambah';
            } else {
                $cek = $this->M_database->ubah_data('dd_sertifikat', 'id_dd_sertifikat', $p->id_dd_sertifikat, $p);
                $a['status'] = 1;
                $a['ket'] = 'Data berhasil diubah';
            }
        }
        if ($cek) {

            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Data gagal ditambah';
            $this->j($a);
        }
    }

    public function aksi_tambah_pegawai() {
        $p = json_decode(file_get_contents('php://input'));

        if ($p->id_dd_pegawai == '') {
            unset($p->id_dd_pegawai);
            $cek = $this->M_database->tambah_data('dd_pegawai', $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil ditambah';
        } else {
            $cek = $this->M_database->ubah_data('dd_pegawai', 'id_dd_pegawai', $p->id_dd_pegawai, $p);
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

    public function aksi_tambah_ak() {
        $p = json_decode(file_get_contents('php://input'));

        if ($p->id_dd_ak == '') {
            unset($p->id_dd_ak);
            $cek = $this->M_database->tambah_data('dd_ak', $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil ditambah';
        } else {
            $cek = $this->M_database->ubah_data('dd_ak', 'id_dd_ak', $p->id_dd_ak, $p);
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

    public function hapus_db() {
        $id = $this->input->post('id');
        $jenis = $this->input->post('jenis');
        if ($jenis == 'pak') {
            $hapus = $this->M_database->hapus_data('dd_pak', 'id_dd_pak', $id);
        } else {
            $hapus = $this->M_database->hapus_data('dd_sertifikat', 'id_dd_sertifikat', $id);
        }
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_pegawai() {
        $id = $this->input->post('id');
        $jenis = $this->input->post('jenis');

        $hapus = $this->M_database->hapus_data('dd_pegawai', 'id_dd_pegawai', $id);

        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_ak() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('dd_ak', 'id_dd_ak', $id);

        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function aksi_tambah_sp() {
        $p = json_decode(file_get_contents('php://input'));

        if ($p->id_dd_sertifikat_pelatihan == '') {
            unset($p->id_dd_sertifikat_pelatihan);
            $cek = $this->M_database->tambah_data('dd_sertifikat_pelatihan', $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil ditambah';
        } else {
            $cek = $this->M_database->ubah_data('dd_sertifikat_pelatihan', 'id_dd_sertifikat_pelatihan', $p->id_dd_sertifikat_pelatihan, $p);
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

    public function get_sp($id) {
        $data = $this->M_database->get_single_data('dd_sertifikat_pelatihan', 'id_dd_sertifikat_pelatihan', $id);
        echo json_encode($data);
    }

    public function get_ak($id) {
        $data = $this->db->query("SELECT * FROM dd_ak a LEFT JOIN dd_pak b on a.id_dd_pak=b.id_dd_pak WHERE a.id_dd_ak={$id}")->row_array();
        echo json_encode($data);
    }

    public function hapus_sp() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('dd_sertifikat_pelatihan', 'id_dd_sertifikat_pelatihan', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function history_ak($id) {
        $dt_pegawai = $this->db->query("SELECT a.*,b.no_sertifikat FROM dd_pegawai a 
		LEFT JOIN dd_sertifikat b on a.id_dd_sertifikat=b.id_dd_sertifikat
	WHERE id_dd_pegawai={$id}")->row_array();
        $data['id_pegawai'] = $id;
        $data['nama'] = $dt_pegawai['nama'];
        $data['nip'] = $dt_pegawai['nip'];
        $data['no_sertifikat'] = $dt_pegawai['no_sertifikat'];
        $this->load->view('v_history_ak', $data);
    }

    public function kebutuhan() {
        $this->load->view('v_kebutuhan');
    }

    public function catatan() {
        $this->load->view('v_catatan');
    }

    public function cetak_sertifikat() {
        $this->load->view('v_cetak_sertifikat');
    }

    public function baca_catatan($id) {
        $this->db->query("UPDATE dd_catatan SET flag_status=1 WHERE id_dd_catatan={$id}");
        $data['catatan'] = $this->db->query("SELECT * FROM dd_catatan WHERE id_dd_catatan={$id}")->row_array();
        $this->load->view('v_baca_catatan', $data);
    }

    public function grafik_jfk($id) {
        $q = "select count(case when a.id_dd_jabatan=1 then a.id_dd_pegawai else null end)jumlah_analis,
count(case when a.id_dd_jabatan=2 then a.id_dd_pegawai else null end)jumlah_assesor,
count(case when a.id_dd_jabatan=3 then a.id_dd_pegawai else null end)jumlah_auditor
from dd_pegawai a
	WHERE a.id_dd_instansi={$id}
";
        $q2 = "select *
from dd_kebutuhan a
	WHERE a.id_dd_instansi={$id}
";
        $data['instansi'] = $this->db->query("SELECT nama FROM dd_instansi WHERE id_dd_instansi={$id}")->row_array();
        $data['jumlah'] = $this->db->query($q)->row_array();
        $data['kebutuhan'] = $this->db->query($q2)->row_array();
        $this->load->view('grafik/v_grafik_1', $data);
    }

    public function grafik_jfk2($id) {
        if ($id == 1) {
            $sqlPlus = " WHERE b.JENIS='P'";
            $data['judul'] = 'Instansi Pusat';
        } elseif ($id == 2) {
            $sqlPlus = " WHERE b.JENIS='D'";
            $data['judul'] = 'Instansi Daerah';
        } else {
            $sqlPlus = "";
            $data['judul'] = 'Instansi Pusat & Daerah';
        }
        $q = "select count(case when a.id_dd_jabatan=1 then a.id_dd_pegawai else null end)jumlah_analis,
count(case when a.id_dd_jabatan=2 then a.id_dd_pegawai else null end)jumlah_assesor,
count(case when a.id_dd_jabatan=3 then a.id_dd_pegawai else null end)jumlah_auditor
from dd_pegawai a 
LEFT JOIN dd_instansi b on a.id_dd_instansi=b.id_dd_instansi
		 {$sqlPlus}
";
        $q2 = "select sum(kebutuhan_analis)kebutuhan_analis,sum(kebutuhan_assesor)kebutuhan_assesor,sum(kebutuhan_auditor)kebutuhan_auditor
from dd_kebutuhan a
LEFT JOIN dd_instansi b on a.id_dd_instansi=b.id_dd_instansi 
	 {$sqlPlus}
";

        $data['instansi'] = $this->db->query("SELECT nama FROM dd_instansi WHERE id_dd_instansi={$id}")->row_array();
        $data['jumlah'] = $this->db->query($q)->row_array();
        $data['kebutuhan'] = $this->db->query($q2)->row_array();
        $this->load->view('grafik/v_grafik_2', $data);
    }

    public function laporan() {
        $this->load->view('v_laporan');
    }

    public function laporan_rekap_utama() {
        $this->load->view('v_laporan_rekap_utama');
    }

    public function laporan_rekap() {
        $tahun = $this->input->post('tahun');
        if ($tahun !== "") {
            $sqlPlus = " WHERE a.tahun={$tahun}";
        } else {
            $sqlPlus = "";
        }
        $q = "SELECT
a.tahun,
count(case when a.id_dd_jabatan=1 THEN a.id_dd_pak ELSE NULL END)ttl_analis,
count(case when a.id_dd_jabatan=2 THEN a.id_dd_pak ELSE NULL END)ttl_assesor,
count(case when a.id_dd_jabatan=3 THEN a.id_dd_pak ELSE NULL END)ttl_auditor
FROM dd_pak a {$sqlPlus}
GROUP BY a.tahun ORDER BY a.tahun ASC;";
        $q2 = "

SELECT
a.tahun,
count(case when a.id_dd_jabatan=1 THEN a.id_dd_sertifikat ELSE NULL END)ttl_analis,
count(case when a.id_dd_jabatan=2 THEN a.id_dd_sertifikat ELSE NULL END)ttl_assesor,
count(case when a.id_dd_jabatan=3 THEN a.id_dd_sertifikat ELSE NULL END)ttl_auditor
FROM dd_sertifikat a {$sqlPlus}
GROUP BY a.tahun ORDER BY a.tahun ASC";
        $data['pak'] = $this->db->query($q)->result_array();
        $data['sertifikat'] = $this->db->query($q2)->result_array();
        $this->load->view('v_laporan_rekap', $data);
    }

    public function cetak_laporan($id) {
//        $id = $this->input->post('id');

        $dt['sertifikat'] = $this->db->query("SELECT * FROM dd_sertifikat WHERE status={$id}")->result_array();
        $this->load->view('v_cetak', $dt);
    }

    function proses_cetak($id) {
        $this->load->library('html2pdf_lib');
        $content = file_get_contents(base_url() . 'C_main/cetak_laporan/' . $id);
        $filename = 'Bukti Kepesertaan.pdf';
        $save_to = $this->config->item('upload_root');
        if ($this->html2pdf_lib->converHtml2pdf($content, $filename, $save_to)) {
            echo $save_to . '/' . $filename;
        } else {
            echo 'failed';
        }
    }

    public function j($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}
