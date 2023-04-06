<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class Dashboard extends \Opencart\System\Engine\Controller {
	// private $error = array();


	public function index() {
		if (!$this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', '', true));
		}
		/* 09 11 2019 */
		$vendorfolder=DIR_IMAGE . 'catalog/multivendor/'.$this->vendor->getId();
		if (!file_exists($vendorfolder)) {
		@mkdir($vendorfolder, 0777);
		}		
		/* 09 11 2019 */
		
		$this->load->language('extension/tmdmultivendor/vendor/dashboard');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('extension/tmdmultivendor/vendor/notification');
		
		$this->document->setTitle($this->language->get('heading_title1'));
				
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			// 'href' => $this->url->link('extension/tmdmultivendor/vendor/dashboard', '', true)
		);
				
		$data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('account/login', '', true));
		$data['heading_title'] 		= $this->language->get('heading_title');
		$data['text_yes'] 			= $this->language->get('text_yes');
		$data['text_no'] 			= $this->language->get('text_no');
		$data['text_select'] 		= $this->language->get('text_select');
		$data['text_none'] 			= $this->language->get('text_none');
		$data['text_loading'] 		= $this->language->get('text_loading');
		
		$data['button_continue'] 	= $this->language->get('button_continue');
		$data['button_upload'] 		= $this->language->get('button_upload');
		
		// if (isset($this->error['warning'])) {
		// 	$data['error_warning'] = $this->error['warning'];
		// } else {
		// 	$data['error_warning'] = '';
		// }
		
		$data['total'] = $this->load->controller('extension/tmdmultivendor/vendor/total');
		$data['totalorder'] = $this->load->controller('extension/tmdmultivendor/vendor/totalorder');
		$data['totalproduct'] = $this->load->controller('extension/tmdmultivendor/vendor/totalproduct');
		$data['latestorder'] = $this->load->controller('extension/tmdmultivendor/vendor/latestorder');
		// 09 06 2018 ///
		$data['mybalance'] = $this->load->controller('extension/tmdmultivendor/vendor/mybalance');
		// 09 06 2018 ///
		
/// Seller Notification Start //		
		// $data['sellernotifi']=array();
		// $sellernotifis = $this->model_vendor_notification->getSellerMessages();
	
		// foreach($sellernotifis as $sellernotifi){
		// 	$data['sellernotifi'][]=array(
		// 		'notification_id' => $sellernotifi['notification_id'],
		// 		'message' 		  => html_entity_decode($sellernotifi['message']),
		// 	);
			
		// }
	
				
		// $data['notifications']=array();
		// $notinfos = $this->model_vendor_notification->getSellerNotification();
		// foreach($notinfos as $notinfo){
		// 	$data['notifications'][]=array(
		// 		'notification_id' => $notinfo['notification_id'],
		// 		'message' 		  => html_entity_decode($notinfo['message']),
		// 	);
		// }
/// Seller Notification End //	
		
		$data['column_left'] 	= $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] 		= $this->load->controller('extension/tmdmultivendor/vendor/footer');
		$data['header'] 		= $this->load->controller('extension/tmdmultivendor/vendor/header');
		
		
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/dashboard', $data));
	}
		
}
