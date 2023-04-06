<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Module;
// Lib Include 
require_once(DIR_EXTENSION.'/tmdmultivendor/system/library/tmd/system.php');
// Lib Include
class TmdVendor extends \Opencart\System\Engine\Controller {
	public function index(): void {
		$this->registry->set('tmd', new  \Tmdmultivendor\System\Library\Tmd\System($this->registry));
		$keydata=array(
		'code'=>'tmdkey_tmdvendor',
		'eid'=>'MzM5MjA=',
		'route'=>'extension/tmdmultivendor/module/tmdvendor',
		);
		$tmdvendor=$this->tmd->getkey($keydata['code']);
		$data['getkeyform']=$this->tmd->loadkeyform($keydata);
		
		$data['HTTP_CATALOG']=HTTP_CATALOG;
		$this->load->language('extension/tmdmultivendor/module/tmdvendor');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->setTitle($this->language->get('heading_title1'));
		
		if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];
		
			unset($this->session->data['warning']);
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/module/tmdvendor', 'user_token=' . $this->session->data['user_token'])
		];

		$data['save'] = $this->url->link('extension/tmdmultivendor/module/tmdvendor|save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		$data['module_tmdvendor_textcolor'] = $this->config->get('module_tmdvendor_textcolor');
		$data['module_tmdvendor_bgcolor'] = $this->config->get('module_tmdvendor_bgcolor');
		$data['module_tmdvendor_imgwidth'] = $this->config->get('module_tmdvendor_imgwidth');
		$data['module_tmdvendor_imgheight'] = $this->config->get('module_tmdvendor_imgheight');
		$data['module_tmdvendor_imagetype'] = $this->config->get('module_tmdvendor_imagetype');	
		$data['module_tmdvendor_status'] = $this->config->get('module_tmdvendor_status');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/module/tmdvendor', $data));
	}

	public function install():void {
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->model_extension_tmdmultivendor_vendor_vendor->install();
		
		// Fix permissions
		$this->load->model('user/user_group');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/module/enquiry');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/module/enquiry');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/module/latestseller');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/module/latestseller');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/module/tmdvendor');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/module/tmdvendor');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/module/vendorfeatured');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/module/vendorfeatured');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/vendor');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/vendor');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/login');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/login');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/store');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/store');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/shipping');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/shipping');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/enquiry');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/enquiry');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/shiftproduct');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/shiftproduct');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/review_report');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/review_report');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/review_field');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/review_field');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/review');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/review');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/report');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/report');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/product');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/product');

		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/report');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/report');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/notification');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/notification');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/mail');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/mail');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/keysubmit');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/keysubmit');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/income');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/income');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/import');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/import');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/export');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/export');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/enquiry');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/enquiry');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/commission_report');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/commission_report');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/commission');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/commission');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/chat');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/chat');
		
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/shippingcost');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/shippingcost');
		
		// Add startup to catalog
			$startup_data = [
				'code'        => 'vendor',
				'description' => 'vendor extension',
				'action'      => 'catalog/extension/tmdmultivendor/startup/vendor',
				'status'      => 1,
				'sort_order'  => 2
			];

			// Add startup for admin
			$this->load->model('setting/startup');
			$this->model_setting_startup->addStartup($startup_data);

		$this->load->model('setting/event');
		
		// Tmd multivendor Event
		$this->model_setting_event->deleteEventByCode('tmd_modulevender_product');
		$eventrequest=[
					'code'=>'tmd_modulevender_product',
					'description'=>'TMD Multivendor Product',
					'trigger'=>'catalog/view/product/product/before',
					'action'=>'extension/tmdmultivendor/module/tmdvendor|productposition',
					'status'=>'1',
					'sort_order'=>'1',
				];
				
		if(VERSION=='4.0.0.0')
		{
		$this->model_setting_event->addEvent('tmd_modulevender_product', 'TMD Multivendor Product', 'catalog/view/product/product/before', 'extension/tmdmultivendor/module/tmdvendor|productposition', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
	
		// TMD admin menu events
		$this->model_setting_event->deleteEventByCode('tmd_modulevender');
		$eventrequest=[
					'code'=>'tmd_modulevender',
					'description'=>'TMD multivendor admin menus',
					'trigger'=>'admin/view/common/column_left/before',
					'action'=>'extension/tmdmultivendor/module/tmdvendor|menu',
					'status'=>'1',
					'sort_order'=>'1',
				];
				
		if(VERSION=='4.0.0.0')
		{
		$this->model_setting_event->addEvent('tmd_modulevender', 'TMD multivendor admin menus', 'admin/view/common/column_left/before', 'extension/tmdmultivendor/module/tmdvendor|menu', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
		
		//admin layout Event
		$this->model_setting_event->deleteEventByCode('module_admin_layout');
        $eventrequest=[
                    'code'=>'module_admin_layout',
                    'description'=>'TMD multivendor admin Positions',
                    'trigger'=>'admin/view/design/layout_form/before',
                    'action'=>'extension/tmdmultivendor/module/tmdvendor|layoutnew',
                    'status'=>'1',
                    'sort_order'=>'1',
                ];
                
        if(VERSION=='4.0.0.0')
        {
        $this->model_setting_event->addEvent('module_admin_layout', 'TMD multivendor admin Positions', 'admin/view/design/layout_form/before', 'extension/tmdmultivendor/module/tmdvendor|layoutnew', true, 1);
        }else{
            $this->model_setting_event->addEvent($eventrequest);
        }
		
		// Admin Product From events
		$this->model_setting_event->deleteEventByCode('tmd_productedit');
		
		$eventrequest=[
					'code'=>'tmd_productedit',
					'description'=>'TMD Product Edit',
					'trigger'=>'admin/view/catalog/product_form/before',
					'action'=>'extension/tmdmultivendor/module/tmdvendor|productedit',
					'status'=>'1',
					'sort_order'=>'1',
				];
		if(VERSION=='4.0.0.0')
		{		
		$this->model_setting_event->addEvent('tmd_productedit', 'TMD Product Edit', 'admin/view/catalog/product_form/before','extension/tmdmultivendor/module/tmdvendor|productedit', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
		
		// Front header menu events 
		$this->model_setting_event->deleteEventByCode('tmd_front_headermenu');
		$eventrequest=[
					'code'=>'tmd_front_headermenu',
					'description'=>'TMD Front Header Menu',
					'trigger'=>'catalog/view/common/header/before',
					'action'=>'extension/tmdmultivendor/module/tmdvendor|headerevent',
					'status'=>'1',
					'sort_order'=>'1',
				];
				
		if(VERSION=='4.0.0.0')
		{
		$this->model_setting_event->addEvent('tmd_front_headermenu', 'TMD Front Header Menu', 'catalog/view/common/header/before','extension/tmdmultivendor/module/tmdvendor|headerevent', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
		
		// Admin Product From Add Model events 
		$this->model_setting_event->deleteEventByCode('tmd_modelproductadd');
		$eventrequest=[
					'code'=>'tmd_modelproductadd',
					'description'=>'TMD Product add model',
					'trigger'=>'admin/model/catalog/product/addProduct/after',
					'action'=>'extension/tmdmultivendor/module/tmdvendor|productmodeladd',
					'status'=>'1',
					'sort_order'=>'1',
				];
		if(VERSION=='4.0.0.0')
		{
		$this->model_setting_event->addEvent('tmd_modelproductadd', 'TMD Product add model', 'admin/model/catalog/product/addProduct/after','extension/tmdmultivendor/module/tmdvendor|productmodeladd', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
		
		// Admin Product From edit Model events 
		$this->model_setting_event->deleteEventByCode('tmd_modelproductedit');
		$eventrequest=[
					'code'=>'tmd_modelproductedit',
					'description'=>'TMD Product edit model',
					'trigger'=>'admin/model/catalog/product/editProduct/before',
					'action'=>'extension/tmdmultivendor/module/tmdvendor|productmodeledit',
					'status'=>'1',
					'sort_order'=>'1',
				];
		if(VERSION=='4.0.0.0')
		{		
		$this->model_setting_event->addEvent('tmd_modelproductedit', 'TMD Product edit model', 'admin/model/catalog/product/editProduct/before','extension/tmdmultivendor/module/tmdvendor|productmodeledit', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
		
		// Admin sale order events
		$this->model_setting_event->deleteEventByCode('tmd_saleorderinfoedit');
		
		$eventrequest=[
					'code'=>'tmd_saleorderinfoedit',
					'description'=>'TMD sale Edit',
					'trigger'=>'admin/view/sale/order_info/before',
					'action'=>'extension/tmdmultivendor/module/tmdvendor|saleorderedit',
					'status'=>'1',
					'sort_order'=>'1',
				];
		if(VERSION=='4.0.0.0')
		{		
		$this->model_setting_event->addEvent('tmd_saleorderinfoedit', 'TMD Product Edit', 'admin/view/sale/order_info/before','extension/tmdmultivendor/module/tmdvendor|saleorderedit', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
		
		// mail events
		$this->model_setting_event->deleteEventByCode('tmd_ordermail');
		
		$eventrequest=[
					'code'=>'tmd_ordermail',
					'description'=>'TMD Order Mail',
					'trigger'=>'catalog/view/mail/order_add/before',
					'action'=>'extension/tmdmultivendor/module/tmdvendor|mailorder',
					'status'=>'1',
					'sort_order'=>'1',
				];
		if(VERSION=='4.0.0.0')
		{		
		$this->model_setting_event->addEvent('tmd_ordermail', 'TMD Order Mail', 'catalog/view/mail/order_add/before','extension/tmdmultivendor/module/tmdvendor|mailorder', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
		
		// order info events
		$this->model_setting_event->deleteEventByCode('tmd_orderinfo');
		
		$eventrequest=[
					'code'=>'tmd_orderinfo',
					'description'=>'TMD Order Info',
					'trigger'=>'catalog/view/account/order_info/before',
					'action'=>'extension/tmdmultivendor/module/tmdvendor|orderinfo',
					'status'=>'1',
					'sort_order'=>'1',
				];
		if(VERSION=='4.0.0.0')
		{		
		$this->model_setting_event->addEvent('tmd_orderinfo', 'TMD Order Info', 'catalog/view/account/order_info/before','extension/tmdmultivendor/module/tmdvendor|orderinfo', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
		
		// order List events
		$this->model_setting_event->deleteEventByCode('tmd_orderlist');
		
		$eventrequest=[
					'code'=>'tmd_orderlist',
					'description'=>'TMD Order List',
					'trigger'=>'catalog/view/account/order_list/before',
					'action'=>'extension/tmdmultivendor/module/tmdvendor|orderlist',
					'status'=>'1',
					'sort_order'=>'1',
				];
		if(VERSION=='4.0.0.0')
		{		
		$this->model_setting_event->addEvent('tmd_orderlist', 'TMD Order List', 'catalog/view/account/order_list/before','extension/tmdmultivendor/module/tmdvendor|orderlist', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
		
		// checkout cart events
		$this->model_setting_event->deleteEventByCode('tmd_checkoutcart');
		
		$eventrequest=[
					'code'=>'tmd_checkoutcart',
					'description'=>'TMD checkout cart',
					'trigger'=>'catalog/view/checkout/cart_list/before',
					'action'=>'extension/tmdmultivendor/module/tmdvendor|checkoutcart',
					'status'=>'1',
					'sort_order'=>'1',
				];
		if(VERSION=='4.0.0.0')
		{		
		$this->model_setting_event->addEvent('tmd_checkoutcart', 'TMD checkout cart', 'catalog/view/checkout/cart_list/before','extension/tmdmultivendor/module/tmdvendor|checkoutcart', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
		
		// checkout confirm events
		$this->model_setting_event->deleteEventByCode('tmd_checkoutconfirm');
		
		$eventrequest=[
					'code'=>'tmd_checkoutconfirm',
					'description'=>'TMD checkout confirm',
					'trigger'=>'catalog/view/checkout/confirm/before',
					'action'=>'extension/tmdmultivendor/module/tmdvendor|checkoutconfirm',
					'status'=>'1',
					'sort_order'=>'1',
				];
		if(VERSION=='4.0.0.0')
		{		
		$this->model_setting_event->addEvent('tmd_checkoutconfirm', 'TMD checkout confirm', 'catalog/view/checkout/confirm/before','extension/tmdmultivendor/module/tmdvendor|checkoutconfirm', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
		
		// common cart events
		$this->model_setting_event->deleteEventByCode('tmd_commoncart');
		
		$eventrequest=[
					'code'=>'tmd_commoncart',
					'description'=>'TMD common cart',
					'trigger'=>'catalog/view/common/cart/before',
					'action'=>'extension/tmdmultivendor/module/tmdvendor|commoncart',
					'status'=>'1',
					'sort_order'=>'1',
				];
		if(VERSION=='4.0.0.0')
		{		
		$this->model_setting_event->addEvent('tmd_commoncart', 'TMD common cart', 'catalog/view/common/cart/before','extension/tmdmultivendor/module/tmdvendor|commoncart', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
		
		// account order events
		$this->model_setting_event->deleteEventByCode('tmd_accountmodel');
		
		$eventrequest=[
					'code'=>'tmd_accountmodel',
					'description'=>'TMD account model order',
					'trigger'=>'catalog/view/account/order/before',
					'action'=>'extension/tmdmultivendor/module/tmdvendor|accountorder',
					'status'=>'1',
					'sort_order'=>'1',
				];
		if(VERSION=='4.0.0.0')
		{		
		$this->model_setting_event->addEvent('tmd_accountmodel', 'TMD account model order', 'catalog/view/account/order/before','extension/tmdmultivendor/module/tmdvendor|accountorder', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
		
		// Front cart events 
		$this->model_setting_event->deleteEventByCode('tmd_getproducts');
		$eventrequest=[
					'code'=>'tmd_getproducts',
					'description'=>'TMD Checkout Cart',
					'trigger'=>'catalog/model/checkout/cart/getProducts/after',
					'action'=>'extension/tmdmultivendor/startup/vendor|checkoutcart',
					'status'=>'1',
					'sort_order'=>'1',
				];
				
		if(VERSION=='4.0.0.0')
		{
		$this->model_setting_event->addEvent('tmd_getproducts', 'TMD Checkout Cart', 'catalog/model/checkout/cart/getProducts/after','extension/tmdmultivendor/startup/vendor|checkoutcart', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}
		
// Front Add order events 
		$this->model_setting_event->deleteEventByCode('tmd_confirmheckoutorder');
		$eventrequest=[
					'code'=>'tmd_confirmheckoutorder',
					'description'=>'TMD Checkout Success',
					'trigger'=>'catalog/controller/checkout/success/before',
					'action'=>'extension/tmdmultivendor/startup/vendor|success',
					'status'=>'1',
					'sort_order'=>'1',
				];
				
		if(VERSION=='4.0.0.0')
		{
		$this->model_setting_event->addEvent('tmd_confirmheckoutorder', 'TMD Checkout Success', 'catalog/controller/checkout/success/before','extension/tmdmultivendor/startup/vendor|success', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}

// Front Delete order events 
		$this->model_setting_event->deleteEventByCode('tmd_deletecheckoutorder');
		$eventrequest=[
					'code'=>'tmd_deletecheckoutorder',
					'description'=>'TMD Delete Checkout Order',
					'trigger'=>'catalog/model/checkout/order/deleteOrder/after',
					'action'=>'extension/tmdmultivendor/startup/vendor|deleteOrder',
					'status'=>'1',
					'sort_order'=>'1',
				];
				
		if(VERSION=='4.0.0.0')
		{
		$this->model_setting_event->addEvent('tmd_deletecheckoutorder', 'TMD Delete Checkout Order', 'catalog/model/checkout/order/deleteOrder/after','extension/tmdmultivendor/startup/vendor|deleteOrder', true, 1);
		}else{
			$this->model_setting_event->addEvent($eventrequest);
		}

	}	
	
	public function uninstall():void {
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->model_extension_tmdmultivendor_vendor_vendor->uninstall();
		
		// Fix permissions
		$this->load->model('user/user_group');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/module/enquiry');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/module/enquiry');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/module/latestseller');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/module/latestseller');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/module/tmdvendor');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/module/tmdvendor');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/module/vendorfeatured');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/module/vendorfeatured');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/vendor');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/vendor');

			$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/store');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/store');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/shipping');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/shipping');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/enuiry');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/enuiry');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/shiftproduct');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/shiftproduct');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/review_report');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/review_report');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/review_field');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/review_field');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/review');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/review');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/report');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/report');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/product');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/product');

		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/report');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/report');
		
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/notification');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/notification');
		
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/mail');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/mail');
		
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/keysubmit');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/keysubmit');
		
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/income');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/income');
		
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/import');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/import');
		
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/export');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/export');
		
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/enquiry');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/enquiry');
		
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/commission_report');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/commission_report');
		
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/commission');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/commission');
		
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/chat');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/chat');
		
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/tmdmultivendor/vendor/shippingcost');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/tmdmultivendor/vendor/shippingcost');
		
		$this->load->model('setting/startup');

		$this->model_setting_startup->deleteStartupByCode('vendor');

		$this->load->model('setting/event');
		$this->model_setting_event->deleteEventByCode('tmd_modulevender_product');
		$this->model_setting_event->deleteEventByCode('tmd_modulevender');
		$this->model_setting_event->deleteEventByCode('module_admin_layout');
		$this->model_setting_event->deleteEventByCode('tmd_productedit');
		$this->model_setting_event->deleteEventByCode('tmd_front_headermenu');
		$this->model_setting_event->deleteEventByCode('tmd_modelproductadd');
		$this->model_setting_event->deleteEventByCode('tmd_modelproductedit');
		$this->model_setting_event->deleteEventByCode('tmd_saleorderinfoedit');
		$this->model_setting_event->deleteEventByCode('tmd_ordermail');
		$this->model_setting_event->deleteEventByCode('tmd_orderinfo');
		$this->model_setting_event->deleteEventByCode('tmd_orderlist');
		$this->model_setting_event->deleteEventByCode('tmd_checkoutcart');
		$this->model_setting_event->deleteEventByCode('tmd_checkoutconfirm');
		$this->model_setting_event->deleteEventByCode('tmd_commoncart');
		$this->model_setting_event->deleteEventByCode('accountorder');

	}
	
	public function layoutnew(string &$route, array &$args, mixed &$output): void {	
		$modulestatus=$this->config->get('module_tmdvendor_status');
		if(!empty($modulestatus)){
		 $template_buffer = $this->getTemplateBuffer($route,$output);
		
		 $layoutcode=file_get_contents(DIR_EXTENSION.'tmdmultivendor/admin/view/template/design/layout.twig');
		 
		 $args['text_column_inpro']='Column InProduct';
		
		$find='<table id="module-column-right" class="table table-bordered table-hover">';
		
		$replace=$layoutcode.'<table id="module-column-right" class="table table-bordered table-hover">';
		
		 $output = str_replace( $find, $replace, $template_buffer );
		 
		 $find="$('#module-column-left, #module-column-right, #module-content-top, #module-content-bottom').on('change', 'select[name*=\'code\']', function() {";
		 $replace="$('#module-column-left, #module-column-right, #module-content-top, #module-content-bottom, #module-column-inpro').on('change', 'select[name*=\'code\']', function() {"; 
		 $output = str_replace( $find, $replace, $output );
		}
		 
	}
	
	public function productedit(string &$route, array &$args, mixed &$output): void {	
		
		$args['entry_vendor'] = 'Seller';
		$args['help_vendor'] = '(Autocomplete)';
		
			/* 03-10-2019*/
		 	$this->load->model('extension/tmdmultivendor/vendor/vendor');
				
			if(isset($args['product_id'])) {									
			$vendorid_info=$this->model_extension_tmdmultivendor_vendor_vendor->getVendorid($args['product_id']);
			}
				
			if (isset($this->request->post['vendor_id'])) {
				$args['vendor_id'] = $this->request->post['vendor_id'];
				} elseif (isset($vendorid_info['vendor_id'])){
					$args['vendor_id'] = $vendorid_info['vendor_id'];
				} else {
					$args['vendor_id'] = '';
				}
			
				if(!empty($args['vendor_id'])){	
					
					$vendor_info=$this->model_extension_tmdmultivendor_vendor_vendor->getVendor($args['vendor_id']);
					if(isset($vendor_info['vname'])){
						$args['vendor']=$vendor_info['vname'];
					} else {
						$args['vendor']='';
					}
				} else {
					$args['vendor']='';
				} 
				
		/* 03-10-2019*/ 
	
		$template_buffer = $this->getTemplateBuffer($route,$output);
		$productseller=file_get_contents(DIR_EXTENSION.'tmdmultivendor/admin/view/template/vendor/productseller.twig'); 
		$find='<div id="tab-links" class="tab-pane">';
		$replace='<div id="tab-links" class="tab-pane">'.$productseller;
		$output = str_replace( $find, $replace, $template_buffer ); 
	}
	
	public function saleorderedit(string &$route, array &$args, mixed &$output): void {	
	
		$vlbles = $this->config->get('vendor_languages');	
		
		if(!empty($vlbles[$this->config->get('config_language_id')]['byseller'])) {
			$args['text_byseller']= $vlbles[$this->config->get('config_language_id')]['byseller'].': ';
		} else {			
			$args['text_byseller'] = 'By Seller';
		}
		
		$template_buffer = $this->getTemplateBuffer($route,$output);
		$find='<td class="text-start"><a href="index.php?route=catalog/product|form&user_token={{ user_token }}&product_id={{ order_product.product_id }}" target="_blank">{{ order_product.name }}</a>';
		$replace='<td class="text-start"><a href="index.php?route=catalog/product|form&user_token={{ user_token }}&product_id={{ order_product.product_id }}" target="_blank">{{ order_product.name }}</a>{% if order_product.sellername %}
					{{ text_byseller }} <a href="index.php?route=extension/tmdmultivendor/vendor/vendor|form&user_token={{ user_token }}&vendor_id={{ order_product.vendor_id }}"> {{ order_product.sellername }} </a>
				{% endif %}';
		$output = str_replace( $find, $replace, $template_buffer ); 
	}
	
	public function productmodeladd(string &$route, array &$args): void {
	$this->load->model('extension/tmdmultivendor/vendor/productseller');
	$product_id=model_extension_tmdmultivendor_vendor_productseller->getnewProductid()-1;
	$sellertab=$args[0];
	$this->model_extension_tmdmultivendor_vendor_productseller->saveProductSeller($product_id,$sellertab);
	}
	
	public function productmodeledit(string &$route, array &$args): void {	
		$product_id=$args[0];
		$sellertab=$args[1];
		$this->load->model('extension/tmdmultivendor/vendor/productseller');
		$this->model_extension_tmdmultivendor_vendor_productseller->saveProductSeller($product_id,$sellertab);
	}

	public function menu(string&$route, array&$args, mixed&$output):void {
		$modulestatus=$this->config->get('module_tmdvendor_status');
		if(!empty($modulestatus)){
			
		$this->load->language('extension/tmdmultivendor/module/tmdvendor');

		$tmdvendor = [];

		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/vendor')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_vendersetting'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/vendor|setting', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}

		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/vendor')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_vendermanage'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/vendor', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}

		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/commission')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_commission'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/commission', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}

		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/commission_report')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_commission_report'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/commission_report', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}

		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/product')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_product'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/product', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}

		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/report')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_order'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/report', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}
		
		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/review')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_review'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/review', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}
		
		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/review_field')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_review_field'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/review_field', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}

		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/income')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_income'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/income', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}
		
		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/mail')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_mail'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/mail', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}

		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/shipping')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_shipping_rate'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/shipping', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}


		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/enquiry')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_enquiry'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/enquiry', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}

		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/import')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_import'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/import', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}

		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/export')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_export'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/export', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}

		if ($this->user->hasPermission('access', 'extension/tmdmultivendor/vendor/shiftproduct')) {
			$tmdvendor[] = [
				'name'     => $this->language->get('text_shipping'),
				'href'     => $this->url->link('extension/tmdmultivendor/vendor/shiftproduct', 'user_token='.$this->session->data['user_token']),
				'children' => []
			];
		}
		
		if ($tmdvendor) {
			$args['menus'][] = [
				'id'       => 'menu-extension',
				'icon'     => 'fas fa-users',
				'name'     => $this->language->get('text_vender'),
				'href'     => '',
				'children' => $tmdvendor
			];
		}
		}
	}
	
	protected function isAdmin() {
		return defined( 'DIR_CATALOG' ) ? true : false;
	}
	
	protected function getTemplateBuffer( $route, $event_template_buffer ) {
		// if there already is a modified template from view/*/before events use that one
		if ($event_template_buffer) {
			return $event_template_buffer;
		}

		// load the template file (possibly modified by ocmod and vqmod) into a string buffer
		if ($this->isAdmin()) {
			$dir_template = DIR_TEMPLATE;
		} else {
			if ($this->config->get('config_theme') == 'default') {
				$theme = $this->config->get('theme_default_directory');
			} else {
				$theme = $this->config->get('config_theme');
			}
			$dir_template = DIR_TEMPLATE . $theme . '/template/';
		}
		$template_file = $dir_template . $route . '.twig';
		if (file_exists
		
		( $template_file ) && is_file( $template_file )) {
			
			return file_get_contents( $template_file );
		}
		if ($this->isAdmin()) {
			trigger_error("Cannot find template file for route '$route'");
			exit;
		}
		 $dir_template = DIR_TEMPLATE . 'default/template/';
		 $template_file = $dir_template . $route . '.twig';
		if (file_exists( $template_file ) && is_file( $template_file )) {
			
			return file_get_contents( $template_file );
		}
		trigger_error("Cannot find template file for route '$route'");
		exit;
	}
	
	public function save(): void {
		$this->load->language('extension/tmdmultivendor/module/tmdvendor');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/module/tmdvendor')) {
			$json['error'] = $this->language->get('error_permission');
		}
		
		/*$tmdvendor=$this->config->get('tmdkey_tmdvendor');
		if (empty(trim($tmdvendor))) {			
		$json['error'] ='Module will Work after add License key!';
		}*/

		if (!$json) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('module_tmdvendor', $this->request->post);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function keysubmit() {
		$json = array(); 
		
      	if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$keydata=array(
			'code'=>'tmdkey_tmdvendor',
			'eid'=>'MzM5MjA=',
			'route'=>'extension/tmdmultivendor/module/tmdvendor',
			'moduledata_key'=>$this->request->post['moduledata_key'],
			);
			$this->registry->set('tmd', new  \Tmdmultivendor\System\Library\Tmd\System($this->registry));
		
            $json=$this->tmd->matchkey($keydata);       
		} 
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}