<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'authentication';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['auth/login'] = 'authentication';
$route['user/logout'] = 'authentication/logout';
$route['logout'] = 'authentication/logout';
$route['auth/dologin'] = 'authentication/dologin';
$route['user/dashboard'] = 'dashboard';
$route['user/registrasi'] = 'team';
$route['user/registrasi/add'] = 'team/add';
$route['user/registrasi/edit/(:any)'] = 'team/edit/$1';
$route['user/registrasi/update/(:any)'] = 'team/update/$1';

$route['user/overview'] = 'overview';
$route['user/overview/edit/(:any)/(:any)'] = 'overview/edit/$1/$2';
$route['user/overview/hapus/(:any)/(:any)'] = 'overview/hapusitem/$1/$2';
$route['user/overview/simpan/(:any)/(:any)'] = 'overview/simpan/$1/$2';
$route['user/overview/upload/strukturorganisasi/(:any)/(:any)'] = 'overview/strukturorganisasi/$1/$2';
$route['user/overview/upload/jadwalkegiatan/(:any)/(:any)'] = 'overview/jadwalkegiatan/$1/$2';
$route['user/overview/uploadjadwal/(:any)/(:any)'] = 'overview/uploadlampiran/$1/$2';
$route['user/overview/uploadstruktur/(:any)/(:any)'] = 'overview/uploadlampiran/$1/$2';
$route['user/overview/hapuslampiran/(:any)/(:any)'] = 'overview/hapuslampiran/$1/$2';

$route['user/abstrak'] = 'abstrak';
$route['user/abstrak/edit/(:any)/(:any)'] = 'abstrak/edit/$1/$2';
$route['user/abstrak/hapus/(:any)/(:any)'] = 'abstrak/hapusitem/$1/$2';
$route['user/abstrak/simpan/(:any)/(:any)'] = 'abstrak/simpan/$1/$2';

$route['user/plan'] = 'plan/index/1';
$route['user/plan/(:any)'] = 'plan/index/$1';

$route['user/plan/edit/(:any)/(:any)/(:any)'] = 'plan/edit/$1/$2/$3';
$route['user/plan/hapus/(:any)/(:any)/(:any)'] = 'plan/hapusitem/$1/$2/$3';
$route['user/plan/simpan/(:any)/(:any)/(:any)'] = 'plan/simpan/$1/$2/$3';

$route['user/doo'] = 'doo/index/1';
$route['user/doo/(:any)'] = 'doo/index/$1';
$route['user/doo/edit/(:any)/(:any)/(:any)'] = 'doo/edit/$1/$2/$3';
$route['user/doo/hapus/(:any)/(:any)/(:any)'] = 'doo/hapusitem/$1/$2/$3';
$route['user/doo/simpan/(:any)/(:any)/(:any)'] = 'doo/simpan/$1/$2/$3';

$route['user/cek'] = 'cek/index/1';
$route['user/cek/(:any)'] = 'cek/index/$1';
$route['user/cek/edit/(:any)/(:any)/(:any)'] = 'cek/edit/$1/$2/$3';
$route['user/cek/hapus/(:any)/(:any)/(:any)'] = 'cek/hapusitem/$1/$2/$3';
$route['user/cek/simpan/(:any)/(:any)/(:any)'] = 'cek/simpan/$1/$2/$3';

$route['user/aksi'] = 'aksi/index/1';
$route['user/aksi/(:any)'] = 'aksi/index/$1';
$route['user/aksi/edit/(:any)/(:any)/(:any)'] = 'aksi/edit/$1/$2/$3';
$route['user/aksi/hapus/(:any)/(:any)/(:any)'] = 'aksi/hapusitem/$1/$2/$3';
$route['user/aksi/simpan/(:any)/(:any)/(:any)'] = 'aksi/simpan/$1/$2/$3';


$route['admin/dashboard'] = 'dashboard/admin';

$route['admin/bab'] = 'babrisalah';
$route['admin/bab/add'] = 'babrisalah/add';
$route['admin/bab/edit/(:any)'] = 'babrisalah/edit/$1';
$route['admin/bab/update/(:any)'] = 'babrisalah/update/$1';
$route['admin/bab/simpan'] = 'babrisalah/simpan';
$route['admin/bab/hapus/(:any)'] = 'babrisalah/delete/$1';

