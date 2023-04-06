<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Vendor;
class CommissionReport extends \Opencart\System\Engine\Controller {	
	// private $error = array();
	public function index(): void {
		$this->load->language('extension/tmdmultivendor/vendor/commission_report');

		$this->document->setTitle($this->language->get('heading_title'));

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		

		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . urlencode(html_entity_decode($this->request->get['filter_vendor'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_from'])) {
			$url .= '&filter_from=' . $this->request->get['filter_from'];
		}
		
		if (isset($this->request->get['filter_to'])) {
			$url .= '&filter_to=' . $this->request->get['filter_to'];
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

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/commission_report', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['add'] = $this->url->link('extension/tmdmultivendor/vendor/commission_report|form', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/commission_report|delete', 'user_token=' . $this->session->data['user_token']);

		$data['list'] = $this->getList();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/commission_report', $data));
	}

	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/commission_report');

		$this->response->setOutput($this->getList());
	}

	protected function getList(): string {

		if (isset($this->request->get['filter_vendor'])) {
			$filter_vendor = $this->request->get['filter_vendor'];
		} else {
			$filter_vendor = '';
		}
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_from'])) {
			$filter_from = $this->request->get['filter_from'];
		} else {
		 	$filter_from = '';
		}
		
		if (isset($this->request->get['filter_to'])) {
			$filter_to = $this->request->get['filter_to'];
		} else {
		 	$filter_to = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'commission_report_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . urlencode(html_entity_decode($this->request->get['filter_vendor'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_from'])) {
			$url .= '&filter_from=' . $this->request->get['filter_from'];
		}
		
		if (isset($this->request->get['filter_to'])) {
			$url .= '&filter_to=' . $this->request->get['filter_to'];
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

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/commission_report|list', 'user_token=' . $this->session->data['user_token'] . $url);

		$data['commissionreports'] = [];

		$filter_data = [
			'filter_vendor' => $filter_vendor,
			'filter_name'  => $filter_name,
			'filter_from'    => $filter_from,
			'filter_to'      => $filter_to,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/commission_report');
	
		$report_total = $this->model_extension_tmdmultivendor_vendor_commission_report->getTotalCommissionReport($filter_data);
		$reports = $this->model_extension_tmdmultivendor_vendor_commission_report->getCommissionReports($filter_data);
	
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
	 	$commi_total=0;
		foreach($reports as $report){
			
			$sellers = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($report['vendor_id']);
			/* 05 02 2020 update vname firstname pe */
			if(isset($sellers['vname'])){
				$sellername = $sellers['vname'];
			} else {
				$sellername ='';
			}
			
		 	$currency_info = $this->model_extension_tmdmultivendor_vendor_commission_report->getOrderCurrency($report['order_id']);
		
			if(isset($currency_info['currency_code'])) {
				$currency = $currency_info['currency_code'];
			} else {
				$currency=$this->config->get('config_currency');
			}
			
			if(!empty($report['tax'])){
				/*############ 13 02 2021 update code ############*/		
				$price1 = $report['total'] + $report['tax']*$report['quantity'];
				$price = $this->currency->format($price1,$currency);
			} else {
				$price = $this->currency->format($report['price'],$currency);
			}
			
			$data['commissionreports'][] = [
				'order_product_id'=>$report['order_product_id'],
				'name'			=>$report['name'],
				'model'			=>$report['model'],
				'quantity'		=>$report['quantity'],					
				'sellername'	=>$sellername,
				
				'price'			 => $price,	
				'totalcommission'=> $this->currency->format($report['totalcommission'],$currency),
				
				'date_added'	=>$report['date_added'],
				'commissionper'	=>$report['commissionper'],
				'commissionfix'	=>$report['commissionfix']
			];
		}

		$url = '';
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . urlencode(html_entity_decode($this->request->get['filter_vendor'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_from'])) {
			$url .= '&filter_from=' . $this->request->get['filter_from'];
		}
		
		if (isset($this->request->get['filter_to'])) {
			$url .= '&filter_to=' . $this->request->get['filter_to'];
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


		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_id']   		 = $this->url->link('extension/tmdmultivendor/vendor/commission_report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=id' . $url, true);
		$data['sort_seller']    	= $this->url->link('extension/tmdmultivendor/vendor/commission_report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=seller' . $url, true);
		$data['sort_name']  		= $this->url->link('extension/tmdmultivendor/vendor/commission_report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);
		$data['sort_model']  		= $this->url->link('extension/tmdmultivendor/vendor/commission_report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=model' . $url, true);
		$data['sort_qty']  		    = $this->url->link('extension/tmdmultivendor/vendor/commission_report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=qty' . $url, true);
		$data['sort_price']  		= $this->url->link('extension/tmdmultivendor/vendor/commission_report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=price' . $url, true);
		$data['sort_date']  		= $this->url->link('extension/tmdmultivendor/vendor/commission_report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=date' . $url, true);
		$data['sort_percentage']  	= $this->url->link('extension/tmdmultivendor/vendor/commission_report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=percentage' . $url, true);
		$data['sort_fixed']  	    = $this->url->link('extension/tmdmultivendor/vendor/commission_report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=fixed' . $url, true);

		$url = '';
		
	
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . urlencode(html_entity_decode($this->request->get['filter_vendor'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_from'])) {
			$url .= '&filter_from=' . $this->request->get['filter_from'];
		}
		
		if (isset($this->request->get['filter_to'])) {
			$url .= '&filter_to=' . $this->request->get['filter_to'];
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
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/commission_report|list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($report_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($report_total - $this->config->get('config_pagination_admin'))) ? $report_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $report_total, ceil($report_total / $this->config->get('config_pagination_admin')));

		$data['filter_name']	= $filter_name;
		$data['filter_vendor']	= $filter_vendor;
		$data['filter_from']	= $filter_from;
		$data['filter_to']		= $filter_to;

		if(isset($data['filter_name'])) {
			$vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($data['filter_name']);
		}

		if(isset($vendor_info['vname'])) {
			$data['sellernme'] = $vendor_info['vname'];
		} else {
			$data['sellernme'] ='';
		}

		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('extension/tmdmultivendor/vendor/commission_report_list', $data);
	}
			
}
