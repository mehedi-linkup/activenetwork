<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'Admin/login';

 
  
// admin controller 

// $route['admin'] = 'Admin/login';
$route['login-form'] = 'Admin/login_in';
$route['dashboard'] = 'Admin/dashboard';
$route['logout'] = 'Admin/logout';
$route['administator/(:any)'] = 'Admin/profile/$1';
$route['view-message/(:any)'] = 'Admin/view_message/$1';
$route['delete-message/(:any)'] = 'Admin/delete_message/$1';
$route['upro'] = 'Admin/upro';
$route['update-user'] = 'Admin/update_user';

$route['contact-us'] = 'Admin/contact_us';

//create admin
$route['create-admin']='Admin/create_admin';
$route['save-admin'] ='Admin/save_admin';
$route['update-admin'] ='Admin/update_admin';
$route['change-pass'] = 'Admin/change_pass';
$route['menu-access/(:any)'] = 'Admin/menu_access/$1';
$route['user-access']='Admin/user_access';
$route['user-delete']='Admin/user_delete';
//company profile
$route['company-profile'] ='Admin/company_profile';
$route['update-profile'] ='Admin/update_profile';

// emplyee controller

$route['get-employees'] = 'Emplyee/get_employees';
$route['employee'] = 'Emplyee/add_emplyee';
$route['save-emp'] = 'Emplyee/save';
$route['edit-emp'] = 'Emplyee/edit_emp';
$route['delete-emp'] = 'Emplyee/delete';

// area 
$route['get_area'] = 'Setting/getArea';
$route['area'] = 'Setting/add_area';
$route['officer-area'] = 'Setting/getOfficerwiseArea';
$route['save-area'] = 'Setting/save_area';
$route['edit-area'] = 'Setting/edit_area';
$route['delete-area'] = 'Setting/delete_area';

//month 

$route['month']='Setting/add_month';
$route['get_months']='Setting/getMonth';
$route['save-month']='Setting/save_month';
$route['edit-month']='Setting/edit_month';
$route['delete-month']='Setting/delete_month';
$route['month-status']='Setting/month_status';

//expense type 
$route['expense-type']='Setting/add_expense_type';
$route['save-expense-type']='Setting/save_expense_type';
$route['edit-expense-type']='Setting/edit_expense_type';
$route['delete-expense-type']='Setting/delete_expense_type';

//account

$route['account']='Setting/add_account';
$route['save-account']='Setting/save_account';
$route['edit-account']='Setting/edit_account';
$route['delete-account']='Setting/delete_account';

//expense

$route['expense']='Setting/add_expense';
$route['save-exp']='Setting/save_exp';
$route['edit-exp']='Setting/edit_exp';
$route['delete-exp']='Setting/delete_exp';
//salary
$route['salary']='Setting/add_salary';
$route['save-salary']='Setting/save_salary';
$route['edit-salary']='Setting/edit_salary';
$route['delete-salary']='Setting/delete_salary';

//transaction

$route['transaction']='Setting/add_transaction';
$route['save-transaction']='Setting/save_transaction';
$route['edit-transaction']='Setting/edit_transaction';
$route['delete-transaction']='Setting/delete_transaction';

$route['cash-view']='Setting/cash_view';
$route['cash-transaction']='Setting/cash_transaction';
//customer controller
$route['get-customers'] = 'Customer/get_customers';
$route['customer'] = 'Customer/add_customer';
$route['save-cust'] = 'Customer/save';
$route['edit-cust'] = 'Customer/edit';
$route['delete-cust'] = 'Customer/delete';
$route['change-type'] = 'Customer/change_type';
$route['change-wifi-type'] = 'Customer/change_wifi_type';

//bill-collection collection-entry
$route['single-cust'] = 'Customer/add_single_report';
$route['save-cust'] = 'Customer/save';
$route['edit-cust'] = 'Customer/edit';
$route['delete-cust'] = 'Customer/delete';

// collection-entry
$route['customer-choose'] = 'Collection/customer_choose';

$route['collection-entry'] = 'Collection/add_collection';
$route['save-collection'] = 'Collection/save_collection';
$route['edit-collection/(:any)'] = 'Collection/edit_colltection/$1';

