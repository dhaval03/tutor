<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class Footer extends \Opencart\System\Engine\Controller {
	public function index() {
		$this->load->language('extension/tmdmultivendor/vendor/footer');

		$data['text_footer'] = $this->language->get('text_footer');

		if ($this->vendor->isLogged() && isset($this->request->get['token']) && ($this->request->get['token'] == $this->session->data['token'])) {
			$data['text_version'] = sprintf($this->language->get('text_version'), VERSION);
		} else {
			$data['text_version'] = '';
		}
		
		$data['bootstrap'] = 'extension/tmdmultivendor/catalog/view/javascript/vendor/bootstrap/js/bootstrap.bundle.min.js';
		return $this->load->view('extension/tmdmultivendor/vendor/footer', $data);
		
		
	}
}
