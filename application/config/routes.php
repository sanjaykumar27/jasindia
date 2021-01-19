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
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//Company Master
$route['manufacturer/getManufacturer'] = 'master/Manufacturer/getManufacturer';
$route['manufacturer/create'] = 'master/Manufacturer/Create';
$route['manufacturer/edit'] = 'master/manufacturer/edit';
$route['manufacturer/update'] = 'master/manufacturer/update';

//State Master
$route['state/getStates'] = 'master/State/getStates';
$route['state/create'] = 'master/State/Create';
$route['state/edit'] = 'master/State/edit';
$route['state/update'] = 'master/State/update';
$route['state/allStates'] = 'master/State/allStates';

// district
$route['state/getDistricts'] = 'master/State/getDistricts';
$route['district/create'] = 'master/State/CreateDistrict';
$route['district/update'] = 'master/State/updateDistrict';
$route['state/allDistricts'] = 'master/State/allDistricts';

// city
$route['city/create'] = 'master/City/Create';
$route['city/getCities'] = 'master/City/getCities';
$route['master/city'] = 'master/City/index';
$route['city/edit'] = 'master/City/edit';
$route['city/update'] = 'master/City/update';
$route['city/delete'] = 'master/City/deletePincode';
$route['city/newPincode'] = 'master/City/newPincode';
$route['city/pincodeUpdate'] = 'master/City/pincodeUpdate';

//engine
$route['engine/getEngines'] = 'master/Engine/getEngine';
$route['engine/allManufacturer'] = 'master/Engine/allManufacturer';
$route['engine/create'] = 'master/Engine/CreateEngine';
$route['engine/update'] = 'master/Engine/update';
$route['engine/edit'] = 'master/Engine/edit';

// fuel
$route['fuel/getFuels'] = 'master/Fuel/getFuels';
$route['fuel/create'] = 'master/Fuel/CreateFuel';
$route['fuel/update'] = 'master/Fuel/update';
$route['fuel/edit'] = 'master/Fuel/edit';

//engine cylinder
$route['engine_cylinder/getEngineCylinders'] = 'master/EngineCylinder/getEngineCylinders';
$route['engine_cylinder/create'] = 'master/EngineCylinder/CreateEngineCylinder';
$route['engine_cylinder/update'] = 'master/EngineCylinder/update';
$route['engine_cylinder/edit'] = 'master/EngineCylinder/edit';
$route['master/engine_cylinder'] = 'master/EngineCylinder/index';

//emission standard
$route['emission_standard/getEmissionStandard'] = 'master/EmissionStandard/getEmissionStandard';
$route['emission_standard/create'] = 'master/EmissionStandard/CreateEmissionStandard';
$route['emission_standard/update'] = 'master/EmissionStandard/update';
$route['emission_standard/edit'] = 'master/EmissionStandard/edit';
$route['master/emission_standard'] = 'master/EmissionStandard/index';

//vehicle segment
$route['vehicle_segment/getVehicleSegment'] = 'master/VehicleSegment/getVehicleSegment';
$route['vehicle_segment/create'] = 'master/VehicleSegment/CreateVehicleSegment';
$route['vehicle_segment/update'] = 'master/VehicleSegment/update';
$route['vehicle_segment/edit'] = 'master/VehicleSegment/edit';
$route['master/vehicle_segment'] = 'master/VehicleSegment/index';

//body Type
$route['body_type/getBodyType'] = 'master/BodyType/getBodyType';
$route['body_type/create'] = 'master/BodyType/CreateBodyType';
$route['body_type/update'] = 'master/BodyType/update';
$route['body_type/edit'] = 'master/BodyType/edit';
$route['master/body_type'] = 'master/BodyType/index';