$route['admin/langkah'] = 'langkah';
$route['admin/langkah/add'] = 'langkah/add';
$route['admin/langkah/edit/(:any)'] = 'langkah/edit/$1';
$route['admin/langkah/update/(:any)'] = 'langkah/update/$1';
$route['admin/langkah/simpan'] = 'langkah/simpan';
$route['admin/langkah/hapus/(:any)'] = 'langkah/delete/$1';

$route['admin/subbab'] = 'subbab';
$route['admin/subbab/add'] = 'subbab/add';
$route['admin/subbab/edit/(:any)'] = 'subbab/edit/$1';
$route['admin/subbab/update/(:any)'] = 'subbab/update/$1';
$route['admin/subbab/simpan'] = 'subbab/simpan';
$route['admin/subbab/hapus/(:any)'] = 'subbab/delete/$1';

$route['user/risalah'] = 'risalah';
$route['user/risalah/edit/(:any)/(:any)'] = 'risalah/edit/$1/$2';
$route['user/risalah/edit/(:any)/(:any)/(:any)'] = 'risalah/edit/$1/$2/$3';
$route['user/risalah/hapus/(:any)/(:any)'] = 'risalah/hapusitem/$1/$2';
$route['user/risalah/simpan/(:any)/(:any)'] = 'risalah/simpan/$1/$2';
$route['user/risalah/simpan/(:any)/(:any)/(:any)'] = 'risalah/simpan/$1/$2/$3';
$route['user/risalah/simpanbab'] = 'risalah/simpanbab';
$route['user/risalah/simpanbab/(:any)'] = 'risalah/simpanbab/$1';

$route['admin/team'] = 'team';
$route['admin/team/add'] = 'team/add';
$route['admin/team/edit/(:any)'] = 'team/edit/$1';
$route['admin/team/update/(:any)'] = 'team/update/$1';

$route['admin/risalah'] = 'risalah';
$route['admin/risalah/edit/(:any)/(:any)'] = 'risalah/edit/$1/$2';
$route['admin/risalah/hapus/(:any)/(:any)'] = 'risalah/hapusitem/$1/$2';
$route['admin/risalah/simpan/(:any)/(:any)'] = 'risalah/simpan/$1/$2';
$route['admin/risalah/simpanbab'] = 'risalah/simpanbab';

$route['admin/verifikasi'] = 'verifikasi/admin';

$route['admin/tahun'] = 'tahun/index';
$route['admin/tahun/changetahun/(:any)/(:any)'] = 'tahun/changetahun/$1/$2';
$route['admin/tahun/add'] = 'tahun/add';
$route['admin/tahun/edit/(:any)'] = 'tahun/edit/$1';
$route['admin/tahun/hapus/(:any)'] = 'tahun/delete/$1';
$route['admin/tahun/simpan'] = 'tahun/save';
$route['admin/tahun/update/(:any)'] = 'tahun/update/$1';

$route['admin/juri'] = 'juri/index';
$route['admin/juri/add'] = 'juri/add';
$route['admin/juri/edit/(:any)'] = 'juri/edit/$1';
$route['admin/juri/hapus/(:any)'] = 'juri/delete/$1';
$route['admin/juri/simpan'] = 'juri/save';
$route['admin/juri/update/(:any)'] = 'juri/update/$1';

$route['admin/pengguna'] = 'pengguna/index';
$route['admin/pengguna/add'] = 'pengguna/add';
$route['admin/pengguna/edit/(:any)'] = 'pengguna/edit/$1';
$route['admin/pengguna/hapus/(:any)'] = 'pengguna/delete/$1';
$route['admin/pengguna/simpan'] = 'pengguna/save';
$route['admin/pengguna/update/(:any)'] = 'pengguna/update/$1';

