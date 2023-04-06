<?php
namespace Opencart\Catalog\Controller\extension\Tmdmultivendor\Vender;
class Account extends \Opencart\System\Engine\Controller {
	public function index(): void {

		$this->load->language('extension/tmdmultivendor/vendor/account');

		if (!$this->vender->isLogged()) {
			// $this->session->data['redirect'] = $this->url->link('vender/account', 'language=' . $this->config->get('config_language'));

			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', 'language=' . $this->config->get('config_language')));
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'language=' . $this->config->get('config_language'))
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/account', 'language=' . $this->config->get('config_language') . '&customer_token=' . $this->session->data['customer_token'])
		];

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['edit'] = $this->url->link('extension/tmdmultivendor/vendor/account/edit', 'language=' . $this->config->get('config_language') . '&customer_token=' . $this->session->data['customer_token']);
		$data['password'] = $this->url->link('extension/tmdmultivendor/vendor/account/password', 'language=' . $this->config->get('config_language') . '&customer_token=' . $this->session->data['customer_token']);
		$data['address'] = $this->url->link('extension/tmdmultivendor/vendor/account/address', 'language=' . $this->config->get('config_language') . '&customer_token=' . $this->session->data['customer_token']);
		// $data['payment_method'] = $this->url->link('extension/tmdmultivendor/vendor/account/payment_method', 'language=' . $this->config->get('config_language') . '&customer_token=' . $this->session->data['customer_token']);
		$data['wishlist'] = $this->url->link('extension/tmdmultivendor/vendor/account/wishlist', 'language=' . $this->config->get('config_language') . '&customer_token=' . $this->session->data['customer_token']);
		$data['order'] = $this->url->link('extension/tmdmultivendor/vendor/account/order', 'language=' . $this->config->get('config_language') . '&customer_token=' . $this->session->data['customer_token']);
		$data['download'] = $this->url->link('extension/tmdmultivendor/vendor/account/download', 'language=' . $this->config->get('config_language') . '&customer_token=' . $this->session->data['customer_token']);
		
		$data['order'] = $this->url->link('extension/tmdmultivendor/vendor/account/order', 'language=' . $this->config->get('config_language') . '&customer_token=' . $this->session->data['customer_token']);
		$data['return'] = $this->url->link('extension/tmdmultivendor/vendor/account/return', 'language=' . $this->config->get('config_language') . '&customer_token=' . $this->session->data['customer_token']);
		$data['transaction'] = $this->url->link('extension/tmdmultivendor/vendor/account/transaction', 'language=' . $this->config->get('config_language') . '&customer_token=' . $this->session->data['customer_token']);
		$data['newsletter'] = $this->url->link('extension/tmdmultivendor/vendor/account/newsletter', 'language=' . $this->config->get('config_language') . '&customer_token=' . $this->session->data['customer_token']);
		$data['recurring'] = $this->url->link('extension/tmdmultivendor/vendor/account/recurring', 'language=' . $this->config->get('config_language') . '&customer_token=' . $this->session->data['customer_token']);

		if ($this->config->get('total_reward_status')) {
			$data['reward'] = $this->url->link('extension/tmdmultivendor/vendor/account/reward', 'language=' . $this->config->get('config_language') . '&customer_token=' . $this->session->data['customer_token']);
		} else {
			$data['reward'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/account', $data));
	}
}
