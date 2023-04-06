<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Shipping;
class Shippingcost extends \Opencart\System\Engine\Controller {
	public function index(): void {

		$this->load->language('extension/tmdmultivendor/shipping/shippingcost');
		$this->document->setTitle($this->language->get('heading_title'));

		if(isset($this->session->data['token'])){
			$tokenchage = 'token=' . $this->session->data['token'];
		} else {
			$tokenchage =  $this->session->data['user_token'];
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $tokenchage)
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $tokenchage . '&type=module')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/shipping/shippingcost', 'user_token=' . $tokenchage)
		];

		$data['save'] = $this->url->link('extension/tmdmultivendor/shipping/shippingcost|save', 'user_token=' . $tokenchage);

		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $tokenchage . '&type=module');

		$data['module_shipping_shippingcost_status'] = $this->config->get('module_shipping_shippingcost_status');

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$data['module_shipping_shippingcost_sort_order'] = $this->config->get('module_shipping_shippingcost_sort_order');
		$data['module_shipping_shippingcost_tax_class_id'] = $this->config->get('module_shipping_shippingcost_tax_class_id');
		$data['module_shipping_shippingcost'] = $this->config->get('module_shipping_shippingcost');
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/shipping/shippingcost', $data));
	}

	public function save(): void {
		$this->load->language('extension/tmdmultivendor/shipping/shippingcost');

		$json = [];


		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/shipping/shippingcost')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('module_shipping_shippingcost', $this->request->post);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}