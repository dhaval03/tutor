<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Vendor;
class Reviewfield extends \Opencart\System\Engine\Controller { 
	public function index(): void {
		$this->load->language('extension/tmdmultivendor/vendor/review_field');

		$this->document->setTitle($this->language->get('heading_title'));

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/review_field', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['add'] = $this->url->link('extension/tmdmultivendor/vendor/review_field|form', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/review_field|delete', 'user_token=' . $this->session->data['user_token']);

		$data['list'] = $this->getList();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/review_field', $data));
	}

	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/review_field');

		$this->response->setOutput($this->getList());
	}

	protected function getList(): string {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = '';
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

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/review_field|list', 'user_token=' . $this->session->data['user_token'] . $url);

		$data['review_fields'] = [];

		$filter_data = [
			'filter_name'    => $filter_name,
			'filter_status'     => $filter_status,
			'sort'              => $sort,
			'order'             => $order,
			'start'             => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit'             => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/review_field');

		$review_field_total = $this->model_extension_tmdmultivendor_vendor_review_field->getTotalReviewFields($filter_data);

		$results = $this->model_extension_tmdmultivendor_vendor_review_field->getReviewFields($filter_data);

		foreach ($results as $result) {
			$data['review_fields'][] = [
				'rf_id' => $result['rf_id'],
				'field_name'   => $result['field_name'],
				'sort_order'   => $result['sort_order'],
				'status'	   => ($result['status'] ? $this->language->get('text_enable'): $this->language->get('text_disable')),
				'edit'       => $this->url->link('extension/tmdmultivendor/vendor/review_field|form', 'user_token=' . $this->session->data['user_token'] . '&rf_id=' . $result['rf_id'] . $url)
			];
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_field_name'] = $this->url->link('extension/tmdmultivendor/vendor/review_field|list', 'user_token=' . $this->session->data['user_token'] . '&sort=fiels_name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('extension/tmdmultivendor/vendor/review_field|list', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_order' . $url, true);
		$data['sort_status'] = $this->url->link('extension/tmdmultivendor/vendor/review_field|list', 'user_token=' . $this->session->data['user_token'] . '&sort=status' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $review_field_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/review_field|list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($review_field_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($review_field_total - $this->config->get('config_pagination_admin'))) ? $review_field_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $review_field_total, ceil($review_field_total / $this->config->get('config_pagination_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('extension/tmdmultivendor/vendor/review_field_list', $data);
	}

	public function form(): void {
		$this->load->language('extension/tmdmultivendor/vendor/review_field');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['text_form'] = !isset($this->request->get['rf_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/review_field', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/review_field|save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/review_field', 'user_token=' . $this->session->data['user_token'] . $url);

		if (isset($this->request->get['rf_id'])) {
			$this->load->model('extension/tmdmultivendor/vendor/review_field');

			$review_field_info = $this->model_extension_tmdmultivendor_vendor_review_field->getReviewField($this->request->get['rf_id']);
		}

		if (isset($this->request->get['rf_id'])) {
			$data['rf_id'] = (int)$this->request->get['rf_id'];
		} else {
			$data['rf_id'] = 0;
		}

		$this->load->model('extension/tmdmultivendor/vendor/product');

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (isset($review_field_info)) {
			$data['sort_order'] = $review_field_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (isset($review_field_info)) {
			$data['status'] = $review_field_info['status'];
		} else {
			$data['status'] = '';
		}
		
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['vendor_review_field_description'])) {
			$data['vendor_review_field_description'] = $this->request->post['vendor_review_field_description'];
		} elseif (isset($review_field_info)) {
			$data['vendor_review_field_description'] = $this->model_extension_tmdmultivendor_vendor_review_field->getVendorReviewFieldDescriptions($this->request->get['rf_id']);
		} else {
			$data['vendor_review_field_description'] = array();
		}

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/review_field_form', $data));
	}

	public function save(): void {
		$this->load->language('extension/tmdmultivendor/vendor/review_field');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/review_field')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['vendor_review_field_description'] as $language_id => $value) {
			if ((strlen(trim($value['field_name'])) < 1) || (strlen($value['field_name']) > 255)) {
				$json['error']['field_name_' . $language_id] = $this->language->get('error_field_name');
			}
		}

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/review_field');

			if (!$this->request->post['rf_id']) {
				$json['rf_id'] = $this->model_extension_tmdmultivendor_vendor_review_field->addReviewField($this->request->post);
			} else {
				$this->model_extension_tmdmultivendor_vendor_review_field->editReviewField($this->request->post['rf_id'], $this->request->post);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete(): void {
		$this->load->language('extension/tmdmultivendor/vendor/review_field');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/review_field')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/review_field');

			foreach ($selected as $rf_id) {
				$this->model_extension_tmdmultivendor_vendor_review_field->deleteReviewField($rf_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete(){
		$json = [];
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'field_name';
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
		$this->load->model('extension/tmdmultivendor/vendor/review_field');
			
		$filter_data = array(
		'sort'  => $sort,
		'order' => $order,
		'start' => 0,
		'limit' => 5
		);
		$results = $this->model_extension_tmdmultivendor_vendor_review_field->getReviewFields($filter_data);

		foreach ($results as $result) {

		$json[] = [
		'rf_id'  => $result['rf_id'],
		'field_name'   => strip_tags(html_entity_decode($result['field_name'], ENT_QUOTES, 'UTF-8'))
		];
		}
		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['field_name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
