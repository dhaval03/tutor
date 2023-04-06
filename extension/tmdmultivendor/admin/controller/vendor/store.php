<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Vendor;
class Store extends \Opencart\System\Engine\Controller { 
	public function index(): void {
		$this->load->language('extension/tmdmultivendor/vendor/store');

		$this->document->setTitle($this->language->get('heading_title'));

		$url = '';

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/store', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['add'] = $this->url->link('extension/tmdmultivendor/vendor/store|form', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/store|delete', 'user_token=' . $this->session->data['user_token']);

		$data['list'] = $this->getList();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/store', $data));
	}

	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/store');

		$this->response->setOutput($this->getList());
	}

	protected function getList(): string {
		if (isset($this->request->get['filter_category'])) {
			$filter_category = $this->request->get['filter_category'];
		} else {
			$filter_category = '';
		}

		if (isset($this->request->get['filter_author'])) {
			$filter_author = $this->request->get['filter_author'];
		} else {
			$filter_author = '';
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = '';
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = '';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'r.date_added';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/store|list', 'user_token=' . $this->session->data['user_token'] . $url);

		$data['stores'] = [];

		$filter_data = [
			'filter_category'    => $filter_category,
			'filter_author'     => $filter_author,
			'filter_status'     => $filter_status,
			'filter_date_added' => $filter_date_added,
			'sort'              => $sort,
			'order'             => $order,
			'start'             => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit'             => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/store');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('localisation/country');
		$this->load->model('localisation/zone');

		$store_total = $this->model_extension_tmdmultivendor_vendor_store->getTotalStore($filter_data);

		$results = $this->model_extension_tmdmultivendor_vendor_store->getStores($filter_data);

		foreach ($results as $result) {

			$vendors = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($result['vendor_id']);
			if(isset($vendors['firstname'])){
				$vname = $vendors['firstname'];
			} else {
				$vname ='';
			}
			
			$country_info = $this->model_localisation_country->getCountry($result['country_id']);
			if(isset($country_info['name'])) {
				$mcountry = $country_info['name'];			
			} else {
				$mcountry='';			
			}
			
			$zone_info = $this->model_localisation_zone->getZone($result['zone_id']);
			if(isset($zone_info['name'])) {
				$mzone = $zone_info['name'];
			} else {
				$mzone='';			
			}

			$data['stores'][] = [
				'vs_id'       => $result['vs_id'],
				'name'     	  => $result['name'],
				'vname'       => $vname,
				'mcountry'	  => $mcountry,
				'mzone'		  => $mzone,
				'edit'       => $this->url->link('extension/tmdmultivendor/vendor/store|form', 'user_token=' . $this->session->data['user_token'] . '&vs_id=' . $result['vs_id'] . $url)
			];
		}

		$url = '';

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_product'] = $this->url->link('extension/tmdmultivendor/vendor/store|list', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.name' . $url);
		$data['sort_name'] = $this->url->link('extension/tmdmultivendor/vendor/store|list', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);
		$data['sort_vendorname'] = $this->url->link('extension/tmdmultivendor/vendor/store|list', 'user_token=' . $this->session->data['user_token'] . '&sort=vendorname' . $url, true);
		$data['sort_country'] = $this->url->link('extension/tmdmultivendor/vendor/store|list', 'user_token=' . $this->session->data['user_token'] . '&sort=country' . $url, true);
		$data['sort_zone'] = $this->url->link('extension/tmdmultivendor/vendor/store|list', 'user_token=' . $this->session->data['user_token'] . '&sort=zone' . $url, true);
		$data['sort_sort_order'] = $this->url->link('extension/tmdmultivendor/vendor/store|list', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $store_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/store|list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($store_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($store_total - $this->config->get('config_pagination_admin'))) ? $store_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $store_total, ceil($store_total / $this->config->get('config_pagination_admin')));

		// $data['filter_category'] = $filter_category;
		// $data['filter_author'] = $filter_author;
		// $data['filter_status'] = $filter_status;
		// $data['filter_date_added'] = $filter_date_added;

		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('extension/tmdmultivendor/vendor/store_list', $data);
	}

	public function form(): void {
		$this->load->language('extension/tmdmultivendor/vendor/store');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['text_form'] = !isset($this->request->get['manufacturer_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$url = '';

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/store', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/store|save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/store', 'user_token=' . $this->session->data['user_token'] . $url);

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

		if (isset($this->request->get['vs_id'])) {
			$this->load->model('extension/tmdmultivendor/vendor/store');

			$store_info = $this->model_extension_tmdmultivendor_vendor_store->getStore($this->request->get['vs_id']);
		}

		if (isset($this->request->get['vs_id'])) {
			$data['vs_id'] = (int)$this->request->get['vs_id'];
		} else {
			$data['vs_id'] = 0;
		}

		$this->load->model('extension/tmdmultivendor/vendor/product');

		if (isset($this->request->post['store_description'])) {
			$data['store_description'] = $this->request->post['store_description'];
		} elseif (isset($store_info)) {
			$data['store_description'] = $this->model_extension_tmdmultivendor_vendor_store->getVendorStoreDescriptions($this->request->get['vs_id']);
		} else {
			$data['store_description'] = array();
		}
		
		if (isset($this->request->post['vendor_id'])) {
			$data['vendor_id'] = $this->request->post['vendor_id'];
		} elseif (isset($store_info['vendor_id'])){
			$data['vendor_id'] = $store_info['vendor_id'];
		} else {
			$data['vendor_id'] = '';
		}
		
		if(!empty($data['vendor_id'])){	
			$this->load->model('extension/tmdmultivendor/vendor/vendor');
			$vendor_info=$this->model_extension_tmdmultivendor_vendor_vendor->getVendor($data['vendor_id']);
			$data['vendor']=$vendor_info['firstname'];
		} else {
			$data['vendor']='';
		}
		
		if (isset($this->request->post['store_about'])) {
			$data['store_about'] = $this->request->post['store_about'];
		} elseif (isset($store_info['store_about'])){
			$data['store_about'] = $store_info['store_about'];
		} else {
			$data['store_about'] = '';
		}
		
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (isset($store_info['email'])){
			$data['email'] = $store_info['email'];
		} else {
			$data['email'] = '';
		}
		
		if (isset($this->request->post['phone'])) {
			$data['phone'] = $this->request->post['phone'];
		} elseif (isset($store_info['phone'])){
			$data['phone'] = $store_info['phone'];
		} else {
			$data['phone'] = '';
		}
		
		if (isset($this->request->post['address'])) {
			$data['address'] = $this->request->post['address'];
		} elseif (isset($store_info['address'])){
			$data['address'] = $store_info['address'];
		} else {
			$data['address'] = '';
		}
		
		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (isset($store_info['city'])){
			$data['city'] = $store_info['city'];
		} else {
			$data['city'] = '';
		}
		
		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = $this->request->post['country_id'];
		} elseif (isset($store_info['country_id'])){
			$data['country_id'] = $store_info['country_id'];
		} else {
			$data['country_id'] = '';
		}
		
		if (isset($this->request->post['zone_id'])) {
			$data['zone_id'] = $this->request->post['zone_id'];
		} elseif (isset($store_info['zone_id'])){
			$data['zone_id'] = $store_info['zone_id'];
		} else {
			$data['zone_id'] = '';
		}
		
		if (isset($this->request->post['banner'])) {
			$data['banner'] = $this->request->post['banner'];
		} elseif (isset($store_info['banner'])){
			$data['banner'] = $store_info['banner'];
		} else {
			$data['banner'] = '';
		}
		
		
		if (isset($this->request->post['logo'])) {
			$data['logo'] = $this->request->post['logo'];
		} elseif (isset($store_info['logo'])){
			$data['logo'] = $store_info['logo'];
		} else {
			$data['logo'] = '';
		}
		
		
		if (isset($this->request->post['bank_detail'])) {
			$data['bank_detail'] = $this->request->post['bank_detail'];
		} elseif (isset($store_info['bank_detail'])){
			$data['bank_detail'] = $store_info['bank_detail'];
		} else {
			$data['bank_detail'] = '';
		}
		
		if (isset($this->request->post['postcode'])) {
			$data['postcode'] = $this->request->post['postcode'];
		} elseif (isset($store_info['postcode'])){
			$data['postcode'] = $store_info['postcode'];
		} else {
			$data['postcode'] = '';
		}
		
		if (isset($this->request->post['tax_number'])) {
			$data['tax_number'] = $this->request->post['tax_number'];
		} elseif (isset($store_info['tax_number'])){
			$data['tax_number'] = $store_info['tax_number'];
		} else {
			$data['tax_number'] = '';
		}
		
		if (isset($this->request->post['shipping_charge'])) {
			$data['shipping_charge'] = $this->request->post['shipping_charge'];
		} elseif (isset($store_info['shipping_charge'])){
			$data['shipping_charge'] = $store_info['shipping_charge'];
		} else {
			$data['shipping_charge'] = '';
		}
		
		if (isset($this->request->post['url'])) {
			$data['url'] = $this->request->post['url'];
		} elseif (isset($store_info['url'])){
			$data['url'] = $store_info['url'];
		} else {
			$data['url'] = '';
		}
		
		if (isset($this->request->post['commission'])) {
			$data['commission'] = $this->request->post['commission'];
		} elseif (isset($store_info['commission'])){
			$data['commission'] = $store_info['commission'];
		} else {
			$data['commission'] = '';
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['banner']) && is_file(DIR_IMAGE . $this->request->post['banner'])) {
			$data['thumb_banner'] = $this->model_tool_image->resize($this->request->post['banner'], 100, 100);
		} elseif (!empty($store_info) && is_file(DIR_IMAGE . $store_info['banner'])) {
			$data['thumb_banner'] = $this->model_tool_image->resize($store_info['banner'], 100, 100);
		} else {
			$data['thumb_banner'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		if (isset($this->request->post['logo']) && is_file(DIR_IMAGE . $this->request->post['logo'])) {
			$data['thumb_logo'] = $this->model_tool_image->resize($this->request->post['banner'], 100, 100);
		} elseif (!empty($store_info) && is_file(DIR_IMAGE . $store_info['logo'])) {
			$data['thumb_logo'] = $this->model_tool_image->resize($store_info['logo'], 100, 100);
		} else {
			$data['thumb_logo'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/store_form', $data));
	}

	public function save(): void {
		$this->load->language('extension/tmdmultivendor/vendor/store');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/store')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		if ((strlen($this->request->post['author']) < 3) || (strlen($this->request->post['author']) > 64)) {
			$json['error']['author'] = $this->language->get('error_author');
		}

		if (!$this->request->post['product_id']) {
			$json['error']['product'] = $this->language->get('error_product');
		}

		if (strlen($this->request->post['text']) < 1) {
			$json['error']['text'] = $this->language->get('error_text');
		}

		if (!isset($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
			$json['error']['rating'] = $this->language->get('error_rating');
		}

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/store');

			if (!$this->request->post['vs_id']) {
				$json['vs_id'] = $this->model_extension_tmdmultivendor_vendor_store->addStore($this->request->post);
			} else {
				$this->model_extension_tmdmultivendor_vendor_store->editStore($this->request->post['vs_id'], $this->request->post);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete(): void {
		$this->load->language('extension/tmdmultivendor/vendor/store');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/store')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/store');

			foreach ($selected as $vs_id) {
				$this->model_extension_tmdmultivendor_vendor_store->deleteStore($vs_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	// public function country() {
	// 	$json = array();

	// 	$this->load->model('localisation/country');

	// 	$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

	// 	if ($country_info) {
	// 		$this->load->model('localisation/zone');

	// 		$json = array(
	// 			'country_id'        => $country_info['country_id'],
	// 			'name'              => $country_info['name'],
	// 			'iso_code_2'        => $country_info['iso_code_2'],
	// 			'iso_code_3'        => $country_info['iso_code_3'],
	// 			'address_format'    => $country_info['address_format'],
	// 			'postcode_required' => $country_info['postcode_required'],
	// 			'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
	// 			'status'            => $country_info['status']
	// 		);
	// 	}

	// 	$this->response->addHeader('Content-Type: application/json');
	// 	$this->response->setOutput(json_encode($json));
	// }
	
	// public function autocomplete(){
		
	// 	if (isset($this->request->get['sort'])) {
	// 		$sort = $this->request->get['sort'];
	// 	} else {
	// 		$sort = 'name';
	// 	}

	// 	if (isset($this->request->get['order'])) {
	// 		$order = $this->request->get['order'];
	// 	} else {
	// 		$order = 'ASC';
	// 	}
	// 	if (isset($this->request->get['page'])) {
	// 		$page = $this->request->get['page'];
	// 	} else {
	// 		$page = 1;
	// 	}
	// 	$this->load->model('vendor/vendor');
			
	// 	$filter_data = array(
	// 	'sort'  => $sort,
	// 	'order' => $order,
	// 	//'filter_name' => $filter_name,
	// 	'start' => ($page - 1) * $this->config->get('config_limit_admin'),
	// 	'limit' => $this->config->get('config_limit_admin')
	// 	);
	// 	$accounts = $this->model_vendor_vendor->getVendors($filter_data);
	// 	foreach ($accounts as $account) {

	// 	$json[] = array(
	// 	'vendor_id'  => $account['vendor_id'],
	// 	'firstname'   => strip_tags(html_entity_decode($account['firstname'], ENT_QUOTES, 'UTF-8'))
	// 	);
	// 	}
	// 	$sort_order = array();

	// 	foreach ($json as $key => $value) {
	// 		$sort_order[$key] = $value['firstname'];
	// 	}

	// 	array_multisort($sort_order, SORT_ASC, $json);

	// 	$this->response->addHeader('Content-Type: application/json');
	// 	$this->response->setOutput(json_encode($json));
	// }
	// /* 27 01 2020 */
	// public function storeautocomplete(){
		
	// 	if (isset($this->request->get['sort'])) {
	// 		$sort = $this->request->get['sort'];
	// 	} else {
	// 		$sort = 'name';
	// 	}

	// 	if (isset($this->request->get['order'])) {
	// 		$order = $this->request->get['order'];
	// 	} else {
	// 		$order = 'ASC';
	// 	}
	// 	if (isset($this->request->get['page'])) {
	// 		$page = $this->request->get['page'];
	// 	} else {
	// 		$page = 1;
	// 	}
	// 	$this->load->model('vendor/vendor');
			
	// 	$filter_data = array(
	// 	'sort'  => $sort,
	// 	'order' => $order,
	// 	//'filter_name' => $filter_name,
	// 	'start' => ($page - 1) * $this->config->get('config_limit_admin'),
	// 	'limit' => $this->config->get('config_limit_admin')
	// 	);
	// 	$accounts = $this->model_vendor_vendor->getVendorsStore($filter_data);
		
	// 	foreach ($accounts as $account) {

	// 	$json[] = array(
	// 	'vendor_id'  => $account['vendor_id'],
	// 	'name'   => strip_tags(html_entity_decode($account['name'], ENT_QUOTES, 'UTF-8'))
	// 	);
	// 	}
	// 	$sort_order = array();

	// 	foreach ($json as $key => $value) {
	// 		$sort_order[$key] = $value['name'];
	// 	}

	// 	array_multisort($sort_order, SORT_ASC, $json);

	// 	$this->response->addHeader('Content-Type: application/json');
	// 	$this->response->setOutput(json_encode($json));
	// }
}
