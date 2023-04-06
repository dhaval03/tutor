<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class Edit extends \Opencart\System\Engine\Controller {

   public function index(): void {

		if (!$this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', '', true));
		}
		
		$this->load->language('extension/tmdmultivendor/vendor/edit');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		
		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();
		
		$data['breadcrumbs'] = [];
		
		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		];
		
		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/edit', '', true)
		];
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('extension/tmdmultivendor/vendor/login', '', true));
		$data['text_form'] = !isset($this->request->get['product_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		

	// 04 03 2019 //
		
		
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
		

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/edit|save', 'language=' . $this->config->get('config_language'));
		
		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($this->vendor->getId());
		}
		
		/* ==== Advance settings 24/11/21 start ==== */
		$data['required_displayname'] 			= $this->config->get('vendor_required_displayname');
		$data['required_lastname'] 				= $this->config->get('vendor_required_lastname');
		$data['required_telephone'] 			= $this->config->get('vendor_required_telephone');
		$data['required_fax'] 		    		= $this->config->get('vendor_required_fax');
		$data['required_company'] 				= $this->config->get('vendor_required_company');
		$data['required_address_1'] 			= $this->config->get('vendor_required_address_1');
		$data['required_address_2'] 			= $this->config->get('vendor_required_address_2');
		$data['required_city'] 					= $this->config->get('vendor_required_city');
		$data['required_country'] 				= $this->config->get('vendor_required_country');
		$data['required_zone'] 					= $this->config->get('vendor_required_zone');
		$data['required_about'] 				= $this->config->get('vendor_required_about');
		$data['chkpostcode'] 					= $this->config->get('vendor_vpostcode');
		
		$data['required_metadesc'] 				= $this->config->get('vendor_required_meta_description');
		$data['required_description'] 			= $this->config->get('vendor_required_description');
		$data['required_shipping_policy'] 		= $this->config->get('vendor_required_shipping_policy');
		$data['required_return_policy'] 		= $this->config->get('vendor_required_return_policy');
		$data['required_meta_keyword'] 			= $this->config->get('vendor_required_meta_keyword');
		
		$data['required_bank_detail'] 			= $this->config->get('vendor_required_bank_detail');
		$data['required_storeabout'] 			= $this->config->get('vendor_required_storeabout');
		$data['required_mapurl'] 				= $this->config->get('vendor_required_mapurl');
		$data['required_tax_number'] 			= $this->config->get('vendor_required_tax_number');
		$data['required_shipping'] 				= $this->config->get('vendor_required_shipping_charge');
		$data['required_url'] 		    		= $this->config->get('vendor_required_url');
		
		
		$data['status_displayname']				= $this->config->get('vendor_status_displayname');
		$data['status_lastname']				= $this->config->get('vendor_status_lastname');
		$data['status_telephone']				= $this->config->get('vendor_status_telephone');
		$data['status_fax']						= $this->config->get('vendor_status_fax');
		$data['status_company']					= $this->config->get('vendor_status_company');
		$data['status_address_1']				= $this->config->get('vendor_status_address_1');
		$data['status_address_2']				= $this->config->get('vendor_status_address_2');
		$data['status_city']					= $this->config->get('vendor_status_city');
		$data['status_country']					= $this->config->get('vendor_status_country');
		$data['status_zone']					= $this->config->get('vendor_status_zone');
		$data['status_postcode']				= $this->config->get('vendor_status_postcode');
		$data['status_about']					= $this->config->get('vendor_status_about');
		$data['status_image']					= $this->config->get('vendor_status_image');
		
		$data['status_metadesc']				= $this->config->get('vendor_status_meta_description');
		$data['status_description']				= $this->config->get('vendor_status_description');
		$data['status_shipping_policy']			= $this->config->get('vendor_status_shipping_policy');
		$data['status_return_policy']			= $this->config->get('vendor_status_return_policy');
		$data['status_meta_keyword']			= $this->config->get('vendor_status_meta_keyword');
		
		$data['status_bank_detail']				= $this->config->get('vendor_status_bank_detail');
		$data['status_storeabout']				= $this->config->get('vendor_status_storeabout');
		$data['status_mapurl']					= $this->config->get('vendor_status_mapurl');
		$data['status_tax_number']				= $this->config->get('vendor_status_tax_number');
		$data['status_shipping_charge']			= $this->config->get('vendor_status_shipping_charge');
		$data['status_url']						= $this->config->get('vendor_status_url');
		$data['status_logo']					= $this->config->get('vendor_status_logo');
		$data['status_banner']					= $this->config->get('vendor_status_banner');
		$data['status_paypal']					= $this->config->get('vendor_status_paypal');
		$data['status_bank']		    		= $this->config->get('vendor_status_bank');
		/* ==== Advance settings 24/11/21 end ==== */

		if (isset($vendor_info)){
			$data['display_name'] = $vendor_info['display_name'];
		} else {
			$data['display_name'] = '';
		}
		
		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (isset($vendor_info)){
			$data['firstname'] = $vendor_info['firstname'];
		} else {
			$data['firstname'] = '';
		}
		
		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (isset($vendor_info)){
			$data['lastname'] = $vendor_info['lastname'];
		} else {
			$data['lastname'] = '';
		}
		
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (isset($vendor_info)){
			$data['email'] = $vendor_info['email'];
		} else {
			$data['email'] = '';
		}
		
		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (isset($vendor_info)){
			$data['telephone'] = $vendor_info['telephone'];
		} else {
			$data['telephone'] = '';
		}
		
		if (isset($this->request->post['fax'])) {
			$data['fax'] = $this->request->post['fax'];
		} elseif (isset($vendor_info)){
			$data['fax'] = $vendor_info['fax'];
		} else {
			$data['fax'] = '';
		}
		
		if (isset($this->request->post['company'])) {
			$data['company'] = $this->request->post['company'];
		} elseif (isset($vendor_info)){
			$data['company'] = $vendor_info['company'];
		} else {
			$data['company'] = '';
		}
		
		if (isset($this->request->post['address_1'])) {
			$data['address_1'] = $this->request->post['address_1'];
		} elseif (isset($vendor_info)){
			$data['address_1'] = $vendor_info['address_1'];
		} else {
			$data['address_1'] = '';
		}
		
		if (isset($this->request->post['address_2'])) {
			$data['address_2'] = $this->request->post['address_2'];
		} elseif (isset($vendor_info)){
			$data['address_2'] = $vendor_info['address_2'];
		} else {
			$data['address_2'] = '';
		}
		
		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (isset($vendor_info)){
			$data['city'] = $vendor_info['city'];
		} else {
			$data['city'] = '';
		}
		
		if (isset($this->request->post['postcode'])) {
			$data['postcode'] = $this->request->post['postcode'];
		} elseif (isset($vendor_info)){
			$data['postcode'] = $vendor_info['postcode'];
		} else {
			$data['postcode'] = '';
		}
		
		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = $this->request->post['country_id'];
		} elseif (isset($vendor_info)){
			$data['country_id'] = $vendor_info['country_id'];
		} else {
			$data['country_id'] = '';
		}
		
		if (isset($this->request->post['zone_id'])) {
			$data['zone_id'] = $this->request->post['zone_id'];
		} elseif (isset($vendor_info)){
			$data['zone_id'] = $vendor_info['zone_id'];
		} else {
			$data['zone_id'] = '';
		}
		
		if(isset($this->request->post['about'])) {
			$data['about']=$this->request->post['about'];
		} else if (isset($vendor_info)){
			$data['about']=$vendor_info['about'];
		} else {
			$data['about']='';
		}

		if (isset($this->request->post['payment_method'])) {
			$data['payment_method'] = $this->request->post['payment_method'];
		} elseif (!empty($vendor_info)) {
			$data['payment_method'] = $vendor_info['payment_method'];
		} else {
			$data['payment_method'] = 'paypal';
		}

		if (isset($this->request->post['paypal'])) {
			$data['paypal'] = $this->request->post['paypal'];
		} elseif (!empty($vendor_info)) {
			$data['paypal'] = $vendor_info['paypal'];
		} else {
			$data['paypal'] = '';
		}

		if (isset($this->request->post['bank_name'])) {
			$data['bank_name'] = $this->request->post['bank_name'];
		} elseif (!empty($vendor_info)) {
			$data['bank_name'] = $vendor_info['bank_name'];
		} else {
			$data['bank_name'] = '';
		}

		if (isset($this->request->post['bank_branch_number'])) {
			$data['bank_branch_number'] = $this->request->post['bank_branch_number'];
		} elseif (!empty($vendor_info)) {
			$data['bank_branch_number'] = $vendor_info['bank_branch_number'];
		} else {
			$data['bank_branch_number'] = '';
		}

		if (isset($this->request->post['bank_swift_code'])) {
			$data['bank_swift_code'] = $this->request->post['bank_swift_code'];
		} elseif (!empty($vendor_info)) {
			$data['bank_swift_code'] = $vendor_info['bank_swift_code'];
		} else {
			$data['bank_swift_code'] = '';
		}

		if (isset($this->request->post['bank_account_name'])) {
			$data['bank_account_name'] = $this->request->post['bank_account_name'];
		} elseif (!empty($vendor_info)) {
			$data['bank_account_name'] = $vendor_info['bank_account_name'];
		} else {
			$data['bank_account_name'] = '';
		}

		if (isset($this->request->post['bank_account_number'])) {
			$data['bank_account_number'] = $this->request->post['bank_account_number'];
		} elseif (!empty($vendor_info)) {
			$data['bank_account_number'] = $vendor_info['bank_account_number'];
		} else {
			$data['bank_account_number'] = '';
		}

		/* new code */
		if(isset($this->request->post['store_logowidth'])) {
			$data['store_logowidth']=$this->request->post['store_logowidth'];
		} else if (isset($vendor_info)){
			$data['store_logowidth']=$vendor_info['store_logowidth'];
		} else {
			$data['store_logowidth']='';
		}
		
		if(isset($this->request->post['store_logoheight'])) {
			$data['store_logoheight']=$this->request->post['store_logoheight'];
		} else if (isset($vendor_info)){
			$data['store_logoheight']=$vendor_info['store_logoheight'];
		} else {
			$data['store_logoheight']='';
		}
		if(isset($this->request->post['store_bannerwidth'])) {
			$data['store_bannerwidth']=$this->request->post['store_bannerwidth'];
		} else if (isset($vendor_info)){
			$data['store_bannerwidth']=$vendor_info['store_bannerwidth'];
		} else {
			$data['store_bannerwidth']='1200';
		}
		
		if(isset($this->request->post['store_bannerheight'])) {
			$data['store_bannerheight']=$this->request->post['store_bannerheight'];
		} else if (isset($vendor_info)){
			$data['store_bannerheight']=$vendor_info['store_bannerheight'];
		} else {
			$data['store_bannerheight']='400';
		}
		
		/* new code */
		
		if(isset($this->request->post['image'])) {
			$data['image']=$this->request->post['image'];
		} else if (isset($vendor_info['image'])){
			$data['image']=$vendor_info['image'];
		} else {
			$data['image']='';
		}
		
		$this->load->model('tool/image');
	 	if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
	  		$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($vendor_info) && is_file(DIR_IMAGE . $vendor_info['image'])) {
		  	$data['thumb'] = $this->model_tool_image->resize($vendor_info['image'], 100, 100);
		} else {
		  	$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
/// Seller Store ////
		
		if (isset($this->request->post['store_description'])) {
			$data['store_description'] = $this->request->post['store_description'];
		} elseif (isset($vendor_info)) {
			$data['store_description'] = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorStoreDescriptions($this->vendor->getId());
		} else {
			$data['store_description'] = [];
		}
				
		if (isset($this->request->post['shipping_charge'])){
			$data['shipping_charge'] = $this->request->post['shipping_charge'];
		} elseif (isset($vendor_info['shipping_charge'])){
			$data['shipping_charge'] = $vendor_info['shipping_charge'];
		} else {
			$data['shipping_charge'] = '';		
		}
		
		if (isset($this->request->post['tax_number'])){
			$data['tax_number'] = $this->request->post['tax_number'];
		} elseif (isset($vendor_info['tax_number'])){
			$data['tax_number'] = $vendor_info['tax_number'];
		} else {
			$data['tax_number'] = '';		
		}
		
		if(isset($this->request->post['logo'])){
			$data['logo']=$this->request->post['logo'];
		} else if(isset($vendor_info['logo'])){
			$data['logo']=$vendor_info['logo'];
		} else {
			$data['logo']='';
		}
// 09 06 2018 ///
		if(isset($this->request->post['keyword'])){
			$data['keyword']=$this->request->post['keyword'];
		} else if(isset($vendor_info['keyword'])){
			$data['keyword']=$vendor_info['keyword'];
		} else {
			$data['keyword']='';
		}
// 09 06 2018 ///
		
		if(isset($this->request->post['banner'])){
			$data['banner']=$this->request->post['banner'];
		} else if(isset($vendor_info['banner'])){
			$data['banner']=$vendor_info['banner'];
		} else {
			$data['banner']='';
		}
		
		if(isset($this->request->post['store_about'])){
			$data['store_about']=$this->request->post['store_about'];
		} else if (isset($vendor_info['store_about'])){
			$data['store_about']=$vendor_info['store_about'];
		} else {
			$data['store_about']='';
		}
		
		/* 05 02 2021 */
		$data['entry_bank_detail'] 		= $this->language->get('entry_bank_detail');
		
		if(isset($this->request->post['bank_detail'])){
			$data['bank_detail']=$this->request->post['bank_detail'];
		} else if (isset($vendor_info['bank_detail'])){
			$data['bank_detail']=$vendor_info['bank_detail'];
		} else {
			$data['bank_detail']='';
		}
		/* 05 02 2021 */
		
		if (isset($this->request->post['map_url'])) {
			$data['map_url'] = $this->request->post['map_url'];
		} elseif (isset($vendor_info)){
			$data['map_url'] = $vendor_info['map_url'];
		} else {
			$data['map_url'] = '';
		}

		if (isset($this->request->post['facebook_url'])) {
			$data['facebook_url'] = $this->request->post['facebook_url'];
		} elseif (isset($vendor_info)){
			$data['facebook_url'] = $vendor_info['facebook_url'];
		} else {
			$data['facebook_url'] = '';
		}

		if (isset($this->request->post['google_url'])) {
			$data['google_url'] = $this->request->post['google_url'];
		} elseif (isset($vendor_info)){
			$data['google_url'] = $vendor_info['google_url'];
		} else {
			$data['google_url'] = '';
		}
		
		/* == Social icon == */	
		if (isset($this->request->post['whatsapp_url'])) {
			$data['whatsapp_url'] = $this->request->post['whatsapp_url'];
		} elseif (isset($vendor_info)){
			$data['whatsapp_url'] = $vendor_info['whatsapp_url'];
		} else {
			$data['whatsapp_url'] = '';
		}
		
		if (isset($this->request->post['instagram_url'])) {
			$data['instagram_url'] = $this->request->post['instagram_url'];
		} elseif (isset($vendor_info)){
			$data['instagram_url'] = $vendor_info['instagram_url'];
		} else {
			$data['instagram_url'] = '';
		}
		
		if (isset($this->request->post['twitter_url'])) {
			$data['twitter_url'] = $this->request->post['twitter_url'];
		} elseif (isset($vendor_info)){
			$data['twitter_url'] = $vendor_info['twitter_url'];
		} else {
			$data['twitter_url'] = '';
		}
		
		if (isset($this->request->post['snapchat_url'])) {
			$data['snapchat_url'] = $this->request->post['snapchat_url'];
		} elseif (isset($vendor_info)){
			$data['snapchat_url'] = $vendor_info['snapchat_url'];
		} else {
			$data['snapchat_url'] = '';
		}
		
		if (isset($this->request->post['pinterest_url'])) {
			$data['pinterest_url'] = $this->request->post['pinterest_url'];
		} elseif (isset($vendor_info)){
			$data['pinterest_url'] = $vendor_info['pinterest_url'];
		} else {
			$data['pinterest_url'] = '';
		}
		
		if (isset($this->request->post['youtube_url'])) {
			$data['youtube_url'] = $this->request->post['youtube_url'];
		} elseif (isset($vendor_info)){
			$data['youtube_url'] = $vendor_info['youtube_url'];
		} else {
			$data['youtube_url'] = '';
		}
		
		if (isset($this->request->post['linkedin_url'])) {
			$data['linkedin_url'] = $this->request->post['linkedin_url'];
		} elseif (isset($vendor_info)){
			$data['linkedin_url'] = $vendor_info['linkedin_url'];
		} else {
			$data['linkedin_url'] = '';
		}
		
		if (isset($this->request->post['tiktok_url'])) {
			$data['tiktok_url'] = $this->request->post['tiktok_url'];
		} elseif (isset($vendor_info)){
			$data['tiktok_url'] = $vendor_info['tiktok_url'];
		} else {
			$data['tiktok_url'] = '';
		}
		
		$this->load->model('tool/image');
	 	if (isset($this->request->post['logo']) && is_file(DIR_IMAGE . $this->request->post['logo'])) {
	  		$data['thumb_logo'] = $this->model_tool_image->resize($this->request->post['logo'], 100, 100);
		} elseif (!empty($vendor_info) && is_file(DIR_IMAGE . $vendor_info['logo'])) {
		  	$data['thumb_logo'] = $this->model_tool_image->resize($vendor_info['logo'], 100, 100);
		} else {
		  	$data['thumb_logo'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		if (isset($this->request->post['banner']) && is_file(DIR_IMAGE . $this->request->post['banner'])) {
	  		$data['thumb_banner'] = $this->model_tool_image->resize($this->request->post['banner'], 100, 100);
		} elseif (!empty($vendor_info) && is_file(DIR_IMAGE . $vendor_info['banner'])) {
		  	$data['thumb_banner'] = $this->model_tool_image->resize($vendor_info['banner'], 100, 100);
		} else {
		  	$data['thumb_banner'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$this->load->model('extension/tmdmultivendor/vendor/seo_url');
		
		$data['vendor_seo_url'] = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorSeoUrls($this->vendor->getId());
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
		
		//06  3 2019 //
		$status_info = $this->model_extension_tmdmultivendor_vendor_vendor->getmsg($this->vendor->getId());
		
		if (isset($this->request->post['chatstatus'])) {
			$data['chatstatus'] = $this->request->post['chatstatus'];
		} elseif (isset($status_info['chatstatus'])){
			$data['chatstatus'] = $status_info['chatstatus'];
		} else {
			$data['chatstatus'] = '';
		}

		if (isset($this->request->post['message'])) {
			$data['message'] = $this->request->post['message'];
		} elseif (isset($status_info['message'])){
			$data['message'] = $status_info['message'];
		} else {
			$data['message'] = '';
		}

	//06  3 2019 //

		$this->load->model('setting/store');
		$data['stores'] = $this->model_setting_store->getStores();

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
        // ckeditor
		$this->document->addScript('extension/tmdmultivendor/catalog/view/javascript/ckeditor/ckeditor.js');
		$this->document->addScript('extension/tmdmultivendor/catalog/view/javascript/ckeditor/adapters/jquery.js');


		$data['imageurls'] = str_replace('http:','',HTTP_SERVER);		
		$data['column_left'] 	= $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['column_right'] 	= $this->load->controller('extension/tmdmultivendor/common/column_right');
		$data['content_top'] 	= $this->load->controller('extension/tmdmultivendor/common/content_top');
		$data['content_bottom'] = $this->load->controller('extension/tmdmultivendor/common/content_bottom');
		$data['footer'] 		= $this->load->controller('extension/tmdmultivendor/vendor/footer');
		$data['header'] 		= $this->load->controller('extension/tmdmultivendor/vendor/header');
		
		
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/edit', $data));
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
			$targetDir = DIR_IMAGE.'catalog/multivendor/'.$this->vendor->getId().'/';
			$file = $filename;
			$location = $targetDir.$file;
			$location1 = 'catalog/multivendor/'.$this->vendor->getId().'/'.$file;
			$location2 = 'catalog/multivendor/'.$this->vendor->getId().'/'.$file;
			move_uploaded_file($this->request->files['file']['tmp_name'], $location);
			$json['filename'] =$filename;
			$json['location1'] =$location1;
			$json['location2'] =$this->model_tool_image->resize($location1, 150, 150);
			$json['success'] = $this->language->get('text_upload');
		}
			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
	}



	public function country() {
		$json = [];

		if (isset($this->request->get['country_id'])) {
			$country_id = (int)$this->request->get['country_id'];
		} else {
			$country_id = 0;
		}

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($country_id);
		
		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = [
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format_id' => $country_info['address_format_id'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($country_id),
				'status'            => $country_info['status']
			];
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

   // function edit

	public function save(): void {
		$json = [];
		$this->load->language('extension/tmdmultivendor/vendor/edit');
		$this->load->language('extension/tmdmultivendor/vendor/vendor');

		$displayname =  $this->config->get('vendor_required_displayname');
		$displaynamestatus =  $this->config->get('vendor_status_displayname');
		if($displaynamestatus==1){
			if($displayname==1){
				if ((strlen(trim($this->request->post['display_name'])) < 1) || (strlen(trim($this->request->post['display_name'])) > 32)) {
					$json['error']['displayname'] = $this->language->get('error_display_name');
				}
			}
		}

		if ((strlen(trim($this->request->post['firstname'])) < 1) || (strlen(trim($this->request->post['firstname'])) > 32)) {
			$json['error']['firstname'] = $this->language->get('error_firstname');
		}
		
		$lastnamestatus =  $this->config->get('vendor_status_lastname');
		$lastname =  $this->config->get('vendor_required_lastname');
		if($lastnamestatus==1){
		if($lastname==1){
			if ((strlen(trim($this->request->post['lastname'])) < 1) || (strlen(trim($this->request->post['lastname'])) > 32)) {
				$json['error']['lastname'] = $this->language->get('error_lastname');
			}
		}
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
				$json['error']['address1'] = $this->language->get('error_address_1');
			}
		}
		}
		
		$address_2status =  $this->config->get('vendor_status_address_2');
		$address_2 =  $this->config->get('vendor_required_address_2');
		if($address_1status==1){
		if($address_1==1){
			if ((strlen(trim($this->request->post['address_2'])) < 3) || (strlen(trim($this->request->post['address_2'])) > 128)) {
				$json['error']['address2'] = $this->language->get('error_address_2');
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
				$json['error']['name'][$language_id] = $this->language->get('error_name');
			}
		
			$meta_description =  $this->config->get('vendor_required_meta_description');
			$meta_descriptionstatus =  $this->config->get('vendor_status_meta_description');
			if($meta_descriptionstatus==1){
			if($meta_description==1){
				if ((strlen($value['meta_description']) < 3) || (strlen($value['meta_description']) > 500)) {
					$json['error']['metadescription'][$language_id] = $this->language->get('error_meta_description');
				}
			}
			}
			
			$description =  $this->config->get('vendor_required_description');
			$descriptionstatus =  $this->config->get('vendor_status_description');
			if($descriptionstatus==1){
			if($description==1){
				if ((strlen($value['description']) < 3) || (strlen($value['description']) > 500)) {
					$json['error']['description'][$language_id] = $this->language->get('error_description');
				}
			}
			}
			
			$shipping_policy =  $this->config->get('vendor_required_shipping_policy');
			$shipping_policystatus =  $this->config->get('vendor_status_shipping_policy');
			if($shipping_policystatus==1){
			if($shipping_policy==1){
				if ((strlen($value['shipping_policy']) < 3) || (strlen($value['shipping_policy']) > 500)) {
					$json['error']['shippingpolicy'][$language_id] = $this->language->get('error_shipping_policy');
				}
			}
			}
			
			$return_policystatus =  $this->config->get('vendor_status_return_policy');
			$return_policy =  $this->config->get('vendor_required_return_policy');
			if($return_policystatus==1){
			if($return_policy==1){
				if ((strlen($value['return_policy']) < 3) || (strlen($value['return_policy']) > 500)) {
					$json['error']['returnpolicy'][$language_id] = $this->language->get('error_return_policy');
				}
			}
			}
			
			$meta_keyword =  $this->config->get('vendor_required_meta_keyword');
			$meta_keywordstatus =  $this->config->get('vendor_status_meta_keyword');
			if($meta_keywordstatus==1){
			if($meta_keyword==1){
				if ((strlen($value['meta_keyword']) < 3) || (strlen($value['meta_keyword']) > 500)) {
					$json['error']['metakeyword'][$language_id] = $this->language->get('error_meta_keyword');
				}
			}
			}
		}


		$bank_detail =  $this->config->get('vendor_required_bank_detail');
		$bank_detailstatus =  $this->config->get('vendor_status_bank_detail');
		if($bank_detailstatus==1){
		if($bank_detail==1){
			if ((strlen(trim($this->request->post['bank_detail'])) < 2) || (strlen(trim($this->request->post['bank_detail'])) > 1000)) {
				$json['error']['bankdetail'] = $this->language->get('error_bank_detail');
			}
		}
		}
				
		$storeabout =  $this->config->get('vendor_required_storeabout');
		$storeaboutstatus =  $this->config->get('vendor_status_storeabout');
		if($storeaboutstatus==1){
		if($storeabout==1){
			if ((strlen(trim($this->request->post['store_about'])) < 2) || (strlen(trim($this->request->post['store_about'])) > 1000)) {
				$json['error']['storeabout'] = $this->language->get('error_store_about');
			}
		}
		}

		$map_url =  $this->config->get('vendor_required_mapurl');
		$map_urlstatus =  $this->config->get('vendor_status_mapurl');
		if($map_urlstatus==1){
		if($map_url==1){
			if ((strlen(trim($this->request->post['map_url'])) < 2) || (strlen(trim($this->request->post['map_url'])) > 1000)) {
				$json['error']['mapurl'] = $this->language->get('error_map_url');
			}
		}	
		}	

				
		$tax_number =  $this->config->get('vendor_required_tax_number');
		$tax_numberstatus =  $this->config->get('vendor_status_tax_number');
		if($tax_numberstatus==1){
		if($tax_number==1){
			if ((strlen(trim($this->request->post['tax_number'])) < 2) || (strlen(trim($this->request->post['tax_number'])) > 128)) {
				$json['error']['taxnumber'] = $this->language->get('error_tax_number');
			}
		}
		}

		$shipping_charge =  $this->config->get('vendor_required_shipping_charge');
		$shipping_chargestatus =  $this->config->get('vendor_status_shipping_charge');
		if($shipping_chargestatus==1){
		if($shipping_charge==1){
			if ((strlen(trim($this->request->post['shipping_charge'])) < 2) || (strlen(trim($this->request->post['shipping_charge'])) > 128)) {
				$json['error']['shippingcharge'] = $this->language->get('error_shipping_charge');
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
					$json['error']['bankaccountname'] = $this->language->get('error_bank_account_name');
				}

				if ($this->request->post['bank_account_number'] == '') {
					$json['error']['bankaccountno'] = $this->language->get('error_bank_account_number');
				}
			}
		}
		
			
		$vendorstatusurl = $this->config->get('vendor_status_url');
		$vendorrequiredurl = $this->config->get('vendor_required_url');
		if($vendorstatusurl==1){
		if($vendorrequiredurl==1){
			if ($this->request->post['vendor_seo_url']) {
			$this->load->model('extension/tmdmultivendor/vendor/seo_url');
			
			foreach ($this->request->post['vendor_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						if (count(array_keys($language, $keyword)) > 1) {
							$json['error']['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
						}							
						
						$seo_urls = $this->model_extension_tmdmultivendor_vendor_seo_url->getSeoUrlsByKeyword($keyword);
						
						foreach ($seo_urls as $seo_url) {
							if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['vendor_id']) || (($seo_url['query'] != 'vendor_id=' . $this->request->get['vendor_id'])))) {
								$json['error']['keyword_' . $store_id . '_' . $language_id]= $this->language->get('error_keyword');
							}
						}
					}
					if (empty($keyword)) {
						$json['error']['keyword_' . $store_id . '_' . $language_id] = $this->language->get('error_seo');
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

			$this->model_extension_tmdmultivendor_vendor_vendor->editVendor($this->vendor->getid(),$this->request->post);
			
			//SEO
			$this->load->model('extension/tmdmultivendor/vendor/seo_url');
			$this->request->post['urlformat']='vendor_seo_url';
			$this->model_extension_tmdmultivendor_vendor_seo_url->saveSeoUrls($this->request->post,'extension/tmdmultivendor/vendor/seo_url');
			//SEO

		   $json['redirect'] = $this->url->link('extension/tmdmultivendor/vendor/dashboard', 'language=' . $this->config->get('config_language'), true);
			

		} 


		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
