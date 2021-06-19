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
