<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Module;
class Enquiry extends \Opencart\System\Engine\Controller {
	public function index(): void {
		$this->load->language('extension/tmdmultivendor/module/enquiry');

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

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/module/enquiry', 'user_token=' . $this->session->data['user_token'])
		];

		$data['save'] = $this->url->link('extension/tmdmultivendor/module/enquiry|save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module');

		$data['module_enquiry_status'] = $this->config->get('module_enquiry_status');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/module/enquiry', $data));
	}

	public function save(): void {
		$this->load->language('extension/tmdmultivendor/module/enquiry');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/module/enquiry')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('module_enquiry', $this->request->post);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}