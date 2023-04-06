<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Module;
use \Opencart\System\Helper AS Helper;
class Vendorfeatured extends \Opencart\System\Engine\Controller {
	public function index(): void {
		$this->load->language('extension/tmdmultivendor/module/vendorfeatured');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->setTitle($this->language->get('heading_title1'));

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module')
		];

		$data['user_token'] = $this->session->data['user_token'];
		
		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = [
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/tmdmultivendor/module/vendorfeatured', 'user_token=' . $this->session->data['user_token'])
			];
		} else {
			$data['breadcrumbs'][] = [
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/tmdmultivendor/module/vendorfeatured', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'])
			];
		}

		if (!isset($this->request->get['module_id'])) {
			$data['save'] = $this->url->link('extension/tmdmultivendor/module/vendorfeatured|save', 'user_token=' . $this->session->data['user_token']);
		} else {
			$data['save'] = $this->url->link('extension/tmdmultivendor/module/vendorfeatured|save', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id']);
		}

		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		if (isset($this->request->get['module_id'])) {
			$this->load->model('setting/module');

			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		if (isset($module_info['name'])) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($module_info['module_description'])) {
			$data['module_description'] = $module_info['module_description'];
		} else {
			$data['module_description'] = [];
		}

		if (isset($module_info['vendorfeatured_id'])) {
			$data['vendorfeatured_id'] = $module_info['vendorfeatured_id'];
		} else {
			$data['vendorfeatured_id'] = '';
		}


		$this->load->model('catalog/product');

		$data['products'] = [];

		if (!empty($this->request->post['product'])) {
			$products = $this->request->post['product'];
		} elseif (!empty($module_info['product'])) {
			$products = $module_info['product'];
		} else {
			$products = [];
		}

		$this->load->model('extension/tmdmultivendor/vendor/product');
		foreach ($products as $product_id) {
			$product_info = $this->model_extension_tmdmultivendor_vendor_product->getProduct($product_id);

			if ($product_info) {
				$data['products'][] = [
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name']
				];
			}
		}

		if (isset($module_info['limit'])) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = '';
		}

		if (isset($module_info['width'])) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = '';
		}

		if (isset($module_info['height'])) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = '';
		}

		if (isset($module_info['status'])) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('extension/tmdmultivendor/module/vendorfeatured', $data));
	}

	public function save(): void {
		$this->load->language('extension/tmdmultivendor/module/vendorfeatured');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/module/vendorfeatured')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		if ((Helper\Utf8\strlen($this->request->post['name']) < 3) || (Helper\Utf8\strlen($this->request->post['name']) > 64)) {
			$json['error']['name'] = $this->language->get('error_name');
		}

		if (!$this->request->post['width']) {
			$json['error']['width'] = $this->language->get('error_width');
		}

		if (!$this->request->post['height']) {
			$json['error']['height'] = $this->language->get('error_height');
		}

		if (!$json) {
			$this->load->model('setting/module');

			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('tmdmultivendor.vendorfeatured', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}