$route['admin/juri/pembagiantim/(:any)'] = 'pembagiantim/index/$1';
$route['admin/juri/pembagiantim/add/(:any)'] = 'pembagiantim/add/$1';
$route['admin/juri/pembagiantim/edit/(:any)/(:any)'] = 'pembagiantim/edit/$1/$2';
$route['admin/juri/pembagiantim/hapus/(:any)/(:any)'] = 'pembagiantim/delete/$1/$2';
$route['admin/juri/pembagiantim/simpan/(:any)'] = 'pembagiantim/save/$1';
$route['admin/juri/pembagiantim/update/(:any)/(:any)'] = 'pembagiantim/update/$1/$2';

$route['admin/kriteria'] = 'kriteria/index';
$route['admin/kriteria/add'] = 'kriteria/add';
$route['admin/kriteria/edit/(:any)'] = 'kriteria/edit/$1';
$route['admin/kriteria/hapus/(:any)'] = 'kriteria/delete/$1';
$route['admin/kriteria/simpan'] = 'kriteria/save';
$route['admin/kriteria/update/(:any)'] = 'kriteria/update/$1';

$route['admin/penilaian'] = 'penilaian/admin';
$route['admin/penilaian/lihat/(:any)'] = 'penilaian/lihat/$1';
$route['admin/penilaian/add'] = 'penilaian/add';
$route['admin/penilaian/edit/(:any)'] = 'penilaian/edit/$1';
$route['admin/penilaian/hapus/(:any)'] = 'penilaian/delete/$1';
$route['admin/penilaian/simpan'] = 'penilaian/save';
$route['admin/penilaian/update/(:any)'] = 'penilaian/update/$1';

$route['admin/verifikasi/lihatrisalah/(:any)'] = 'verifikasi/lihat/$1';
$route['admin/verifikasi/approve/(:any)/(:any)'] = 'verifikasi/approve/$1/$2';
$route['admin/verifikasi/risalah/edit/(:any)/(:any)'] = 'risalah/edit2/$1/$2';
$route['admin/verifikasi/risalah/edit/(:any)/(:any)/(:any)'] = 'risalah/edit2/$1/$2/$3';
$route['admin/verifikasi/risalah/simpan/(:any)/(:any)'] = 'risalah/simpan2/$1/$2';
$route['admin/verifikasi/risalah/simpan/(:any)/(:any)/(:any)'] = 'risalah/simpan2/$1/$2/$3';


$route['pimpinan/verifikasi'] = 'verifikasi/pimpinanlist';
$route['pimpinan/verifikasi/(:any)'] = 'verifikasi/pimpinan/$1';
$route['pimpinan/risalah/simpanbab/(:any)'] = 'verifikasi/simpanbab/$1';
$route['pimpinan/risalah/simpanbab/(:any)/(:any)'] = 'verifikasi/simpanbab/$1/$2';

$route['pimpinan/verifikasi/risalah/edit/(:any)/(:any)'] = 'risalah/edit3/$1/$2';
$route['pimpinan/verifikasi/risalah/edit/(:any)/(:any)/(:any)'] = 'risalah/edit3/$1/$2/$3';
$route['pimpinan/verifikasi/risalah/simpan/(:any)/(:any)'] = 'risalah/simpan3/$1/$2';
$route['pimpinan/verifikasi/risalah/simpan/(:any)/(:any)/(:any)'] = 'risalah/simpan3/$1/$2/$3';


$route['juri/penilaian'] = 'penilaian/index';
$route['juri/penilaian/(:any)'] = 'penilaian/listkriteria/$1';
$route['juri/penilaian/simpan/(:any)'] = 'penilaian/save/$1';
$route['juri/penilaian/hasil/(:any)'] = 'penilaian/lihat/$1';

$route['admin/penilaian/lihat/(:any)'] = 'penilaian/lihat/$1';
$route['admin/penilaian/add'] = 'penilaian/add';
$route['admin/penilaian/edit/(:any)'] = 'penilaian/edit/$1';
$route['admin/penilaian/hapus/(:any)'] = 'penilaian/delete/$1';
$route['admin/penilaian/simpan'] = 'penilaian/save';
$route['admin/penilaian/update/(:any)'] = 'penilaian/update/$1';