$route['advance-payment']='Collection/customer_advance';
$route['payment-save']='Collection/payment_save';
$route['show-advance']='Collection/advance_payment';
$route['previous-due']='Collection/previous_due';
$route['get_collections'] = 'Collection/getCollection';
$route['cash-collection'] = 'Collection/cashCollection';
$route['get-collection-statement'] = 'Collection/getCashStatement';
// collection setting 
$route['collection-setting'] = 'Collection/collection_setting';
$route['view-customer'] = 'Setting/viewCustomer';
$route['save-setting'] = 'Setting/collection_save';
$route['month-recoed'] = 'Setting/month_recoed';
//single customer bill generate
$route['bill-generate'] = 'Setting/single_bill_generate';
$route['single-bill'] = 'Setting/single_bill_save';


$route['customer-payment'] = 'Setting/customer_service_payment';
$route['pay-customer'] = 'Setting/pay_customer';

//add bill collection
$route['bill-collection'] = 'Collection/add_bill_collection';
$route['save-bill'] = 'Collection/save_customer_bill';

$route['edit-collection'] = 'Collection/collection_edit';
$route['delete-collection'] = 'Collection/coll_delete';

//complaint
$route['complaint']='Setting/add_complaint';
$route['save-complaint']='Setting/save_complaint';
$route['edit-complaint']='Setting/edit_complaint';
$route['delete-complaint']='Setting/delete_complaint';
$route['change-status']='Setting/change_status';


// speed
$route['speed'] = 'Setting/speed';
$route['save-speed'] = 'Setting/saveSpeed';
$route['edit-speed'] = 'Setting/editSpeed';
$route['delete-speed'] = 'Setting/deleteSpeed';

// all report 

//customer report
$route['registration'] = 'Customer/registration';
$route['edit_registration/(:num)'] = 'Customer/editRegistration/$1';
$route['store_registration'] = 'Customer/storeRegistration';
$route['update_registration'] = 'Customer/updateRegistration';
$route['print_registration_form/(:num)'] = 'Customer/printRegistrationForm/$1';
$route['delete_registration/(:num)'] = 'Customer/deleteRegistration/$1';
$route['registration_record'] = 'Customer/registrationRecord';
$route['registration_record/(:any)'] = 'Customer/registrationRecord';
$route['due-bill'] = 'Report/due_report';
$route['customer-due'] = 'Report/customer_due';
// $route['single-cust-due'] = 'Report/single_cust_due';
$route['cust-due-report'] = 'Report/cust_due_report';
$route['due-print'] = 'Report/print_customer_due';
$route['due-list'] = 'Report/coll_due_list';
$route['collection-due'] = 'Report/coll_due';
$route['due-all-cust'] = 'Report/due_all_cust';
$route['due-customer-print'] = 'Report/print_all_customer_due';
$route['areawise-due'] = 'Report/areawise_due';
$route['areawise-cust-due'] = 'Report/areawise_cust_due';
$route['areawise-due-print'] = 'Report/areawise_due_print';
$route['areawise-paid-print'] = 'Report/areawise_paid_print';
$route['customer-ledger'] = 'Report/customerLedger';
$route['get-customer-ledger'] = 'Report/getCustomerLedger';

$route['payment-list'] = 'Report/payment_list';
$route['pay-all-cust'] = 'Report/payment_all_cust';
$route['pay-customer-print'] = 'Report/pay_customer_print';
$route['areawise-payment'] = 'Report/areawise_payment';
$route['areawise-cust-paid'] = 'Report/areawise_customer_payment';


$route['payment-bill'] = 'Report/payment_cust';
$route['cust-payment-report'] = 'Report/cust_payment_report';
$route['payment-print'] = 'Report/print_customer_payment';
$route['service-payment'] = 'Report/other_payment';
$route['ser-report'] = 'Report/service_report';
$route['service-print'] = 'Report/service_report_print';
$route['expense-report'] = 'Report/expense_report';
$route['exp-reports'] = 'Report/exp_reports';
$route['expense-print'] = 'Report/expense_print';

$route['all-transaction-report']='Report/all_transaction_report';
$route['all-report']='Report/all_report';

