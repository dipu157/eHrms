<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('autocomplete/employees', 'AutoComplete@employee');

Route::get('autocomplete/rosterEmployee','AutoComplete@employeeForRoster');

Route::get('autocomplete/doctors','AutoComplete@doctors');
Route::get('autocomplete/refDoctors','AutoComplete@refDoctors');


Route::get('autocomplete/departmentEmployee','AutoComplete@employeeDepartment');

Route::get('attendance/autocomplete/{date}','AutoComplete@employeeAttendance');

Route::get('autocomplete/employeeNameId','AutoComplete@employeeNameId');

Route::get('autocomplete/biodataSearch','AutoComplete@biodataSearch');

Route::get('password/check','Auth\ResetPasswordController@passCheck');



Route::get('employee/postcode/ajax/{id}',['as'=>'postcode/ajax', 'uses'=>'AutoComplete@postCode']);
Route::get('postcode/ajax/{id}',['as'=>'postcode/ajax', 'uses'=>'AutoComplete@postCode']);


Route::group(['prefix' => 'privillege', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {

    //  Auth Privillege Route

    Route::get('index',['as'=>'privillege/index','uses' => 'PrivillegeController@index']);
    Route::post('grant',['as'=>'privillege/grant','uses' => 'PrivillegeController@grant']);


});


Route::group(['prefix' => '', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {

    //  Password Change

    route::get('password/reset',['as'=>'password/reset','uses' => 'ResetPasswordController@showResetForm']);

});

Route::group(['prefix' => '', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {

   Route::get('usersDataTable','RegisterController@userTableData');

    //  Auth PAssword Route

    Route::get('passwordChange/index',['as'=>'passwordChange/index','uses' => 'PrivillegeController@index']);
    Route::get('passwordReset/index',['as'=>'passwordReset/index','uses' => 'PrivillegeController@index']);

});



Route::group(['prefix' => 'company', 'namespace' => 'Company', 'middleware' => ['auth']], function () {

    //  Company Route

    Route::get('index',['as'=>'company/index','uses' => 'CompanyController@index']);

    Route::get('companyDataTable',['as'=>'company/companyDataTable','uses' => 'CompanyController@companyData']); // Data Table Roure

});


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {

    //  Division Route

    Route::get('divisionIndex',['as'=>'admin/divisionIndex','uses' => 'DivisionController@index']);

    Route::get('divisionDataTable','DivisionController@divisionData'); // Data Table Roure

    Route::post('division/save',['as'=>'admin/division/save','uses' => 'DivisionController@create']);
    Route::post('division/update',['as'=>'admin/division/update','uses' => 'DivisionController@update']);

    // Department Routes

    Route::get('departmentIndex',['as'=>'admin/departmentIndex','uses' => 'DepartmentController@index']);
    Route::get('departmentDataTable','DepartmentController@departmentData'); // Data Table Roure
    Route::post('department/save',['as'=>'admin/department/save','uses' => 'DepartmentController@create']);
    Route::post('department/update',['as'=>'admin/department/update','uses' => 'DepartmentController@update']);

    // Doctor Department Routes

    Route::get('doctorDepartmentIndex',['as'=>'admin/doctorDepartmentIndex','uses' => 'DepartmentController@doctorDeptindex']);
    Route::get('doctorDepartmentDataTable','DepartmentController@doctorDepartmentData'); // Data Table Roure
    Route::post('doctorDepartment/save',['as'=>'admin/doctorDepartment/save','uses' => 'DepartmentController@doctorDeptcreate']);
    Route::post('doctorDepartment/update',['as'=>'admin/doctorDepartment/update','uses' => 'DepartmentController@doctorDeptupdate']);


//  Sections/Units Route

    Route::get('sectionIndex',['as'=>'admin/sectionIndex','uses' => 'SectionController@index']);
    Route::get('sectionDataTable','SectionController@sectionData'); // Data Table Roure
    Route::post('section/save',['as'=>'admin/section/save','uses' => 'SectionController@create']);

// Report

    Route::get('allreportList',['as'=>'admin/report/reportList','uses' => 'AdminReportController@index']);

    Route::get('report/{status}',['as'=>'admin/report/divlist','uses' => 'AdminReportController@divisionList']);

});



Route::group(['prefix' => 'employee', 'namespace' => 'Employee', 'middleware' => ['auth']], function () {

    //  Designation Route

    Route::get('designationIndex',['as'=>'employee/designationIndex','uses' => 'DesignationController@index']);
    Route::get('designationDataTable','DesignationController@designationData'); // Data Table Roure
    Route::post('designation/save',['as'=>'employee/designation/save','uses' => 'DesignationController@create']);

    Route::post('designation/update',['as'=>'employee/designation/update','uses' => 'DesignationController@update']);

// Title Routes

    Route::get('titleIndex',['as'=>'employee/titleIndex','uses' => 'TitleController@index']);
    Route::get('titleDataTable','TitleController@titleData'); // Data Table Roure
    Route::post('title/save',['as'=>'employee/title/save','uses' => 'TitleController@create']);

    Route::post('title/update',['as'=>'employee/title/update','uses' => 'TitleController@update']);

    // Employee Routes

//Personal

    Route::get('employeeIndex',['as'=>'employee/employeeIndex','uses' => 'EmployeeController@index']);
    Route::get('employeeDataTable','EmployeeController@employeeData'); // Data Table Roure
    Route::post('personal/save',['as'=>'employee/personal/save','uses' => 'EmployeeController@create']);

    Route::post('edit/personal/update',['as'=>'employee/personal/update','uses' => 'EmployeeController@update']);
    Route::post('edit/professional/update',['as'=>'employee/professional/update','uses' => 'EmployeeController@update']);
    Route::get('appLetter/{id}',['as'=>'employee/appLetter','uses' => 'EmployeeController@appLetter']);

    Route::get('punish/{id}',['as'=>'employee/punish/get','uses' => 'EmployeeController@punish']);

    Route::post('punish',['as'=>'employee/punish/post','uses' => 'EmployeeController@punishPost']);



// Employee VIEW Route
    Route::get('view/{id}',['as'=>'employee/view','uses' => 'EmployeeController@view']);

    Route::post('professional/save',['as'=>'employee/professional/save','uses' => 'EmployeeController@create']);


    //Edit Employee Routes

    Route::get('edit/{id}','EmployeeController@empInfoForEdit');

// Dependant Routes
    Route::get('history/{id}',['as'=>'employee/view','uses' => 'EmployeeController@history']);
    Route::get('history/historyDataTable/{id}','EmployeeController@historyTableData'); // Dependant Data Table Roure
    Route::post('history/save',['as'=>'employee/history/save','uses' => 'EmployeeController@saveHistory']);
    Route::post('dependant/update',['as'=>'employee/dependant/update','uses' => 'EmployeeController@update']);


    // Employee Education


    Route::get('education/{id}',['as'=>'employee/education/index','uses' => 'EmployeeController@educationIndex']);
    Route::get('education/educationsDataTable/{id}','EmployeeController@educationTableData'); // Educations Data Table Roure
    Route::post('education/save',['as'=>'employee/education/save','uses' => 'EmployeeController@educationSave']);

    Route::post('education/update',['as'=>'employee/education/update','uses' => 'EmployeeController@educationUpdate']);
    Route::post('education/delete/{id}',['as'=>'employee/education/delete','uses' => 'EmployeeController@educationDestroy']);



    //Posting Routes

    Route::get('posting/{id}',['as'=>'employee/posting/index','uses' => 'EmployeeController@postingIndex']);
    Route::get('posting/postingDataTable/{id}','EmployeeController@postingTableData'); // Educations Data Table Roure
    Route::post('posting/save',['as'=>'employee/posting/save','uses' => 'EmployeeController@postingSave']);

    Route::post('posting/update',['as'=>'employee/posting/update','uses' => 'EmployeeController@postingUpdate']);

    Route::get('posting/delete/{id}',['as'=>'employee/posting/delete','uses' => 'EmployeeController@postingDelete']);


Route::get('recomended/{id}',['as'=>'employee/recomended/get','uses' => 'EmployeeController@recomended']);

    Route::get('recomended/recomendedDataTable/{id}','EmployeeController@recomendedTableData'); // Dependant Data Table Roure
    Route::post('recomended/save',['as'=>'employee/recomended/save','uses' => 'EmployeeController@saveRecomended']);
    
    Route::get('promotion/{id}',['as'=>'employee/promotion/get','uses' => 'EmployeeController@promotion']);

    Route::post('promotion',['as'=>'employee/promotion/post','uses' => 'EmployeeController@promotionPost']);

    //Employee Image Edit

    Route::post('image/save',['as'=>'employee/image/save','uses' => 'EmployeeController@updateImage']);


    //ID CARD ROUTE

//    Route::get('idcard/{id}',['as'=>'employee/idcard/index','uses' => 'EmployeeController@test_print']);

    Route::get('cardprint',['as'=>'employee/idcard/index','uses' => 'EmployeeController@card_print']);


    Route::get('leave/print/{id}',['as'=>'employee/leave/print','uses' => 'EmployeeController@leavePrint']);



    Route::get('empProfileIndex',['as'=>'employee/empProfileIndex','uses' => 'Report\EmployeeProfileController@index']);

    Route::get('report/empListIndex',['as'=>'employee/report/empListIndex','uses' => 'Report\EmployeeListController@index']);

    Route::get('report/empBDesigwiseList',['as'=>'employee/report/empBDesigwiseList','uses' => 'Report\EmployeeListController@BaseDesigEmpList']);
    Route::get('report/empDesigwiseList',['as'=>'employee/report/empDesigwiseList','uses' => 'Report\EmployeeListController@DesigEmpList']);
    Route::get('report/empHistoryList',['as'=>'employee/report/empHistoryList','uses' => 'Report\EmployeeListController@empHistoryList']);
    Route::get('report/dateEmpListIndex',['as'=>'employee/report/dateEmpListIndex','uses' => 'Report\EmployeeListController@DateRangewStatus']);

    Route::get('report/monthEmpListWStatusIndex',['as'=>'employee/report/monthEmpListWStatusIndex','uses' => 'Report\EmployeeListController@MonthwStatus']);

    Route::get('report/empListWStatusIndex',['as'=>'employee/report/empListWStatusIndex','uses' => 'Report\EmployeeListController@wStatus']);

    Route::get('report/empListGenderIndex',['as'=>'employee/report/empListGenderIndex','uses' => 'Report\EmployeeListController@genderList']);

    Route::get('report/dateEmpListWStatusIndex',['as'=>'employee/report/dateEmpListWStatusIndex','uses' => 'Report\EmployeeListController@DateRangewStatus']);

    Route::get('report/punishEmpListIndex',['as'=>'employee/report/punishEmpListIndex','uses' => 'Report\EmployeeListController@DateRangePunishStatus']);

Route::get('report/allDoctorListIndex',['as'=>'employee/report/allDoctorListIndex','uses' => 'Report\EmployeeListController@doctorEmpList']);
    Route::get('report/empsectionDoctorEmpList',['as'=>'employee/report/empsectionDoctorEmpList','uses' => 'Report\EmployeeListController@sectionDoctorEmpList']);
    Route::get('report/specialempDoctorEmpList',['as'=>'employee/report/specialempDoctorEmpList','uses' => 'Report\EmployeeListController@specialDoctorEmpList']);

    Route::get('report/empsectionEmpList',['as'=>'employee/report/empsectionEmpList','uses' => 'Report\EmployeeListController@sectionWiseEmpList']);
//REPORTS
//    Route::get('inactiveEmpListIndex',['as'=>'employee/inactiveEmpListIndex','uses' => 'Report\EmployeeProfileController@index']);



});


// ROSTER ROUTES


Route::group(['prefix' => 'roster', 'namespace' => 'Roster', 'middleware' => ['auth']], function () {

    //Locations Route

    Route::get('locationIndex',['as'=>'roster/locationIndex','uses' => 'DutyLocationController@index']);

    Route::get('locationsDataTable','DutyLocationController@locationData'); // Data Table Roure
    Route::post('location/save',['as'=>'location/save','uses' => 'DutyLocationController@create']);


//    roster save



    //  Roster Settings Route

    Route::get('shiftIndex',['as'=>'roster/shiftIndex','uses' => 'ShiftsController@index']);

    Route::get('shiftsDataTable','ShiftsController@shiftData'); // Data Table Roure
    Route::post('shift/save',['as'=>'shift/save','uses' => 'ShiftsController@create']);
    Route::post('shift/update',['as'=>'shift/update','uses' => 'ShiftsController@update']);


    Route::get('employeeRosterIndex',['as'=>'roster/employeeRosterIndex','uses' => 'EmployeeRosterController@index']);


    Route::post('weekdays/save',['as'=>'weekone/save','uses' => 'EmployeeRosterController@create']);


    Route::get('approveRosterIndex',['as'=>'roster/approveRosterIndex','uses' => 'ApproveRosterController@index']);

    Route::post('approve',['as'=>'roster/approve','uses' => 'ApproveRosterController@approve']);


    Route::get('updateRosterIndex',['as'=>'roster/updateRosterIndex','uses' => 'UpdateRosterController@index']);
    Route::post('updateRoster',['as'=>'roster/updateRoster','uses' => 'UpdateRosterController@update']);


    Route::get('printRosterIndex',['as'=>'roster/printRosterIndex','uses' => 'PrintRosterController@index']);

    Route::get('rosterDataTable/{year}/{month}/{dept_id}',['as'=>'roster/rosterDataTable','uses' => 'PrintRosterController@getRosterData']);

    Route::get('printRosterWiseEmployeeIndex',['as'=>'roster/printRosterWiseEmployeeIndex','uses' => 'RosterWiseEmployeeReportController@index']);

    Route::get('printDeptWiseEmployeeShiftIndex',['as'=>'roster/printDeptWiseEmployeeShiftIndex','uses' => 'ShiftWiseEmployeeReportController@index']);

    Route::get('printShiftWiseEmployeeIndex',['as'=>'roster/printShiftWiseEmployeeIndex','uses' => 'ShiftWiseEmployeeReportController@shiftEmployee']);

    
    Route::get('DeptContainRoster',['as'=>'roster/DeptContainRoster','uses' => 'PrintRosterController@DeptContainRoster']);

});

// TRAINING ROUTES



Route::group(['prefix' => 'training', 'namespace' => 'Training', 'middleware' => ['auth']], function () {

    //Training Route
   
    Route::get('newTrainingIndex',['as'=>'training/newTrainingIndex','uses' => 'AddTrainingController@index']);


    Route::get('newsetupIndex',['as'=>'training/TrainingIndex','uses' => 'AddTrainingController@trainingindex']);
    Route::post('ApplyTraining',['as'=>'training/ApplyTraining','uses' => 'AddTrainingController@applytraining']);
    Route::get('finalTraining',['as'=>'training/finaltraining','uses' => 'AddTrainingController@finaltraining']);
    Route::get('trainingDataTable','AddTrainingController@trainingData'); // Data Table Roure
    Route::post('training/save',['as'=>'training/save','uses' => 'AddTrainingController@create']);

    Route::post('training/update',['as'=>'training/update','uses' => 'AddTrainingController@update']);
    Route::get('approveIndex',['as'=>'training/approveIndex','uses' => 'ApproveTrainingController@index']);
    Route::post('approve',['as'=>'training/approve','uses' => 'ApproveTrainingController@create']);

    Route::get('view/{id}',['as'=>'training/view','uses' => 'AddTrainingController@view']);

    Route::get('printIndex/{id}',['as'=>'training/print','uses' => 'AddTrainingController@printTrainingIndex']);
    Route::get('printTraining/{tid}/{did}',['as'=>'training/printTraining','uses' => 'AddTrainingController@printTraining']);

    Route::get('scheduleTrainingIndex',['as'=>'training/scheduleTrainingIndex','uses' => 'TrainingScheduleController@index']);
    Route::get('scheduleDataTable','TrainingScheduleController@scheduleData'); // Data Table Roure
    Route::post('scheduleSave',['as'=>'training/scheduleSave','uses' => 'TrainingScheduleController@create']);
    Route::get('scheduleView/{id}',['as'=>'training/scheduleView','uses' => 'TrainingScheduleController@view']);

    Route::post('deleteSchedule/{id}',['as'=>'training/deleteSchedule','uses' => 'TrainingScheduleController@destroy']);

    Route::get('scheduleView/print/{id}/{ba}',['as'=>'training/scheduleView','uses' => 'TrainingScheduleController@printDetails']);

    Route::get('addTraineeIndex/{schId}',['as'=>'training/addTraineeIndex','uses' => 'ManageParticipantController@index']);

    Route::get('traineeList/{dId}/{schId}',['as'=>'training/traineeList','uses' => 'ManageParticipantController@traineeList']);
    Route::post('traineeList',['as'=>'training/traineeList','uses' => 'ManageParticipantController@traineePost']);

    Route::get('completeTrainingIndex/{id}',['as'=>'training/completeTrainingIndex','uses' => 'CompleteTrainingController@index']);

    Route::get('completeList/{dId}/{schId}',['as'=>'training/completeList','uses' => 'CompleteTrainingController@participantList']);
    Route::post('completeAttendList',['as'=>'training/completeAttendList','uses' => 'CompleteTrainingController@CompleteAttendList']);
//    roster save

});

// Documentation Route

Route::group(['prefix' => 'document', 'namespace' => 'Document', 'middleware' => ['auth']], function () {

    //Document Route
   
    Route::get('newDocumentIndex',['as'=>'document/newDocumentIndex','uses' => 'DocumentationController@index']);
    Route::post('documentationSave',['as'=>'document/newDocumentSave','uses' => 'DocumentationController@create']);
    Route::get('documentDataTable','DocumentationController@documentData'); // Data Table Roure
    Route::post('saveDocumentFile',['as'=>'document/saveDocumentFile','uses' => 'DocumentationController@saveFile']);
    Route::get('view/{id}',['as'=>'document/view','uses' => 'DocumentationController@viewFile']);
    Route::get('edit/{id}','DocumentationController@documentEdit');
    Route::post('edit/document/update',['as'=>'document/update','uses' => 'DocumentationController@update']);
});


// LEAVE ROUTES


Route::group(['prefix' => 'leave', 'namespace' => 'Leave', 'middleware' => ['auth']], function () {

    //Leave Route

    Route::get('processIndex',['as'=>'leave/processIndex','uses' => 'LeaveProcessController@index']);
    Route::post('leaveProcess',['as'=>'leave/process','uses' => 'LeaveProcessController@process']);


    Route::get('masterIndex',['as'=>'leave/masterIndex','uses' => 'LeaveMasterController@index']);
    Route::get('leaveMasterDataTable','LeaveMasterController@trainingData'); // Data Table Roure
    Route::post('leaveMaster/save',['as'=>'leaveMaster/save','uses' => 'LeaveMasterController@create']);

//    Route::post('training/update',['as'=>'training/update','uses' => 'AddTrainingController@update']);

//    Route::get('view/{id}',['as'=>'training/view','uses' => 'AddTrainingController@view']);


//    Apply Leave
    Route::get('applyIndex',['as'=>'leave/applyIndex','uses' => 'ApplyLeaveController@index']);
    Route::post('application/save',['as'=>'leave/save','uses' => 'ApplyLeaveController@create']);


//    Acknowledge By Alternate

    Route::get('acknowledgeIndex',['as'=>'leave/acknowledgeIndex','uses' => 'AlternateAcknowledgeLeaveController@index']);
    Route::get('acknowledgeDataTable','AlternateAcknowledgeLeaveController@acknowledgeData'); // Data Table Roure

    Route::post('acknowledge/{id}',['as'=>'acknowledge/save','uses' => 'AlternateAcknowledgeLeaveController@acknowledge']);
    Route::post('refuse/{id}',['as'=>'refuse/save','uses' => 'AlternateAcknowledgeLeaveController@refuse']);


//    Recommend Leave
    Route::get('recommendIndex',['as'=>'leave/recommendIndex','uses' => 'RecommendLeaveController@index']);
    Route::get('recommendDataTable','RecommendLeaveController@recommendData'); // Data Table Roure

    Route::get('view/{id}',['as'=>'leave/view','uses' => 'RecommendLeaveController@view']);

    Route::post('recommend/{id}',['as'=>'recommend/save','uses' => 'RecommendLeaveController@recommend']);
    Route::post('reject/{id}',['as'=>'reject/save','uses' => 'RecommendLeaveController@reject']);
//    Route::post('recommend/allow',['as'=>'recommend/save','uses' => 'ApplyLeaveController@create']);



    //    Approve Leave
    Route::get('approveIndex',['as'=>'leave/approveIndex','uses' => 'ApproveLeaveController@index']);
    Route::get('approveDataTable','ApproveLeaveController@approveData'); // Data Table Roure

    Route::get('approve/view/{id}',['as'=>'leave/view','uses' => 'ApproveLeaveController@view']);

    Route::post('approve/{id}',['as'=>'approve/save','uses' => 'ApproveLeaveController@approve']);
    Route::post('approve/reject/{id}',['as'=>'approve/reject/save','uses' => 'ApproveLeaveController@reject']);


    Route::get('updateIndex',['as'=>'leave/updateIndex','uses' => 'UpdateLeaveController@index']);

    Route::post('register/update',['as'=>'leave/register/update','uses' => 'UpdateLeaveController@update']);

    Route::post('leaveAddByAdmin/save',['as'=>'leave/leaveAddByAdmin/save','uses' => 'UpdateLeaveController@addLeaveApp']);

    Route::post('cancel',['as'=>'leave/cancel','uses' => 'UpdateLeaveController@cancelLeave']);

    Route::get('pendingLeaveIndex',['as'=>'leave/pendingLeaveIndex','uses' => 'PendingLeaveController@index']);

    Route::get('dateleaveReportIndex',['as'=>'leave/dateleaveReportIndex','uses' => 'LeaveReportController@index']);

    Route::get('dateRangeLeaveStatusPrint',['as'=>'leave/dateRangeStatusPrint','uses' => 'LeaveReportController@leaveStatusPrint']);
Route::get('leaveSummaryPrint',['as'=>'leave/leaveSummaryPrint','uses' => 'LeaveReportController@leaveSummaryPrint']);
    Route::get('empleaveReportIndex',['as'=>'leave/empleaveReportIndex','uses' => 'LeaveReportController@empLeaveReport']);

    // Route::get('report/department/print/{id}/{date}',['as'=>'attendance/report/department/print','uses' => 'Report\DateWiseAttendanceController@printdepartmentDetailsReport']);


    // Route::get('report/department/leave/{date}',['as'=>'attendance/report/leave','uses' => 'Report\DateWiseAttendanceController@inLeaveReport']);

});

Route::group(['prefix' => 'attendance', 'namespace' => 'Attendance', 'middleware' => ['auth']], function () {

    Route::get('holidayIndex',['as'=>'attendance/holidayIndex','uses' => 'HolidaySetupController@index']);
    Route::get('holidaysDataTable','HolidaySetupController@holidaysData'); // Data Table Roure
    Route::post('publicHoliday/save',['as'=>'publicHoliday/save','uses' => 'HolidaySetupController@create']);

    Route::get('manualIndex',['as'=>'attendance/manualIndex','uses' => 'ManualAttendanceController@index']);
    Route::post('manualPost',['as'=>'attendance/manualPost','uses' => 'ManualAttendanceController@create']);

    Route::get('updateIndex',['as'=>'attendance/updateIndex','uses' => 'UpdateAttendanceController@index']);

    Route::post('updatePost',['as'=>'attendance/updatePost','uses' => 'UpdateAttendanceController@update']);


    //On Duty Employee
    Route::get('onDutyIndex',['as'=>'attendance/onDutyIndex','uses' => 'OnDutyEmployeeController@index']);

    Route::post('onDutyIndex',['as'=>'attendance/onDutyIndex','uses' => 'OnDutyEmployeeController@create']);

    Route::post('deleteOnDuty',['as'=>'attendance/deleteOnDuty','uses' => 'OnDutyEmployeeController@destroy']);

    //Informed Absent Employee
    Route::get('informedAbsentIndex',['as'=>'attendance/informedAbsentIndex','uses' => 'InformedAbsentController@index']);

    Route::post('informedAbsentSave',['as'=>'attendance/informedAbsentSave','uses' => 'InformedAbsentController@create']);    

    Route::post('deleteAbsentEmployee',['as'=>'attendance/deleteAbsentEmployee','uses' => 'InformedAbsentController@destroy']);


    //Process Route

    Route::get('processIndex',['as'=>'attendance/processIndex','uses' => 'AttendanceProcessController@index']);
//    Route::get('leaveMasterDataTable','AttendanceProcessController@trainingData'); // Data Table Roure
    Route::post('create',['as'=>'attendance/create','uses' => 'AttendanceProcessController@create']);


//    Report

    Route::get('dateReportIndex',['as'=>'attendance/dateReportIndex','uses' => 'Report\DateWiseAttendanceController@index']);

    Route::get('departmentDailyReportIndex',['as'=>'attendance/departmentDailyReportIndex','uses' => 'Report\DateWiseAttendanceController@departmentDailyReport']);

    Route::get('dateShiftReportIndex',['as'=>'attendance/dateShiftReportIndex','uses' => 'Report\DateWiseAttendanceController@dateShiftReport']);

    Route::get('dateShiftPunchReportIndex',['as'=>'attendance/dateShiftPunchReportIndex','uses' => 'Report\DateWiseAttendanceController@dateShiftPunchReport']);

    Route::get('report/department/{id}/{date}',['as'=>'attendance/report/department','uses' => 'Report\DateWiseAttendanceController@departmentDetailsReport']);

    Route::get('report/department/print/{id}/{date}',['as'=>'attendance/report/department/print','uses' => 'Report\DateWiseAttendanceController@printdepartmentDetailsReport']);


    Route::get('report/department/leave/{date}',['as'=>'attendance/report/leave','uses' => 'Report\DateWiseAttendanceController@inLeaveReport']);



    Route::get('dateRangeReportIndex',['as'=>'attendance/dateRangeReportIndex','uses' => 'Report\DateRangeAttendanceController@index']);
    Route::get('report/employee/{id}/{from}/{to}',['as'=>'attendance/report/employee','uses' => 'Report\DateRangeAttendanceController@employeeRange']);
    Route::get('print/employee/{id}/{from}/{to}',['as'=>'attendance/print/employee','uses' => 'Report\DateRangeAttendanceController@printEmployeeRange']);

    Route::get('dateRangeStatusPrint',['as'=>'attendance/dateRangeStatusPrint','uses' => 'Report\DateRangeAttendanceController@statusPrint']);

    
 Route::get('dateRangePunchStatus',['as'=>'attendance/dateRangePunchStatus','uses' => 'Report\DateRangeAttendanceController@punchStatus']);



    Route::get('dailyAttendanceStatusIndex',['as'=>'attendance/dailyAttendanceStatusIndex','uses' => 'Report\DailyAttendanceStatusController@index']);

    Route::get('daily/{status}/{id}',['as'=>'attendance/status/leave','uses' => 'Report\DailyAttendanceStatusController@statusPrint']);

    Route::get('dateRangeDepartmentReportIndex',['as'=>'attendance/dateRangeDepartmentReportIndex','uses' => 'Report\DateRangeAttendanceController@departmentAttendece']);

    Route::get('dateWiseNotPresent',['as'=>'attendance/notPresent/leave','uses' => 'Report\DailyAttendanceStatusController@statusNotAttendent']);



});


//Over Time

Route::group(['prefix' => 'overtime', 'namespace' => 'Overtime', 'middleware' => ['auth']], function () {

    //  Auth Privillege Route

    Route::get('setupIndex',['as'=>'overtime/setupIndex','uses' => 'OvertimeSetupController@index']);
    Route::post('overtimePost',['as'=>'overtime/overtimePost','uses' => 'OvertimeSetupController@create']);

    Route::post('deleteOvertime',['as'=>'overtime/deleteOvertime','uses' => 'OvertimeSetupController@delete']);


    Route::get('updateIndex',['as'=>'overtime/updateIndex','uses' => 'UpdateOvertimeController@index']);
    Route::post('updateIndex',['as'=>'overtime/updateIndex','uses' => 'UpdateOvertimeController@update']);

    Route::get('approveIndex',['as'=>'overtime/approveIndex','uses' => 'ApproveOvertimeController@index']);
    Route::post('approve',['as'=>'overtime/approve','uses' => 'ApproveOvertimeController@create']);


    Route::get('calculationIndex',['as'=>'overtime/calculationIndex','uses' => 'MonthlyOvertimeCalculationController@index']);
    Route::post('calculate',['as'=>'overtime/calculate','uses' => 'MonthlyOvertimeCalculationController@update']);

    Route::post('overtimeReject',['as'=>'overtime/overtimeReject','uses' => 'MonthlyOvertimeCalculationController@reject']);


    Route::get('dateRangeOvertimeReportIndex',['as'=>'overtime/dateRangeReportIndex','uses' => 'Report\DateRangeOvertimeReportController@index']);

    Route::get('employeeMonthlyOvertimeIndex',['as'=>'overtime/employeeMonthlyOvertimeIndex','uses' => 'Report\DateRangeOvertimeReportController@empmonthlyovertime']);


    Route::get('dateRangeApproveRejectReportIndex',['as'=>'overtime/dateRangeApproveRejectReportIndex','uses' => 'Report\DateRangeOvertimeReportController@approveRejectOvertime']);

    Route::get('allDeptReportIndex',['as'=>'overtime/allDeptReportIndex','uses' => 'Report\DateRangeOvertimeReportController@allDeptReport']);


    Route::get('getPunchData',['as'=>'overtime/getPunchData','uses' => 'MonthlyOvertimeCalculationController@getPunchData']);

    Route::get('employeeOvertimeIndex',['as'=>'overtime/employeeOvertimeIndex','uses' => 'Report\EmployeeOvertimeController@index']);

});

//Apprisal

Route::group(['prefix' => 'apprisal', 'namespace' => 'Apprisal', 'middleware' => ['auth']], function () {

    //  Auth Privillege Route

    Route::get('setupIndex',['as'=>'apprisal/setupIndex','uses' => 'ApprisalController@index']);
    
});



Route::group(['prefix' => 'payroll', 'namespace' => 'Payroll\Salary', 'middleware' => ['auth']], function () {


    Route::get('salarySetupIndex',['as'=>'payroll/salarySetupIndex','uses' => 'SalarySetupController@index']);


    Route::get('salaryProcessIndex',['as'=>'payroll/salaryProcessIndex','uses' => 'SalaryProcessController@index']);
    Route::post('salaryProcess',['as'=>'payroll/salaryProcess','uses' => 'SalaryProcessController@process']);

    Route::get('salaryHeldupIndex',['as'=>'payroll/salaryHeldupIndex','uses' => 'UpdateSalaryController@Heldupindex']);


    Route::get('salaryUpdateIndex',['as'=>'payroll/salaryUpdateIndex','uses' => 'UpdateSalaryController@index']);

    Route::get('prevSalaryIndex',['as'=>'payroll/prevSalaryIndex','uses' => 'PrevSalaryController@index']);

    Route::get('MonthlySalaryDataTable','UpdateSalaryController@salaryData'); // Data Table Roure

    Route::get('editSalary/{id}',['as'=>'payroll/editSalary','uses' => 'UpdateSalaryController@editIndex']);
    
    Route::post('editSalary/updateSalary',['as'=>'editSalary/updateSalary','uses' => 'UpdateSalaryController@update']);

    Route::get('salaryReportIndex',['as'=>'payroll/salaryReportIndex','uses' => 'SalaryReportController@index']);

    Route::get('bonusReportIndex',['as'=>'payroll/bonusReportIndex','uses' => 'SalaryReportController@BonusReport']);

    Route::get('bonusTobankIndex',['as'=>'payroll/bonusTobankIndex','uses' => 'SalaryReportController@bonusTobankIndex']);

    Route::get('cashbonusIndex',['as'=>'payroll/cashbonusIndex','uses' => 'SalaryReportController@cashbonusIndex']);

    Route::get('empSalaryDataTable/{id}','SalarySetupController@employeeData'); // Data Table Roure
    Route::get('bankLetterIndex',['as'=>'payroll/bankLetterIndex','uses' => 'SalaryReportController@bankLetterIndex']);

    Route::get('overtimeReportIndex',['as'=>'payroll/overtimeReportIndex','uses' => 'SalaryReportController@overtimeReportIndex']);

    Route::get('heldupIndex',['as'=>'payroll/heldupIndex','uses' => 'SalaryReportController@heldupIndex']);

    Route::get('CashsalaryReportIndex',['as'=>'payroll/CashsalaryReportIndex','uses' => 'SalaryReportController@CashsalaryReport']);

    Route::get('arearSetupIndex',['as'=>'payroll/arearSetupIndex','uses' => 'ArearSetupController@index']);
    Route::post('arearSetupPost',['as'=>'payroll/arearSetupPost','uses' => 'ArearSetupController@create']);

    Route::post('deleteArear',['as'=>'payroll/deleteArear','uses' => 'ArearSetupController@destroy']);

    Route::get('incrementSetupIndex',['as'=>'payroll/incrementSetupIndex','uses' => 'IncrementSetupController@index']);
    Route::post('incrementSetup',['as'=>'payroll/incrementSetup','uses' => 'IncrementSetupController@create']);

    Route::post('deleteIncrement',['as'=>'payroll/deleteIncrement','uses' => 'IncrementSetupController@destroy']);





//    Route::get('arearSetupIndex',['as'=>'payroll/arearSetupIndex','uses' => 'SalarySetupController@arear']);

    Route::get('advanceSetupIndex',['as'=>'payroll/advanceSetupIndex','uses' => 'SalarySetupController@advance']);

    Route::get('food&otherSetupIndex',['as'=>'payroll/food&otherSetupIndex','uses' => 'SalarySetupController@food']);




    
    Route::get('employeeDataforAdvance/{id}','SalarySetupController@employeeDataforAdvance');

    Route::get('employeeDataforFood/{id}','SalarySetupController@employeeDataforFood');

    Route::post('salary-setup/save',['as'=>'payroll/salary/save','uses' => 'SalarySetupController@create']);

    Route::post('advance-setup/save',['as'=>'payroll/advance/save','uses' => 'SalarySetupController@createadvance']);

     Route::post('food-setup/save',['as'=>'payroll/food/save','uses' => 'SalarySetupController@Foodentry']);

     Route::post('arear-setup/save',['as'=>'payroll/arear/save','uses' => 'SalarySetupController@createarear']);

});

Route::group(['prefix' => 'payroll', 'namespace' => 'Payroll\Increment', 'middleware' => ['auth']], function () {

    Route::get('incrementSetupIndex',['as'=>'payroll/incrementSetupIndex','uses' => 'IncrementSetupController@index']);
    Route::post('incrementSetup',['as'=>'payroll/incrementSetup','uses' => 'IncrementSetupController@create']);

    Route::post('deleteIncrement',['as'=>'payroll/deleteIncrement','uses' => 'IncrementSetupController@destroy']);


});



Route::group(['prefix' => 'bioData', 'namespace' => 'External\Biodata', 'middleware' => ['auth']], function () {

    //Circular Route

    Route::get('circularIndex',['as'=>'bioData/circularIndex','uses' => 'CircularController@index']);
    Route::get('circularDataTable','CircularController@circularData');
    Route::post('circular/save',['as'=>'bioData/circular/save','uses' => 'CircularController@create']);
    Route::post('circular/update',['as'=>'bioData/circular/update','uses' => 'CircularController@update']);


    //Training Route

    Route::get('applicantIndex',['as'=>'bioData/applicantIndex','uses' => 'BiodataCollectionController@index']);
    Route::post('save',['as'=>'biodata/save','uses' => 'BiodataCollectionController@create']);


    Route::get('updateIndex',['as'=>'bioData/updateIndex','uses' => 'BiodataCollectionController@updateIndex']);
    Route::post('update',['as'=>'bioData/update','uses' => 'BiodataCollectionController@update']);

//    Route::post('payroll/update',['as'=>'payroll/update','uses' => 'AddTrainingController@update']);

    Route::get('appointIndex',['as'=>'bioData/appointIndex','uses' => 'AppointmentController@index']);
    Route::post('appointmentSave',['as'=>'bioData/appointmentsave','uses' => 'AppointmentController@create']);

    Route::get('searchIndex',['as'=>'bioData/searchIndex','uses' => 'BiodataCollectionController@search']);

    Route::get('print/english/{id}',['as'=>'bioData/print/english','uses' => 'AppointmentController@printEngAppointLetter']);
    Route::get('print/bangla/{id}',['as'=>'bioData/print/bangla','uses' => 'AppointmentController@printBangAppointLetter']);


//    roster save

});




//NOTICE BOARD RELATED ROUTE

Route::group(['prefix' => 'notice', 'namespace' => 'Notice', 'middleware' => ['auth']], function () {

    //Training Route

    Route::get('createNoticeIndex',['as'=>'notice/createNoticeIndex','uses' => 'CreateNoticeController@index']);
    Route::get('noticeDataTable','CreateNoticeController@noticeData'); // Data Table Roure
    Route::post('newNoticeSave',['as'=>'notice/newNoticeSave','uses' => 'CreateNoticeController@create']);
    Route::post('saveNoticeFile',['as'=>'notice/saveNoticeFile','uses' => 'CreateNoticeController@saveFile']);

    Route::get('view/{id}',['as'=>'notice/view','uses' => 'CreateNoticeController@viewFile']);

});




//MIS RELATED ROUTE

Route::group(['prefix' => 'doctorReport', 'namespace' => 'Report\Doctor', 'middleware' => ['auth']], function () {

    //Training Route

    Route::get('doctorServiceIndex',['as'=>'doctorReport/doctorServiceIndex','uses' => 'DoctorServiceReportController@index']);
    Route::get('referDoctorServiceIndex',['as'=>'doctorReport/referDoctorServiceIndex','uses' => 'ReferDoctorServiceAdviceController@index']);

});


//MIS RELATED ROUTE

Route::group(['prefix' => 'foodBeverages', 'namespace' => 'Hospitality', 'middleware' => ['auth']], function () {

    //Training Route

    Route::get('monthlyFoodChargeIndex',['as'=>'foodBeverages/monthlyFoodChargeIndex','uses' => 'MonthlyFoodChargeController@index']);
    Route::get('employeeFoodChargeData',['as'=>'foodBeverages/employeeFoodChargeData','uses' => 'MonthlyFoodChargeController@foodChargeData']);
    Route::post('foodCharge/save',['as'=>'foodBeverages/foodCharge/save','uses' => 'MonthlyFoodChargeController@create']);
    Route::get('approveFoodChargeIndex',['as'=>'foodBeverages/approveFoodChargeIndex','uses' => 'ApproveFoodChargeController@index']);
    Route::get('approveFoodCharge',['as'=>'foodBeverages/approveFoodCharge','uses' => 'ApproveFoodChargeController@approve']);

    Route::get('printFoodChargeIndex',['as'=>'foodBeverages/printFoodChargeIndex','uses' => 'PrintFoodChargeController@index']);


});



Route::group(['prefix' => 'ot', 'namespace' => 'ot', 'middleware' => ['auth']], function () {

    //OT Route

    Route::get('otIndex',['as'=>'ot/otIndex','uses' => 'OtController@index']);
    Route::get('otDisplayIndex',['as'=>'ot/otDisplayIndex','uses' => 'OtController@otDisplayIndex']);
    Route::get('otReporIndex',['as'=>'ot/otReporIndex','uses' => 'OtController@otReport']);
    Route::post('otSetupPost',['as'=>'ot/otSetupPost','uses' => 'OtController@create']);

    Route::post('otStatusChange',['as'=>'ot/otStatusChange','uses' => 'OtController@otStart']);
    Route::post('otAttendentCall',['as'=>'ot/otAttendentCall','uses' => 'OtController@otCallAttendent']);
    Route::post('otComplete',['as'=>'ot/otComplete','uses' => 'OtController@otComplete']);


});

Route::group(['namespace' => 'Phone','middleware' => ['auth']], function () {

    Route::get('phone/phoneIndex',['as'=>'phone/phoneIndex','uses' => 'PhoneController@index']);
    Route::get('phone/phoneDataTable',['as'=>'phone/phoneDataTable','uses' => 'PhoneController@phoneData']);
    Route::post('Phone/save',['as'=>'phone/save','uses' => 'PhoneController@create']);
    Route::post('Phone/update',['as'=>'phone/update','uses' => 'PhoneController@update']);

  //  Route::post('phone/update',function () { return $request->all(); });

    Route::get('phone/report/phoneReportIndex',['as'=>'phone/phoneReportIndex','uses' => 'PhoneController@reportIndex']);

    Route::get('phone/report/department',['as'=>'phone/report/department','uses' => 'PhoneController@departmentreport']);

    Route::get('phone/report/location',['as'=>'phone/report/location','uses' => 'PhoneController@locationreport']);
});

