<?php
namespace Opencart\Catalog\Controller\extension\Tmdmultivendor\Vendor;
class Attributegroup extends \Opencart\System\Engine\Controller {
	public function index(): void {
		$this->load->language('extension/tmdmultivendor/vendor/attribute_group');

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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/dashboard')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/attribute_group', $url)
		];

		$data['add'] = $this->url->link('extension/tmdmultivendor/vendor/attribute_group|form', $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/attribute_group|delete');

		$data['list'] = $this->getList();

		

		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/attribute_group', $data));
	}

	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/attribute_group');

		$this->response->setOutput($this->getList());
	}

	protected function getList(): string {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'agd.name';
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

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/attribute_group|list', $url);

		$data['attribute_groups'] = [];

		$filter_data = [
			'sort'  => $sort,
			'order' => $order,
			'vendor_id'  => $this->vendor->getId(),
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/attribute_group');

		$attribute_group_total = $this->model_extension_tmdmultivendor_vendor_attribute_group->getTotalAttributeGroups($filter_data);

		$results = $this->model_extension_tmdmultivendor_vendor_attribute_group->getAttributeGroups($filter_data);

		foreach ($results as $result) {
			$data['attribute_groups'][] = [
				'attribute_group_id' => $result['attribute_group_id'],
				'name'               => $result['name'],
				'sort_order'         => $result['sort_order'],
				'edit'               => $this->url->link('extension/tmdmultivendor/vendor/attribute_group|form', '&attribute_group_id=' . $result['attribute_group_id'] . $url)
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

		$data['sort_name'] = $this->url->link('extension/tmdmultivendor/vendor/attribute_group|list', '&sort=agd.name' . $url);
		$data['sort_sort_order'] = $this->url->link('extension/tmdmultivendor/vendor/attribute_group|list', '&sort=ag.sort_order' . $url);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $attribute_group_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/attribute_group|list', $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($attribute_group_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($attribute_group_total - $this->config->get('config_pagination_admin'))) ? $attribute_group_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $attribute_group_total, ceil($attribute_group_total / $this->config->get('config_pagination_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('extension/tmdmultivendor/vendor/attribute_group_list', $data);
	}

	public function form(): void {
		$this->load->language('extension/tmdmultivendor/vendor/attribute_group');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['text_form'] = !isset($this->request->get['attribute_group_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

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
			'href' => $this->url->link('common/dashboard',)
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/attribute_group', $url)
		];

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/attribute_group|save', 'language=' . $this->config->get('config_language'));
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/attribute_group', $url);

		if (isset($this->request->get['attribute_group_id'])) {
			$this->load->model('extension/tmdmultivendor/vendor/attribute_group');

			$attribute_group_info = $this->model_extension_tmdmultivendor_vendor_attribute_group->getAttributeGroup($this->request->get['attribute_group_id']);
		}

		if (isset($this->request->get['attribute_group_id'])) {
			$data['attribute_group_id'] = (int)$this->request->get['attribute_group_id'];
		} else {
			$data['attribute_group_id'] = 0;
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->get['attribute_group_id'])) {
			$data['attribute_group_description'] = $this->model_extension_tmdmultivendor_vendor_attribute_group->getAttributeGroupDescriptions($this->request->get['attribute_group_id']);
		} else {
			$data['attribute_group_description'] = [];
		}

		if (!empty($attribute_group_info)) {
			$data['sort_order'] = $attribute_group_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		
		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/attribute_group_form', $data));
	}

	public function save(): void {
		$this->load->language('extension/tmdmultivendor/vendor/attribute_group');

		$json = [];
		
		if (!$json) {

		foreach ($this->request->post['attribute_group_description'] as $language_id => $value) {
				if ((strlen(trim($value['name'])) < 1) || (strlen($value['name']) > 128)) {
				$json['error']['name_' . $language_id] = $this->language->get('error_name');
			}
		}
		}

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/attribute_group');

			if (!$this->request->post['attribute_group_id']) {
				$json['attribute_group_id'] = $this->model_extension_tmdmultivendor_vendor_attribute_group->addAttributeGroup($this->request->post);
			} else {
				$this->model_extension_tmdmultivendor_vendor_attribute_group->editAttributeGroup($this->request->post['attribute_group_id'], $this->request->post);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete(): void {
		$this->load->language('catalog/attribute_group');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}

		if (!$this->user->hasPermission('modify', 'catalog/attribute_group')) {
			$json['error'] = $this->language->get('error_permission');
		}

		$this->load->model('catalog/attribute');

		foreach ($selected as $attribute_group_id) {
			$attribute_total = $this->model_catalog_attribute->getTotalAttributesByAttributeGroupId($attribute_group_id);

			if ($attribute_total) {
				$json['error'] = sprintf($this->language->get('error_attribute'), $attribute_total);
			}
		}

		if (!$json) {
			$this->load->model('catalog/attribute_group');

			foreach ($selected as $attribute_group_id) {
				$this->model_catalog_attribute_group->deleteAttributeGroup($attribute_group_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
