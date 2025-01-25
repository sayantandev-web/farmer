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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//frontend
$route['signup'] = 'login/registrationform';
$route['identification_document'] = 'login/identification_document';
$route['complete_submission'] = 'login/complete_submission';
$route['about-us'] = 'page/about';
$route['contact-us'] = 'page/contact';
$route['privacy-policy'] = 'page/privacy_policy';
$route['terms-and-condition'] = 'page/term';
$route['preventingpain'] = 'page/preventingpain';
$route['help'] = 'page/help';
$route['frequently-asked-questions'] = 'page/faq';
$route['logout'] = 'login/logout';
$route['event/my-event'] = 'event/my_event';
$route['event/invite-people'] = 'event/invite_people';
$route['search/my-event'] = 'search/my_event';
$route['event-details'] = 'home/event_details';
$route['event-and-participant'] = 'event/event_participant';
$route['setting/customize-payment'] = 'setting/customize_pay';
$route['email/template-management'] = 'email/template_management';
$route['setting/payment-method'] = 'setting/payment_method';
$route['resetpassword/(:any)'] = 'Forgetpassword/reset/$1';

//clinic admin
$route['clinic_admin/profile_settings'] = 'clinic_admin/Dashboard/profile';
$route['clinic_admin/update_profile'] = 'clinic_admin/Dashboard/update_profile';
$route['clinic_admin/change_password'] = 'clinic_admin/Dashboard/change_password';

$route['clinic_admin/clinic'] = 'clinic_admin/Dashboard/clinic';
$route['clinic_admin/add_clinic'] = 'clinic_admin/Dashboard/add_clinic';
$route['clinic_admin/update_clinic'] = 'clinic_admin/Dashboard/update_clinic';
$route['clinic_admin/clinic_details/(:any)'] = 'clinic_admin/Dashboard/clinic_details/$1';

$route['clinic_admin/add_clinic_admin'] = 'clinic_admin/Dashboard/add_clinic_admin';
$route['clinic_admin/update_clinic_admin'] = 'clinic_admin/Dashboard/update_clinic_admin';

$route['clinic_admin/participants'] = 'clinic_admin/Dashboard/participants';
$route['clinic_admin/participants/(:any)'] = 'clinic_admin/Dashboard/participants/$1';
$route['clinic_admin/add_participant'] = 'clinic_admin/Dashboard/add_participant';
$route['clinic_admin/update_participant'] = 'clinic_admin/Dashboard/update_participant';

$route['clinic_admin/providers'] = 'clinic_admin/Dashboard/providers';
$route['clinic_admin/providers/(:any)'] = 'clinic_admin/Dashboard/providers/$1';
$route['clinic_admin/add_provider'] = 'clinic_admin/Dashboard/add_provider';
$route['clinic_admin/update_provider'] = 'clinic_admin/Dashboard/update_provider';


//coach
$route['coach/profile_settings'] = 'coach/Dashboard/profile';
$route['coach/update_profile'] = 'coach/Dashboard/update_profile';
$route['coach/change_password'] = 'coach/Dashboard/change_password';
$route['coach/participants'] = 'coach/Dashboard/participants';
$route['coach/add_participant'] = 'coach/Dashboard/add_participant';
$route['coach/update_participant'] = 'coach/Dashboard/update_participant';

$route['coach/providers'] = 'coach/Dashboard/providers';
$route['coach/add_provider'] = 'coach/Dashboard/add_provider';
$route['coach/update_provider'] = 'coach/Dashboard/update_provider';

//welcome
$route['paymentPage'] = 'welcome/paymentPage';
$route['paymentStatus'] = 'welcome/paymentStatus';
$route['web_view_stripe_payment'] = 'welcome/web_view_stripe_payment';
$route['web_view_event_pay'] = 'welcome/web_view_event_pay';
$route['stripeEventPayment'] = 'welcome/stripeEventPayment';
$route['stripeEventPaymentStatus'] = 'welcome/stripeEventPaymentStatus';
$route['paypalEventPaymentStatus'] = 'welcome/paypalEventPaymentStatus';
$route['paypalPayment'] = 'welcome/paypalPayment';
$route['paypalSuccess'] = 'welcome/paypalSuccess';
$route['paypalCancel'] = 'welcome/paypalCancel';
$route['paypalIpn'] = 'welcome/paypalIpn';

//api
$route['paypalReturn'] = 'restapi/api/paypalReturn';
$route['paypalConnectStatus'] = 'restapi/api/paypalConnectStatus';
//admin

$route['admin'] = 'admin/login';
$route['userLogin'] = 'user/login';
