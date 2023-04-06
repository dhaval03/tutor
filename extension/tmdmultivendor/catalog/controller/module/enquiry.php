<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Module;
class Enquiry extends \Opencart\System\Engine\Controller {
	public function index() {

		$this->load->language('extension/tmdmultivendor/module/enquiry');
		$this->load->model('extension/tmdmultivendor/vendor/enquiry');

		$data['heading_title'] 		= $this->language->get('heading_title');
		$data['text_name']  		= $this->language->get('text_name');
		$data['text_email']  		= $this->language->get('text_email');
		$data['text_telephone']  	= $this->language->get('text_telephone');
		$data['text_description']  	= $this->language->get('text_description');
		$data['button_send']  		= $this->language->get('button_send');
		
		$headingbg = $this->config->get('module_tmdvendor_bgcolor');
		$textcolor = $this->config->get('module_tmdvendor_textcolor');
		
		if(!empty($textcolor)){
		$data['headingbg'] = $headingbg;
		} else {
		$data['headingbg'] = '';
		}
		
		if(!empty($textcolor)){
		$data['textcolor'] = $textcolor;
		} else {
		$data['textcolor'] = '';
		}
			
		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$product_id = 0;
		}

		/* 10 02 2020 */
		if(!empty($this->request->get['vendor_id'])){
		$vendor_ids = $this->request->get['vendor_id'];
		} else {
		$vendor_ids = '';
		}
		$product_info = $this->model_extension_tmdmultivendor_vendor_enquiry->getProduct($product_id, $vendor_ids);

		/* 10 02 2020 */
		if(isset($product_info['product_id'])) {
			$data['product_id'] = $product_info['product_id'];
		} else {
			$data['product_id'] ='';
		}
	
		$this->load->model('extension/tmdmultivendor/vendor/enquiry');
		if(isset($product_info['product_id'])) {
			$vendor_info = $this->model_extension_tmdmultivendor_vendor_enquiry->getProductVendor($product_info['product_id']);
		}

		if(isset($vendor_info['vendor_id'])) {
			$data['vendor_id'] = $vendor_info['vendor_id'];
		} elseif(isset($this->request->get['vendor_id'])) {
			$data['vendor_id'] =$this->request->get['vendor_id'];
		}
		else {
			
			$data['vendor_id'] ='';
		}
		
		return $this->load->view('extension/tmdmultivendor/module/enquiry', $data);	
	}

	public function addenquiry(){
        $this->load->language('extension/tmdmultivendor/module/enquiry');
        $this->load->model('extension/tmdmultivendor/vendor/enquiry');
      	if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
          	$json = array();
          	
	        if(empty($this->request->post['name'])) {
				$json['error']['name']= $this->language->get('error_name');
			}

			if(empty($this->request->post['email'])) {
				$json['error']['email']= $this->language->get('error_email');
			}

			if(empty($this->request->post['telephone'])) {
				$json['error']['telephone']= $this->language->get('error_telephone');
			}

			if(empty($this->request->post['description'])) {
				$json['error']['description']= $this->language->get('error_description');
			}

	        if(empty($json['error'])) {
				
				if(isset($this->request->get['product_id'])){
				$product_id = $this->request->get['product_id'];
				} else {
				$product_id ='';
				}
				
	           	$this->model_extension_tmdmultivendor_vendor_enquiry->addEnquiry($product_id,$this->request->post);  
	           	
				
	           	$json['success'] = $this->language->get('text_success');
	        }
    	}         
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
    }
}