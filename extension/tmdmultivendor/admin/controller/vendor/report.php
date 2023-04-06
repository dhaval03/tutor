<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Vendor;
class Report extends \Opencart\System\Engine\Controller {
	public function index(): void {
		$this->load->language('extension/tmdmultivendor/vendor/report');

		$this->document->setTitle($this->language->get('heading_title'));

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . (int)$this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		/* 11 02 2020 */
		
		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . $this->request->get['filter_vendor'];
		}
		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . $this->request->get['filter_customer_name'];
		}
		/* 11 02 2020 */
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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/report', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['invoice'] = $this->url->link('extension/tmdmultivendor/vendor/report|invoice', 'user_token=' . $this->session->data['user_token']);
		$data['shipping'] = $this->url->link('sale/order|shipping', 'user_token=' . $this->session->data['user_token']);
		
		$data['list'] = $this->getList();

		$data['stores'] = [];

		$data['stores'][] = [
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		];

		$this->load->model('setting/store');

		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = [
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			];
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/report', $data));
	}

	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/report');

		$this->response->setOutput($this->getList());


	}

	protected function getList(): string {

		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
		 	$filter_order_id = '';
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = (int)$this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = '';
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
		 	$filter_customer = '';
		}
		/* 11 02 2020 */
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
		 	$filter_name = '';
		}

		/* 11 02 2020 */
		if (isset($this->request->get['filter_customer_name'])) {
			$filter_customer_name = $this->request->get['filter_customer_name'];
		} else {
			$filter_customer_name = '';
		}
		
		if (isset($this->request->get['filter_vendor'])) {
			$filter_vendor = $this->request->get['filter_vendor'];
		} else {
			$filter_vendor = '';
		}
		/* 11 02 2020 */
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
		 	$filter_status = '';
		}
		
		if (isset($this->request->get['filter_date'])) {
			$filter_date = $this->request->get['filter_date'];
		} else {
		 	$filter_date = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'order_id';
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

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . (int)$this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		/* 11 02 2020 */
		
		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . $this->request->get['filter_vendor'];
		}
		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . $this->request->get['filter_customer_name'];
		}
		/* 11 02 2020 */
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

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/report|list', 'user_token=' . $this->session->data['user_token'] . $url);

		$data['reports'] = [];

		$filter_data = [
			'filter_order_id'  => $filter_order_id,
			'filter_order_status_id' => $filter_order_status_id,
			'filter_vendor'    => $filter_vendor,
			'filter_customer_name' => $filter_customer_name,
			'filter_customer'  => $filter_customer,
			'filter_name'      => $filter_name,
			'filter_status'    => $filter_status,
			'filter_date'      => $filter_date,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/report');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');

		$report_total = $this->model_extension_tmdmultivendor_vendor_report->getTotalReport($filter_data);

		$reports = $this->model_extension_tmdmultivendor_vendor_report->getReports($filter_data);



		if(isset($reports)) {
			foreach($reports as $report){
				$sellers = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($report['vendor_id']);
				
				
				if(isset($sellers['vname'])){
					$sellername = $sellers['vname'];
				} else {
					$sellername ='';
				}
				
				$getorder_info = $this->model_extension_tmdmultivendor_vendor_report->getOrder($report['order_id']);
				$status_info = $this->model_extension_tmdmultivendor_vendor_report->getOrderStatus($getorder_info['order_status_id']);
				
				if(isset($status_info['name'])){
					$statusname = $status_info['name'];
				} else {
					$statusname ='';
				}
				

				
				$productnameinfos = $this->model_extension_tmdmultivendor_vendor_report->getOrderProductsNames($report['order_id'], $report['vendor_id']);

				
				$productnames = [];
				
				foreach ($productnameinfos as $productnameinfo) {
				
				$vendorstatusinfo = $this->model_extension_tmdmultivendor_vendor_report->getOrderProductstatus($productnameinfo['order_product_id']);
				$vendornamesinfo = $this->model_extension_tmdmultivendor_vendor_report->getVendorName($productnameinfo['order_product_id']);
				
				$vendorstorename = $this->model_extension_tmdmultivendor_vendor_report->getVendorStoreName($vendornamesinfo['order_product_id']);
					
				
				// $status_infos='';
				
				if(!empty($report['status'])) {
					$reportstatus=$report['status'];
				} else {
					$reportstatus='';
				}
				
				if(isset($vendorstatusinfo['status'])) {
					$status_infos=$vendorstatusinfo['status'];
				} else {
					$status_infos=$reportstatus;
				}

			
				$vendor_infos='';
			
				$vname = $vendornamesinfo['firstname'].' '.$vendornamesinfo['lastname'];
				
				if(isset($vname)) {
					$vendor_infos=$vname;
				} else {
					$vendor_infos=$report['name'];
				}
			
				$productnames[] = [
					'productname'=> $productnameinfo['name'],				
					'vstatus'    => $status_infos,
					'sellername' => $vendor_infos,
					'storename' => $vendorstorename['name']
				];	
			}
				$data['reports'][] = [
					'order_product_id'=>$report['order_product_id'],
					'order_id'      =>$report['order_id'],					
					'firstname'     =>$report['cname'],	
					'productname' 	 => $productnames,
					/* 18-02-2020 */
					'shipping_code' => $report['shipping_code'],
					/* 18-02-2020 */
					'total'     	=>$this->currency->format($report['total'], $report['currency_code'], $report['currency_value']),				
					'sellername'    =>$sellername,					
					'statusname'    =>$statusname,					
					'date_added'	=>date($this->language->get('date_format_short'), strtotime($report['date_added'])),					
					'view'          => $this->url->link('extension/tmdmultivendor/vendor/report|view', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $report['order_id'] . $url, true)
				];
			}
		}

		
		$url = '';
		
		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . (int)$this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		/* 11 02 2020 */
		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . $this->request->get['filter_customer_name'];
		}
		
		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . $this->request->get['filter_vendor'];
		}
		/* 11 02 2020 */
		
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


		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_order_id']  = $this->url->link('extension/tmdmultivendor/vendor/report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=o.order_id' . $url);
		$data['sort_seller']    = $this->url->link('extension/tmdmultivendor/vendor/report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=vop.seller' . $url);
		$data['sort_customer']  = $this->url->link('extension/tmdmultivendor/vendor/report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=o.customer' . $url);
		$data['sort_product']   = $this->url->link('extension/tmdmultivendor/vendor/report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=vop.product' . $url);
		
		$data['sort_total']   = $this->url->link('extension/tmdmultivendor/vendor/report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=vop.total' . $url);
		
		$data['sort_status']  	= $this->url->link('extension/tmdmultivendor/vendor/report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=o.status' . $url);
		$data['sort_date']  	= $this->url->link('extension/tmdmultivendor/vendor/report|list', 'user_token=' . $this->session->data['user_token'] . '&sort=vop.date' . $url);

		$url = '';
		
	
		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . (int)$this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		/* 11 02 2020 */
		
		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . $this->request->get['filter_vendor'];
		}
		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . $this->request->get['filter_customer_name'];
		}
		/* 11 02 2020 */
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

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $report_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/report|list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($report_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($report_total - $this->config->get('config_pagination_admin'))) ? $report_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $report_total, ceil($report_total / $this->config->get('config_pagination_admin')));

		$data['filter_order_id']	= $filter_order_id;
		$data['filter_order_status_id'] = $filter_order_status_id;
		$data['filter_customer']	= $filter_customer;
		$data['filter_name']		= $filter_name;
		$data['filter_status']		= $filter_status;
		$data['filter_date']		= $filter_date;
		/* 11 02 2020 */
		$data['filter_vendor']    = $filter_vendor;
		$data['filter_customer_name']  = $filter_customer_name;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		if(isset($data['filter_name'])) {
			$vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($data['filter_name']);
		}
		
		if(isset($vendor_info['vname'])) {
			$data['sellernme'] = $vendor_info['vname'];
		} else {
			$data['sellernme'] ='';
		}

		$this->load->model('customer/customer');
		if (isset($data['filter_customer'])) {

			$customer_info = $this->model_customer_customer->getCustomer((int)$data['filter_customer']);
		}

		if(isset($customer_info['firstname'])) {
			$data['customernme'] = $customer_info['firstname'];
		} else {
			$data['customernme'] ='';
		}

		// Order Status
		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (!empty($order_info)) {
			$data['order_status_id'] = $order_info['order_status_id'];
		} else {
			$data['order_status_id'] = $this->config->get('config_order_status_id');
		}

		return $this->load->view('extension/tmdmultivendor/vendor/report_list', $data);
	}

	public function view(): void {
		$this->load->language('extension/tmdmultivendor/vendor/report');
		$this->load->language('extension/tmdmultivendor/vendor/vendor');
				
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
		 	$order_id = 0;
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
							
		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}
		
		$url = '';
		
		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . (int)$this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . $this->request->get['filter_customer'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}	
		
		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . $this->request->get['filter_vendor'];
		}
		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . $this->request->get['filter_customer_name'];
		}
	
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
		
		if (isset($this->request->get['filter_date'])) {
			$url .= '&filter_date=' . $this->request->get['filter_date'];
		}
	
	
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_view'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/report', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);
		
		$this->load->model('extension/tmdmultivendor/vendor/report');
		$orderprduct_info = $this->model_extension_tmdmultivendor_vendor_report->getorderproductid($order_id);
		
		$data['order_id'] 		= $this->request->get['order_id'];

		$data['shipping'] = $this->url->link('sale/order|shipping', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $order_id);
		$data['invoice'] = $this->url->link('extension/tmdmultivendor/vendor/report|invoice', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $order_id);
		
		$this->document->setTitle($this->language->get('heading_view'));
		$data['heading_view']          = $this->language->get('heading_view');
		
		$vlbles = $this->config->get('vendor_languages');	
		if(!empty($vlbles[$this->config->get('config_language_id')]['byseller'])) {
		$data['text_byseller']= $vlbles[$this->config->get('config_language_id')]['byseller'].': ';
		} else {			
		$data['text_byseller'] = $this->language->get('text_byseller');
		}
	
		$data['user_token'] = $this->session->data['user_token'];
	
		// Order Status
		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (!empty($order_info)) {
			$data['order_status_id'] = $order_info['order_status_id'];
		} else {
			$data['order_status_id'] = $this->config->get('config_order_status_id');
		}


		if (isset($this->request->post['tracking'])) {
			$data['tracking'] = $this->request->post['tracking'];
		} else {
			$data['tracking'] = '';
		}
		
		if (isset($this->request->post['comment'])) {
			$data['comment'] = $this->request->post['comment'];
		} else {
			$data['comment'] = '';
		}

		$this->load->model('extension/tmdmultivendor/vendor/report');
	
		$order_info = $this->model_extension_tmdmultivendor_vendor_report->getOrder($orderprduct_info['order_id']);
		
		$data['order_id'] 		= $order_info['order_id'];
		$data['date_added'] 	= $order_info['date_added'];
		$data['payment_method'] = $order_info['payment_method'];
		$data['shipping_method']= $order_info['shipping_method'];
		
		// Payment Address
		if ($order_info['payment_address_format']) {
			$format = $order_info['payment_address_format'];
		} else {
			$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
		}

		$find = array(
			'{firstname}',
			'{lastname}',
			'{company}',
			'{address_1}',
			'{address_2}',
			'{city}',
			'{postcode}',
			'{zone}',
			'{zone_code}',
			'{country}'
		);

		$replace = array(
			'firstname' => $order_info['payment_firstname'],
			'lastname'  => $order_info['payment_lastname'],
			'company'   => $order_info['payment_company'],
			'address_1' => $order_info['payment_address_1'],
			'address_2' => $order_info['payment_address_2'],
			'city'      => $order_info['payment_city'],
			'postcode'  => $order_info['payment_postcode'],
			'zone'      => $order_info['payment_zone'],
			'country'   => $order_info['payment_country']
		);

		$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

		// Shipping Address
		if ($order_info['shipping_address_format']) {
			$format = $order_info['shipping_address_format'];
		} else {
			$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
		}

		$find = array(
			'{firstname}',
			'{lastname}',
			'{company}',
			'{address_1}',
			'{address_2}',
			'{city}',
			'{postcode}',
			'{zone}',
			'{country}'
		);

		$replace = array(
			'firstname' => $order_info['shipping_firstname'],
			'lastname'  => $order_info['shipping_lastname'],
			'company'   => $order_info['shipping_company'],
			'address_1' => $order_info['shipping_address_1'],
			'address_2' => $order_info['shipping_address_2'],
			'city'      => $order_info['shipping_city'],
			'postcode'  => $order_info['shipping_postcode'],
			'zone'      => $order_info['shipping_zone'],
			'country'   => $order_info['shipping_country']
		);

		$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
		$this->load->model('extension/tmdmultivendor/vendor/product');
		$this->load->model('extension/tmdmultivendor/vendor/report');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		
		$data['products']=[];
		
		$products = $this->model_extension_tmdmultivendor_vendor_report->getOrderProduct($orderprduct_info['order_id']);
		
		foreach($products as $product){
	
			$this->load->model('localisation/order_status');
			$seller_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($product['vendor_id']);
			if(isset($seller_info['name'])){
				$sellername = $seller_info['display_name'];
			} else {
				$sellername ='';
			}
			if(isset($seller_info['vendor_id'])){
				$ids = $seller_info['vendor_id'];
			} else {
				$ids ='';
			}
			$status_info = $this->model_localisation_order_status->getOrderStatus($product['order_status_id']);
			if(isset($status_info['name'])){
				$statusname = $status_info['name'];
			} else {
				$statusname='';
			}
			
			
			if($product['tracking']==0){
				$data['trackingcode'] = 'hide';
			} else {
				$data['trackingcode'] =  $product['tracking'];
			}
			$data['chkshipcost'] = $this->config->get('shipping_shippingcost_status');
				
				if(!empty($product['tmdshippingcost'])){
						$shippingcost = $product['tmdshippingcost'];
					} else {
						$shippingcost = 0;
				}
			
			/* 13 04 2020 */
			$option_data = array();				
			$options = $this->model_extension_tmdmultivendor_vendor_report->getOrderOptions($product['order_id'], $product['order_product_id']);
			
			foreach ($options as $option) {
				
				if ($option['type'] != 'file') {
				$option_data[] = array(
					'name'  => $option['name'],
					'value' => $option['value'],
					'type'  => $option['type']
				);
				} else {
					$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

					if ($upload_info) {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $upload_info['name'],
							'type'  => $option['type'],
							'href'  => $this->url->link('extension/tmdmultivendor/vendor/latestorder/download','&code=' . $upload_info['code'], true)
						);
					}
				}
			}			
			/* 13 04 2020 */
			
			$data['products'][]=[
				'order_product_id' => $product['order_product_id'],
				'order_id' => $product['order_id'],   
				/* 07 04 2020 */
				'tmdshippingcost' 	=> $this->currency->format($product['tmdshippingcost'],$order_info['currency_code'], $order_info['currency_value']),
				/* 07 04 2020 */	
				/* 13 04 2020 */
				'option'   => $option_data,
				/* 13 04 2020 */
				'product_id' => $product['product_id'],				
				'name' 		=> $product['name'],
				'model' 	=> $product['model'],
				'quantity'	=> $product['quantity'],
				'tracking' 	=> $product['tracking'],
				'sellername'=> $sellername,
				'statusname'=> $statusname,
				'price'    	=> $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
				'total'    	=> $this->currency->format($product['total']+ $shippingcost  + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
				'href'      => $this->url->link('catalog/product|form', 'user_token=' . $this->session->data['user_token'] . '&product_id=' . $product['product_id'] . $url, true),
				'sellerhref'=> $this->url->link('extension/tmdmultivendor/vendor/vendor|form', 'user_token=' . $this->session->data['user_token'] . '&vendor_id=' . $ids . $url, true)
			];

		}
	
		$data['totals'] = [];
		
		$totals = $this->model_extension_tmdmultivendor_vendor_report->getOrderTotals($orderprduct_info['order_id']);
		

		foreach ($totals as $total) {
			$data['totals'][] = [
				'title' => $total['title'],
				'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
			];
		}
		
		$this->load->model('localisation/order_status');
		$data['order_statuss'] = $this->model_localisation_order_status->getOrderStatuses($data);
		
		
			
			$orderstatus = $this->model_extension_tmdmultivendor_vendor_report->getorderproductid($this->request->get['order_id']);
			if(isset($orderstatus['order_status_id'])){
			$status_info = $this->model_localisation_order_status->getOrderStatus($orderstatus['order_status_id']);
			if(isset($status_info['name'])){
				$data['statusname'] = $status_info['name'];
			} else {
				$data['statusname'] = '""';
			}
			} else {
			$data['statusname'] = '""';	
			}

			if(isset($orderstatus['date_added'])){
				$data['dateadded'] = $orderstatus['date_added'];
			} else {
				$data['dateadded'] = '';
			}
			
			$data['histories'] = [];
		  
			$results = $this->model_extension_tmdmultivendor_vendor_report->getVendorOrderHistories($orderprduct_info['order_id'], ($page - 1) * 10, 10);
			
			foreach ($results as $result) {
				$productname = $this->model_extension_tmdmultivendor_vendor_report->getOrderProductsName($order_info['order_id'],$result['vendor_id']);

				
				$status_info = $this->model_extension_tmdmultivendor_vendor_report->getCustomerOrderStatus($result['order_status_id']);
				if(isset($status_info['name'])) {
					$statusname = $status_info['name'];
				} else {
					$statusname='';
				} 
				
				/* 2020 */
				if(isset($productname['name'])) {
					$proname = $productname['name'];
				} else {
					$proname='';
				} 
				/* 2020 */
				
				$data['histories'][] = [
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'status'       => $statusname,					
					'productname'  => $proname,
					'updatedstatus'=> $result['updateby'],
					'comment'      => $result['comment']
				];


			}			
		if(isset($orderprduct_info['order_id'])){
		$history_total = $this->model_extension_tmdmultivendor_vendor_report->getTotalOrderHistories($orderprduct_info['order_id']);
	}
		
		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $history_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/report|view', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $this->request->get['order_id']  . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($history_total - $this->config->get('config_pagination_admin'))) ? $history_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $history_total, ceil($history_total / $this->config->get('config_pagination_admin')));
		
		
		$data['header']      = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']      = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/view_list', $data));
		
	}
	
	public function invoice(): void {
		$this->load->language('extension/tmdmultivendor/vendor/report');

		$data['title'] = $this->language->get('text_invoice');

		$data['base'] = HTTP_SERVER;
		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');

		// Hard coding css so they can be replaced via the events system.
		$data['bootstrap_css'] = 'view/stylesheet/bootstrap.css';
		$data['icons'] = 'view/stylesheet/icon/fontawesome/css/all.css';
		$data['stylesheet'] = 'view/stylesheet/stylesheet.css';

		// Hard coding scripts so they can be replaced via the events system.
		$data['jquery'] = 'view/javascript/jquery/jquery-3.5.1.min.js';
		$data['bootstrap_js'] = 'view/javascript/bootstrap/js/bootstrap.bundle.min.js';

		$this->load->model('extension/tmdmultivendor/vendor/report');	

		$orders = [];

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		}

		if (isset($this->request->get['order_id'])) {
			$orders[] = (int)$this->request->get['order_id'];
		}
		

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = '';
		}
		foreach ($orders as $order_id) {
			$this->load->model('sale/order');

		$order_infos = $this->model_sale_order->getOrder($order_id);

			if ($order_infos) {

		$order_info = $this->model_extension_tmdmultivendor_vendor_report->getOrder($order_infos['order_id']);

		$orderprduct_info = $this->model_extension_tmdmultivendor_vendor_report->getorderproductid($order_info['order_id']);
		
		$data['order_id'] 		= $order_info['order_id'];
		$data['date_added'] 	= $order_info['date_added'];
		$data['payment_method'] = $order_info['payment_method'];
		$data['shipping_method']= $order_info['shipping_method'];
		$data['telephone']		= $order_info['telephone'];
		$data['email']		    = $order_info['email'];
		
		// Payment Address
		if ($order_info['payment_address_format']) {
			$format = $order_info['payment_address_format'];
		} else {
			$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
		}

		$find = array(
			'{firstname}',
			'{lastname}',
			'{company}',
			'{address_1}',
			'{address_2}',
			'{city}',
			'{postcode}',
			'{zone}',
			'{zone_code}',
			'{country}'
		);

		$replace = array(
			'firstname' => $order_info['payment_firstname'],
			'lastname'  => $order_info['payment_lastname'],
			'company'   => $order_info['payment_company'],
			'address_1' => $order_info['payment_address_1'],
			'address_2' => $order_info['payment_address_2'],
			'city'      => $order_info['payment_city'],
			'postcode'  => $order_info['payment_postcode'],
			'zone'      => $order_info['payment_zone'],
			'country'   => $order_info['payment_country']
		);

		$data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

		// Shipping Address
		if ($order_info['shipping_address_format']) {
			$format = $order_info['shipping_address_format'];
		} else {
			$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
		}

		$find = array(
			'{firstname}',
			'{lastname}',
			'{company}',
			'{address_1}',
			'{address_2}',
			'{city}',
			'{postcode}',
			'{zone}',
			'{country}'
		);

		$replace = array(
			'firstname' => $order_info['shipping_firstname'],
			'lastname'  => $order_info['shipping_lastname'],
			'company'   => $order_info['shipping_company'],
			'address_1' => $order_info['shipping_address_1'],
			'address_2' => $order_info['shipping_address_2'],
			'city'      => $order_info['shipping_city'],
			'postcode'  => $order_info['shipping_postcode'],
			'zone'      => $order_info['shipping_zone'],
			'country'   => $order_info['shipping_country']
		);

		$data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
		
		$data['products']=array();
		
		
		$products = $this->model_extension_tmdmultivendor_vendor_report->getOrderProduct($order_id);
		foreach($products as $product){
			
			
			$this->load->model('localisation/order_status');
			
			$status_info = $this->model_localisation_order_status->getOrderStatus($product['order_status_id']);
			if(isset($status_info['name'])){
				$statusname = $status_info['name'];
			} else {
				$statusname='';
			}
			/* 07 04 2020 */
			$data['chkshipcost'] = $this->config->get('shipping_shippingcost_status');
				if(!empty($product['tmdshippingcost'])){
						$shippingcost = $product['tmdshippingcost'];
					} else {
						$shippingcost = 0;
				}
			/* 07 04 2020 */		
				$data['products'][]=array(
				'order_product_id' => $product['order_product_id'],
				'order_id' => $product['order_id'],
				/* 07 04 2020 */
				'tmdshippingcost' 	=> $this->currency->format($product['tmdshippingcost'],$order_info['currency_code'], $order_info['currency_value']),
				/* 07 04 2020 */
				'name' 		=> $product['name'],
				'model' 	=> $product['model'],
				'statusname'=> $statusname,
				'quantity'	=> $product['quantity'],
				'price'    	=> $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
				'total'    	=> $this->currency->format($product['total'] + $shippingcost +  ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
			);

		}
		
		$data['totals'] = array();
		
		$totals = $this->model_extension_tmdmultivendor_vendor_report->getOrderTotals($order_id);
       
		foreach ($totals as $total) {
			$data['totals'][] = array(
				'title' => $total['title'],
				'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
			);
		}
	}
	}

	 	$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/invoice', $data));

	}	

	
}
