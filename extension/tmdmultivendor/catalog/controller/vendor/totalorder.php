<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class totalorder extends \Opencart\System\Engine\Controller {
	public function index() {
		$this->load->language('extension/tmdmultivendor/vendor/totalorder');
			/* update 02 11 2020 */
		$this->load->model('extension/tmdmultivendor/vendor/order_report');
			/* update 02 11 2020 */
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');
		$filter_data=array(
			'vendor_id' 	=> $this->vendor->getId()		
		);
			/* update 02 11 2020 */
		$data['totalorder'] = $this->model_extension_tmdmultivendor_vendor_order_report->getTotalReport($filter_data);
		/* update 02 11 2020 */
		$data['orderhref'] = $this->url->link('extension/tmdmultivendor/vendor/order_report');
		
		return $this->load->view('extension/tmdmultivendor/vendor/totalorder', $data);
	}
}
