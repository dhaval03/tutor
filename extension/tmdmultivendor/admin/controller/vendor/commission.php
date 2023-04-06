<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Vendor;
class Commission extends \Opencart\System\Engine\Controller {
	public function index(): void {
		$this->load->language('extension/tmdmultivendor/vendor/commission');

		$this->document->setTitle($this->language->get('heading_title'));

		$url = '';

		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/commission', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['add'] = $this->url->link('extension/tmdmultivendor/vendor/commission|form', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/commission|delete', 'user_token=' . $this->session->data['user_token']);

		$data['list'] = $this->getList();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/commission', $data));
	}

	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/commission');

		$this->response->setOutput($this->getList());
	}

	protected function getList(): string {

		if (isset($this->request->get['filter_id'])) {
			$filter_id = $this->request->get['filter_id'];
		} else {
			$filter_id = '';
		}

			if (isset($this->request->get['filter_category'])) {
			$filter_category = $this->request->get['filter_category'];
		} else {
			$filter_category = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'commission_id';
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

		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
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

		$url = '';

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/commission|list', 'user_token=' . $this->session->data['user_token'] . $url);

		$data['categories'] = [];

		$filter_data = [
			'filter_id'     => $filter_id,
			
			'filter_category'    => $filter_category,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/commission');

		$commission_total = $this->model_extension_tmdmultivendor_vendor_commission->getTotalCommission($filter_data);

		$results = $this->model_extension_tmdmultivendor_vendor_commission->getCommissions($filter_data);
		// print_r($results);

		foreach ($results as $result) {
			
			$data['categories'][] = [
				'commission_id' => $result['commission_id'],
				'fixed'         => $result['fixed'],
				'percentage'    => $result['percentage'],
				'catnames'      => $result['name'],
				'edit'            => $this->url->link('extension/tmdmultivendor/vendor/commission|form', 'user_token=' . $this->session->data['user_token'] . '&commission_id=' . $result['commission_id'] . $url)
			];
		}


		$url = '';
		
		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}


		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
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


		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_commission_id'] = $this->url->link('extension/tmdmultivendor/vendor/commission|list', 'user_token=' . $this->session->data['user_token'] . '&sort=commission_id' . $url, true);
		$data['sort_name']   = $this->url->link('extension/tmdmultivendor/vendor/commission|list', 'user_token=' . $this->session->data['user_token'] . '&sort=cd.name' . $url, true);
		$data['sort_commission'] = $this->url->link('extension/tmdmultivendor/vendor/commission|list', 'user_token=' . $this->session->data['user_token'] . '&sort=commission' . $url, true);

		$url = '';
		
	
		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}


		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
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


		

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $commission_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/commission|list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($commission_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($commission_total - $this->config->get('config_pagination_admin'))) ? $commission_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $commission_total, ceil($commission_total / $this->config->get('config_pagination_admin')));

		$data['filter_id']        = $filter_id;
		$data['filter_category'] = $filter_category;

		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('extension/tmdmultivendor/vendor/commission_list', $data);
	}

	public function form(): void {
		$this->load->language('extension/tmdmultivendor/vendor/commission');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['text_form'] = !isset($this->request->get['commission_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$url = '';
		
		if (isset($this->request->get['filter_id'])) {
			$url .= '&filter_id=' . $this->request->get['filter_id'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/commission', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/commission|save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/commission', 'user_token=' . $this->session->data['user_token'] . $url);

		if (isset($this->request->get['commission_id'])) {
			$this->load->model('extension/tmdmultivendor/vendor/commission');

			$commission_info = $this->model_extension_tmdmultivendor_vendor_commission->getCommission($this->request->get['commission_id']);
		}

		if (isset($this->request->get['commission_id'])) {
			$data['commission_id'] = (int)$this->request->get['commission_id'];
		} else {
			$data['commission_id'] = 0;
		}

		$this->load->model('catalog/category');
		$data['categories'] = $this->model_catalog_category->getCategories($data);

		if (isset($this->request->post['category_id'])) {
			$data['category_id'] = $this->request->post['category_id'];
		} elseif (isset($commission_info['category_id'])){
			$data['category_id'] = $commission_info['category_id'];
		} else {
			$data['category_id'] = '';
		}

        /* 21 02 2019 */
		if (isset($this->request->post['fixed'])) {
			$data['fixed'] = $this->request->post['fixed'];
		} elseif (isset($commission_info['fixed'])){
			$data['fixed'] = $commission_info['fixed'];
		} else {
			$data['fixed'] = '';
		}
		if (isset($this->request->post['percentage'])) {
			$data['percentage'] = $this->request->post['percentage'];
		} elseif (isset($commission_info['percentage'])){
			$data['percentage'] = $commission_info['percentage'];
		} else {
			$data['percentage'] = '';
		}

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/commission_form', $data));
	}

	public function save(): void {
		$this->load->language('extension/tmdmultivendor/vendor/commission');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/commission')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		if (!isset($this->request->post['category_id']) || $this->request->post['category_id'] =='') {
			$json['error']['category'] = $this->language->get('error_category_id');
		}

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/commission');

			if (!$this->request->post['commission_id']) {
				$json['commission_id'] = $this->model_extension_tmdmultivendor_vendor_commission->addCommission($this->request->post);
			} else {
				$this->model_extension_tmdmultivendor_vendor_commission->editCommission($this->request->post['commission_id'], $this->request->post);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete(): void {
		$this->load->language('extension/tmdmultivendor/vendor/commission');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/commission')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/commission');

			foreach ($selected as $commission_id) {
				$this->model_extension_tmdmultivendor_vendor_commission->deleteCommission($commission_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	
}
