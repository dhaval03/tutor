<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class total extends \Opencart\System\Engine\Controller {
	public function index() {
		$this->load->language('extension/tmdmultivendor/vendor/total');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');
		$data['totalreviews'] = $this->model_extension_tmdmultivendor_vendor_vendor->getTotalDashboardReviews($this->vendor->getId());
		
		/* tmd 05-03-2019 */
		$data['reviewhref'] = $this->url->link('extension/tmdmultivendor/vendor/review');		
		/* tmd 05-03-2019 */
		return $this->load->view('extension/tmdmultivendor/vendor/total', $data);
	}
}
