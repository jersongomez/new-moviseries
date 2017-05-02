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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['logout'] = 'users/logout';
$route['peliculas'] = 'peliculas';
$route['android-app'] = 'home/android';
$route['premium'] = 'home/premium';
$route['series'] = 'series';
$route['download-file']['post'] = 'home/stream_moe_download';
$route['suggestions'] = 'home/suggestions';
$route['activacion/(.+)/(.+)'] = 'users/activation/$1/$2';
$route['peliculas/([0-9]+)'] = 'home/movie/$1';
$route['peliculas/categoria/(.+)'] = 'peliculas/peliculas_categoria/$1';
$route['series/categoria/(.+)'] = 'series/series_categoria/$1';
$route['series/([0-9]+)'] = 'home/serie/$1';
$route['peliculas/([0-9]+)/([0-9]+)'] = 'home/movie_url/$1/$2';
$route['recuperacion/([0-9]+)/(.+)'] = 'users/recuperacion/$1/$2';

$route['admin/seed'] = 'admin/app/seed';
$route['admin/seed_series'] = 'admin/app/seed_series';
$route['admin/seed_users'] = 'admin/app/seed_users';

//post
$route['new-user']['post'] = 'users/new_user';
$route['calificar-pelicula']['post'] = 'peliculas/calificar';
$route['calificar-serie']['post'] = 'series/calificar';
$route['login']['post'] = 'users/login';
$route['reset-password']['post'] = 'users/reset_password';
$route['new-password']['post'] = 'users/new_password';

//listas
$route['admin/get-users']['post'] = 'admin/user/get_users';
$route['admin/get-idiomas']['post'] = 'admin/idiomas/get_idiomas';
$route['admin/capitulos-temporada']['post'] = 'admin/series/get_capitulos_temporada';
$route['admin/series/list']['post'] = 'admin/series/list_series';
$route['admin/peliculas/list']['post'] = 'admin/peliculas/list_movies';
$route['admin/peliculas/enlaces']['post'] = 'admin/urls/get_urls';
$route['admin/get-generos']['post'] = 'admin/categorias/get_categorias';
$route['admin/serie-temporadas']['post'] = 'admin/series/get_temporadas_serie';

//edicion
$route['admin/edit-language']['post'] = 'admin/idiomas/edit_language';
$route['admin/peliculas/edit']['post'] = 'admin/peliculas/edit_movie';
$route['admin/serie/edit']['post'] = 'admin/series/edit_serie';


$route['admin/datos-usuario']['post'] = 'admin/user/user_data';
$route['admin/edit-user']['post'] = 'admin/user/edit_user';


//insert
$route['admin/nueva-categoria']['post'] = 'admin/categorias/insert';
$route['admin/insert-movie']['post'] = 'admin/peliculas/insert_movie';
$route['admin/insert-serie']['post'] = 'admin/series/insert_serie';
$route['admin/insert-language']['post'] = 'admin/idiomas/insert_language';
$route['admin/peliculas/insert-enlaces']['post'] = 'admin/urls/insert';
$route['admin/serie/insert-temporada']['post'] = 'admin/series/nueva_temporada';
$route['admin/serie/insert-enlaces']['post'] = 'admin/capitulos/insert';

//eliminar
$route['admin/peliculas/delete']['post'] = 'admin/peliculas/delete_row';
$route['admin/eliminar-idioma']['post'] = 'admin/idiomas/delete_language';
$route['admin/eliminar-capitulo']['post'] = 'admin/capitulos/delete_row';
$route['admin/eliminar-temporada']['post'] = 'admin/series/eliminar_temporada';
$route['admin/eliminar-serie']['post'] = 'admin/series/eliminar_serie';
$route['admin/eliminar-genero']['post'] = 'admin/categorias/delete';
$route['admin/eliminar-usuario']['post'] = 'admin/user/delete_user';
$route['admin/peliculas/eliminar-enlace']['post'] = 'admin/urls/delete_row';


$route['admin'] = 'admin/user';
$route['admin/categorias'] = 'admin/categorias';
$route['admin/series'] = 'admin/series';
$route['admin/users'] = 'admin/user/users';
$route['admin/editar-serie/([0-9]+)'] = 'admin/series/editar_serie/$1';

$route['admin/serie/([0-9]+)/temporada/([0-9]+)'] = 'admin/series/capitulos/$1/$2';
$route['admin/series/([0-9]+)/temporadas'] = 'admin/series/temporadas/$1';


$route['admin/peliculas'] = 'admin/peliculas';
$route['admin/peliculas/enlaces/([0-9]+)'] = 'admin/urls/index/$1';

$route['admin/idiomas'] = 'admin/idiomas';
$route['admin/nueva-pelicula'] = 'admin/peliculas/nueva_pelicula';
$route['admin/nueva-serie'] = 'admin/series/nueva_serie';
$route['admin/editar-pelicula/([0-9]+)'] = 'admin/peliculas/editar_pelicula/$1';

