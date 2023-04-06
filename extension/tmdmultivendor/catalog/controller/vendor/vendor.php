<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class vendor extends \Opencart\System\Engine\Controller {
	
	public function index() {
		
		if ($this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/success', '', true));
		}
		
		$this->load->language('extension/tmdmultivendor/vendor/vendor');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$data['language'] = $this->config->get('config_language');
				
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		
		
		
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_login'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/dashboard', '', true)
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/vendor', '', true)
		);
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('extension/tmdmultivendor/vendor/login', '', true));
		
		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/vendor|save', 'language=' . $this->config->get('config_language'));
	
		if (isset($this->request->post['display_name'])) {
			$data['display_name'] = $this->request->post['display_name'];
		} else {
			$data['display_name'] = '';
		}
		
		/*advance settings*/
		$data['required_displayname'] 	= $this->config->get('vendor_required_displayname');
		$data['required_lastname'] 		= $this->config->get('vendor_required_lastname');
		$data['required_telephone'] 	= $this->config->get('vendor_required_telephone');
		$data['required_fax'] 		    = $this->config->get('vendor_required_fax');
		$data['required_company'] 		= $this->config->get('vendor_required_company');
		$data['required_address_1'] 	= $this->config->get('vendor_required_address_1');
		$data['required_address_2'] 	= $this->config->get('vendor_required_address_2');
		$data['required_city'] 			= $this->config->get('vendor_required_city');
		$data['required_country'] 		= $this->config->get('vendor_required_country');
		$data['required_zone'] 			= $this->config->get('vendor_required_zone');
		$data['required_about'] 		= $this->config->get('vendor_required_about');
		$data['chkpostcode'] 			=  $this->config->get('vendor_vpostcode');
		
		$data['required_metadesc'] 		= $this->config->get('vendor_required_meta_description');
		$data['required_description'] 	= $this->config->get('vendor_required_description');
		$data['required_shipping_policy'] 		= $this->config->get('vendor_required_shipping_policy');
		$data['required_return_policy'] 		= $this->config->get('vendor_required_return_policy');
		$data['required_meta_keyword'] 		= $this->config->get('vendor_required_meta_keyword');
		
		$data['required_bank_detail'] 	= $this->config->get('vendor_required_bank_detail');
		$data['required_storeabout'] 	= $this->config->get('vendor_required_storeabout');
		$data['required_mapurl'] 		= $this->config->get('vendor_required_mapurl');
		$data['required_tax_number'] 	= $this->config->get('vendor_required_tax_number');
		$data['required_shipping'] 		= $this->config->get('vendor_required_shipping_charge');
		$data['required_url'] 		    = $this->config->get('vendor_required_url');
		
		
		$data['status_displayname']		= $this->config->get('vendor_status_displayname');
		$data['status_lastname']		= $this->config->get('vendor_status_lastname');
		$data['status_telephone']		= $this->config->get('vendor_status_telephone');
		$data['status_fax']				= $this->config->get('vendor_status_fax');
		$data['status_company']			= $this->config->get('vendor_status_company');
		$data['status_address_1']		= $this->config->get('vendor_status_address_1');
		$data['status_address_2']		= $this->config->get('vendor_status_address_2');
		$data['status_city']			= $this->config->get('vendor_status_city');
		$data['status_country']			= $this->config->get('vendor_status_country');
		$data['status_zone']			= $this->config->get('vendor_status_zone');
		$data['status_postcode']		= $this->config->get('vendor_status_postcode');
		$data['status_about']			= $this->config->get('vendor_status_about');
		$data['status_image']			= $this->config->get('vendor_status_image');
		
		$data['status_metadesc']		= $this->config->get('vendor_status_meta_description');
		$data['status_description']		= $this->config->get('vendor_status_description');
		$data['status_shipping_policy']	= $this->config->get('vendor_status_shipping_policy');
		$data['status_return_policy']	= $this->config->get('vendor_status_return_policy');
		$data['status_meta_keyword']	= $this->config->get('vendor_status_meta_keyword');
		
		$data['status_bank_detail']		= $this->config->get('vendor_status_bank_detail');
		$data['status_storeabout']		= $this->config->get('vendor_status_storeabout');
		$data['status_mapurl']			= $this->config->get('vendor_status_mapurl');
		$data['status_tax_number']		= $this->config->get('vendor_status_tax_number');
		$data['status_shipping_charge']	= $this->config->get('vendor_status_shipping_charge');
		$data['status_url']				= $this->config->get('vendor_status_url');
		$data['status_logo']			= $this->config->get('vendor_status_logo');
		$data['status_banner']			= $this->config->get('vendor_status_banner');
		$data['status_paypal']			= $this->config->get('vendor_status_paypal');
		$data['status_bank']		    = $this->config->get('vendor_status_bank');
		/*advance settings*/

		    // ckeditor
		$this->document->addScript('extension/tmdmultivendor/catalog/view/javascript/vendor/ckeditor/ckeditor.js');
		$this->document->addScript('extension/tmdmultivendor/catalog/view/javascript/vendor/ckeditor/adapters/jquery.js');
		
		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} else {
			$data['firstname'] = '';
		}
		
		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} else {
			$data['lastname'] = '';
		}
		
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}
		
		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} else {
			$data['telephone'] = '';
		}
		
		if (isset($this->request->post['fax'])) {
			$data['fax'] = $this->request->post['fax'];
		} else {
			$data['fax'] = '';
		}
		
		if (isset($this->request->post['company'])) {
			$data['company'] = $this->request->post['company'];
		} else {
			$data['company'] = '';
		}	
		
		if (isset($this->request->post['address_1'])) {
			$data['address_1'] = $this->request->post['address_1'];
		} else {
			$data['address_1'] = '';
		}
		
		if (isset($this->request->post['address_2'])) {
			$data['address_2'] = $this->request->post['address_2'];
		} else {
			$data['address_2'] = '';
		}
		
		if (isset($this->request->post['postcode'])) {
			$data['postcode'] = $this->request->post['postcode'];
		} elseif (isset($this->session->data['shipping_address']['postcode'])) {
			$data['postcode'] = $this->session->data['shipping_address']['postcode'];
		} else {
			$data['postcode'] = '';
		}
		
		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} else {
			$data['city'] = '';
		}

		if (isset($this->request->post['payment_method'])) {
			$data['payment_method'] = $this->request->post['payment_method'];
		} else {
			$data['payment_method'] = 'paypal';
		}

		if (isset($this->request->post['paypal'])) {
			$data['paypal'] = $this->request->post['paypal'];
		} else {
			$data['paypal'] = '';
		}

		if (isset($this->request->post['bank_name'])) {
			$data['bank_name'] = $this->request->post['bank_name'];
		} else {
			$data['bank_name'] = '';
		}

		if (isset($this->request->post['bank_branch_number'])) {
			$data['bank_branch_number'] = $this->request->post['bank_branch_number'];
		} else {
			$data['bank_branch_number'] = '';
		}

		if (isset($this->request->post['bank_swift_code'])) {
			$data['bank_swift_code'] = $this->request->post['bank_swift_code'];
		} else {
			$data['bank_swift_code'] = '';
		}

		if (isset($this->request->post['bank_account_name'])) {
			$data['bank_account_name'] = $this->request->post['bank_account_name'];
		} else {
			$data['bank_account_name'] = '';
		}

		if (isset($this->request->post['bank_account_number'])) {
			$data['bank_account_number'] = $this->request->post['bank_account_number'];
		} else {
			$data['bank_account_number'] = '';
		}
		
		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = (int)$this->request->post['country_id'];
		} elseif (isset($this->session->data['shipping_address']['country_id'])) {
			$data['country_id'] = $this->session->data['shipping_address']['country_id'];
		} else {
			$data['country_id'] = $this->config->get('config_country_id');
		}
		
		if (isset($this->request->post['zone_id'])) {
			$data['zone_id'] = (int)$this->request->post['zone_id'];
		} elseif (isset($this->session->data['shipping_address']['zone_id'])) {
			$data['zone_id'] = $this->session->data['shipping_address']['zone_id'];
		} else {
			$data['zone_id'] = '';
		}
		
		
		
		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->load->model('tool/image');
	 	if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
	  		$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($store_info) && is_file(DIR_IMAGE . $store_info['image'])) {
		  	$data['thumb'] = $this->model_tool_image->resize($store_info['image'], 100, 100);
		} else {
		  	$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
//// Seller Store///
		
		if (isset($this->request->post['bank_detail'])) {
			$data['bank_detail'] = $this->request->post['bank_detail'];
		} else {
			$data['bank_detail'] = '';
		}
		
		if (isset($this->request->post['store_about'])) {
			$data['store_about'] = $this->request->post['store_about'];
		} else {
			$data['store_about'] = '';
		}
		
		if (isset($this->request->post['tax_number'])) {
			$data['tax_number'] = $this->request->post['tax_number'];
		} else {
			$data['tax_number'] = '';
		}
		
		if (isset($this->request->post['shipping_charge'])) {
			$data['shipping_charge'] = $this->request->post['shipping_charge'];
		} else {
			$data['shipping_charge'] = '';
		}
		
		$this->load->model('extension/tmdmultivendor/vendor/seo_url');
		//SEO
		$data['vendor_seo_url'] = $this->model_extension_tmdmultivendor_vendor_seo_url->getSeoUrls('extension/tmdmultivendor/vendor/seo_url');
		//SEO

		
		$this->load->model('setting/store');

		$data['stores'] = [];

		$data['stores'][] = [
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		];

		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = [
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			];
		}
		

		if (isset($this->request->post['map_url'])) {
			$data['map_url'] = $this->request->post['map_url'];
		} else {
			$data['map_url'] = '';
		}
		if (isset($this->request->post['about'])) {
			$data['about'] = $this->request->post['about'];
		} else {
			$data['about'] = '';
		}
		
		
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} else {
			$data['image'] = '';
		}
		
		if (isset($this->request->post['logo'])) {
			$data['logo'] = $this->request->post['logo'];
		} else {
			$data['logo'] = '';
		}
		
		if (isset($this->request->post['store_description'])) {
			$data['store_description'] = $this->request->post['store_description'];
		}  else {
			$data['store_description'] = array();
		}
		
		if (isset($this->request->post['banner'])) {
			$data['banner'] = $this->request->post['banner'];
		} else {
			$data['banner'] = '';
		}
		
		$this->load->model('tool/image');
	 	if (isset($this->request->post['logo']) && is_file(DIR_IMAGE . $this->request->post['logo'])) {
	  		$data['thumb_logo'] = $this->model_tool_image->resize($this->request->post['logo'], 100, 100);
		} elseif (!empty($store_info) && is_file(DIR_IMAGE . $store_info['logo'])) {
		  	$data['thumb_logo'] = $this->model_tool_image->resize($store_info['logo'], 100, 100);
		} else {
		  	$data['thumb_logo'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		if (isset($this->request->post['banner']) && is_file(DIR_IMAGE . $this->request->post['banner'])) {
	  		$data['thumb_banner'] = $this->model_tool_image->resize($this->request->post['banner'], 100, 100);
		} elseif (!empty($store_info) && is_file(DIR_IMAGE . $store_info['banner'])) {
		  	$data['thumb_banner'] = $this->model_tool_image->resize($store_info['banner'], 100, 100);
		} else {
		  	$data['thumb_banner'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		/* 10 04 2020 */
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
		
		$data['vendor_vprivacy'] = $this->config->get('vendor_vprivacy_id');
		
			$this->load->model('catalog/information');
			$information_info = $this->model_catalog_information->getInformation($this->config->get('vendor_vprivacy_id'));

			if ($information_info) {
				$data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information|info','language=' . $this->config->get('config_language') .'&information_id=' . $this->config->get('vendor_vprivacy_id'), true), $information_info['title'], $information_info['title']);
			} else {
				$data['text_agree'] = '';
			}
			
			if (isset($this->request->post['agree'])) {
			$data['agree'] = $this->request->post['agree'];
			} else {
			$data['agree'] = false;
			}
		/* 10 04 2020 */
		
		
		$data['column_left'] 	= $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['column_right'] 	= $this->load->controller('common/column_right');
		$data['content_top'] 	= $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] 		= $this->load->controller('common/footer');
		$data['header'] 		= $this->load->controller('common/header');

		
		
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/vendor', $data));
	}
	
	
	public function autocomplete(){
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'firstname';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
			
		$filter_data = array(
		'sort'  => $sort,
		'order' => $order,
		//'filter_name' => $filter_name,
		'start' => ($page - 1) * $this->config->get('config_limit_admin'),
		'limit' => $this->config->get('config_limit_admin')
		);
		$results=$this->model_extension_tmdmultivendor_vendor_vendor->getVendors($filter_data);

		foreach ($results as $result) {

		$json[] = array(
		'vendor_id'  => $result['vendor_id'],
		'firstname'   => strip_tags(html_entity_decode($result['firstname'], ENT_QUOTES, 'UTF-8'))
		);
		}
		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['firstname'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function upload(){
		$this->load->language('tool/upload');
		$json = array();
		if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
			// Sanitize the filename
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));
			// Validate the filename length
			if ((strlen($filename) < 3) || (strlen($filename) > 64)) {
				$json['error'] = $this->language->get('error_filename');
			}
			// Allowed file extension types
			$allowed = array();
			$extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));
			$filetypes = explode("\n", $extension_allowed);
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}
			if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}
			// Allowed file mime types
			$allowed = array();
			$mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));
			$filetypes = explode("\n", $mime_allowed);
			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}
			if (!in_array($this->request->files['file']['type'], $allowed)) {
				$json['error'] = $this->language->get('error_filetype');

			}
			// Check to see if any PHP files are trying to be uploaded
			$content = file_get_contents($this->request->files['file']['tmp_name']);
			if (preg_match('/\<\?php/i', $content)) {
				$json['error'] = $this->language->get('error_filetype');
			}
			// Return any upload error
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}
		
		$this->load->model('tool/image');
		if (!$json) {
			$targetDir = DIR_IMAGE.'catalog/multivendor/';
			
			if(!file_exists($targetDir))
			{
				mkdir($targetDir , 0777);
			}
			
			$file = $filename;
			$location = $targetDir.$file;
			$location1 = 'catalog/multivendor/'.$file;
			$location2 = 'catalog/multivendor/'.$file;
			move_uploaded_file($this->request->files['file']['tmp_name'], $location);
			$json['filename'] =$filename;
			$json['location1'] =$location1;
			$json['location2'] =$this->model_tool_image->resize($location1, 150, 150);
			$json['success'] = $this->language->get('text_upload');
		}
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
	}

	public function save(): void {
		$json = [];

		$this->load->language('extension/tmdmultivendor/vendor/edit');
		$this->load->language('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('localisation/country');
		if (!$json) {
		$displayname =  $this->config->get('vendor_required_displayname');
		$displaynamestatus =  $this->config->get('vendor_status_displayname');
		if($displaynamestatus==1){
			if($displayname==1){
				
				if ((strlen($this->request->post['display_name']) < 2) || (strlen($this->request->post['display_name']) > 64)) {
					$json['error']['display_name'] = $this->language->get('error_display_name');
				}
			}
		}
		
		if ((strlen($this->request->post['firstname']) < 1) || (strlen($this->request->post['firstname']) > 32)) {
				$json['error']['firstname'] = $this->language->get('error_firstname');
			}
		
		$lastnamestatus =  $this->config->get('vendor_status_lastname');
		$lastname =  $this->config->get('vendor_required_lastname');
		if($lastnamestatus==1){
		if($lastname==1){
			if ((strlen($this->request->post['lastname']) < 1) || (strlen($this->request->post['lastname']) > 32)) {
				$json['error']['lastname'] = $this->language->get('error_lastname');
			}
		}
		}
		
		$email_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorByEmail($this->request->post['email']);

		if (!isset($this->request->get['vendor_id'])) {
			if ($email_info) {
				$json['error']['warning'] = $this->language->get('error_email_match');
			}
		} else {
			if ($email_info && ($this->request->get['vendor_id'] != $email_info['vendor_id'])) {
				$json['error']['warning'] = $this->language->get('error_email_match');
			}
		}
		
		if ((strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$json['error']['email'] = $this->language->get('error_email');
		}
		
		$telephonestatus =  $this->config->get('vendor_status_telephone');
		$telephone =  $this->config->get('vendor_required_telephone');
		if($telephonestatus==1){
		if($telephone==1){
			if ((strlen($this->request->post['telephone']) < 3) || (strlen($this->request->post['telephone']) > 32)) {
				$json['error']['telephone'] = $this->language->get('error_telephone');
			}
		}
		}
		
		$faxstatus =  $this->config->get('vendor_status_fax');
		$fax =  $this->config->get('vendor_required_fax');
		if($faxstatus==1){
		if($fax==1){
			if ((strlen($this->request->post['fax']) < 3) || (strlen($this->request->post['fax']) > 32)) {
				$json['error']['fax'] = $this->language->get('error_fax');
			}
		}
		}
		
		$company =  $this->config->get('vendor_required_company');
		$companystatus =  $this->config->get('vendor_status_company');
		if($companystatus==1){
		if($company==1){
			if ((strlen($this->request->post['company']) < 3) || (strlen($this->request->post['company']) > 32)) {
				$json['error']['company'] = $this->language->get('error_company');
			}
		}
		}
		
		$address_1status =  $this->config->get('vendor_status_address_1');
		$address_1 =  $this->config->get('vendor_required_address_1');
		if($address_1status==1){
		if($address_1==1){
			if ((strlen(trim($this->request->post['address_1'])) < 3) || (strlen(trim($this->request->post['address_1'])) > 128)) {
				$json['error']['address_1'] = $this->language->get('error_address_1');
			}
		}
		}
		
		$address_2status =  $this->config->get('vendor_status_address_2');
		$address_2 =  $this->config->get('vendor_required_address_2');
		if($address_2status==1){
		if($address_2==1){
			if ((strlen(trim($this->request->post['address_2'])) < 3) || (strlen(trim($this->request->post['address_2'])) > 128)) {
				$json['error']['address_2'] = $this->language->get('error_address_2');
			}
		}
		}
		
		$citystatus =  $this->config->get('vendor_status_city');
		$city =  $this->config->get('vendor_required_city');
		if($citystatus==1){
		if($city==1){
			if ((strlen(trim($this->request->post['city'])) < 2) || (strlen(trim($this->request->post['city'])) > 128)) {
				$json['error']['city'] = $this->language->get('error_city');
			}
		}
		}

		if (!isset($this->request->post['country_id']) || $this->request->post['country_id'] == '') {
			$json['error']['country'] = $this->language->get('error_country');
		} 
		else {

			$this->load->model('localisation/country');

			$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

			if ($country_info && $country_info['postcode_required'] && (strlen($this->request->post['postcode']) < 2 || strlen($this->request->post['postcode']) > 10)) {
				$json['error']['postcode'] = $this->language->get('error_postcode');
			}
		}
		
		
		$zonestatus =  $this->config->get('vendor_status_zone');
		$zone =  $this->config->get('vendor_required_zone');
		if($zonestatus==1){
		if($zone==1){
			if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '' || !is_numeric($this->request->post['zone_id'])) {
				$json['error']['zone'] = $this->language->get('error_zone');
			}
		}
		}

			
				
		if ((strlen($this->request->post['password']) < 4) || (strlen($this->request->post['password']) > 20)) {
			$json['error']['password'] = $this->language->get('error_password');
		}
		
		if ($this->request->post['confirm'] != $this->request->post['password']) {
			$json['error']['confirm'] = $this->language->get('error_confirm');
		}
		
		$aboutstatus =  $this->config->get('vendor_status_about');
		$about =  $this->config->get('vendor_required_about');
		if($aboutstatus==1){
		if($about==1){
			if ((strlen(trim($this->request->post['about'])) < 2) || (strlen(trim($this->request->post['about'])) > 1000)) {
				$json['error']['about'] = $this->language->get('error_about');
			}
		}
		}
		
		
		foreach ($this->request->post['store_description'] as $language_id => $value) {
			
				if ((strlen($value['name']) < 3) || (strlen($value['name']) > 255)) {
					$json['error']['name_' . $language_id]  = $this->language->get('error_name');
				}
			
				$meta_description =  $this->config->get('vendor_required_meta_description');
				$meta_descriptionstatus =  $this->config->get('vendor_status_meta_description');
				if($meta_descriptionstatus==1){
				if($meta_description==1){
					if ((strlen($value['meta_description']) < 3) || (strlen($value['meta_description']) > 500)) {
						$json['error']['meta_description_' . $language_id]  = $this->language->get('error_meta_description');
					}
				}
				}
				
				$description =  $this->config->get('vendor_required_description');
				$descriptionstatus =  $this->config->get('vendor_status_description');
				if($descriptionstatus==1){
				if($description==1){
					if ((strlen($value['description']) < 3) || (strlen($value['description']) > 500)) {
						$json['error']['description_' . $language_id] = $this->language->get('error_description');
					}
				}
				}
				
				$shipping_policy =  $this->config->get('vendor_required_shipping_policy');
				$shipping_policystatus =  $this->config->get('vendor_status_shipping_policy');
				if($shipping_policystatus==1){
				if($shipping_policy==1){
					if ((strlen($value['shipping_policy']) < 3) || (strlen($value['shipping_policy']) > 500)) {
						$json['error']['shipping_policy_' . $language_id] = $this->language->get('error_shipping_policy');
					}
				}
				}
				
				$return_policystatus =  $this->config->get('vendor_status_return_policy');
				$return_policy =  $this->config->get('vendor_required_return_policy');
				if($return_policystatus==1){
				if($return_policy==1){
					if ((strlen($value['return_policy']) < 3) || (strlen($value['return_policy']) > 500)) {
						$json['error']['return_policy_' . $language_id] = $this->language->get('error_return_policy');
					}
				}
				}
				
				$meta_keyword =  $this->config->get('vendor_required_meta_keyword');
				$meta_keywordstatus =  $this->config->get('vendor_status_meta_keyword');
				if($meta_keywordstatus==1){
				if($meta_keyword==1){
					if ((strlen($value['meta_keyword']) < 3) || (strlen($value['meta_keyword']) > 500)) {
						$json['error']['meta_keyword_' . $language_id] = $this->language->get('error_meta_keyword');
					}
				}
				}
		}
		
		        $bank_detail =  $this->config->get('vendor_required_bank_detail');
		        $bank_detailstatus =  $this->config->get('vendor_status_bank_detail');
				if($bank_detailstatus==1){
				if($bank_detail==1){
					if ((strlen(trim($this->request->post['bank_detail'])) < 2) || (strlen(trim($this->request->post['bank_detail'])) > 1000)) {
						$json['error']['bank_detail'] = $this->language->get('error_bank_detail');
					}
				}
				}
				
				$storeabout =  $this->config->get('vendor_required_storeabout');
				$storeaboutstatus =  $this->config->get('vendor_status_storeabout');
				if($storeaboutstatus==1){
				if($storeabout==1){
					if ((strlen(trim($this->request->post['store_about'])) < 2) || (strlen(trim($this->request->post['store_about'])) > 1000)) {
						$json['error']['store_about'] = $this->language->get('error_store_about');
					}
				}
				}

				$map_url =  $this->config->get('vendor_required_mapurl');
				$map_urlstatus =  $this->config->get('vendor_status_mapurl');
				if($map_urlstatus==1){
				if($map_url==1){
					if ((strlen(trim($this->request->post['map_url'])) < 2) || (strlen(trim($this->request->post['map_url'])) > 1000)) {
						$json['error']['map_url'] = $this->language->get('error_map_url');
					}
				}	
				}	

				
				$tax_number =  $this->config->get('vendor_required_tax_number');
				$tax_numberstatus =  $this->config->get('vendor_status_tax_number');
				if($tax_numberstatus==1){
				if($tax_number==1){
					if ((strlen(trim($this->request->post['tax_number'])) < 2) || (strlen(trim($this->request->post['tax_number'])) > 128)) {
						$json['error']['tax_number'] = $this->language->get('error_tax_number');
					}
				}
				}

				$shipping_charge =  $this->config->get('vendor_required_shipping_charge');
				$shipping_chargestatus =  $this->config->get('vendor_status_shipping_charge');
				if($shipping_chargestatus==1){
				if($shipping_charge==1){
					if ((strlen(trim($this->request->post['tax_number'])) < 2) || (strlen(trim($this->request->post['shipping_charge'])) > 128)) {
						$json['error']['shipping_charge'] = $this->language->get('error_shipping_charge');
					}
				}	
				}	

								
		$statuspaypal= $this->config->get('vendor_status_paypal');
		if($statuspaypal==1){
			if ($this->request->post['payment_method'] == 'paypal') {
				if ($this->request->post['paypal'] == '') {
					$json['error']['paypal'] = $this->language->get('error_paypal');
				}
			} elseif ($this->request->post['payment_method'] == 'banktransfer') {
				if ($this->request->post['bank_account_name'] == '') {
					$json['error']['bank_account_name'] = $this->language->get('error_bank_account_name');
				}

				if ($this->request->post['bank_account_number'] == '') {
					$json['error']['bank_account_number'] = $this->language->get('error_bank_account_number');
				}
			}
		}
		
		    $chkpostcode =  $this->config->get('vendor_vpostcode');
		    $chkpostcodestatus =  $this->config->get('vendor_status_postcode');
			if($chkpostcodestatus==1){
			if($chkpostcode==1){
				if (empty($this->request->post['postcode'])) {
					$json['error']['postcode'] = $this->language->get('error_postcode');
				}
			}
			}
		/* 24 03 2020 */
		if (!empty($json['error'])) {			
		$json['error']['filedwarning'] =  $this->language->get('error_filedwarning');
		}
		/* 24 03 2020 */
		
		/* 10 04 2020 */
		
		$vendor_vprivacy = $this->config->get('vendor_vprivacy_id');
		if($vendor_vprivacy!=0){
			if ($this->config->get('vendor_vprivacy_id')) {
				$this->load->model('catalog/information');

				$information_info = $this->model_catalog_information->getInformation($this->config->get('vendor_vprivacy_id'));

				if ($information_info && !isset($this->request->post['agree'])) {
					$json['error']['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
				}
			}
		}
		/* 10 04 2020 */

		/* 05 02 2021 */
		$vendorstatusurl = $this->config->get('vendor_status_url');
		$vendorrequiredurl = $this->config->get('vendor_required_url');
		if($vendorstatusurl==1){
		if($vendorrequiredurl==1){
		if ($this->request->post['vendor_seo_url']) {
			
			$this->load->model('design/seo_url');
			
			foreach ($this->request->post['vendor_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						if (count(array_keys($language, $keyword)) > 1) {
							$json['error']['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
						}							
						
						$seo_urls = $this->model_design_seo_url->getSeoUrlByKeyword($keyword, $store_id, $language_id);
						
						foreach ($seo_urls as $seo_url) {
							if(!empty($seo_url['query'])){
							if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['vendor_id']) || (($seo_url['query'] != 'vendor_id=' . $this->request->get['vendor_id'])))) {
								$json['error']['keyword_' . $store_id . '_' . $language_id]= $this->language->get('error_keyword');
							}
							}
						}
					}
					if (empty($keyword)) {
						$json['error']['keyword_' . $store_id . '_' . $language_id] = $this->language->get('error_srequired');
					}
				}
			}
		}
		}
		}
		}

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}
		

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/vendor');

			 $this->model_extension_tmdmultivendor_vendor_vendor->addVendor($this->request->post);
			 
			 //SEO
			$this->load->model('extension/tmdmultivendor/vendor/seo_url');
			$this->request->post['urlformat']='vendor_seo_url';
			$this->model_extension_tmdmultivendor_vendor_seo_url->saveSeoUrls($this->request->post,'extension/tmdmultivendor/vendor/seo_url');
			//SEO
			
			
			$this->vendor->login($this->request->post['email'], $this->request->post['password']);	

$json['redirect'] = $this->url->link('extension/tmdmultivendor/vendor/success', 'language=' . $this->config->get('config_language') . (isset($this->session->data['customer_token']) ? '&customer_token=' . $this->session->data['customer_token'] : ''), true);
			
			

			// $this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/dashboard'));
			//$json['success'] = $this->language->get('text_success');

		} 


		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
}