<?php

use App\Http\Controllers\AnalyseController;
use App\Http\Controllers\AnalysedispoController;
use App\Http\Controllers\AppointController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SpeController;
use App\Http\Controllers\UserController;
use App\Models\Doctor;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\tables\Basic as TablesBasic;

//
use App\Http\Controllers\PatientController;
//

// Main Page Route
Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');

// layout
Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

// cards
Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

// User Interface
Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

// icons
Route::get('/icons/boxicons', [Boxicons::class, 'index'])->name('icons-boxicons');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');

// tables
Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');


//routes secre-admin

Route::get('/patients', [PatientController::class, 'index'])->name('patientindex');
Route::get('/newpatient', [PatientController::class, 'create'])->name('createpatient');
Route::post('/patients', [PatientController::class, 'store'])->name('patientstore');
Route::get('/patients/{uuid}/editpat', [PatientController::class, 'edit'])->name('patientsedit');
Route::post('/patients/{uuid}/updatpat', [PatientController::class, 'update'])->name('patientsupdate');

//routes rdv-secre
Route::get('/appointments', [AppointController::class, 'index'])->name('appointindex');
Route::get('/newappoint', [AppointController::class, 'create'])->name('createappoint');
Route::post('/appointments', [AppointController::class, 'store'])->name('appointstore');
Route::get('/appoints/edit', [AppointController::class, 'edit'])->name('appoint.edit');
Route::post('/appoints/update', [AppointController::class, 'update'])->name('appoint.update');

Route::get('/patients/search', [AppointController::class, 'searchPatient'])->name('patients.search'); 

//Doctor routes
Route::get('/doctorpat', [PatientController::class, 'indexdoctor'])->name('docpat');
Route::get('/patients/{uuid}/consultations', [ConsultationController::class, 'index'])->name('patient.consultations');
Route::post('/consultations/store', [ConsultationController::class, 'store'])->name('consultations.store');
Route::post('/consultations/{id_cons}', [ConsultationController::class, 'update'])->name('consultations.update');
Route::post('/consultations/destroy/{id_cons}', [ConsultationController::class, 'destroy'])->name('consultations.destroy');

//doctor-analyse
Route::post('/patients/analyses', [AnalyseController::class, 'store'])->name('analysestore');
Route::post('/patients/analyseupdate/{id_an}', [AnalyseController::class, 'update'])->name('analyseupdate');
Route::post('/patients/analysedestroy/{id_an}', [AnalyseController::class, 'destroy'])->name('analysedestroy');

//admin

Route::get('/adminservice', [ServiceController::class, 'index'])->name('service.index');
Route::post('/services/store', [ServiceController::class, 'store'])->name('servicestore');
Route::post('/services/{id_serv}', [ServiceController::class, 'update'])->name('servicesupdate');
Route::post('/services/destroy/{id_serv}', [ServiceController::class, 'destroy'])->name('services.destroy');

//adminanalyse
Route::post('/analyse/store', [AnalysedispoController::class, 'store'])->name('analyses.store');
Route::post('/analyse/destroy/{id}', [AnalysedispoController::class, 'destroy'])->name('analyses.destroy');

//admin-consultation
Route::get('/admin/history', [ConsultationController::class, 'history'])->name('consultation.history');

//admin-spe
Route::post('/admin/spe/store', [SpeController::class, 'store'])->name('specialite.store');
Route::post('/admin/speupdate/{id_spe}', [SpeController::class, 'update'])->name('specialite.update');
Route::post('/admin/spedestroy/{id_spe}', [SpeController::class, 'destroy'])->name('specialite.destroy');


Route::get('/login', function () {
  return view('login.login');
});

//admin-user
Route::get('/admin/user', [UserController::class, 'index'])->name('user.index');
Route::post('/admin/userstore', [UserController::class, 'store'])->name('userstore');
Route::put('/admin/user/{uuid}', [UserController::class, 'update'])->name('user.update');
Route::delete('/admin/user/{uuid}', [UserController::class, 'destroy'])->name('user.destroy');



//admin-doctor
Route::get('/admin/doctor', [DoctorController::class, 'index'])->name('doctor.index');
Route::post('/doctors/store', [DoctorController::class, 'store'])->name('doctor.store');
Route::post('/doctors/update/{id}', [DoctorController::class, 'update'])->name('doctor.update');
