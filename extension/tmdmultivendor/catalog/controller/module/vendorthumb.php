<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Module;
class Vendorthumb extends \Opencart\System\Engine\Controller {
	public function index(array $data): string {
	$this->load->language('extension/tmdmultivendor/vendor/vendorthumb');

		$data['cart'] = $this->url->link('common/cart|info', 'language=' . $this->config->get('config_language'));

		$data['add_to_cart'] = $this->url->link('checkout/cart|add', 'language=' . $this->config->get('config_language'));
		$data['add_to_wishlist'] = $this->url->link('account/wishlist|add', 'language=' . $this->config->get('config_language'));
		$data['add_to_compare'] = $this->url->link('product/compare|add', 'language=' . $this->config->get('config_language'));

		$data['review_status'] = (int)$this->config->get('config_review_status');
		return $this->load->view('extension/tmdmultivendor/vendor/vendorproduct', $data);
	}
}
