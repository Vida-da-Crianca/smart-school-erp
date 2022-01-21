<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome/index';
$route['user/resetpassword/([a-z]+)/(:any)'] = 'site/resetpassword/$1/$2';
$route['admin/resetpassword/(:any)'] = 'site/admin_resetpassword/$1';
$route['admin/unauthorized'] = 'admin/admin/unauthorized';
$route['parent/unauthorized'] = 'parent/parents/unauthorized';
$route['student/unauthorized'] = 'user/user/unauthorized';
$route['teacher/unauthorized'] = 'teacher/teacher/unauthorized';
$route['accountant/unauthorized'] = 'accountant/accountant/unauthorized';
$route['librarian/unauthorized'] = 'librarian/librarian/unauthorized';
$route['404_override'] = 'school/show_404';
$route['translate_uri_dashes'] = FALSE;
$route['cron/(:any)'] = 'cron/index/$1';

#alterado
$route['admin/orcamento/output/(:any)'] = 'admin/orcamento/Orcamento/output/$1';
$route['admin/orcamento/item/(:any)'] = 'admin/orcamento/Item/$1';
$route['admin/orcamento'] = 'admin/orcamento/Orcamento/index';
$route['admin/orcamento/(:any)'] = 'admin/orcamento/Orcamento/$1';

$route['admin/data_corte'] = 'admin/data_corte/Data_corte/index';
$route['admin/data_corte/delete/(:any)'] = 'admin/data_corte/Data_corte/delete/$1';
$route['admin/data_corte/(:any)'] = 'admin/data_corte/Data_corte/$1';

//======= front url rewriting==========
$route['page/(:any)'] = 'welcome/page/$1';
$route['read/(:any)'] = 'welcome/read/$1';
$route['online_admission'] = 'welcome/admission';
$route['frontend'] = 'welcome';
$route['admin/documents']['get'] = 'admin/DocumentController';
$route['admin/documents/create']['get'] = 'admin/DocumentController/create';
$route['admin/documents/create']['post'] = 'admin/DocumentController/store';
$route['admin/documents/preview/(:any)/(:any)']['get'] = 'admin/DocumentController/preview/$1/$2';
$route['admin/documents/previewMultiple/(:any)/(:any)']['get'] = 'admin/DocumentController/previewMultiple/$1/$2';
$route['admin/documents/(:any)']['get'] = 'admin/DocumentController/show/$1';
$route['admin/documents/(:any)']['post'] = 'admin/DocumentController/update/$1';
$route['admin/documents/(:any)']['delete'] = 'admin/DocumentController/destroy/$1';

// Curriculos
$route['workwithus'] = 'welcome/workwithus';
$route['workwithus/enviar']['post'] = 'welcome/workwithus_ajax';
$route['admin/curriculos'] = 'admin/Staff/curriculos'; // Lista de curriculos
$route['admin/curriculos/ver/(:num)']['get'] = 'admin/Staff/curriculos/$1'; // Ver um curriculo
$route['admin/curriculos/salvar/(:any)']['post'] = 'admin/Staff/salvar_curriculo/$1'; // Salvar um curriculo
$route['admin/curriculos/deletar/(:num)']['get'] = 'admin/Staff/curriculo_deletar/$1'; // Deletar um cúrriculo do banco de dados
$route['admin/curriculos/pdf/(:num)']['get'] = 'admin/Staff/cv_pdf/$1';