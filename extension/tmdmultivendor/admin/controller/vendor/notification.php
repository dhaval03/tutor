<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Vendor;
class Notification extends \Opencart\System\Engine\Controller { 
	// private $error = array();
	public function index(): void {
		$this->load->language('extension/tmdmultivendor/vendor/notification');

		$this->document->setTitle($this->language->get('heading_title'));

		$url = '';

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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/notification', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['add'] = $this->url->link('extension/tmdmultivendor/vendor/notification|form', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/notification|delete', 'user_token=' . $this->session->data['user_token']);

		$data['list'] = $this->getList();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/notification', $data));
	}

	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/notification');

		$this->response->setOutput($this->getList());
	}

	protected function getList(): string {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'notification_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/notification|list', 'user_token=' . $this->session->data['user_token'] . $url);

		$data['notifications'] = [];

		$filter_data = [
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/notification');

		$notification_total = $this->model_extension_tmdmultivendor_vendor_notification->getTotalNotifications($filter_data);

		$results = $this->model_extension_tmdmultivendor_vendor_notification->getNotifications($filter_data);

		foreach ($results as $result) {
			$data['notifications'][] = [
				'notification_id'   => $result['notification_id'],
				'message'    	  => html_entity_decode($result['message']),
				'date'			  => $result['date'],
				'edit'           => $this->url->link('extension/tmdmultivendor/vendor/notification|form', 'user_token=' . $this->session->data['user_token'] . '&notification_id=' . $result['notification_id'] . $url)
			];
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_message'] = $this->url->link('extension/tmdmultivendor/vendor/notification|list', 'user_token=' . $this->session->data['user_token'] . '&sort=message' . $url);
		$data['sort_date'] = $this->url->link('extension/tmdmultivendor/vendor/notification|list', 'user_token=' . $this->session->data['user_token'] . '&sort=date' . $url);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $notification_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/notification|list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($notification_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($notification_total - $this->config->get('config_pagination_admin'))) ? $notification_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $notification_total, ceil($notification_total / $this->config->get('config_pagination_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('extension/tmdmultivendor/vendor/notification_list', $data);
	}

	public function form(): void {
		$this->load->language('extension/tmdmultivendor/vendor/notification');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
		$this->document->addScript('view/javascript/ckeditor/adapters/jquery.js');

		$data['text_form'] = !isset($this->request->get['notification_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$url = '';

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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/notification', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/notification|save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/notification', 'user_token=' . $this->session->data['user_token'] . $url);

		if (isset($this->request->get['notification_id'])) {
			$this->load->model('extension/tmdmultivendor/vendor/notification');

			$notification_info = $this->model_extension_tmdmultivendor_vendor_notification->getNotification($this->request->get['notification_id']);
		}

		if (isset($this->request->get['notification_id'])) {
			$data['notification_id'] = (int)$this->request->get['notification_id'];
		} else {
			$data['notification_id'] = 0;
		}

		$data['notifications']=array();
		$data['notifications'][] = array(
			'type'  		=> $this->language->get('text_all'),
			'value' 		=> 'all'
		);
		$data['notifications'][] = array(
			'type'  		=> $this->language->get('text_customer'),
			'value' 		=> 'customer'
		);
		$data['notifications'][] = array(
			'type'  		=> $this->language->get('text_seller'),
			'value' 		=> 'seller'
		);
		$data['notifications'][] = array(
			'type'  		=> $this->language->get('text_select_customer'),
			'value' 		=> 'select_customer'
		);
		$data['notifications'][] = array(
			'type'  		=> $this->language->get('text_select_seller'),
			'value' 		=> 'select_seller'
		);

		if (isset($this->request->post['notification_message'])) {
			$data['notification_message'] = $this->request->post['notification_message'];
		} elseif (isset($notification_info)) {
			$data['notification_message'] = $this->model_extension_tmdmultivendor_vendor_notification->getNotificationMessage($this->request->get['notification_id']);
		} else {
			$data['notification_message'] = array();
		}

		if (isset($this->request->post['type'])){
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($notification_info['type'])){
			$data['type'] = $notification_info['type'];
		} else {
			$data['type'] = '';
		}

		if (isset($this->request->post['date'])){
			$data['date'] = $this->request->post['date'];
		} elseif (!empty($notification_info)){
			$data['date'] = $notification_info['date'];
		} else {
			$data['date'] = '';
		}
		
		$this->load->model('customer/customer');
		if (isset($this->request->post['notification_customer'])) {
			$customers = $this->request->post['notification_customer'];
		} elseif (isset($this->request->get['notification_id'])) {
			$customers = $this->model_extension_tmdmultivendor_vendor_notification->getNotificationCustomer($this->request->get['notification_id']);
		} else {
			$customers = array();
		}
		//print_r($customers);die();

		$data['notification_customers'] = array();

		foreach ($customers as $customer_id) {
			$customer_info = $this->model_customer_customer->getCustomer($customer_id);

			if ($customer_info) {
				$data['notification_customers'][] = array(
					'customer_id' => $customer_info['customer_id'],
					'firstname'   => $customer_info['firstname'],
				);
				//print_r($data['notification_customers']);die();
			}
		}
		
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		if (isset($this->request->post['notification_seller'])) {
			$sellers = $this->request->post['notification_seller'];
		} elseif (isset($this->request->get['notification_id'])) {
			$sellers = $this->model_extension_tmdmultivendor_vendor_notification->getNotificationSeller($this->request->get['notification_id']);
		} else {
			$sellers = array();
		}
		
		$data['notification_sellers'] = array();

		foreach ($sellers as $vendor_id) {
			$seller_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($vendor_id);

			if ($seller_info) {
				$data['notification_sellers'][] = array(
					'vendor_id' => $seller_info['vendor_id'],
					'firstname'   => $seller_info['firstname'],
				);
			}
		}

		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/notification_form', $data));
	}

	public function save(): void {
		$this->load->language('extension/tmdmultivendor/vendor/notification');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/notification')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		// foreach ($this->request->post['seller_notification'] as $language_id => $value) {
		// 	if ((strlen(trim($value['name'])) < 1) || (strlen($value['name']) > 64)) {
		// 		$json['error']['name_' . $language_id] = $this->language->get('error_name');
		// 	}

		// }

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/notification');

			if (!$this->request->post['notification_id']) {
				$json['notification_id'] = $this->model_extension_tmdmultivendor_vendor_notification->addNotification($this->request->post);
			} else {
				$this->model_extension_tmdmultivendor_vendor_notification->editNotification($this->request->post['notification_id'], $this->request->post);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete(): void {
		$this->load->language('extension/tmdmultivendor/vendor/notification');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/notification')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/notification');

			foreach ($selected as $notification_id) {
				$this->model_extension_tmdmultivendor_vendor_notification->deleteNotification($notification_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete(): void {
		$json = [];

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

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = 5;
		}
		$this->load->model('customer/customer');
			
		$filter_data = array(
		'sort'  => $sort,
		'order' => $order,
		//'filter_name' => $filter_name,
		'start'        => 0,
			'limit'        => $limit
		);
		$accounts = $this->model_customer_customer->getCustomers($filter_data);

		foreach ($accounts as $account) {

		$json[] = array(
		'customer_id'  => $account['customer_id'],
		'firstname'   => strip_tags(html_entity_decode($account['firstname'], ENT_QUOTES, 'UTF-8'))
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
}