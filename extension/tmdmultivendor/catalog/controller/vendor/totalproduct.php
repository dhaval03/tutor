<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class totalproduct extends \Opencart\System\Engine\Controller {
	public function index() {
		$this->load->language('extension/tmdmultivendor/vendor/totalproduct');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');
		
		$data['totalproducts'] = $this->model_extension_tmdmultivendor_vendor_vendor->getTotalProducts($this->vendor->getId());
		/* update */
		$data['prohref'] = $this->url->link('extension/tmdmultivendor/vendor/product');
		/* update */
		
		
		return $this->load->view('extension/tmdmultivendor/vendor/totalproduct', $data);
	}
	
}
