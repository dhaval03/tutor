<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Vendor;
class Income extends \Opencart\System\Engine\Controller {	
	// private $error = array();
	public function index(): void {
		$this->load->language('extension/tmdmultivendor/vendor/income');

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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/income', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['add'] = $this->url->link('extension/tmdmultivendor/vendor/income|form', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/income|delete', 'user_token=' . $this->session->data['user_token']);

		$data['list'] = $this->getList();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/income', $data));
	}

	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/income');

		$this->response->setOutput($this->getList());
	}

	protected function getList(): string {

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
		 	$filter_name = false;
		}
		
		if (isset($this->request->get['filter_vendor'])) {
			$filter_vendor = $this->request->get['filter_vendor'];
		} else {
			$filter_vendor = '';
		}
		
		if (isset($this->request->get['filter_from'])) {
			$filter_from = $this->request->get['filter_from'];
		} else {
		 	$filter_from = false;
		}

		if (isset($this->request->get['filter_to'])) {
			$filter_to = $this->request->get['filter_to'];
		} else {
		 	$filter_to = false;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'income_id';
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

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/income|add', 'user_token=' . $this->session->data['user_token'] . $url);
		// $data['add']	=$this->url->link('extension/tmdmultivendor/vendor/income|add','&user_token='.$this->session->data['user_token'].$url,true);

		$data['incomes'] = [];

		$filter_data = [
			'filter_vendor' => $filter_vendor,
			'filter_name'  => $filter_name,
			'filter_from'	=> $filter_from,
			'filter_to'	=> $filter_to,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/income');
	
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$report_total = $this->model_extension_tmdmultivendor_vendor_income->getTotalIncome($filter_data);
		$reports = $this->model_extension_tmdmultivendor_vendor_income->getIncomes($filter_data);
	 	
		foreach($reports as $report){
				$taxamount ='0';
				$shipingamount =$this->model_extension_tmdmultivendor_vendor_income->getTotalShipping($filter_data,$report['vendor_id']);
			
			
		// Total Amount 
			$total = $this->model_extension_tmdmultivendor_vendor_income->getTotal($filter_data,$report['vendor_id']);

		// Seller Amount
			$totalcommission = $this->model_extension_tmdmultivendor_vendor_income->getTotalCommission($filter_data,$report['vendor_id']);


		// Admin Amount
			$totalamount = $total-$totalcommission+$taxamount+$shipingamount;


		// Pay Seller Amount
			$payamount = $this->model_extension_tmdmultivendor_vendor_income->getAmount($report['vendor_id']);

			
		// Remaining Amount
			$remaining_amounts = $totalamount-$payamount;
		
			if (isset($remaining_amounts)) {
				$remaining_amount = $this->currency->format($remaining_amounts , $this->config->get('config_currency'). $this->config->get('currency_value'));
			} 

			$sellers = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($report['vendor_id']);
				
				
				if(isset($sellers['vname'])){
					$sellername = $sellers['vname'];
				} else {
					$sellername ='';
				}

			
			$data['incomes'][] = array(
				'vendor_id'			=> $report['vendor_id'],
				'tmdshippingcost'	=> $this->currency->format($shipingamount , $this->config->get('config_currency'). $this->config->get('currency_value')),	
				'sellername'		=> $sellername,				
				'date_added'		=> $report['date_added'],				
				'display_name'		=> $report['display_name'],
				'total'				=> $this->currency->format($total+$taxamount, $this->config->get('config_currency'). $this->config->get('currency_value')),
				'totalcommission'	=> $this->currency->format($totalcommission, $this->config->get('config_currency'). $this->config->get('currency_value')),
				'totalamount'		=> $this->currency->format($totalamount, $this->config->get('config_currency'). $this->config->get('currency_value')),
				'payamount'			=> $this->currency->format($payamount, $this->config->get('config_currency'). $this->config->get('currency_value')),
				
				'remaining_amount'	=> $remaining_amount,
				'payment'       	=> $this->url->link('extension/tmdmultivendor/vendor/income|form', 'user_token=' . $this->session->data['user_token'] .'&vendor_id=' . $report['vendor_id'] . $url, true)
			);
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

		$data['sort_seller']    	= $this->url->link('extension/tmdmultivendor/vendor/income|list', 'user_token=' . $this->session->data['user_token'] . '&sort=seller' . $url, true);
		$data['sort_tamount']  		= $this->url->link('extension/tmdmultivendor/vendor/income|list', 'user_token=' . $this->session->data['user_token'] . '&sort=tamount' . $url, true);
		$data['sort_samount']  		= $this->url->link('extension/tmdmultivendor/vendor/income|list', 'user_token=' . $this->session->data['user_token'] . '&sort=samount' . $url, true);
		$data['sort_admin_amount']  = $this->url->link('extension/tmdmultivendor/vendor/income|list', 'user_token=' . $this->session->data['user_token'] . '&sort=admin_amount' . $url, true);

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
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/income|list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
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

		return $this->load->view('extension/tmdmultivendor/vendor/income_list', $data);
	}

	public function form(): void {
		$this->load->language('extension/tmdmultivendor/vendor/income');
		$this->load->model('extension/tmdmultivendor/vendor/income');

		$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
		$this->document->addScript('view/javascript/ckeditor/adapters/jquery.js');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['text_form'] = !isset($this->request->get['vendor_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . urlencode(html_entity_decode($this->request->get['filter_approved'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];
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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/income', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/income|add', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/income', 'user_token=' . $this->session->data['user_token'] . $url);


		if (isset($this->request->get['vendor_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$pay_info=$this->model_extension_tmdmultivendor_vendor_income->getPay($this->request->get['vendor_id']);
			
		}
			
		if (isset($this->request->get['vendor_id'])) {
			$data['vendor_id'] = $this->request->get['vendor_id'];
		
		} elseif (isset($pay_info['vendor_id'])){
			$data['vendor_id'] = $pay_info['vendor_id'];
		} else {
			$data['vendor_id'] = '';
		}

		if(isset($this->request->post['vendor_id'])){	
			$this->load->model('extension/tmdmultivendor/vendor/vendor');
			$vendor_info=$this->model_extension_tmdmultivendor_vendor_vendor->getVendor($pay_info['vendor_id']);
			$data['vendor']=$vendor_info['firstname'];
		} else {
			$data['vendor']='';
		}

		if (isset($this->request->post['comment'])) {
			$data['comment'] = $this->request->post['comment'];
		} elseif (isset($pay_info['comment'])){
			$data['comment'] = $pay_info['comment'];
		} else {
			$data['comment'] = '';
		}

		if (isset($this->request->post['payment_method'])) {
			$data['payment_method'] = $this->request->post['payment_method'];
		} elseif (!empty($pay_info)) {
			$data['payment_method'] = $pay_info['payment_method'];
		} else {
			$data['payment_method'] = 'paypal';
		}

		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$vendor_infos = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($this->request->get['vendor_id']);
		
		
		$data['paypal'] 				= $vendor_infos['paypal'];
		$data['bank_name'] 				= $vendor_infos['bank_name'];
		$data['bank_branch_number'] 	= $vendor_infos['bank_branch_number'];
		$data['bank_swift_code'] 		= $vendor_infos['bank_swift_code'];
		$data['bank_account_name'] 		= $vendor_infos['bank_account_name'];
		$data['bank_account_number'] 	= $vendor_infos['bank_account_number'];
		$data['vendor'] 				= $vendor_infos['vname'];
		

		$data['total'] = $this->model_extension_tmdmultivendor_vendor_income->getVendorTotal($this->request->get['vendor_id']);

		$data['totalcommission'] = $this->model_extension_tmdmultivendor_vendor_income->getTotalAmount($this->request->get['vendor_id']);
		
		$data['totalamount'] = $data['total']-$data['totalcommission'];

		$data['payamount'] = $this->model_extension_tmdmultivendor_vendor_income->getAmount($this->request->get['vendor_id']);

		$filter_data = array();
		
		$shipingamount =$this->model_extension_tmdmultivendor_vendor_income->getTotalShipping($filter_data,$this->request->get['vendor_id']);
			
		$data['remaining_amount'] = $data['totalamount']-$data['payamount']+$shipingamount;
		
		if (isset($this->request->post['amount'])) {
			$data['amount'] = $this->request->post['amount'];
		} elseif (isset($data['remaining_amount'])){
			$data['amount'] = $data['remaining_amount'];
		} else {
			$data['amount'] = '';
		}

		
		
		$data['cancel'] = $this->url->link('extension/tmdmultivendor/vendor/income', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['vendor_id'])) {
			$data['vendor_id'] = (int)$this->request->get['vendor_id'];
		} else {
			$data['vendor_id'] = 0;
		}


		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/payment_form', $data));
	}

	public function add(): void {
		$this->load->language('extension/tmdmultivendor/vendor/income');
		$this->load->model('extension/tmdmultivendor/vendor/income');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/income')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['remaining_amount']< $this->request->post['amount']) {
			$json['error']['amount'] = $this->language->get('error_amount');
		}
		
		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			// $this->load->model('extension/tmdmultivendor/vendor/vendor');


			if ($this->request->post) {

				$this->model_extension_tmdmultivendor_vendor_income->addAmount($this->request->post);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete(){
		if (isset($this->request->get['filter_name'])) {
			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
			} else {
				$sort = 'name';
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
			$this->load->model('extension/tmdmultivendor/vendor/vendor');

			$filter_data = array(
				'sort'  => $sort,
				'order' => $order,
				'start' => ($page - 1) * $this->config->get('config_limit_admin'),
				'limit' => $this->config->get('config_limit_admin')
			);
			$accounts = $this->model_extension_tmdmultivendor_vendor_vendor->getVendors($filter_data);
			foreach ($accounts as $account) {

				$json[] = array(
					'vendor_id'  => $account['vendor_id'],
					'firstname'   => strip_tags(html_entity_decode($account['firstname'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}
		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['firstname'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function getPaymentMethod(){
		$this->load->language('extension/tmdmultivendor/vendor/income');
		$this->load->model('extension/tmdmultivendor/vendor/income');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		
		$data['entry_payment'] 	= $this->language->get('entry_payment');
		$data['text_bank']  	= $this->language->get('text_bank');
		$data['text_paypal']  	= $this->language->get('text_paypal');
		$data['entry_bankname']  = $this->language->get('entry_bankname');
		$data['entry_bnumber']  = $this->language->get('entry_bnumber');
		$data['entry_swiftcode'] = $this->language->get('entry_swiftcode');
		$data['entry_aname']  	= $this->language->get('entry_aname');
		$data['entry_anumber']  = $this->language->get('entry_anumber');
		$data['entry_Emailid']  = $this->language->get('entry_Emailid');
		$data['entry_method']  	= $this->language->get('entry_method');
		
		
		$vendor_info=$this->model_extension_tmdmultivendor_vendor_vendor->getVendor($this->request->get['vendor_id']);

		if (isset($this->request->post['payment_method'])) {
			$data['payment_method'] = $this->request->post['payment_method'];
		} elseif (!empty($vendor_info['payment_method'])) {
			$data['payment_method'] = $vendor_info['payment_method'];
		} else {
			$data['payment_method'] = 'paypal';
		}

		if (isset($this->request->post['bank_name'])) {
			$data['bank_name'] = $this->request->post['bank_name'];
		} elseif (!empty($vendor_info['bank_name'])) {
			$data['bank_name'] = $vendor_info['bank_name'];
		} else {
			$data['bank_name'] = '';
		}
		
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/bank_detail', $data));
	}		
			
}
