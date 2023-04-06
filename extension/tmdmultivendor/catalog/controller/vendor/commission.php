<?php
namespace Opencart\Catalog\Controller\extension\Tmdmultivendor\Vendor;
class Commission extends \Opencart\System\Engine\Controller {

	public function index() {
		if (!$this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', '', 'SSL'));
		}
		$this->load->language('extension/tmdmultivendor/vendor/commission');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/tmdmultivendor/vendor/commission');

		$url = '';


		$data['list'] = $this->getList();

		$this->load->model('localisation/language');

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/commission',$url)
		];

	     

		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/commission', $data));

	}

     
     public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/commission');
		

		$this->response->setOutput($this->getList());
	}

	protected function getList() {

		$this->load->model('extension/tmdmultivendor/vendor/commission');
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'r.date_added';
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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/commission')
		);
		
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

       $data['action'] = $this->url->link('extension/tmdmultivendor/vendor/commission|list' . $url);
		$data['commissions'] = array();

		$filter_data = array(
			'vendor_id' => $this->vendor->getId(),
			'sort'      => $sort,
			'order'     => $order,
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		);

		$this->load->model('extension/tmdmultivendor/vendor/vendor');

		$commission_total = $this->model_extension_tmdmultivendor_vendor_commission->getTotalCommissionReport($filter_data);
		$reports = $this->model_extension_tmdmultivendor_vendor_commission->getCommissionReports($filter_data);
	 	 
	 	$commi_total=0;
		foreach($reports as $report){
			$sellers = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($report['vendor_id']);
			if(isset($sellers['firstname'])){
				$sellername = $sellers['firstname'];
			} else {
				$sellername ='';
			}
			
		 	$currency_info = $this->model_extension_tmdmultivendor_vendor_commission->getOrderCurrency($report['order_id']);
		
			if(isset($currency_info['currency_code'])) {
				$currency = $currency_info['currency_code'];
			} else {
				$currency=$this->config->get('config_currency');
			}
			
			if(!empty($report['tax'])){
				/*############ 13 02 2021 update ############*/		
				$price1 = $report['total'] + $report['tax']*$report['quantity'];
				$price = $this->currency->format($price1,$currency);
			} else {
				$price = $this->currency->format($report['price'],$currency);
			}
		
			$data['commissions'][] = array(
				'order_product_id'=>$report['order_product_id'],
				'sellername'	 =>$sellername,
				'name'			 =>$report['name'],
				'model'			 =>$report['model'],
				'quantity'		 =>$report['quantity'],
				/* 07-03-2019 update code */
				'price'			 => $price,					
				'totalcommission'=> $this->currency->format($report['totalcommission'],$currency),
				/* 07-03-2019 update code */
				'commissionper'	 => $report['commissionper'].'%',
				'commissionfix'	 =>$report['commissionfix'],
				'date_added'	 =>$report['date_added'],
			);
		}


	
			$url = '';

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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_vendor']		 = $this->url->link('extension/tmdmultivendor/vendor/commission','&sort=vendor'.$url , true);
		$data['sort_name']   		 = $this->url->link('extension/tmdmultivendor/vendor/commission','&sort=name'.$url , true);
		$data['sort_model']			 = $this->url->link('extension/tmdmultivendor/vendor/commission','&sort=model'.$url , true);
		$data['sort_quantity']   	 = $this->url->link('extension/tmdmultivendor/vendor/commission','&sort=quantity'.$url , true);
		$data['sort_price']   		 = $this->url->link('extension/tmdmultivendor/vendor/commission','&sort=price'.$url , true);
		$data['sort_commission']   	 = $this->url->link('extension/tmdmultivendor/vendor/commission','&sort=commission'.$url , true);
		$data['sort_commissionfixed']= $this->url->link('extension/tmdmultivendor/vendor/commission','&sort=commissionfixed'.$url , true);
		$data['sort_commissiontotal']= $this->url->link('extension/tmdmultivendor/vendor/commission','&sort=commissiontotal'.$url , true);
		$data['sort_date']   		 = $this->url->link('extension/tmdmultivendor/vendor/commission','&sort=date'.$url , true);



		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $commission_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/commission|list' . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($commission_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($commission_total - $this->config->get('config_pagination_admin'))) ? $commission_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $commission_total, ceil($commission_total / $this->config->get('config_pagination_admin')));
		
		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('extension/tmdmultivendor/vendor/commission_list', $data);
	}

}
