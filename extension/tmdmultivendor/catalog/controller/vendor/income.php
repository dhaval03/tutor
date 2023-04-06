<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class Income extends \Opencart\System\Engine\Controller {
	
	public function index() {
		$this->load->language('extension/tmdmultivendor/vendor/income');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('extension/tmdmultivendor/vendor/income');
		if (!$this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', '', true));
		}
		$url = '';
           
        if (isset($this->request->get['filter_date_from'])) {
			$url .= '&filter_date_from=' . $this->request->get['filter_date_from'];
		}

		if (isset($this->request->get['filter_date_to'])) {
			$url .= '&filter_date_to=' . $this->request->get['filter_date_to'];
		}


		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/income')
		);	

		$data['list'] = $this->getList();

		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/income', $data));
	}

	public function list(): void {

		$this->load->language('extension/tmdmultivendor/vendor/income');

		$this->response->setOutput($this->getList());
	}
	
	protected function getList() {

		$this->load->model('extension/tmdmultivendor/vendor/income');

		if (isset($this->request->get['filter_date_from'])) {
			$filter_date_from = $this->request->get['filter_date_from'];
		} else {
			$filter_date_from = false;
		}

		if (isset($this->request->get['filter_date_to'])) {
			$filter_date_to = $this->request->get['filter_date_to'];
		} else {
			$filter_date_to = false;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pay_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['filter_date_from'])) {
			$url .= '&filter_date_from=' . $this->request->get['filter_date_from'];
		}

		if (isset($this->request->get['filter_date_to'])) {
			$url .= '&filter_date_to=' . $this->request->get['filter_date_to'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
	
	
		
		$data['incomes'] = array();

		$filter_data = array(
			'vendor_id' => $this->vendor->getId(),
			'filter_date_from' => $filter_date_from,
			'filter_date_to'   => $filter_date_to,
			'sort'      => $sort,
			'order' 	=> $order,
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		);

		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('extension/tmdmultivendor/vendor/mybalance');

		$report_total = $this->model_extension_tmdmultivendor_vendor_income->getTotalIncome($filter_data);
		$reports = $this->model_extension_tmdmultivendor_vendor_income->getIncomes($filter_data);

		
	

		//print_r($reports); die();
	 	foreach($reports as $report) {
		 	$seller_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($report['vendor_id']);
		 	if(isset($seller_info['display_name'])) {
		 		$sellername = $seller_info['display_name'];
		 	} else {
		 		$sellername='';
		 	}

			$data['incomes'][] = array(
				'vendor_id' 		=> $report['vendor_id'],
				'amount' 			=> $this->currency->format($report['amount'], $this->config->get('config_currency')),	
				'date_added' 		=> $report['date_added'],
				'payment_method' 	=> $report['payment_method'],
				'sellername' 		=> $sellername,
			);
	 	}
   		


		$filter1=array(
			'vendor_id' 	=> $this->vendor->getId(),
		);

		$data['total'] = $this->model_extension_tmdmultivendor_vendor_mybalance->getVendorTotal($filter1);
  
		$data['totalcommission'] = $this->model_extension_tmdmultivendor_vendor_mybalance->getTotalAmount($filter1);
		
		$data['totalamount'] = $data['total'];

		$data['payamount'] = $this->model_extension_tmdmultivendor_vendor_mybalance->getAmount($filter1);
		
		$seller_info = $this->model_extension_tmdmultivendor_vendor_mybalance->getVendorOrder($this->vendor->getId());		
		/*############13 02 2021 Remove code################*/
		
		if(!empty($seller_info['tmdshippingcost'])){
			$tmdshippingcost = $seller_info['tmdshippingcost'];
		} else{
			$tmdshippingcost =0;
		}
		
		
		$totalcommissions = $this->model_extension_tmdmultivendor_vendor_mybalance->getTotalCommissionamount($filter_data,$this->vendor->getId());
		
		/*############13 02 2021 Remove code################*/
		$data['remaining_amounts'] = $data['totalamount']-$data['payamount']+$tmdshippingcost-$totalcommissions;
	

		
		
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		
		$url = '';
				
		if (isset($this->request->get['filter_date_from'])) {
			$url .= '&filter_date_from=' . $this->request->get['filter_date_from'];
		}
		
		if (isset($this->request->get['filter_date_to'])) {
			$url .= '&filter_date_to=' . $this->request->get['filter_date_to'];
		}
		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$url = '';

		if (isset($this->request->get['filter_date_from'])) {
			$url .= '&filter_date_from=' . $this->request->get['filter_date_from'];
		}

		if (isset($this->request->get['filter_date_to'])) {
			$url .= '&filter_date_to=' . $this->request->get['filter_date_to'];
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				       
	   $data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $report_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/income|list' . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($report_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($report_total - $this->config->get('config_pagination_admin'))) ? $report_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $report_total, ceil($report_total / $this->config->get('config_pagination_admin')));

		
		$data['filter_date_from'] = $filter_date_from;
		$data['filter_date_to']	 = $filter_date_to;
		$data['sort']		= $sort;
		$data['order']		= $order;
						
		
		
		return $this->load->view('extension/tmdmultivendor/vendor/income_list', $data);
	}		
}
?>