$route['customer-report'] = 'Report/customer_list';
$route['all-customer'] = 'Report/all_customer_report';
$route['customer-print'] = 'Report/customer_print';

$route['officer-collection']='Report/officer_collection';
$route['officer-coll-report']='Report/officer_coll_report';
$route['officer-print']='Report/officer_print';

$route['user-complaint']='Report/user_complaint';
$route['complaint-report']='Report/complaint_report';
$route['complaint-print']='Report/complaint_print';

$route['areawise-customer']='Report/areawise_customer';
$route['area-cust-list']='Report/area_cust_list';
//$route['print-customerlist']='Report/print_areawise_customer';
$route['print-customerlist/(:any)/(:any)']='Report/print_areawise_customer/$1/$2';
$route['advance-list']='Report/advance_list';
$route['advance-payment-list']='Report/advance_payment_ist';
$route['advance-print']='Report/advance_print';
$route['monthly-collection'] ='Report/monthlyReport';
$route['get-monthly-collection'] ='Report/getMonthlyCollection';

//payment invoice
$route['payment-invoice/(:any)'] = 'Report/payment_invoice/$1';

$route['payment-invoices']='Report/payment_invoices';
$route['invoice-data']='Report/invoice_data';
$route['print-invoice']='Report/print_invoice';
$route['print-invoice/(:any)/(:any)']='Report/print_invoices/$1/$2';

//collection record
$route['collection-record'] = 'Collection/collection_record';
$route['collection-records'] = 'Collection/collection_records';


// store module 

// category

$route['get-categories'] = 'Metarial/get_categories';
$route['category'] = 'Metarial/cateogry';
$route['save-category'] = 'Metarial/save_category';
$route['category-edit'] = 'Metarial/category_edit';
$route['category-delete'] = 'Metarial/category_delete';

// category
$route['unit'] = 'Metarial/unit';
$route['save-unit'] = 'Metarial/save_unit';
$route['unit-edit'] = 'Metarial/unit_edit';
$route['unit-delete'] = 'Metarial/unit_delete';

// product 
$route['get-products'] = 'Metarial/get_products';
$route['product'] = 'Metarial/product';
$route['save-product'] = 'Metarial/save_product';
$route['edit-product'] = 'Metarial/product_edit';
$route['delete-product'] = 'Metarial/product_delete';

//supplier 
$route['get-suppliers'] = 'Supplier/get_suppliers';
$route['supplier'] = 'Supplier/index';
$route['save-supplier'] = 'Supplier/save_supplier';
$route['edit-supplier'] = 'Supplier/edit_supplier';
$route['delete-supplier'] = 'Supplier/delete_supplier';
$route['supplier-due'] = 'Supplier/supplier_due';

//supplier-payment
$route['supplier-payment'] = 'Supplier/supplier_payment';
$route['get-supplier-payment'] = 'Supplier/get_supplier_payment';
$route['save-supplier-payment'] = 'Supplier/save_supplier_payment';
$route['update-supplier-payment'] = 'Supplier/update_supplier_payment';
$route['delete-supplier-payment'] = 'Supplier/delete_supplier_payment';

//purchase entry

$route['purchase'] = 'Purchase/index';
$route['save-purchase'] = 'Purchase/save_purchase';
$route['purchase-record'] = 'Purchase/purchase_record';
$route['purchase-report'] = 'Purchase/purchase_report';
$route['purchase-invoice/(:any)'] = 'Purchase/purchase_invoice/$1';

//consumption
$route['consumption'] = 'Consumption/index';
$route['generate-code'] = 'Consumption/invoice_code';
$route['save-consumption'] = 'Consumption/save_consumption';
$route['consumption-record'] = 'Consumption/consumption_record';
$route['consumption-report'] = 'Consumption/consumption_report';
$route['consumption-invoice/(:any)'] = 'Consumption/consumption_invoice/$1';

//stock 
$route['get-product-stock'] = 'Purchase/get_product_stock';
$route['stock'] = 'Purchase/stock';
$route['get-stock-report'] = 'Purchase/stock_record';


$route['404_override'] = '';
$route['translate_uri_dashes'] = true;
