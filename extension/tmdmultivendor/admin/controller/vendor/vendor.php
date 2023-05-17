<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Vendor;
class Vendor extends \Opencart\System\Engine\Controller { 
	// private $error = array();

	public function index(): void {
		$this->load->language('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('extension/tmdmultivendor/vendor/store');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		
		$this->document->setTitle($this->language->get('heading_title'));

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . urlencode(html_entity_decode($this->request->get['filter_approved'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];
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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/vendor', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['setting'] = $this->url->link('extension/tmdmultivendor/vendor/vendor|setting', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['add'] = $this->url->link('extension/tmdmultivendor/vendor/vendor|form', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/vendor|delete', 'user_token=' . $this->session->data['user_token']);

		$data['list'] = $this->getList();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/vendor', $data));
	}

	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/vendor');

		$this->response->setOutput($this->getList());
	}

	protected function getList(): string {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_approved'])) {
			$filter_approved = $this->request->get['filter_approved'];
		} else {
			$filter_approved = '';
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = '';
		}

		if (isset($this->request->get['filter_date'])) {
			$filter_date = $this->request->get['filter_date'];
		} else {
			$filter_date = '';
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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . urlencode(html_entity_decode($this->request->get['filter_approved'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];
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

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/vendor|list', 'user_token=' . $this->session->data['user_token'] . $url);

		$data['vendors'] = [];

		$filter_data = [
			'filter_name'    	=> $filter_name,
			'filter_approved'   => $filter_approved,
			'filter_status'     => $filter_status,
			'filter_date' 		=> $filter_date,
			'sort'              => $sort,
			'order'             => $order,
			'start'             => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit'             => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('tool/image');

		$vendor_total = $this->model_extension_tmdmultivendor_vendor_vendor->getTotalVendor($filter_data);

		$results = $this->model_extension_tmdmultivendor_vendor_vendor->getVendors($filter_data);

		foreach ($results as $result) {
			$totalproduct = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorProducts($result['vendor_id']);
		
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}
			
			if (!$result['approved']) {
				$approve = $this->url->link('extension/tmdmultivendor/vendor/vendor|approve', 'user_token=' . $this->session->data['user_token'] . '&vendor_id=' . $result['vendor_id'] . $url, true);
			} else {
				$approve = '';
			}
			
			if ($result['approved']) {
				$disapproved = $this->url->link('extension/tmdmultivendor/vendor/vendor|disapprove', 'user_token=' . $this->session->data['user_token'] . '&vendor_id=' . $result['vendor_id'] . $url, true);
			} else {
				$disapproved = '';
			}
			if(!empty($result['firstname'])){
				$firstname = $result['firstname'];
			} else {
				$firstname ='';
			}
			if(!empty($result['lastname'])){
				$lastname = $result['lastname'];
			} else {
				$lastname ='';
			}		

			$sellername = $firstname.' '.$lastname;
		
			$vendorstorename = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorsStorename($result['vendor_id']);
			
			if(!empty($vendorstorename['name'])){
				$storename = $vendorstorename['name'];
			} else {
				$storename ='';
			}
			
			if($result['status']==1 && $result['approved']==1){
				$status = $this->language->get('text_enable');
			} elseif($result['approved']==0) {
				$status = $this->language->get('text_waitingapproved');
			} else  {
				$status = $this->language->get('text_disable');
			}			
		
			$data['vendors'][] = [
				'vendor_id'       => $result['vendor_id'],
				'display_name'    => $result['display_name'],
				'sellername' 	  => $sellername,					
				'vendorstorename' => $storename,				
				'totalproduct' 	  => $totalproduct['total'],
				'date_added' 	  => $result['date_added'],			
				'email'           => $result['email'],
				'status'          => $status,
				'approve'		  => $approve,
				'disapproved'	  => $disapproved,
				'image'		      => $image,
				'edit'            => $this->url->link('extension/tmdmultivendor/vendor/vendor|form', 'user_token=' . $this->session->data['user_token'] . '&vendor_id=' . $result['vendor_id'] . $url, true)
			];
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . urlencode(html_entity_decode($this->request->get['filter_approved'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_image'] 	= $this->url->link('extension/tmdmultivendor/vendor/vendor|list', 'user_token=' . $this->session->data['user_token'] . '&sort=image' . $url, true);
		$data['sort_display_name'] = $this->url->link('extension/tmdmultivendor/vendor/vendor|list', 'user_token=' . $this->session->data['user_token'] . '&sort=display_name' . $url, true);
		$data['sort_sellername'] = $this->url->link('extension/tmdmultivendor/vendor/vendor|list', 'user_token=' . $this->session->data['user_token'] . '&sort=vendorname' . $url, true);
		$data['sort_lastname'] 	= $this->url->link('extension/tmdmultivendor/vendor/vendor|list', 'user_token=' . $this->session->data['user_token'] . '&sort=lastname' . $url, true);
		$data['sort_email'] 	= $this->url->link('extension/tmdmultivendor/vendor/vendor|list', 'user_token=' . $this->session->data['user_token'] . '&sort=email' . $url, true);
		$data['sort_status'] 	= $this->url->link('extension/tmdmultivendor/vendor/vendor|list', 'user_token=' . $this->session->data['user_token'] . '&sort=status' . $url, true);
		$data['sort_sort_order']= $this->url->link('extension/tmdmultivendor/vendor/vendor|list', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_order' . $url, true);
		$data['sort_date_added'] = $this->url->link('extension/tmdmultivendor/vendor/vendor|list', 'user_token=' . $this->session->data['user_token'] . '&sort=date_added' . $url, true);
		$data['sort_totalproduct'] = $this->url->link('extension/tmdmultivendor/vendor/vendor|list', 'user_token=' . $this->session->data['user_token'] . '&sort=totalproduct' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . urlencode(html_entity_decode($this->request->get['filter_approved'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $vendor_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/vendor|list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($vendor_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($vendor_total - $this->config->get('config_pagination_admin'))) ? $vendor_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $vendor_total, ceil($vendor_total / $this->config->get('config_pagination_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_approved'] = $filter_approved;
		$data['filter_status'] = $filter_status;
		$data['filter_date'] = $filter_date;

		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('extension/tmdmultivendor/vendor/vendor_list', $data);
	}

	public function form(): void {
		$this->load->language('extension/tmdmultivendor/vendor/vendor');

		$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
		$this->document->addScript('view/javascript/ckeditor/adapters/jquery.js');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['text_form'] = !isset($this->request->get['vendor_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . urlencode(html_entity_decode($this->request->get['filter_approved'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];
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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/vendor', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/vendor|save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/vendor', 'user_token=' . $this->session->data['user_token'] . $url);

		if (isset($this->request->get['vendor_id'])) {
			$this->load->model('extension/tmdmultivendor/vendor/vendor');

			$vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($this->request->get['vendor_id']);
			
		}

		if (isset($this->request->get['vendor_id'])) {
			$data['vendor_id'] = (int)$this->request->get['vendor_id'];
		} else {
			$data['vendor_id'] = 0;
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

		$this->load->model('extension/tmdmultivendor/vendor/product');

		if (isset($this->request->post['display_name'])) {
			$data['display_name'] = $this->request->post['display_name'];
		} elseif (isset($vendor_info['display_name'])){
			$data['display_name'] = $vendor_info['display_name'];
		} else {
			$data['display_name'] = '';
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (isset($vendor_info['firstname'])){
			$data['firstname'] = $vendor_info['firstname'];
		} else {
			$data['firstname'] = '';
		}
		

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (isset($vendor_info['lastname'])){
			$data['lastname'] = $vendor_info['lastname'];
		} else {
			$data['lastname'] = '';
		}
		
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (isset($vendor_info['email'])){
			$data['email'] = $vendor_info['email'];
		} else {
			$data['email'] = '';
		}
		
		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (isset($vendor_info['telephone'])){
			$data['telephone'] = $vendor_info['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->request->post['fax'])) {
			$data['fax'] = $this->request->post['fax'];
		} elseif (isset($vendor_info['fax'])){
			$data['fax'] = $vendor_info['fax'];
		} else {
			$data['fax'] = '';
		}
		
		if (isset($this->request->post['about'])) {
			$data['about'] = $this->request->post['about'];
		} elseif (isset($vendor_info['about'])){
			$data['about'] = $vendor_info['about'];
		} else {
			$data['about'] = '';
		}
		
		if (isset($this->request->post['company'])) {
			$data['company'] = $this->request->post['company'];
		} elseif (isset($vendor_info['company'])){
			$data['company'] = $vendor_info['company'];
		} else {
			$data['company'] = '';
		}
		
		if (isset($this->request->post['address_1'])) {
			$data['address_1'] = $this->request->post['address_1'];
		} elseif (isset($vendor_info['address_1'])){
			$data['address_1'] = $vendor_info['address_1'];
		} else {
			$data['address_1'] = '';
		}
		
		if (isset($this->request->post['address_2'])) {
			$data['address_2'] = $this->request->post['address_2'];
		} elseif (isset($vendor_info['address_2'])){
			$data['address_2'] = $vendor_info['address_2'];
		} else {
			$data['address_2'] = '';
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (isset($vendor_info['status'])){
			$data['status'] = $vendor_info['status'];
		} else {
			$data['status'] = '';
		}
		
		if (isset($this->request->post['product_status'])) {
			$data['product_status'] = $this->request->post['product_status'];
		} elseif (isset($vendor_info['product_status'])){
			$data['product_status'] = $vendor_info['product_status'];
		} else {
			$data['product_status'] = '';
		}
		
		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (isset($vendor_info['city'])){
			$data['city'] = $vendor_info['city'];
		} else {
			$data['city'] = '';
		}
		
		if (isset($this->request->post['postcode'])) {
			$data['postcode'] = $this->request->post['postcode'];
		} elseif (isset($vendor_info['postcode'])){
			$data['postcode'] = $vendor_info['postcode'];
		} else {
			$data['postcode'] = '';
		}
		
		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = $this->request->post['country_id'];
		} elseif (isset($vendor_info['country_id'])){
			$data['country_id'] = $vendor_info['country_id'];
		} else {
			$data['country_id'] = '';
		}
		
		if (isset($this->request->post['zone_id'])) {
			$data['zone_id'] = $this->request->post['zone_id'];
		} elseif (isset($vendor_info['zone_id'])){
			$data['zone_id'] = $vendor_info['zone_id'];
		} else {
			$data['zone_id'] = '';
		}

		if (isset($this->request->post['vendor_id'])) {
			$data['vendor_id'] = $this->request->post['vendor_id'];
		} elseif (isset($vendor_info['vendor_id'])){
			$data['vendor_id'] = $vendor_info['vendor_id'];
		} else {
			$data['vendor_id'] = '';
		}
		
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (isset($vendor_info['image'])){
			$data['image'] = $vendor_info['image'];
		} else {
			$data['image'] = '';
		}
		
		$this->load->model('tool/image');
			
		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($vendor_info) && is_file(DIR_IMAGE . $vendor_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($vendor_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
			
		// Seller Store Start //
				
		if (isset($this->request->post['store_description'])) {
			$data['store_description'] = $this->request->post['store_description'];
		} elseif (isset($vendor_info)) {
			$data['store_description'] = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorStoreDescriptions($this->request->get['vendor_id']);
		} else {
			$data['store_description'] = array();
		}
		
		if (isset($this->request->post['store_about'])) {
			$data['store_about'] = $this->request->post['store_about'];
		} elseif (isset($vendor_info['store_about'])){
			$data['store_about'] = $vendor_info['store_about'];
		} else {
			$data['store_about'] = '';
		}
		
				
		if (isset($this->request->post['banner'])) {
			$data['banner'] = $this->request->post['banner'];
		} elseif (isset($vendor_info['banner'])){
			$data['banner'] = $vendor_info['banner'];
		} else {
			$data['banner'] = '';
		}
		
		
		if (isset($this->request->post['logo'])) {
			$data['logo'] = $this->request->post['logo'];
		} elseif (isset($vendor_info['logo'])){
			$data['logo'] = $vendor_info['logo'];
		} else {
			$data['logo'] = '';
		}
		
		if (isset($this->request->post['tax_number'])) {
			$data['tax_number'] = $this->request->post['tax_number'];
		} elseif (isset($vendor_info['tax_number'])){
			$data['tax_number'] = $vendor_info['tax_number'];
		} else {
			$data['tax_number'] = '';
		}

		if (isset($this->request->post['facebook_url'])) {
			$data['facebook_url'] = $this->request->post['facebook_url'];
		} elseif (isset($vendor_info['facebook_url'])){
			$data['facebook_url'] = $vendor_info['facebook_url'];
		} else {
			$data['facebook_url'] = '';
		}

		if (isset($this->request->post['google_url'])) {
			$data['google_url'] = $this->request->post['google_url'];
		} elseif (isset($vendor_info['google_url'])){
			$data['google_url'] = $vendor_info['google_url'];
		} else {
			$data['google_url'] = '';
		}

		/* Social icon */
				
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
		
		/* Social icon */
		
		if (isset($this->request->post['map_url'])) {
			$data['map_url'] = $this->request->post['map_url'];
		} elseif (isset($vendor_info['map_url'])){
			$data['map_url'] = $vendor_info['map_url'];
		} else {
			$data['map_url'] = '';
		}

		if (isset($this->request->post['shipping_charge'])) {
			$data['shipping_charge'] = $this->request->post['shipping_charge'];
		} elseif (isset($vendor_info['shipping_charge'])){
			$data['shipping_charge'] = $vendor_info['shipping_charge'];
		} else {
			$data['shipping_charge'] = '';
		}
		if (isset($this->request->post['bank_detail'])) {
			$data['bank_detail'] = $this->request->post['bank_detail'];
		} elseif (isset($vendor_info['bank_detail'])){
			$data['bank_detail'] = $vendor_info['bank_detail'];
		} else {
			$data['bank_detail'] = '';
		}
		
		if (isset($this->request->post['vendor_seo_url'])) {
			$data['vendor_seo_url'] = $this->request->post['vendor_seo_url'];
		} elseif (isset($this->request->get['vendor_id'])) {
			$data['vendor_seo_url'] = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorSeoUrls($this->request->get['vendor_id']);
		} else {
			$data['vendor_seo_url'] = [];
		}
		
		
		$this->load->model('setting/store');

		$data['stores'] = array();
		
		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);
		
		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}
		
		if (isset($this->request->post['vendor_id'])) {
			$data['vendor_id'] = $this->request->post['vendor_id'];
		} elseif (isset($vendor_info['vendor_id'])){
			$data['vendor_id'] = $vendor_info['vendor_id'];
		} else {
			$data['vendor_id'] = '';
		}
		
		if (isset($this->request->post['commission'])) {
			$data['commission'] = $this->request->post['commission'];
		} elseif (isset($vendor_info['commission'])){
			$data['commission'] = $vendor_info['commission'];
		} else {
			$data['commission'] = '';
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
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['banner']) && is_file(DIR_IMAGE . $this->request->post['banner'])) {
			$data['thumb_banner'] = $this->model_tool_image->resize($this->request->post['banner'], 100, 100);
		} elseif (!empty($vendor_info) && is_file(DIR_IMAGE . $vendor_info['banner'])) {
			$data['thumb_banner'] = $this->model_tool_image->resize($vendor_info['banner'], 100, 100);
		} else {
			$data['thumb_banner'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		if (isset($this->request->post['logo']) && is_file(DIR_IMAGE . $this->request->post['logo'])) {
			$data['thumb_logo'] = $this->model_tool_image->resize($this->request->post['logo'], 100, 100);
		} elseif (!empty($vendor_info) && is_file(DIR_IMAGE . $vendor_info['logo'])) {
			$data['thumb_logo'] = $this->model_tool_image->resize($vendor_info['logo'], 100, 100);
		} else {
			$data['thumb_logo'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		$data['banner_placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		$data['logo_placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		// Seller Store End //
		
		if(isset($vendor_info['vendor_id'])){
			$status_info = $this->model_extension_tmdmultivendor_vendor_vendor->getmsg($vendor_info['vendor_id']);
		}
		
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

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/vendor_form', $data));
	}

	public function setting() {
		$this->load->language('extension/tmdmultivendor/vendor/vendor');

		$this->document->setTitle($this->language->get('heading_title'));


		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_setting_setting->editSetting('vendor', $this->request->post);
			//SEO
			$this->load->model('extension/tmdmultivendor/vendor/vendor');
			
			$this->request->post['urlformat']='vendorlogin_seo_url';
			$this->model_extension_tmdmultivendor_vendor_vendor->saveSeoUrls($this->request->post,'extension/tmdmultivendor/vendor/login');
			
			$this->request->post['urlformat']='vendorregister_seo_url';
			$this->model_extension_tmdmultivendor_vendor_vendor->saveSeoUrls($this->request->post,'extension/tmdmultivendor/vendor/vendor');
			
			$this->request->post['urlformat']='vendorsuccess_seo_url';
			$this->model_extension_tmdmultivendor_vendor_vendor->saveSeoUrls($this->request->post,'extension/tmdmultivendor/vendor/success');
			
			$this->request->post['urlformat']='vendorprofile_seo_url';
			$this->model_extension_tmdmultivendor_vendor_vendor->saveSeoUrls($this->request->post,'extension/tmdmultivendor/vendor/vendor_profile');
			
			$this->request->post['urlformat']='vendorallseller_seo_url';
			$this->model_extension_tmdmultivendor_vendor_vendor->saveSeoUrls($this->request->post,'extension/tmdmultivendor/vendor/allseller');
			//SEO
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/vendor|setting', 'user_token=' . $this->session->data['user_token'], true));
		}
		
		
		$data['user_token'] =$this->session->data['user_token'] ;
				
		$data['heading_title'] = $this->language->get('text_settingvendor');
		$url = '';

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_vendorlist'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/vendor', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/vendor|setting', 'user_token=' . $this->session->data['user_token'] . $url);
		
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/vendor', 'user_token=' . $this->session->data['user_token'] . $url);
		
		if (isset($this->request->post['vendor_customer2vendor'])) {
			$data['vendor_customer2vendor'] = $this->request->post['vendor_customer2vendor'];
		} else {
			$data['vendor_customer2vendor'] = $this->config->get('vendor_customer2vendor');
		}

		if (isset($this->request->post['vendor_vendor2customer'])) {
			$data['vendor_vendor2customer'] = $this->request->post['vendor_vendor2customer'];
		} else {
			$data['vendor_vendor2customer'] = $this->config->get('vendor_vendor2customer');
		}	
        
        if (isset($this->request->post['vendor_vendorautoapprove'])) {
			$data['vendor_vendorautoapprove'] = $this->request->post['vendor_vendorautoapprove'];
		} else {
			$data['vendor_vendorautoapprove'] = $this->config->get('vendor_vendorautoapprove');
		}	
        
        if (isset($this->request->post['vendor_proautoapprove'])) {
			$data['vendor_proautoapprove'] = $this->request->post['vendor_proautoapprove'];
		} else {
			$data['vendor_proautoapprove'] = $this->config->get('vendor_proautoapprove');
		}	
		
        if (isset($this->request->post['vendor_hidevendorcontact'])) {
			$data['vendor_hidevendorcontact'] = $this->request->post['vendor_hidevendorcontact'];
		} else {
			$data['vendor_hidevendorcontact'] = $this->config->get('vendor_hidevendorcontact');
		}	
		
        if (isset($this->request->post['vendor_hidevendorname'])) {
			$data['vendor_hidevendorname'] = $this->request->post['vendor_hidevendorname'];
		} else {
			 $data['vendor_hidevendorname'] = $this->config->get('vendor_hidevendorname');
		}
		
		if (isset($this->request->post['vendor_vhidevname'])) {
			$data['vendor_vhidevname'] = $this->request->post['vendor_vhidevname'];
		} else {
			 $data['vendor_vhidevname'] = $this->config->get('vendor_vhidevname');
		}
		
        if (isset($this->request->post['vendor_hidevemail'])) {
			$data['vendor_hidevemail'] = $this->request->post['vendor_hidevemail'];
		} else {
			 $data['vendor_hidevemail'] = $this->config->get('vendor_hidevemail');
		}
		
		
        if (isset($this->request->post['vendor_hidevponeno'])) {
			$data['vendor_hidevponeno'] = $this->request->post['vendor_hidevponeno'];
		} else {
			 $data['vendor_hidevponeno'] = $this->config->get('vendor_hidevponeno');
		}
		
        if (isset($this->request->post['vendor_hidevsocialicon'])) {
			$data['vendor_hidevsocialicon'] = $this->request->post['vendor_hidevsocialicon'];
		} else {
			$data['vendor_hidevsocialicon'] = $this->config->get('vendor_hidevsocialicon');
		}
      
        if (isset($this->request->post['vendor_vprivacy_id'])) {
			$data['vendor_vprivacy_id'] = $this->request->post['vendor_vprivacy_id'];
		} else {
			 $data['vendor_vprivacy_id'] = $this->config->get('vendor_vprivacy_id');
		}
		
		$this->load->model('catalog/information');

		$data['informations'] = $this->model_catalog_information->getInformations();

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['vendor_languages'])) {
			$data['vendor_languages'] = $this->request->post['vendor_languages'];
		} else {
			$data['vendor_languages'] = $this->config->get('vendor_languages');;
		}
						
		if (isset($this->request->post['vendor_showorder_status'])) {
			$data['vendor_showorder_status'] = $this->request->post['vendor_showorder_status'];
		} elseif ($this->config->get('vendor_showorder_status')) {
			$data['vendor_showorder_status'] = $this->config->get('vendor_showorder_status');
		} else {
			$data['vendor_showorder_status'] = array();
		}
		
		if (isset($this->request->post['vendor_earnpayment_status'])) {
			$data['vendor_earnpayment_status'] = $this->request->post['vendor_earnpayment_status'];
		} elseif ($this->config->get('vendor_earnpayment_status')) {
			$data['vendor_earnpayment_status'] = $this->config->get('vendor_earnpayment_status');
		} else {
			$data['vendor_earnpayment_status'] = array();
		}
		
		if (isset($this->request->post['vendor_aboutstore'])) {
			$data['vendor_aboutstore'] = $this->request->post['vendor_aboutstore'];
		} elseif ($this->config->get('vendor_aboutstore')) {
			$data['vendor_aboutstore'] = $this->config->get('vendor_aboutstore');
		} else {
			$data['vendor_aboutstore'] = '';
		}
		
		if (isset($this->request->post['vendor_tabproduct'])) {
			$data['vendor_tabproduct'] = $this->request->post['vendor_tabproduct'];
		} elseif ($this->config->get('vendor_tabproduct')) {
			$data['vendor_tabproduct'] = $this->config->get('vendor_tabproduct');
		} else {
			$data['vendor_tabproduct'] = '';
		}		
		
		if (isset($this->request->post['vendor_review'])) {
			$data['vendor_review'] = $this->request->post['vendor_review'];
		} elseif ($this->config->get('vendor_review')) {
			$data['vendor_review'] = $this->config->get('vendor_review');
		} else {
			$data['vendor_review'] = '';
		}
		
		if (isset($this->request->post['vendor_productreview'])) {
			$data['vendor_productreview'] = $this->request->post['vendor_productreview'];
		} elseif ($this->config->get('vendor_productreview')) {
			$data['vendor_productreview'] = $this->config->get('vendor_productreview');
		} else {
			$data['vendor_productreview'] = '';
		}
		
		if (isset($this->request->post['vendor_profile'])) {
			$data['vendor_profile'] = $this->request->post['vendor_profile'];
		} elseif ($this->config->get('vendor_profile')) {
			$data['vendor_profile'] = $this->config->get('vendor_profile');
		} else {
			$data['vendor_profile'] = '';
		}
		
		if (isset($this->request->post['vendor_aboutstoresort'])) {
			$data['vendor_aboutstoresort'] = $this->request->post['vendor_aboutstoresort'];
		} elseif ($this->config->get('vendor_aboutstoresort')) {
			$data['vendor_aboutstoresort'] = $this->config->get('vendor_aboutstoresort');
		} else {
			$data['vendor_aboutstoresort'] = '';
		}
		
		if (isset($this->request->post['vendor_tabproductsort'])) {
			$data['vendor_tabproductsort'] = $this->request->post['vendor_tabproductsort'];
		} elseif ($this->config->get('vendor_tabproductsort')) {
			$data['vendor_tabproductsort'] = $this->config->get('vendor_tabproductsort');
		} else {
			$data['vendor_tabproductsort'] = '';
		}
		
		if (isset($this->request->post['vendor_reviewsort'])) {
			$data['vendor_reviewsort'] = $this->request->post['vendor_reviewsort'];
		} elseif ($this->config->get('vendor_reviewsort')) {
			$data['vendor_reviewsort'] = $this->config->get('vendor_reviewsort');
		} else {
			$data['vendor_reviewsort'] = '';
		}
		
		if (isset($this->request->post['vendor_productreviewsort'])) {
			$data['vendor_productreviewsort'] = $this->request->post['vendor_productreviewsort'];
		} elseif ($this->config->get('vendor_productreviewsort')) {
			$data['vendor_productreviewsort'] = $this->config->get('vendor_productreviewsort');
		} else {
			$data['vendor_productreviewsort'] = '';
		}	
		
		if (isset($this->request->post['vendor_profilestoresort'])) {
			$data['vendor_profilestoresort'] = $this->request->post['vendor_profilestoresort'];
		} elseif ($this->config->get('vendor_profilestoresort')) {
			$data['vendor_profilestoresort'] = $this->config->get('vendor_profilestoresort');
		} else {
			$data['vendor_profilestoresort'] = '';
		}	
		
		/*advance settings */
		if (isset($this->request->post['vendor_required_displayname'])) {
			$data['vendor_required_displayname'] = $this->request->post['vendor_required_displayname'];
		} elseif ($this->config->get('vendor_required_displayname')) {
			$data['vendor_required_displayname'] = $this->config->get('vendor_required_displayname');
		} else {
			$data['vendor_required_displayname'] = '';
		}
		
		if (isset($this->request->post['vendor_status_displayname'])) {
			$data['vendor_status_displayname'] = $this->request->post['vendor_status_displayname'];
		} elseif ($this->config->get('vendor_status_displayname')) {
			$data['vendor_status_displayname'] = $this->config->get('vendor_status_displayname');
		} else {
			$data['vendor_status_displayname'] = '';
		}
		
		if (isset($this->request->post['vendor_required_lastname'])) {
			$data['vendor_required_lastname'] = $this->request->post['vendor_required_lastname'];
		} elseif ($this->config->get('vendor_required_lastname')) {
			$data['vendor_required_lastname'] = $this->config->get('vendor_required_lastname');
		} else {
			$data['vendor_required_lastname'] = '';
		}
		
		if (isset($this->request->post['vendor_status_lastname'])) {
			$data['vendor_status_lastname'] = $this->request->post['vendor_status_lastname'];
		} elseif ($this->config->get('vendor_status_lastname')) {
			$data['vendor_status_lastname'] = $this->config->get('vendor_status_lastname');
		} else {
			$data['vendor_status_lastname'] = '';
		}
		
		if (isset($this->request->post['vendor_required_telephone'])) {
			$data['vendor_required_telephone'] = $this->request->post['vendor_required_telephone'];
		} elseif ($this->config->get('vendor_required_telephone')) {
			$data['vendor_required_telephone'] = $this->config->get('vendor_required_telephone');
		} else {
			$data['vendor_required_telephone'] = '';
		}
		
		if (isset($this->request->post['vendor_status_telephone'])) {
			$data['vendor_status_telephone'] = $this->request->post['vendor_status_telephone'];
		} elseif ($this->config->get('vendor_status_telephone')) {
			$data['vendor_status_telephone'] = $this->config->get('vendor_status_telephone');
		} else {
			$data['vendor_status_telephone'] = '';
		}
		
		if (isset($this->request->post['vendor_required_fax'])) {
			$data['vendor_required_fax'] = $this->request->post['vendor_required_fax'];
		} elseif ($this->config->get('vendor_required_fax')) {
			$data['vendor_required_fax'] = $this->config->get('vendor_required_fax');
		} else {
			$data['vendor_required_fax'] = '';
		}
		
		if (isset($this->request->post['vendor_status_fax'])) {
			$data['vendor_status_fax'] = $this->request->post['vendor_status_fax'];
		} elseif ($this->config->get('vendor_status_fax')) {
			$data['vendor_status_fax'] = $this->config->get('vendor_status_fax');
		} else {
			$data['vendor_status_fax'] = '';
		}
		
		if (isset($this->request->post['vendor_required_company'])) {
			$data['vendor_required_company'] = $this->request->post['vendor_required_company'];
		} elseif ($this->config->get('vendor_required_company')) {
			$data['vendor_required_company'] = $this->config->get('vendor_required_company');
		} else {
			$data['vendor_required_company'] = '';
		}
		
		if (isset($this->request->post['vendor_status_company'])) {
			$data['vendor_status_company'] = $this->request->post['vendor_status_company'];
		} elseif ($this->config->get('vendor_status_company')) {
			$data['vendor_status_company'] = $this->config->get('vendor_status_company');
		} else {
			$data['vendor_status_company'] = '';
		}
		
		if (isset($this->request->post['vendor_required_address_1'])) {
			$data['vendor_required_address_1'] = $this->request->post['vendor_required_address_1'];
		} elseif ($this->config->get('vendor_required_address_1')) {
			$data['vendor_required_address_1'] = $this->config->get('vendor_required_address_1');
		} else {
			$data['vendor_required_address_1'] = '';
		}
		
		if (isset($this->request->post['vendor_status_address_1'])) {
			$data['vendor_status_address_1'] = $this->request->post['vendor_status_address_1'];
		} elseif ($this->config->get('vendor_status_address_1')) {
			$data['vendor_status_address_1'] = $this->config->get('vendor_status_address_1');
		} else {
			$data['vendor_status_address_1'] = '';
		}
		
		if (isset($this->request->post['vendor_required_address_2'])) {
			$data['vendor_required_address_2'] = $this->request->post['vendor_required_address_2'];
		} elseif ($this->config->get('vendor_required_address_2')) {
			$data['vendor_required_address_2'] = $this->config->get('vendor_required_address_2');
		} else {
			$data['vendor_required_address_2'] = '';
		}
		
		if (isset($this->request->post['vendor_status_address_2'])) {
			$data['vendor_status_address_2'] = $this->request->post['vendor_status_address_2'];
		} elseif ($this->config->get('vendor_status_address_2')) {
			$data['vendor_status_address_2'] = $this->config->get('vendor_status_address_2');
		} else {
			$data['vendor_status_address_2'] = '';
		}
		
		if (isset($this->request->post['vendor_required_city'])) {
			$data['vendor_required_city'] = $this->request->post['vendor_required_city'];
		} elseif ($this->config->get('vendor_required_city')) {
			$data['vendor_required_city'] = $this->config->get('vendor_required_city');
		} else {
			$data['vendor_required_city'] = '';
		}
		
		if (isset($this->request->post['vendor_status_city'])) {
			$data['vendor_status_city'] = $this->request->post['vendor_status_city'];
		} elseif ($this->config->get('vendor_status_city')) {
			$data['vendor_status_city'] = $this->config->get('vendor_status_city');
		} else {
			$data['vendor_status_city'] = '';
		}
		
		if (isset($this->request->post['vendor_required_country'])) {
			$data['vendor_required_country'] = $this->request->post['vendor_required_country'];
		} elseif ($this->config->get('vendor_required_country')) {
			$data['vendor_required_country'] = $this->config->get('vendor_required_country');
		} else {
			$data['vendor_required_country'] = '';
		}
		
		if (isset($this->request->post['vendor_status_country'])) {
			$data['vendor_status_country'] = $this->request->post['vendor_status_country'];
		} elseif ($this->config->get('vendor_status_country')) {
			$data['vendor_status_country'] = $this->config->get('vendor_status_country');
		} else {
			$data['vendor_status_country'] = '';
		}
		
		if (isset($this->request->post['vendor_required_zone'])) {
			$data['vendor_required_zone'] = $this->request->post['vendor_required_zone'];
		} elseif ($this->config->get('vendor_required_zone')) {
			$data['vendor_required_zone'] = $this->config->get('vendor_required_zone');
		} else {
			$data['vendor_required_zone'] = '';
		}
		
		if (isset($this->request->post['vendor_status_zone'])) {
			$data['vendor_status_zone'] = $this->request->post['vendor_status_zone'];
		} elseif ($this->config->get('vendor_status_zone')) {
			$data['vendor_status_zone'] = $this->config->get('vendor_status_zone');
		} else {
			$data['vendor_status_zone'] = '';
		}
		
		
		if (isset($this->request->post['vendor_vpostcode'])) {
			$data['vendor_vpostcode'] = $this->request->post['vendor_vpostcode'];
		} elseif ($this->config->get('vendor_vpostcode')) {
			$data['vendor_vpostcode'] = $this->config->get('vendor_vpostcode');
		} else {
			$data['vendor_vpostcode'] = '';
		}
		
		if (isset($this->request->post['vendor_status_postcode'])) {
			$data['vendor_status_postcode'] = $this->request->post['vendor_status_postcode'];
		} elseif ($this->config->get('vendor_status_postcode')) {
			$data['vendor_status_postcode'] = $this->config->get('vendor_status_postcode');
		} else {
			$data['vendor_status_postcode'] = '';
		}
		
		if (isset($this->request->post['vendor_required_about'])) {
			$data['vendor_required_about'] = $this->request->post['vendor_required_about'];
		} elseif ($this->config->get('vendor_required_about')) {
			$data['vendor_required_about'] = $this->config->get('vendor_required_about');
		} else {
			$data['vendor_required_about'] = '';
		}
		
		if (isset($this->request->post['vendor_status_about'])) {
			$data['vendor_status_about'] = $this->request->post['vendor_status_about'];
		} elseif ($this->config->get('vendor_status_about')) {
			$data['vendor_status_about'] = $this->config->get('vendor_status_about');
		} else {
			$data['vendor_status_about'] = '';
		}
		
		if (isset($this->request->post['vendor_status_image'])) {
			$data['vendor_status_image'] = $this->request->post['vendor_status_image'];
		} elseif ($this->config->get('vendor_status_image')) {
			$data['vendor_status_image'] = $this->config->get('vendor_status_image');
		} else {
			$data['vendor_status_image'] = '';
		}
		
		//general tab
		
		if (isset($this->request->post['vendor_required_meta_description'])) {
			$data['vendor_required_meta_description'] = $this->request->post['vendor_required_meta_description'];
		} elseif ($this->config->get('vendor_required_meta_description')) {
			$data['vendor_required_meta_description'] = $this->config->get('vendor_required_meta_description');
		} else {
			$data['vendor_required_meta_description'] = '';
		}
		
		if (isset($this->request->post['vendor_status_meta_description'])) {
			$data['vendor_status_meta_description'] = $this->request->post['vendor_status_meta_description'];
		} elseif ($this->config->get('vendor_status_meta_description')) {
			$data['vendor_status_meta_description'] = $this->config->get('vendor_status_meta_description');
		} else {
			$data['vendor_status_meta_description'] = '';
		}
		
		if (isset($this->request->post['vendor_required_description'])) {
			$data['vendor_required_description'] = $this->request->post['vendor_required_description'];
		} elseif ($this->config->get('vendor_required_description')) {
			$data['vendor_required_description'] = $this->config->get('vendor_required_description');
		} else {
			$data['vendor_required_description'] = '';
		}
		
		if (isset($this->request->post['vendor_status_description'])) {
			$data['vendor_status_description'] = $this->request->post['vendor_status_description'];
		} elseif ($this->config->get('vendor_status_description')) {
			$data['vendor_status_description'] = $this->config->get('vendor_status_description');
		} else {
			$data['vendor_status_description'] = '';
		}
		
		if (isset($this->request->post['vendor_required_shipping_policy'])) {
			$data['vendor_required_shipping_policy'] = $this->request->post['vendor_required_shipping_policy'];
		} elseif ($this->config->get('vendor_required_shipping_policy')) {
			$data['vendor_required_shipping_policy'] = $this->config->get('vendor_required_shipping_policy');
		} else {
			$data['vendor_required_shipping_policy'] = '';
		}
		
		if (isset($this->request->post['vendor_status_shipping_policy'])) {
			$data['vendor_status_shipping_policy'] = $this->request->post['vendor_status_shipping_policy'];
		} elseif ($this->config->get('vendor_status_shipping_policy')) {
			$data['vendor_status_shipping_policy'] = $this->config->get('vendor_status_shipping_policy');
		} else {
			$data['vendor_status_shipping_policy'] = '';
		}
		
		if (isset($this->request->post['vendor_required_return_policy'])) {
			$data['vendor_required_return_policy'] = $this->request->post['vendor_required_return_policy'];
		} elseif ($this->config->get('vendor_required_return_policy')) {
			$data['vendor_required_return_policy'] = $this->config->get('vendor_required_return_policy');
		} else {
			$data['vendor_required_return_policy'] = '';
		}
		
		if (isset($this->request->post['vendor_status_return_policy'])) {
			$data['vendor_status_return_policy'] = $this->request->post['vendor_status_return_policy'];
		} elseif ($this->config->get('vendor_status_return_policy')) {
			$data['vendor_status_return_policy'] = $this->config->get('vendor_status_return_policy');
		} else {
			$data['vendor_status_return_policy'] = '';
		}
		
		if (isset($this->request->post['vendor_required_meta_keyword'])) {
			$data['vendor_required_meta_keyword'] = $this->request->post['vendor_required_meta_keyword'];
		} elseif ($this->config->get('vendor_required_meta_keyword')) {
			$data['vendor_required_meta_keyword'] = $this->config->get('vendor_required_meta_keyword');
		} else {
			$data['vendor_required_meta_keyword'] = '';
		}
		
		if (isset($this->request->post['vendor_status_meta_keyword'])) {
			$data['vendor_status_meta_keyword'] = $this->request->post['vendor_status_meta_keyword'];
		} elseif ($this->config->get('vendor_status_meta_keyword')) {
			$data['vendor_status_meta_keyword'] = $this->config->get('vendor_status_meta_keyword');
		} else {
			$data['vendor_status_meta_keyword'] = '';
		}
		
		if (isset($this->request->post['vendor_required_bank_detail'])) {
			$data['vendor_required_bank_detail'] = $this->request->post['vendor_required_bank_detail'];
		} elseif ($this->config->get('vendor_required_bank_detail')) {
			$data['vendor_required_bank_detail'] = $this->config->get('vendor_required_bank_detail');
		} else {
			$data['vendor_required_bank_detail'] = '';
		}
		
		if (isset($this->request->post['vendor_status_bank_detail'])) {
			$data['vendor_status_bank_detail'] = $this->request->post['vendor_status_bank_detail'];
		} elseif ($this->config->get('vendor_status_bank_detail')) {
			$data['vendor_status_bank_detail'] = $this->config->get('vendor_status_bank_detail');
		} else {
			$data['vendor_status_bank_detail'] = '';
		}
		
		if (isset($this->request->post['vendor_required_storeabout'])) {
			$data['vendor_required_storeabout'] = $this->request->post['vendor_required_storeabout'];
		} elseif ($this->config->get('vendor_required_storeabout')) {
			$data['vendor_required_storeabout'] = $this->config->get('vendor_required_storeabout');
		} else {
			$data['vendor_required_storeabout'] = '';
		}
		
		if (isset($this->request->post['vendor_status_storeabout'])) {
			$data['vendor_status_storeabout'] = $this->request->post['vendor_status_storeabout'];
		} elseif ($this->config->get('vendor_status_storeabout')) {
			$data['vendor_status_storeabout'] = $this->config->get('vendor_status_storeabout');
		} else {
			$data['vendor_status_storeabout'] = '';
		}
		
		if (isset($this->request->post['vendor_required_mapurl'])) {
			$data['vendor_required_mapurl'] = $this->request->post['vendor_required_mapurl'];
		} elseif ($this->config->get('vendor_required_mapurl')) {
			$data['vendor_required_mapurl'] = $this->config->get('vendor_required_mapurl');
		} else {
			$data['vendor_required_mapurl'] = '';
		}
		
		if (isset($this->request->post['vendor_status_mapurl'])) {
			$data['vendor_status_mapurl'] = $this->request->post['vendor_status_mapurl'];
		} elseif ($this->config->get('vendor_status_mapurl')) {
			$data['vendor_status_mapurl'] = $this->config->get('vendor_status_mapurl');
		} else {
			$data['vendor_status_mapurl'] = '';
		}
		
		if (isset($this->request->post['vendor_required_tax_number'])) {
			$data['vendor_required_tax_number'] = $this->request->post['vendor_required_tax_number'];
		} elseif ($this->config->get('vendor_required_tax_number')) {
			$data['vendor_required_tax_number'] = $this->config->get('vendor_required_tax_number');
		} else {
			$data['vendor_required_tax_number'] = '';
		}
		
		if (isset($this->request->post['vendor_status_tax_number'])) {
			$data['vendor_status_tax_number'] = $this->request->post['vendor_status_tax_number'];
		} elseif ($this->config->get('vendor_status_tax_number')) {
			$data['vendor_status_tax_number'] = $this->config->get('vendor_status_tax_number');
		} else {
			$data['vendor_status_tax_number'] = '';
		}
		
		if (isset($this->request->post['vendor_required_shipping_charge'])) {
			$data['vendor_required_shipping_charge'] = $this->request->post['vendor_required_shipping_charge'];
		} elseif ($this->config->get('vendor_required_shipping_charge')) {
			$data['vendor_required_shipping_charge'] = $this->config->get('vendor_required_shipping_charge');
		} else {
			$data['vendor_required_shipping_charge'] = '';
		}
		
		if (isset($this->request->post['vendor_status_shipping_charge'])) {
			$data['vendor_status_shipping_charge'] = $this->request->post['vendor_status_shipping_charge'];
		} elseif ($this->config->get('vendor_status_shipping_charge')) {
			$data['vendor_status_shipping_charge'] = $this->config->get('vendor_status_shipping_charge');
		} else {
			$data['vendor_status_shipping_charge'] = '';
		}
		
		if (isset($this->request->post['vendor_status_url'])) {
			$data['vendor_status_url'] = $this->request->post['vendor_status_url'];
		} elseif ($this->config->get('vendor_status_url')) {
			$data['vendor_status_url'] = $this->config->get('vendor_status_url');
		} else {
			$data['vendor_status_url'] = '';
		}
		
		if (isset($this->request->post['vendor_required_url'])) {
			$data['vendor_required_url'] = $this->request->post['vendor_required_url'];
		} elseif ($this->config->get('vendor_required_url')) {
			$data['vendor_required_url'] = $this->config->get('vendor_required_url');
		} else {
			$data['vendor_required_url'] = '';
		}
		
		if (isset($this->request->post['vendor_status_logo'])) {
			$data['vendor_status_logo'] = $this->request->post['vendor_status_logo'];
		} elseif ($this->config->get('vendor_status_logo')) {
			$data['vendor_status_logo'] = $this->config->get('vendor_status_logo');
		} else {
			$data['vendor_status_logo'] = '';
		}
		
		if (isset($this->request->post['vendor_status_banner'])) {
			$data['vendor_status_banner'] = $this->request->post['vendor_status_banner'];
		} elseif ($this->config->get('vendor_status_banner')) {
			$data['vendor_status_banner'] = $this->config->get('vendor_status_banner');
		} else {
			$data['vendor_status_banner'] = '';
		}
		
		if (isset($this->request->post['vendor_status_paypal'])) {
			$data['vendor_status_paypal'] = $this->request->post['vendor_status_paypal'];
		} elseif ($this->config->get('vendor_status_paypal')) {
			$data['vendor_status_paypal'] = $this->config->get('vendor_status_paypal');
		} else {
			$data['vendor_status_paypal'] = '';
		}
		
		if (isset($this->request->post['vendor_status_bank'])) {
			$data['vendor_status_bank'] = $this->request->post['vendor_status_bank'];
		} elseif ($this->config->get('vendor_status_bank')) {
			$data['vendor_status_bank'] = $this->config->get('vendor_status_bank');
		} else {
			$data['vendor_status_bank'] = '';
		}
		
		//SEO
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		
		$data['vendorlogin_seo_url'] = $this->model_extension_tmdmultivendor_vendor_vendor->getSeoUrls('extension/tmdmultivendor/vendor/login');
		
		$data['vendorregister_seo_url'] = $this->model_extension_tmdmultivendor_vendor_vendor->getSeoUrls('extension/tmdmultivendor/vendor/vendor');
		
		$data['vendorsuccess_seo_url'] = $this->model_extension_tmdmultivendor_vendor_vendor->getSeoUrls('extension/tmdmultivendor/vendor/success');
		
		$data['vendorprofile_seo_url'] = $this->model_extension_tmdmultivendor_vendor_vendor->getSeoUrls('extension/tmdmultivendor/vendor/vendor_profile');
		
		$data['vendorallseller_seo_url'] = $this->model_extension_tmdmultivendor_vendor_vendor->getSeoUrls('extension/tmdmultivendor/vendor/allseller');
		
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
		//SEO
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();	

		$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
		$this->document->addScript('view/javascript/ckeditor/adapters/jquery.js');

		$data['user_token'] = $this->session->data['user_token'];	
						
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/vendor_setting', $data));
	}	

	public function save(): void {
		$this->load->language('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/vendor')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		if ((strlen($this->request->post['display_name']) < 2) || (strlen($this->request->post['display_name']) > 64)) {
			$json['error']['display_name'] = $this->language->get('error_display_name');
		}

		if ((strlen($this->request->post['firstname']) < 2) || (strlen($this->request->post['firstname']) > 64)) {
			$json['error']['firstname'] = $this->language->get('error_firstname');
		}

		if ((strlen($this->request->post['lastname']) < 2) || (strlen($this->request->post['lastname']) > 64)) {
			$json['error']['lastname'] = $this->language->get('error_lastname');
		}

		if ((strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$json['error']['email'] = $this->language->get('error_email');
		}

		$email_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorByEmail($this->request->post['email']);

		if (!$this->request->post['vendor_id']) {
			if ($email_info) {
				$json['error']['warning'] = $this->language->get('error_email_match');
			}
		} else {
			if ($email_info && ($this->request->post['vendor_id'] != $email_info['vendor_id'])) {
				$json['error']['warning'] = $this->language->get('error_email_match');
			}
		}
				
		if ((strlen($this->request->post['telephone']) < 2) || (strlen($this->request->post['telephone']) > 64)) {
			$json['error']['telephone'] = $this->language->get('error_telephone');
		}
		
		if ((strlen($this->request->post['address_1']) < 2) || (strlen($this->request->post['address_1']) > 64)) {
			$json['error']['address_1'] = $this->language->get('error_address_1');
		}
		
		if ((strlen($this->request->post['city']) < 2) || (strlen($this->request->post['city']) > 64)) {
			$json['error']['city'] = $this->language->get('error_city');
		}

		if ($this->request->post['password'] || (!isset($this->request->post['vendor_id']))) {
			if ((strlen(html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8')) < 4) || (strlen(html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8')) > 40)) {
				$json['error']['password'] = $this->language->get('error_password');
			}

			if ($this->request->post['password'] != $this->request->post['confirmpassword']) {
				$json['error']['confirmpassword'] = $this->language->get('error_confirm');
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

		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
			$json['error']['zone'] = $this->language->get('error_zone');
		}

		foreach ($this->request->post['store_description'] as $language_id => $value) {
			if ((strlen(trim($value['name'])) < 1) || (strlen($value['name']) > 255)) {
				$json['error']['name_' . $language_id] = $this->language->get('error_name');
			}
		}

		if ($this->request->post['payment_method'] == 'paypal') {
			if ((strlen($this->request->post['paypal']) > 96) || !filter_var($this->request->post['paypal'], FILTER_VALIDATE_EMAIL)) {
				$json['error']['paypal'] = $this->language->get('error_paypal');
			}
		} elseif ($this->request->post['payment_method'] == 'banktransfer') {
			if ($this->request->post['bank_name'] == '') {
				$json['error']['bankname'] = $this->language->get('error_bankname');
			}

			if ($this->request->post['bank_account_name'] == '') {
				$json['error']['bank_account_name'] = $this->language->get('error_bank_account_name');
			}

			if ($this->request->post['bank_account_number'] == '') {
				$json['error']['bank_account_number'] = $this->language->get('error_bank_account_number');
			}
		}

		if ($this->request->post['vendor_seo_url']) {
			$this->load->model('design/seo_url');

			foreach ($this->request->post['vendor_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if ($keyword) {
						$seo_url_info = $this->model_design_seo_url->getSeoUrlByKeyword($keyword, $store_id, $language_id);

						if ($seo_url_info && ($seo_url_info['key'] != 'vendor_id' || !isset($this->request->post['vendor_id']) || $seo_url_info['value'] != (int)$this->request->post['vendor_id'])) {
							$json['error']['keyword_' . $store_id . '_' . $language_id] = $this->language->get('error_keyword');
						}
					} else {
						$json['error']['keyword_' . $store_id . '_' . $language_id] = $this->language->get('error_seo');
					}
				}
			}
		}	

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			
			
			if (!$this->request->post['vendor_id']) {
				$json['vendor_id'] = $this->model_extension_tmdmultivendor_vendor_vendor->addVendor($this->request->post);
			} else {
				$this->model_extension_tmdmultivendor_vendor_vendor->editVendor($this->request->post['vendor_id'], $this->request->post);
			}
			
			
			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete(): void {
		$this->load->language('extension/tmdmultivendor/vendor/vendor');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/vendor')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/vendor');

			foreach ($selected as $vendor_id) {
				$this->model_extension_tmdmultivendor_vendor_vendor->deleteVendor($vendor_id);
			}

			$json['success'] = $this->language->get('text_success');
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
	
	public function autocomplete(){	
		/* 20 08 2020 */
		$json = [];
		/* 20 08 2020 */
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}
			
		if (isset($this->request->get['filter_seller'])) {
				$filter_seller = $this->request->get['filter_seller'];
			} else {
				$filter_seller = '';
			}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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
		'filter_seller' => $filter_seller,
		'filter_name' => $filter_name,
		'start' => 0,
		'limit' => 5
		);
		$accounts = $this->model_extension_tmdmultivendor_vendor_vendor->getVendors($filter_data);
		foreach ($accounts as $account) {
			$json[] = array(
				'vendor_id'  => $account['vendor_id'],
				'vendorname'   => strip_tags(html_entity_decode($account['vendorname'], ENT_QUOTES, 'UTF-8'))
			);
		}
		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['vendorname'];
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function approve(){
		$this->load->language('extension/tmdmultivendor/vendor/vendor');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$approves = [];
		if (isset($this->request->post['selected'])){
			$approve = $this->request->post['selected'];
		} 
		elseif (isset($this->request->get['vendor_id'])){
			$approves[] = $this->request->get['vendor_id'];
		}
		if (isset($approves)){
			foreach($approves as $vendor_id){
				$this->model_extension_tmdmultivendor_vendor_vendor->approve($vendor_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			/* 18 02 2020 */
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
			
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}
		
			
			if (isset($this->request->get['filter_date'])) {
				$url .= '&filter_date=' . $this->request->get['filter_date'];
			}
				/* 18 02 2020 */
			if (isset($this->request->get['sort'])){
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])){
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/vendor', 'user_token=' . $this->session->data['user_token'] . $url, true));


		}
		$this->response->setOutput($this->getList());	
	}

	public function disapprove(){
		$this->load->language('extension/tmdmultivendor/vendor/vendor');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$approves = [];
		if (isset($this->request->post['selected'])){
			$approve = $this->request->post['selected'];
		} 
		elseif (isset($this->request->get['vendor_id'])){
			$approves[] = $this->request->get['vendor_id'];
		}
		if ($approves){
			foreach($approves as $vendor_id){
				$this->model_extension_tmdmultivendor_vendor_vendor->Disapprove($vendor_id);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			
			/* 18 02 2020 */
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
			
			
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}
			
			
			if (isset($this->request->get['filter_date'])) {
				$url .= '&filter_date=' . $this->request->get['filter_date'];
			}
			/* 18 02 2020 */
			if (isset($this->request->get['sort'])){
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['page'])){
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/vendor', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}
		$this->response->setOutput($this->getList());	 

	 }	
}


