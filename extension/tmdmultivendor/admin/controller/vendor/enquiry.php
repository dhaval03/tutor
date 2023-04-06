<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Vendor;
class Enquiry extends \Opencart\System\Engine\Controller {
	public function index(): void {
		$this->load->language('extension/tmdmultivendor/vendor/enquiry');

		$this->document->setTitle($this->language->get('heading_title'));

		$url = '';

		if (isset($this->request->get['filter_enqname'])) {
			$url .= '&filter_enqname=' . $this->request->get['filter_enqname'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}
		
		/* 11 02 2020 */
		
		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . $this->request->get['filter_vendor'];
		}
		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . $this->request->get['filter_customer_name'];
		}
		
		if (isset($this->request->get['filter_productname'])) {
			$url .= '&filter_productname=' . $this->request->get['filter_productname'];
		}
		/* 11 02 2020 */
		
		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . $this->request->get['filter_product'];
		}
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/enquiry', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['add'] = $this->url->link('extension/tmdmultivendor/vendor/enquiry|form', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/enquiry|delete', 'user_token=' . $this->session->data['user_token']);

		$data['list'] = $this->getList();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/enquiry', $data));
	}

	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/enquiry');

		$this->response->setOutput($this->getList());
	}

	protected function getList(): string {
		if (isset($this->request->get['filter_enqname'])) {
			$filter_enqname = $this->request->get['filter_enqname'];
		} else {
			$filter_enqname = '';
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = '';
		}
	
		if (isset($this->request->get['filter_product'])) {
			$filter_product = $this->request->get['filter_product'];
		} else {
			$filter_product = null;
		}
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}
		
		/* 11 02 2020 */
		if (isset($this->request->get['filter_productname'])) {
			$filter_productname = $this->request->get['filter_productname'];
		} else {
			$filter_productname = '';
		}
		if (isset($this->request->get['filter_customer_name'])) {
			$filter_customer_name = $this->request->get['filter_customer_name'];
		} else {
			$filter_customer_name = '';
		}
		
		if (isset($this->request->get['filter_vendor'])) {
			$filter_vendor = $this->request->get['filter_vendor'];
		} else {
			$filter_vendor = '';
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

		if (isset($this->request->get['filter_enqname'])) {
			$url .= '&filter_enqname=' . $this->request->get['filter_enqname'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}
		
		/* 11 02 2020 */
		
		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . $this->request->get['filter_vendor'];
		}
		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . $this->request->get['filter_customer_name'];
		}
		
		if (isset($this->request->get['filter_productname'])) {
			$url .= '&filter_productname=' . $this->request->get['filter_productname'];
		}
		/* 11 02 2020 */
		
		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . $this->request->get['filter_product'];
		}
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
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

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list', 'user_token=' . $this->session->data['user_token'] . $url);

		$data['enquirys'] = [];

		$filter_data = [
			'filter_enqname' => $filter_enqname,
			'filter_customer' => $filter_customer,
			'filter_product' => $filter_product,
			'filter_name' 	=> $filter_name,
			'filter_vendor' => $filter_vendor,
			'filter_customer_name' => $filter_customer_name,
			'filter_productname' => $filter_productname,
			'sort'              => $sort,
			'order'             => $order,
			'start'             => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit'             => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/enquiry');
		$this->load->model('extension/tmdmultivendor/vendor/product');

		$enquiry_total = $this->model_extension_tmdmultivendor_vendor_enquiry->getTotalEnquiry($filter_data);

		$results = $this->model_extension_tmdmultivendor_vendor_enquiry->getEnquires($filter_data);

		foreach ($results as $result) {

			$sellers = $this->model_extension_tmdmultivendor_vendor_enquiry->getVendor($result['vendor_id']);
			/* 11 02 2020 sname */
			if(isset($sellers['sname'])){
				$sname = $sellers['sname'];
			} else {
				$sname ='';
			}
			$customers = $this->model_extension_tmdmultivendor_vendor_enquiry->getCustomer($result['customer_id']);
			if(isset($customers['customername'])){
				$cname = $customers['customername'];
			} else {
				$cname ='Guest';
			}

			$products = $this->model_extension_tmdmultivendor_vendor_product->getProduct($result['product_id']);
			
			if(isset($products['name'])){
				$pname = $products['name'];
			} else {
				$pname ='';
			}

			$data['enquirys'][] = [
				'inquiry_id'  => $result['inquiry_id'],
				'name'  	  => $result['name'],
				'email'   	  => $result['email'],
				'pname'       => $pname,
				'sname'       => $sname,
				'cname'       => $cname,
				'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
				'status'      => ($result['status'] ? $this->language->get('text_enable') : $this->language->get('text_disable')),
				'date_added'  => $result['date_added'],
				'view'        => $this->url->link('extension/tmdmultivendor/vendor/enquiry/view', 'user_token=' . $this->session->data['user_token'] . '&inquiry_id=' . $result['inquiry_id'] . $url),
				'producturl'        => $this->url->link('extension/tmdmultivendor/vendor/product|form', 'user_token=' . $this->session->data['user_token'] . '&product_id=' . $result['product_id'] . $url),
				'edit'       => $this->url->link('extension/tmdmultivendor/vendor/enquiry|form', 'user_token=' . $this->session->data['user_token'] . '&inquiry_id=' . $result['inquiry_id'] . $url)
			];
		}

		$url = '';

		if (isset($this->request->get['filter_enqname'])) {
			$url .= '&filter_enqname=' . $this->request->get['filter_enqname'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}
				
		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . $this->request->get['filter_vendor'];
		}
		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . $this->request->get['filter_customer_name'];
		}
		
		if (isset($this->request->get['filter_productname'])) {
			$url .= '&filter_productname=' . $this->request->get['filter_productname'];
		}
		
		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . $this->request->get['filter_product'];
		}
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_product'] = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list', 'user_token=' . $this->session->data['user_token'] . '&sort=pd.name' . $url);
		$data['sort_name']     = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);
		$data['sort_email']    = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list', 'user_token=' . $this->session->data['user_token'] . '&sort=email' . $url, true);
		$data['sort_product']  = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list', 'user_token=' . $this->session->data['user_token'] . '&sort=product' . $url, true);
		$data['sort_seller']   = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list', 'user_token=' . $this->session->data['user_token'] . '&sort=seller' . $url, true);
		$data['sort_customer'] = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list', 'user_token=' . $this->session->data['user_token'] . '&sort=customer' . $url, true);
		$data['sort_status']   = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list', 'user_token=' . $this->session->data['user_token'] . '&sort=status' . $url, true);
		$data['sort_date']     = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list', 'user_token=' . $this->session->data['user_token'] . '&sort=date' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_enqname'])) {
			$url .= '&filter_enqname=' . $this->request->get['filter_enqname'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}
		
		/* 11 02 2020 */
		
		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . $this->request->get['filter_vendor'];
		}
		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . $this->request->get['filter_customer_name'];
		}
		
		if (isset($this->request->get['filter_productname'])) {
			$url .= '&filter_productname=' . $this->request->get['filter_productname'];
		}
		/* 11 02 2020 */
		
		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . $this->request->get['filter_product'];
		}
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $enquiry_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/enquiry|list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($enquiry_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($enquiry_total - $this->config->get('config_pagination_admin'))) ? $enquiry_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $enquiry_total, ceil($enquiry_total / $this->config->get('config_pagination_admin')));

		if(isset($data['filter_name'])){
			$sellers = $this->model_extension_tmdmultivendor_vendor_enquiry->getVendor($data['filter_name']);
		}

		if(isset($sellers['sname'])){
			$data['sellername'] = $sellers['sname'];
		} else {
			$data['sellername'] ='';
		}

		if(isset($data['filter_customer'])){
			$customers = $this->model_extension_tmdmultivendor_vendor_enquiry->getCustomer($data['filter_customer']);
		}
		if(isset($customers['firstname'])){
			$data['customername'] = $customers['firstname'];
		} else {
			$data['customername'] ='';
		}
		
		$this->load->model('extension/tmdmultivendor/vendor/product');
		if(isset($data['filter_product'])){
			$products_info = $this->model_extension_tmdmultivendor_vendor_product->getProduct($data['filter_product']);
		}
		if(isset($products_info['name'])){
			$names = $products_info['name'];
		} else {
			$names = '';
		}
		$data['productname'] = $names;

		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('extension/tmdmultivendor/vendor/enquiry_list', $data);
	}

	public function save(): void {
		$this->load->language('extension/tmdmultivendor/vendor/enquiry');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/enquiry')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete(): void {
		$this->load->language('extension/tmdmultivendor/vendor/enquiry');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/enquiry')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/enquiry');

			foreach ($selected as $inquiry_id) {
				$this->model_extension_tmdmultivendor_vendor_enquiry->deleteEnquiry($inquiry_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
