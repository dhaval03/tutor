<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class latestorder extends \Opencart\System\Engine\Controller { 
	public function index(): string{
		$this->load->language('extension/tmdmultivendor/vendor/latestorder');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_view'] = $this->language->get('text_view');
		$data['text_select'] = $this->language->get('text_select');
		$data['button_view'] = $this->language->get('button_view');
		$data['button_save'] = $this->language->get('button_save');
		$data['text_viewallorders'] =  $this->language->get('text_viewallorders');
		$data['viewallorder'] = $this->url->link('extension/tmdmultivendor/vendor/order_report','',true);
		
		
		$data['column_noofproduct']   = $this->language->get('column_noofproduct');
		$this->load->model('localisation/order_status');
		$data['order_statuss'] = $this->model_localisation_order_status->getOrderStatuses($data);	
		
		
		$this->load->model('localisation/order_status');
		$data['order_statuss'] = $this->model_localisation_order_status->getOrderStatuses($data);
		
		$data['orders'] = array();
		$filter_data=array(
			'vendor_id' => $this->vendor->getId(),
			'customer_id' => $this->customer->getId(),
			'sort' => 'date_added',
			'order' => 'DESC',
		);
		$orders = $this->model_extension_tmdmultivendor_vendor_vendor->getOrders($filter_data);
		
		foreach($orders as $order){
			
			$status_info = $this->model_extension_tmdmultivendor_vendor_vendor->getOrderStatus($order['order_status_id']);
			
			$product_total = $this->model_extension_tmdmultivendor_vendor_vendor->getTotalOrderProductsByOrderId($order['order_id'], $order['vendor_id']);
			$vorder_total = $this->model_extension_tmdmultivendor_vendor_vendor->getvendorOrdertotal($order['vendor_id'],$order['order_id']);
			
			if(isset($status_info['name'])){
				$statusname = $status_info['name'];
			} else {
				$statusname ='';
			}
			
			
			$data['orders'][]=array(
				'order_product_id'	=> $order['order_product_id'],
				/* 2020 */	
				'customer_id'	=> $order['customer_id'],
				/* 2020 */
				'order_status_id'	=> $order['order_status_id'],
				'order_id'	=> $order['order_id'],
				'firstname' => $order['name'],
				
				'date_added'=> date($this->language->get('date_format_short'), strtotime($order['date_added'])),
				
				'total' 	=> $this->currency->format($vorder_total['total'], $this->config->get('config_currency')),
				'statusname'=> $statusname,	
				'noofproduct'=> $product_total,
				'view'       => $this->url->link('extension/tmdmultivendor/vendor/latestorder|letestview', '&order_id=' . $order['order_id'])
				
			);
		}
		
		
		$data['customer2vendor'] = $this->config->get('vendor_vendor2customer');
		
		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_action'] = $this->language->get('column_action');
			return $this->load->view('extension/tmdmultivendor/vendor/latestorder', $data);
		
	}

	public function letestview() {
		
		if (!$this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', '', true));
		}
		$this->load->language('extension/tmdmultivendor/vendor/latestorder');
		$this->load->model('tool/upload');
		
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
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_view'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/dashboard')
		);
		
		$this->document->setTitle($this->language->get('heading_title1'));
		
		/* 07 04 2020 */

		$data['chkshipcost'] = $this->config->get('shipping_shippingcost_status');
		/* 07 04 2020 */
		
		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		
		
		if (isset($this->request->post['comment'])) {
			$data['comment'] = $this->request->post['comment'];
		} else {
			$data['comment'] = '';
		}
		
		
		
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$vendor_id = $this->vendor->getId();	
		$orderprduct_info = $this->model_extension_tmdmultivendor_vendor_vendor->getorderproductid($order_id, $vendor_id);
		
		if(isset($orderprduct_info['order_id'])){
		$order_info = $this->model_extension_tmdmultivendor_vendor_vendor->getOrder($orderprduct_info['order_id']);
		/* 07-10-2020 */
}
		if(!empty($order_info)){
		/* 07-10-2020 */
		$trackingcode_info =  $this->model_extension_tmdmultivendor_vendor_vendor->getTrackingCodeInfo($this->vendor->getId(),$order_id);	
		$data['tracking'] = $trackingcode_info['tracking'];		
		
		$data['order_id'] 		= $order_info['order_id'];
		$data['date_added'] 	= $order_info['date_added'];
		$data['payment_method'] = $order_info['payment_method'];
		$data['shipping_method']= $order_info['shipping_method'];
		
		$data['invoice'] = $this->url->link('extension/tmdmultivendor/vendor/latestorder|invoice', '&order_id=' .  $order_info['order_id']);
		/* 07-10-2020 */
		$data['shipping'] = $this->url->link('extension/tmdmultivendor/vendor/latestorder|shipping', '&order_id=' .  $order_info['order_id']);
		/* 07-10-2020 */
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
		
		
		$products = $this->model_extension_tmdmultivendor_vendor_vendor->getSellerOrders($this->request->get['order_id']);
		
		foreach($products as $product){
			$this->load->model('localisation/order_status');
			$this->load->model('extension/tmdmultivendor/vendor/option');
			
			$seller_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($product['vendor_id']);
			
			
			if(isset($seller_info['display_name'])){
				$sellername = $seller_info['display_name'];
			} else {
				$sellername='';
			}
			if(isset($seller_info['vendor_id'])){
				$ids = $seller_info['vendor_id'];
			} else {
				$ids='';
			}


			/* 20 11 2020 */
			
/* 20 11 2020 */
			$this->load->model('tool/image');
			$this->load->model('catalog/product');
			$product_info = $this->model_catalog_product->getProduct($product['product_id']);

			if(isset($product_info['image'])){

			
			if (is_file(DIR_IMAGE . $product_info['image'])) {
				$image = $this->model_tool_image->resize($product_info['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

		}else{
			$image='';
		}
		

			/* 20 11 2020 */
			$status_info = $this->model_localisation_order_status->getOrderStatus($product['order_id']);
			
			if(isset($status_info['name'])){
				$statusname = $status_info['name'];
			} else {
				$statusname='';
			}
				$option_data = array();
					/* 01 02 2020 update */
					$options = $this->model_extension_tmdmultivendor_vendor_option->getOrderOptions($product['order_id'], $product['order_product_id']);
					
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
				/* 01 02 2020 */	
			
			if($product['tracking']==''){
				$data['trackingcode'] = 'hide';
			} else {
				$data['trackingcode'] =  $product['tracking'];
			}
			
			if(!empty($product['tmdshippingcost'])){
				$shippingcost = $product['tmdshippingcost'];
			} else {
				$shippingcost = 0;
			}
			
			$data['products'][]=array(
				'order_product_id' => $product['order_product_id'],
				'order_status_id' => $product['order_status_id'],
				'statusname'=> $statusname,
				'order_id' 	=> $product['order_id'],
				/* 07 04 2020 */
				'tmdshippingcost' 	=> $this->currency->format($product['tmdshippingcost'],$order_info['currency_code'], $order_info['currency_value']),
				/* 07 04 2020 */
				'product_id' 	=> $product['product_id'],
				'name' 		=> $product['name'],
				'model' 	=> $product['model'],
				'quantity'	=> $product['quantity'],
				'tracking' 	=> $product['tracking'],
				'sellername'=> $sellername,
				'option'   => $option_data,
				'image'      => $image,
				'price'    	=> $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
				'total'    	=> $this->currency->format($product['total']+ $shippingcost  + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
				'href'      => $this->url->link('product/product','&product_id=' . $product['product_id'] . $url, true),
				'sellerhref'=> $this->url->link('extension/tmdmultivendor/vendor/vendor_profile','&vendor_id=' . $ids . $url, true)
			);
		}
		
		$data['totals'] = array();
		
		$totals = $this->model_extension_tmdmultivendor_vendor_vendor->getOrderTotals($this->request->get['order_id']);

		foreach ($totals as $total) {
			$data['totals'][] = array(
				'title' => $total['title'],
				'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
			);
		}
		
		$this->load->model('localisation/order_status');
		$data['order_statuss'] = $this->model_localisation_order_status->getOrderStatuses($data);
		
			$data['histories'] = array();
			
			$results = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorOrderHistories($orderprduct_info['order_id'], $this->vendor->getId(), ($page - 1) * 10, 10);

			foreach ($results as $result) {


				/* 03 10 2019 s */
				$productname = $this->model_extension_tmdmultivendor_vendor_vendor->getOrderProductsName($result['order_product_id']);

				if(empty($productname)) {
					$productname['name']='';
				}
				
				$status_info = $this->model_extension_tmdmultivendor_vendor_vendor->getCustomerOrderStatus($result['order_status_id']);
				if(isset($status_info['name'])) {
					$statusname = $status_info['name'];
				} else {
					$statusname='';
				} 
				/* 03 10 2019 e */
				
				$data['histories'][] = array(
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),					
					'status'       => $statusname,					
					'productname'  => $productname['name'],
					'updatedstatus'=> $result['updateby'],
					'comment'      => $result['comment']
					
				);
			}
			
		
		$history_total = $this->model_extension_tmdmultivendor_vendor_vendor->getTotalOrderHistories($orderprduct_info['order_id'], $vendor_id);

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $history_total,
			'page'  => $page,
			'limit' => 10,
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/latestorder|letestview', '&order_id=' . $order_id . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($history_total - 10)) ? $history_total : ((($page - 1) * 10) + 10), $history_total, ceil($history_total / 10));
		
		}

       

		$data['customer2vendor'] = $this->config->get('vendor_vendor2customer');
		
		$data['header']      = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer']      = $this->load->controller('extension/tmdmultivendor/vendor/footer');
		
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/letestview_list', $data));
		
	}
	
	function addtrack(){
		$json = array();
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->language('extension/tmdmultivendor/vendor/latestorder');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {			
			$this->model_extension_tmdmultivendor_vendor_vendor->addTracks($this->request->get['order_id'],$this->request->post);
			$json['success'] = $this->language->get('text_success');
			
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function addorderstatus(){
		
		$json = array();
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->language('extension/tmdmultivendor/vendor/vendor');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			/* 2020 */
			$vendor_id = $this->vendor->getId();
			$this->model_extension_tmdmultivendor_vendor_vendor->addOrdeStatus($this->request->post['order_id'],$this->request->post,$vendor_id);
			/* 2020 */
			$json['success'] = $this->language->get('text_success');
			
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function addorderstatusview(){
		
		$json = array();
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->language('extension/tmdmultivendor/vendor/vendor');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			/* 2020 */
			$vendor_id = $this->vendor->getId();	
			$this->model_extension_tmdmultivendor_vendor_vendor->addOrdeStatus($this->request->get['order_id'],$this->request->post, $vendor_id);
			/* 2020 */			
			if(isset($this->request->post['tracking'])) { 
			$this->addtrack();			
			}
			
			$json['success'] = $this->language->get('text_success');


		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function invoice() {

		$this->load->language('extension/tmdmultivendor/vendor/latestorder');
		$this->load->model('localisation/order_status');
		$this->load->model('setting/setting');		
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('extension/tmdmultivendor/vendor/store');
		$this->load->model('tool/upload');
		$this->load->model('extension/tmdmultivendor/vendor/option');
		
		
		$this->load->model('localisation/country');
		$this->load->model('localisation/zone');
			
		
		if (isset($this->request->get['order_product_id'])) {
			$order_product_id = $this->request->get['order_product_id'];
		} else {
		 	$order_product_id = 0;
		}
		
	
		$data['text_address']	  = $this->language->get('text_address');
		$data['text_address2']	  = $this->language->get('text_address2');
		$data['text_city']	      = $this->language->get('text_city');
		$data['text_country']	  = $this->language->get('text_country');
		$data['text_zone']	      = $this->language->get('text_zone');
		
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
		 	$order_id = 0;
		}
		$vendor_id = $this->vendor->getId();
		$orderprduct_info = $this->model_extension_tmdmultivendor_vendor_vendor->getorderproductid($order_id, $vendor_id);
		
	   $store_infos = $this->model_extension_tmdmultivendor_vendor_store->getViewStore($orderprduct_info['vendor_id']);
		
		$data['title'] = $this->language->get('text_invoice');

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');
		
		$url = '';
		
		$data['orders'] = array();
		
		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($orderprduct_info['order_id'])) {
			$orders[] = $orderprduct_info['order_id'];
		}

		foreach ($orders as $order_id) {
			$order_info = $this->model_extension_tmdmultivendor_vendor_vendor->getOrder($order_id);
			
			// Make sure there is a shipping method
			if ($order_info) {
				
				if (!empty($store_infos['address_2'])) {
					$store_address2 = $store_infos['address_2'];
				} else {
					$store_address2 ='';
				}
				
				$country_info = $this->model_localisation_country->getCountry($store_infos['country_id']);
				$zone_info = $this->model_localisation_zone->getZone($store_infos['zone_id']);
				
				if ($store_infos) {
					$store_address = $store_infos['address_1'] ;
					$store_email = $store_infos['email'];
					$store_city = $store_infos['city'];
					$store_telephone = $store_infos['telephone'];
					$country= $country_info['name'];
					$zones= $zone_info['name'];
				} 
				
			
				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}
				
				
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
					'zone_code' => $order_info['payment_code'],
					'country'   => $order_info['payment_country']
				);
				
				$payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));
				
				
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
					'{zone_code}',
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

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$product_data = array();

				$products = $this->model_extension_tmdmultivendor_vendor_vendor->getSellerOrders($order_id);
	
				foreach ($products as $product) {
				
				$seller_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($product['vendor_id']);
				
				
				$status_info = $this->model_localisation_order_status->getOrderStatus($product['order_status_id']);
				if(isset($status_info['name'])){
					$statusname = $status_info['name'];
				} else {
					$statusname='';
				}
			
				if(isset($seller_info['display_name'])){
					$sellername = $seller_info['display_name'];
				} else {
					$sellername='';
				}
				
				if(isset($seller_info['vendor_id'])){
					$ids = $seller_info['vendor_id'];
				} else {
					$ids='';
				}
				
					$option_data = array();
					/* 01 02 2020 */
					$options = $this->model_extension_tmdmultivendor_vendor_option->getOrderOptions($order_id, $product['order_product_id']);
					/* 01 02 2020 */
					foreach ($options as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

							if ($upload_info) {
								$value = $upload_info['name'];
							} else {
								$value = '';
							}
						}

						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $value
						);
					}
					
					/* 07 04 2020 */	
					$data['chkshipcost'] = $this->config->get('shipping_shippingcost_status');
		
					if(!empty($product['tmdshippingcost'])){
						$shippingcost = $product['tmdshippingcost'];
					} else {
						$shippingcost = 0;
					}
					/* 07 04 2020 */	
					$product_data[] = array(
						'name'     => $product['name'],
						'model'    => $product['model'],
						'option'   => $option_data,
						/* 07 04 2020 */
						'tmdshippingcost' 	=> $this->currency->format($product['tmdshippingcost'],$order_info['currency_code'], $order_info['currency_value']),
						/* 07 04 2020 */
						'sellername'=> $sellername,
						'statusname'=> $statusname,
						'sellerhref'=> $this->url->link('extension/tmdmultivendor/vendor/vendor_profile','&vendor_id=' . $ids . $url, true),	
						'quantity' => $product['quantity'],
						'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'    => $this->currency->format($product['total'] + $shippingcost + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
					);
					
				}
				
				$total_data = array();

				$totals = $this->model_extension_tmdmultivendor_vendor_vendor->getOrderTotals($order_id);

				foreach ($totals as $total) {
					$total_data[] = array(
						'title' => $total['title'],
						'text'  => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'])
					);
				}
				
				$data['orders'][] = array(
					'order_id'	       => $order_id,
					'invoice_no'       => $invoice_no,
					'date_added'       => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
					
					'store_name'       => $store_infos['name'],
					'store_address2'   => $store_address2,
					'store_city'   	   => $store_city,
					'country'   	   => $country,
					'zones'   	  	   => $zones,
					
					'store_url'        => rtrim($order_info['store_url'], '/'),
					'store_address'    => nl2br($store_address),
					'store_email'      => $store_email,
					'store_telephone'  => $store_telephone,
					'email'            => $order_info['email'],
					'telephone'        => $order_info['telephone'],
					'shipping_address' => $shipping_address,
					'payment_address' => $payment_address,
					'payment_method'  => $order_info['payment_method'],
					'shipping_method'  => $order_info['shipping_method'],
					'product'          => $product_data,
					'total'            => $total_data,
					'comment'          => nl2br($order_info['comment'])
				);
			}
		}
		
		$data['customer2vendor'] = $this->config->get('vendor_vendor2customer');

		$data['header'] = $this->load->controller('extension/tmdmultivendor/common/header');
				$data['column_left'] = $this->load->controller('extension/tmdmultivendor/common/column_left');
				$data['footer'] = $this->load->controller('extension/tmdmultivendor/common/footer');
			
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/order_invoice', $data));
	}
	/* 01 02 2020 */
	public function shipping() {
		
		$this->load->language('extension/tmdmultivendor/vendor/latestorder');
		$this->load->model('extension/tmdmultivendor/vendor/store');
		$this->load->model('localisation/country');
		$this->load->model('localisation/zone');
		$this->load->model('tool/upload');
		$this->load->model('extension/tmdmultivendor/vendor/option');
		$this->load->model('extension/tmdmultivendor/vendor/product');
		
		$data['title'] = $this->language->get('text_shipping');

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}
		
		$data['lang'] = $this->language->get('code');

		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
		 	$order_id = 0;
		}
		$vendor_id = $this->vendor->getId();
		
		$orderprduct_info = $this->model_extension_tmdmultivendor_vendor_vendor->getorderproductid($order_id, $vendor_id);
		
		$store_infos = $this->model_extension_tmdmultivendor_vendor_store->getViewStore($orderprduct_info['vendor_id']);
		
		$data['orders'] = array();

		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
		}		
		
		foreach ($orders as $order_id) {
			$order_info = $this->model_extension_tmdmultivendor_vendor_vendor->getOrder($order_id);
			
			// Make sure there is a shipping method
			if ($order_info) {
				
				if (!empty($store_infos['address_2'])) {
					$store_address2 = $store_infos['address_2'];
				} else {
					$store_address2 ='';
				}
				
				$country_info = $this->model_localisation_country->getCountry($store_infos['country_id']);
				$zone_info = $this->model_localisation_zone->getZone($store_infos['zone_id']);
				
				if ($store_infos) {
					$store_address = $store_infos['address_1'] ;
					$store_email = $store_infos['email'];
					$store_city = $store_infos['city'];
					$store_telephone = $store_infos['telephone'];
					$country= $country_info['name'];
					$zones= $zone_info['name'];
				} 

				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}

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
					'{zone_code}',
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
					//'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$this->load->model('tool/upload');

				$product_data = array();

				$products = $this->model_extension_tmdmultivendor_vendor_vendor->getSellerOrders($order_id);

				foreach ($products as $product) {
					$option_weight = 0;
					
					$product_info = $this->model_extension_tmdmultivendor_vendor_product->getProduct($product['product_id'], $product['vendor_id']);
					if ($product_info) {
						$option_data = array();

						$options = $this->model_extension_tmdmultivendor_vendor_option->getOrderOptions($order_id, $product['order_product_id']);

						foreach ($options as $option) {
							if ($option['type'] != 'file') {
								$value = $option['value'];
							} else {
								$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

								if ($upload_info) {
									$value = $upload_info['name'];
								} else {
									$value = '';
								}
							}

							$option_data[] = array(
								'name'  => $option['name'],
								'value' => $value
							);

							$product_option_value_info = $this->model_extension_tmdmultivendor_vendor_product->getProductOptionValue($product['product_id'], $option['product_option_value_id']);
							
							if (!empty($product_option_value_info)) {
								if ($product_option_value_info['weight_prefix'] == '+') {
									$option_weight += $product_option_value_info['weight'];
								} elseif ($product_option_value_info['weight_prefix'] == '-') {
									$option_weight -= $product_option_value_info['weight'];
								}
							}

						}

						$product_data[] = array(
							'name'     => $product_info['name'],
							'model'    => $product_info['model'],
							'option'   => $option_data,
							'quantity' => $product['quantity'],
							'location' => $product_info['location'],
							'sku'      => $product_info['sku'],
							'upc'      => $product_info['upc'],
							'ean'      => $product_info['ean'],
							'jan'      => $product_info['jan'],
							'isbn'     => $product_info['isbn'],
							'mpn'      => $product_info['mpn'],
							'weight'   => $this->weight->format(($product_info['weight'] + (float)$option_weight) * $product['quantity'], $product_info['weight_class_id'], $this->language->get('decimal_point'), $this->language->get('thousand_point'))
						);
					}
				}

				$data['orders'][] = array(
					'order_id'	       => $order_id,
					'invoice_no'       => $invoice_no,
					'date_added'       => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
					'store_name'       => $order_info['store_name'],
					'store_url'        => rtrim($order_info['store_url'], '/'),
					'store_address'    => nl2br($store_address),
					'store_email'      => $store_email,
					'store_telephone'  => $store_telephone,
					'email'            => $order_info['email'],
					'telephone'        => $order_info['telephone'],
					'shipping_address' => $shipping_address,
					'shipping_method'  => $order_info['shipping_method'],
					'product'          => $product_data,
					'comment'          => nl2br($order_info['comment'])
				);
			}
		}

			   
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/order_shipping', $data));
	}
		
	public function download() {
		$this->load->model('tool/upload');

		if (isset($this->request->get['code'])) {
			$code = $this->request->get['code'];
		} else {
			$code = 0;
		}

		$upload_info = $this->model_tool_upload->getUploadByCode($code);

		if ($upload_info) {
			$file = DIR_UPLOAD . $upload_info['filename'];
			$mask = basename($upload_info['name']);

			if (!headers_sent()) {
				if (is_file($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					readfile($file, 'rb');
					exit;
				} else {
					exit('Error: Could not find file ' . $file . '!');
				}
			} else {
				exit('Error: Headers already sent out!');
			}
			} else {
				$this->load->language('error/not_found');

				$this->document->setTitle($this->language->get('heading_title'));

				$data['breadcrumbs'] = array();

				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('text_home'),
					'href' => $this->url->link('common/home', 'user_token=' . $this->session->data['user_token'], true)
				);

				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('heading_title'),
					'href' => $this->url->link('error/not_found', 'user_token=' . $this->session->data['user_token'], true)
				);

				$data['header'] = $this->load->controller('extension/tmdmultivendor/common/header');
				$data['column_left'] = $this->load->controller('extension/tmdmultivendor/common/column_left');
				$data['footer'] = $this->load->controller('extension/tmdmultivendor/common/footer');

				$this->response->setOutput($this->load->view('error/not_found', $data));
			}
		}	
		/* 01 02 2020 */
}