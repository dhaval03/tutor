<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class Changepassword extends \Opencart\System\Engine\Controller {
	
	    public function index() {
		if (!$this->vendor->isLogged()) {
			/* 23-07-2019 */
			$this->session->data['redirect'] = $this->url->link('extension/tmdmultivendor/vendor/changepassword', '', true);

			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', '', true));
			/* 23-07-2019 */
			
		}
		
		$this->load->language('extension/tmdmultivendor/vendor/changepassword');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		
		
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/changepassword', '', 'SSL')
		);
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('vendor/login', '', 'SSL'));
		$data['text_form'] = !isset($this->request->get['product_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		
		 $data['save'] = $this->url->link('extension/tmdmultivendor/vendor/changepassword|save', 'language=' . $this->config->get('config_language'));
		
		
		if (isset($this->request->post['oldpassword'])) {
			$data['oldpassword'] = $this->request->post['oldpassword'];
		} else {
			$data['oldpassword'] = '';
		}
		
		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}
		
		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}
		
				
		$data['column_left'] 	= $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['column_right'] 	= $this->load->controller('extension/tmdmultivendor/common/column_right');
		$data['content_top'] 	= $this->load->controller('extension/tmdmultivendor/common/content_top');
		$data['content_bottom'] = $this->load->controller('extension/tmdmultivendor/common/content_bottom');
		$data['footer'] 		= $this->load->controller('extension/tmdmultivendor/vendor/footer');
		$data['header'] 		= $this->load->controller('extension/tmdmultivendor/vendor/header');
		
		
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/changepassword', $data));
	}


    public function save(): void {
		$json = [];
		
		$this->load->language('extension/tmdmultivendor/vendor/changepassword');
		
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		
		$vendor_id=$this->vendor->getId();
		if (!$json) {
		if (!$this->model_extension_tmdmultivendor_vendor_vendor->verifyPassword($vendor_id,$this->request->post)) {
			$json['error']['warning'] = $this->language->get('error_not_match');
		}

		if ((strlen($this->request->post['password']) < 4) || (strlen($this->request->post['password']) > 20)) { 
			$json['error']['password'] = $this->language->get('error_password');
		}

		if ($this->request->post['confirm'] != $this->request->post['password']) {
			$json['error']['confirm'] = $this->language->get('error_confirm');


		}
		
		
			$this->load->model('extension/tmdmultivendor/vendor/vendor');

			$this->model_extension_tmdmultivendor_vendor_vendor->editPassword($vendor_id,$this->request->post);	

			$json['success'] = $this->language->get('text_success');

			 $json['redirect'] = $this->url->link('extension/tmdmultivendor/vendor/changesuccess', 'language=' . $this->config->get('config_language'), true);
			
		} 

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}
