<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Vendor;
class Shiftproduct extends \Opencart\System\Engine\Controller { 
	public function index(): void {
		$this->load->language('extension/tmdmultivendor/vendor/shiftproduct');
		$this->load->model('extension/tmdmultivendor/vendor/shiftproduct');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('catalog/manufacturer');

		$this->document->setTitle($this->language->get('heading_title'));

		$url='';


		$data['vendors']= $this->model_extension_tmdmultivendor_vendor_vendor->getVendors(array());
		
		$data['user_token'] = $this->session->data['user_token'];
		
		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/shiftproduct|save', 'user_token=' . $this->session->data['user_token']);

		// Manufacture
		$this->load->model('extension/tmdmultivendor/vendor/shiftproduct');	
		
		if (isset($this->request->post['product_manufacture'])) {
			$product_manufacturies = $this->request->post['product_manufacture'];
		}  elseif (isset($this->request->get['manufacturer_id'])) {
			$product_manufacturies = $this->model_extension_tmdmultivendor_vendor_shiftproduct->getManufacturer($this->request->get['manufacturer_id']);
		} else {
			$product_manufacturies = array();
		}
 
		$data['product_manufacturies'] = array();

		foreach ($product_manufacturies as $manufacturer_id) {
			$manufacture_info = $this->model_extension_tmdmultivendor_vendor_shiftproduct->getManufacturer($manufacturer_id);
			
			if ($manufacture_info) {
				$data['product_manufacturies'][] = array(
					'manufacturer_id' => $manufacture_info['manufacturer_id'],
					'name'           => $manufacture_info['name'],
				);
			}
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		// Vendors
		$this->load->model('extension/tmdmultivendor/vendor/vendor');	
		
		if (isset($this->request->post['product_vendor'])) {
			$product_vendories = $this->request->post['product_vendor'];
		}  elseif (isset($this->request->get['vendor_id'])) {
			$product_vendories = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($this->request->get['vendor_id']);
		} else {
			$product_vendories = array();
		}
 
		$data['product_vendories'] = array();

		foreach ($product_vendories as $vendor_id) {
			$vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($vendor_id);
			
			if ($vendor_info) {
				$data['product_vendories'][] = array(
					'vendor_id' => $vendor_info['vendor_id'],
					'name' => $vendor_info['firstname'],
				);
			}
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/shiftproduct', $data));
	}
	

	public function autocomplete(): void {
		$json = [];

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('extension/tmdmultivendor/vendor/shiftproduct');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_extension_tmdmultivendor_vendor_shiftproduct->getManufacturers($filter_data);

			foreach ($results as $result) {				
				$json[] = [
					'manufacturer_id' => $result['manufacturer_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				];
			}
		}

		$sort_order = [];

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function save(): void {
		$this->load->language('extension/tmdmultivendor/vendor/shiftproduct');
		$this->load->model('extension/tmdmultivendor/vendor/shiftproduct');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/shiftproduct')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		if (!isset($this->request->post['vendor']) || $this->request->post['vendor'] == '') {
			$json['error']['vendor'] = $this->language->get('error_vendor');
		}

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		$data['vendors']= $this->model_extension_tmdmultivendor_vendor_vendor->getVendors(array());

		if (!$json) {

			$this->model_extension_tmdmultivendor_vendor_shiftproduct->shiftproduct($this->request->post);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
}