<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Module;
class Tmdvendor extends \Opencart\System\Engine\Controller {
	
	public function accountorder(string &$route, array &$args, mixed &$output): void{
		$this->load->model('account/order');
		$results = $this->model_account_order->getOrders();
		$tmdorders=[];
		foreach ($results as $result) {
			/* xml */
			$this->load->model('extension/tmdmultivendor/vendor/vendor');
			$orderstatus_info = $this->model_extension_tmdmultivendor_vendor_vendor->getCustomerOrder($result['order_id']);
			if(isset($orderstatus_info['order_status_id'])){
			 $order_status_id = $orderstatus_info['order_status_id'];
			} else {
			$order_status_id =0;
			}
			$status_info = $this->model_extension_tmdmultivendor_vendor_vendor->getCustomerOrderStatus($order_status_id);
			if(isset($status_info['name'])) {
				$statusname = $status_info['name'];
			} else {
				$statusname='';
			}
			
			/* 03-10-2019 */
			$this->load->model('extension/tmdmultivendor/vendor/vendor');
			$args['column_productname'] = $this->language->get('column_productname');
			
			$productnameinfos = $this->model_extension_tmdmultivendor_vendor_vendor->getOrderProductsNames($result['order_id']);			
			$productnames = [];
			
			foreach ($productnameinfos as $productnameinfo) {				
				
				$vendorstatusinfo = $this->model_extension_tmdmultivendor_vendor_vendor->getOrderProductstatus($productnameinfo['order_product_id']);
				
				$status_infos='';
				
				if(isset($vendorstatusinfo['status'])) {
					$status_infos=$vendorstatusinfo['status'];
				} else {
					$status_infos=$result['status'];
				}
							 
				$productnames[] = [
					'productname'=> $productnameinfo['name'],				
					'vstatus'    => $status_infos
				];				
			}

			$args['orders'][] = [
				'statusname'=>$statusname,
				'order_status_id'=>$order_status_id,
				'productname'=>$productnames,
			];
		}
		 
	}
	
	public function checkoutconfirm(string &$route, array &$args, mixed &$output): void{

		$vlbles = $this->config->get('vendor_languages');	
		if(!empty($vlbles[$this->config->get('config_language_id')]['byseller'])) {
			$args['text_byseller']= $vlbles[$this->config->get('config_language_id')]['byseller'].': ';
		} else {			
			$args['text_byseller'] = $this->language->get('text_byseller');
		}
		
		$args['customer2vendor'] = $this->config->get('vendor_customer2vendor');
		
		$this->load->model('checkout/cart');
		
		$args['products'] = $this->model_checkout_cart->getProducts();
		
		$template_buffer = $this->getTemplateBuffer($route,$output);
		$find='{% for option in product.option %}';
		$replace='{% if customer2vendor==1 %}
					{% if product.sellerdisplay %}
					 &nbsp; {{ text_byseller }}
					<a href="{{ product.vendor_ids }}">{{ product.sellerdisplay }}</a>
					{% endif %}
				{% endif %}{% for option in product.option %}';
		$output = str_replace( $find, $replace, $template_buffer );
	}
	
	public function checkoutcart(string &$route, array &$args, mixed &$output): void{
		
		$vlbles = $this->config->get('vendor_languages');	
		if(!empty($vlbles[$this->config->get('config_language_id')]['byseller'])) {
			$args['text_byseller']= $vlbles[$this->config->get('config_language_id')]['byseller'].': ';
		} else {			
			$args['text_byseller'] = $this->language->get('text_byseller');
		}
		
		$args['customer2vendor'] = $this->config->get('vendor_customer2vendor');
		
		$this->load->model('checkout/cart');
		
		$args['products'] = $this->model_checkout_cart->getProducts();
		
		$template_buffer = $this->getTemplateBuffer($route,$output);
		$find='{% if product.option %}';
		$replace='{% if customer2vendor==1 %}
					{% if product.sellerdisplay %}
					{{ text_byseller }}
					<a href="{{ product.vendor_ids }}">{{ product.sellerdisplay }}</a>
					{% endif %}
				{% endif %}{% if product.option %}';
		$output = str_replace( $find, $replace, $template_buffer );
	}

	public function commoncart(string &$route, array &$args, mixed &$output): void{
		$vlbles = $this->config->get('vendor_languages');	
		if(!empty($vlbles[$this->config->get('config_language_id')]['byseller'])) {
			$args['text_byseller']= $vlbles[$this->config->get('config_language_id')]['byseller'].': ';
		} else {			
			$args['text_byseller'] = $this->language->get('text_byseller');
		}
		
		$args['customer2vendor'] = $this->config->get('vendor_customer2vendor');
		
		$this->load->model('checkout/cart');
		
		$args['products'] = $this->model_checkout_cart->getProducts();
		
		$template_buffer = $this->getTemplateBuffer($route,$output);
		$find='<td class="text-start"><a href="{{ product.href }}">{{ product.name }}</a>';
		$replace='<td class="text-start td-name"><a href="{{ product.href }}">{{ product.name }}</a>
				{% if customer2vendor==1 %}
					{% if product.sellerdisplay %}
					{{ text_byseller }}
					<a href="{{ product.vendor_ids }}">{{ product.sellerdisplay }}</a>
					{% endif %}
				{% endif %}';
		$output = str_replace( $find, $replace, $template_buffer );
	}
	public function orderinfo(string &$route, array &$args, mixed &$output): void{
		$args['column_productname']    = 'Product Info';
		$args['column_updatedstatus']  = 'Status Updated By';

		$template_buffer = $this->getTemplateBuffer($route,$output);
		$find='<td class="text-start">{{ column_comment }}</td>';
		$replace='<td class="text-start">{{ column_productname }}</td><td class="text-start">{{ column_updatedstatus }}</td><td class="text-start">{{ column_comment }}</td>';
		$output1 = str_replace( $find, $replace, $template_buffer );
		
		$find='<td class="text-start">{{ history.comment }}</td>';
		$replace='{% if chkvendor_id %}
			   <td class="text-left">{{ history.productname }}</td>
			   <td class="text-left">{{ history.updatedstatus }}</td>
			   {% endif %}<td class="text-start">{{ history.comment }}</td>';
		$output = str_replace( $find, $replace, $output1 );
	}
	public function orderlist(string &$route, array &$args, mixed &$output): void{
		$args['column_productname']    = 'Product Info';
		
		$template_buffer = $this->getTemplateBuffer($route,$output);
		$find='<td class="text-end">{{ column_product }}</td>';
		$replace='<td class="text-end">{{ column_product }}</td><td class="text-left">{{ column_productname }}</td>';
		$output1 = str_replace( $find, $replace, $template_buffer );
		
		$find='<td class="text-end">{{ order.products }}</td>';
		$replace='<td class="text-end">{{ order.products }}</td><td class="text-start">
					<table class="table table-bordered table-hover">
						<tbody>	 
						   {% for productnam in order.productname %}
						    <tr>
								<td class="text-left">{{ productnam.productname }}</td>							
								<td class="text-left">{{ productnam.vstatus }}</td>						
						    </tr>
						   {% endfor %}
						</tbody>
					</table>
			    </td>';
		$output = str_replace( $find, $replace, $output1 );
	}
	
	public function mailorder(string &$route, array &$args, mixed &$output): void{
		$vendor2customers = $this->config->get('vendor_vendor2customer');
		$emailtemplete = $this->db->query("SELECT * from " . DB_PREFIX . "vendor_mail vm left join " . DB_PREFIX . "vendor_mail_language vml on vml.mail_id=vm.mail_id WHERE vm.sellertype = 'customer_to_seller_order_email' and vml.language_id='".$this->config->get('config_language_id')."' and vm.status='1'");
		if(!empty($emailtemplete->row['sellertype'])) {
			if($emailtemplete->row['sellertype']=='customer_to_seller_order_email') {
				$subject=$emailtemplete->row['subject'];
				$message=$emailtemplete->row['message'];
				$orderss_query = $this->db->query("SELECT vendor_id FROM " . DB_PREFIX . "vendor_order_product WHERE order_id = '" .$order_info['order_id'] . "' group by vendor_id");

				if(!empty($orderss_query->rows)) {

				foreach($orderss_query->rows as $vendorids) {

					$vendor_id=$vendorids['vendor_id'];
					$vendorinfo = $this->db->query("SELECT * from " . DB_PREFIX . "vendor WHERE vendor_id = '" .$vendor_id. "'");
					if(!empty($vendorinfo->row['email'])) {
						// Products
						$seller_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product  op LEFT JOIN " . DB_PREFIX . "vendor_order_product vop ON (op.order_id = vop.order_id) WHERE op.order_id = '" . (int)$order_info['order_id'] . "' and vop.vendor_id='".$vendor_id."' GROUP BY vop.order_product_id");


					$sellerproduct['products'] = array();

					foreach ($seller_product_query->rows as $product) {
						$option_data = array();

						$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_info['order_id'] . "' AND order_product_id = '" . (int)$product['order_product_id'] . "'");

						foreach ($order_option_query->rows as $option) {
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
								'value' => (strlen($value) > 20 ? substr($value, 0, 20) . '..' : $value)
							);
							}



							$this->load->model('vendor/vendor');
							$seller_info = $this->model_vendor_vendor->getVendor($product['vendor_id']);

							if ($this->request->server['HTTPS']) {
							$server = $this->config->get('config_ssl');
							} else {
							$server = $this->config->get('config_url');
							}

							if(isset($seller_info['display_name'])){
							$sellerdisplay = $seller_info['display_name'];
							} else{
								$sellerdisplay ='';
							}
						if(isset($seller_info['vendor_id'])){
							$vendor_ids = $server .'index.php?route=vendor/vendor_profile&'.'&vendor_id=' . $seller_info['vendor_id'];
						} else{
							$vendor_ids ='';
						}

							$customer2vendors = $this->config->get('vendor_customer2vendor');
							if($customer2vendors==1){
							 $data['customer2vendor'] = $customer2vendors;
							} else {
							 $data['customer2vendor']= false;
							}

						$sellerproduct['products'][] = array(
							'name'     => $product['name'],
							'sellerdisplay'   => $sellerdisplay,
							'vendor_ids'      => $vendor_ids,
							'model'    => $product['model'],
							'option'   => $option_data,
							'quantity' => $product['quantity'],
							'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
							'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
						);
						}

						$language = new Language($order_info['language_code']);
						$language->load($order_info['language_code']);
						$language->load('vendor/seller_order');

						$sellerproduct['text_shipping_address']= $language->get('text_shipping_address');
						$sellerproduct['text_payment_address']=$language->get('text_payment_address');
						$sellerproduct['text_product']= $language->get('text_product');
						$sellerproduct['text_model']=$language->get('text_model');
						$sellerproduct['text_quantity']=$language->get('text_quantity');
						$sellerproduct['text_price']=$language->get('text_price');
						$sellerproduct['text_total']=$language->get('text_total');
						$sellerproduct['text_order_detail']=$language->get('text_order_detail');
						$sellerproduct['text_order_detail']=$language->get('text_order_detail');
						$sellerproduct['text_email']=$language->get('text_email');
						$sellerproduct['text_shipping_method']=$language->get('text_shipping_method');
						$sellerproduct['text_payment_method']=$language->get('text_payment_method');
						$sellerproduct['text_telephone']=$language->get('text_telephone');
						$sellerproduct['text_ip']=$language->get('text_ip');
						$sellerproduct['title'] = sprintf($language->get('text_subject'), $order_info['store_name'], $order_info['order_id']);

						if($vendor2customers==1){
						 $sellerproduct['vendor2customer'] = $vendor2customers;
						} else {
						 $sellerproduct['vendor2customer']= false;
						}


						$sellerproduct['order_id'] = $order_info['order_id'];
						$sellerproduct['email'] = $order_info['email'];
						$sellerproduct['date_added'] = date($language->get('date_format_short'), strtotime($order_info['date_added']));
						$sellerproduct['shipping_method'] = $order_info['shipping_method'];
						$sellerproduct['payment_method'] = $order_info['payment_method'];
						$sellerproduct['telephone'] = $order_info['telephone'];
						$sellerproduct['ip'] = $order_info['ip'];
						// Order Totals
							$sellerproduct['sellrtotals'] = array();
							$sellerproductorder_totals = $this->model_checkout_order->getOrderTotals($order_info['order_id']);

							foreach ($sellerproductorder_totals as $sellerorder_total) {
								$sellerproduct['sellrtotals'][] = array(
									'title' => $sellerorder_total['title'],
									'text'  => $this->currency->format($sellerorder_total['value'], $order_info['currency_code'], $order_info['currency_value']),
								);
							}


						/* payment address start */
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
							'zone_code' => $order_info['payment_zone_code'],
							'country'   => $order_info['payment_country']
						);

						$sellerproduct['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

					/* payment address end */

					/* shipping address start */
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
							'zone_code' => $order_info['shipping_zone_code'],
							'country'   => $order_info['shipping_country']
						);

						$sellerproduct['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

						/* shipping address end */

						$selerhtmldata=$this->load->view('vendor/seller_order', $sellerproduct);

						$find = array(
							'{order_id}',
							'{display_name}',
							'{email}',
							'{seller_telephone}',
							'{address_1}',
							'{seller_lastname}'	,
							'{seller_firstname}',
							'{product_info}',
							'{productname}',
							/* 01 10 2020 */
							'{customername}',
							'{customeremail}',
							'{customertelephone}',
							'{customer_id}',
							/* 01 10 2020 */
						);
						$replace = array(
							'order_id' => $order_info['order_id'],
							'display_name'=> $vendorinfo->row['display_name'],
							'email' 	=> $vendorinfo->row['email'],
							'seller_telephone' => $vendorinfo->row['telephone'],
							'address_1' => $vendorinfo->row['address_1'],
							'seller_lastname' => $vendorinfo->row['lastname'],
							'seller_firstname' => $vendorinfo->row['firstname'],
							'product_info' => $selerhtmldata,
							'productname' =>  $product['name'],
							/* 01 10 2020 */
							'customername' =>  $order_info['firstname'].' '. $order_info['lastname'],
							'customeremail' =>  $order_info['email'],
							'customertelephone' =>  $order_info['telephone'],
							'customer_id' =>  $order_info['customer_id']
							/* 01 10 2020 */
						);

						$subject= str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $subject))));
						$message= str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $emailtemplete->row['message']))));
						
						$mail = new \Opencart\System\Library\Mail($this->config->get('config_mail_engine'));
						$mail->parameter = $this->config->get('config_mail_parameter');
						$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
						$mail->smtp_username = $this->config->get('config_mail_smtp_username');
						$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
						$mail->smtp_port = $this->config->get('config_mail_smtp_port');
						$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

						$mail->setTo($vendorinfo->row['email']);
						$mail->setFrom($this->config->get('config_email'));
						$mail->setSender(html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'));
						$mail->setSubject($subject);
						$mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
						$mail->send();
					}

				}
			}
		 } 
	  }
	  
		$template_buffer = $this->getTemplateBuffer($route,$output);
		$find='{% for option in product.option %}';
		$replace='{% if customer2vendor==1 %}
                {% if product.sellerdisplay %}
                 {{ text_byseller }}
                <a href="{{ product.vendor_ids }}">{{ product.sellerdisplay }}</a>
                {% endif %}
              {% endif %}
            <!-- xml -->{% for option in product.option %}';
		$output = str_replace( $find, $replace, $template_buffer );
	}
	
	public function productposition(string &$route, array &$args, mixed &$output): void
	{
		$args['column_inpro'] = $this->load->controller('extension/tmdmultivendor/common/column_inpro');
		
		// xml
			$this->load->model('extension/tmdmultivendor/vendor/vendor');
			$vendorproduct_id = $this->model_extension_tmdmultivendor_vendor_vendor->getSellerProduct($this->request->get['product_id']);
			
			if(!empty($vendorproduct_id['vendor_id'])){
			$vendor_ids = $vendorproduct_id['vendor_id'];
			} else {
			$vendor_ids = '';
			}
			$vendorchat_ids = $this->model_extension_tmdmultivendor_vendor_vendor->getChatid($vendor_ids);

			if(!empty($vendorchat_ids['message'])){
			$args['vendorchat_id'] = $vendorchat_ids['message'];
			} else {
			$args['vendorchat_id'] = '';
			}
			

			if(!empty($vendorproduct_id['vendor_id'])){
			$vendornameinfo = $this->model_extension_tmdmultivendor_vendor_vendor->getInProductSellerName($this->request->get['product_id'], $vendorproduct_id['vendor_id']);
			}
			
			$vlbles = $this->config->get('vendor_languages');
			
			if(!empty($vlbles[$this->config->get('config_language_id')]['selernameinpro'])) {
			$args['text_vendorname']= $vlbles[$this->config->get('config_language_id')]['selernameinpro'].': ';
			} else {			
			$args['text_vendorname'] = $this->language->get('text_vendorname');
			}
			
			if(!empty($vendorproduct_id['vendor_id'])){
			$args['chkvendor_ids'] = $vendorproduct_id['vendor_id'];
			} else {
			$args['chkvendor_ids'] = 0;
			}
			
			if(!empty($vendornameinfo['firstname'])){					
			    $vendornames = $vendornameinfo['firstname'].' '.$vendornameinfo['lastname'];
			} else {				
				$vendornames = '';
			}

			if(!empty($vendornameinfo['display_name'])){					
			    $vendordisplay_name = $vendornameinfo['display_name'];
			} else {				
				$vendordisplay_name = '';
			}

			if(!empty($vendornameinfo['company'])){					
			    $vendorcompany = $vendornameinfo['company'];
			} else {				
				$vendorcompany = '';
			}
			
			if(!empty($vendornameinfo['storename'])){					
			    $vendorstorename = $vendornameinfo['storename'];
			} else {				
				$vendorstorename = '';
			}
					
			$find = array(
				'{vendorname}',			
				'{display_name}',
				'{company}',
				'{storename}'			
			);
			
			$replace = array(
				'vendorname' => $vendornames,	
				'display_name' => $vendordisplay_name,
				'company' => $vendorcompany,			
				'storename' => $vendorstorename			
			);			
			
			if(!empty($vlbles[$this->config->get('config_language_id')]['sellershortcut'])) {
			$sellershortcut= $vlbles[$this->config->get('config_language_id')]['sellershortcut'];
			} else {			
			$sellershortcut = '';
			}
			if(!empty(strip_tags(html_entity_decode($vlbles[$this->config->get('config_language_id')]['sellershortcut'])))){
				$args['vendorname'] = str_replace($find, $replace, strip_tags(html_entity_decode($sellershortcut, ENT_QUOTES, 'UTF-8')));
			} else {
				$args['vendorname'] = $vendornames;
			}
		
			
		
		$template_buffer = $this->getTemplateBuffer($route,$output);
		$find='<li>{{ text_stock }} {{ stock }}</li>';
		$replace='<li>{{ text_stock }} {{ stock }}</li><!-- xml -->
            {% if chkvendor_ids !=0 %}
              <li><b>{{ text_vendorname}} {{ vendorname }}</b></li>
            {% endif %}
            <!-- xml end -->';
		$output1 = str_replace( $find, $replace, $template_buffer );
	
		$find='<ul class="nav nav-tabs">';
		$replace='<div class="row px-0 m-0"><div class="col-sm-9 col-xs-12"><ul class="nav nav-tabs">';
		$output2 = str_replace($find, $replace,$output1); 
		
		$find='{% if products %}'."\n";
		$replace='
			  {{ column_inpro }}
			  </div></div>{% if products %}	';
		$output3 = str_replace($find, $replace,$output2); 
		
		$find='{{ footer }}';
		$replace='{% if vendorchat_id %}
				<script type="text/javascript">
					var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
					(function(){
					var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
					s1.async=true;
					s1.src="https://embed.tawk.to/{{vendorchat_id}}";
					s1.charset="UTF-8";
					s1.setAttribute("crossorigin","*");
					s0.parentNode.insertBefore(s1,s0);
					})();
				</script>
			{% endif %}{{ footer }}';
		$output = str_replace($find, $replace,$output3); 
			
	}
	
	public function headerevent(string &$route, array &$args, mixed &$output): void{

		$modulestatus=$this->config->get('module_tmdvendor_status');
		if(!empty($modulestatus)){
			$this->load->language('extension/tmdmultivendor/module/modulevariables');
			
			$allalbles = $this->config->get('vendor_languages');	
			
			if(!empty($allalbles[$this->config->get('config_language_id')]['loginseller'])) {
			$args['text_loginseller']	= $allalbles[$this->config->get('config_language_id')]['loginseller'];
			} else {
			$args['text_loginseller'] = $this->language->get('text_loginseller');
			}
			
			if(!empty($allalbles[$this->config->get('config_language_id')]['sellerlist'])) {
			$args['text_allseller']	= $allalbles[$this->config->get('config_language_id')]['sellerlist'];
			} else {
			$args['text_allseller'] = $this->language->get('text_allseller');
			}
			
			if(!empty($allalbles[$this->config->get('config_language_id')]['afterloginseller'])) {
			$args['text_selleraccount']	= $allalbles[$this->config->get('config_language_id')]['afterloginseller'];
			} else {
			$args['text_selleraccount'] = $this->language->get('text_selleraccount');
			}
			
			if(!empty($allalbles[$this->config->get('config_language_id')]['sellerdash'])) {
			$args['text_dashboard']	= $allalbles[$this->config->get('config_language_id')]['sellerdash'];
			} else {
			$args['text_dashboard'] = $this->language->get('text_dashboard');
			}
			
			if(!empty($allalbles[$this->config->get('config_language_id')]['sellerproduct'])) {
			$args['text_products']	= $allalbles[$this->config->get('config_language_id')]['sellerproduct'];
			} else {
			$args['text_products'] = $this->language->get('text_products');
			}
			
			
			if(!empty($allalbles[$this->config->get('config_language_id')]['sellerreview'])) {
			$args['text_review']	= $allalbles[$this->config->get('config_language_id')]['sellerreview'];
			} else {
			$args['text_review'] = $this->language->get('text_review');
			}
			
			if(!empty($allalbles[$this->config->get('config_language_id')]['managestore'])) {
			$args['text_managestore']	= $allalbles[$this->config->get('config_language_id')]['managestore'];
			} else {
			$args['text_managestore'] = $this->language->get('text_managestore');
			}
			
			if(!empty($allalbles[$this->config->get('config_language_id')]['manageprofile'])) {
			$args['text_manageprofile']	= $allalbles[$this->config->get('config_language_id')]['manageprofile'];
			} else {
			$args['text_manageprofile'] = $this->language->get('text_manageprofile');
			}
			
			if(!empty($allalbles[$this->config->get('config_language_id')]['download'])) {
			$args['text_sellerdownload']	= $allalbles[$this->config->get('config_language_id')]['download'];
			} else {
			$args['text_sellerdownload'] = $this->language->get('text_sellerdownload');
			}
			
			if(!empty($allalbles[$this->config->get('config_language_id')]['manufacture'])) {
			$args['text_manufacture']	= $allalbles[$this->config->get('config_language_id')]['manufacture'];
			} else {
			$args['text_manufacture'] = $this->language->get('text_manufacture');
			}
			
			if(!empty($allalbles[$this->config->get('config_language_id')]['sellerprofile'])) {
			$args['text_profile']	= $allalbles[$this->config->get('config_language_id')]['sellerprofile'];
			} else {
			$args['text_profile'] = $this->language->get('text_profile');
			}
			if(!empty($allalbles[$this->config->get('config_language_id')]['sellerlogout'])) {
			$args['text_sellerlogout']	= $allalbles[$this->config->get('config_language_id')]['sellerlogout'];
			} else {
			$args['text_sellerlogout'] = $this->language->get('text_sellerlogout');
			}
			
			$args['vendorlogged'] = $this->vendor->isLogged();		
			$args['sellerlogin'] = $this->url->link('extension/tmdmultivendor/vendor/login', 'language=' . $this->config->get('config_language'));
			$args['allseller'] = $this->url->link('extension/tmdmultivendor/vendor/allseller', 'language=' . $this->config->get('config_language'));
			$args['dashboard'] = $this->url->link('extension/tmdmultivendor/vendor/dashboard', '', true);
			$args['products'] = $this->url->link('extension/tmdmultivendor/vendor/product', '', true);
			$args['review'] = $this->url->link('extension/tmdmultivendor/vendor/review', '', true);
			$args['managestore'] = $this->url->link('extension/tmdmultivendor/vendor/store', '', true);
			$args['manageprofile'] = $this->url->link('extension/tmdmultivendor/vendor/edit', '', true);
			$args['vdownload'] = $this->url->link('extension/tmdmultivendor/vendor/download', '', true);
			$args['manufacture'] = $this->url->link('extension/tmdmultivendor/vendor/manufacturer', '', true);
			$args['logouts'] = $this->url->link('extension/tmdmultivendor/vendor/logout', '', true);
			
			$this->load->model('extension/tmdmultivendor/vendor/vendor');	
			$vendorinfo =  $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($this->vendor->getId());
		
			if(!empty($vendorinfo['keyword'])){
			$vendorkeyword = $vendorinfo['keyword'];
			} else{
			$vendorkeyword = $this->url->link('extension/tmdmultivendor/vendor/vendor_profile', '&vendor_id=' . $this->vendor->getId(), true);
			}
			$args['vendor_profile'] = $vendorkeyword;

			$vlbles = $this->config->get('vendor_languages');	
				if(!empty($vlbles[$this->config->get('config_language_id')]['byseller'])) {
				$args['text_byseller']= $vlbles[$this->config->get('config_language_id')]['byseller'].': ';
				} else {			
				$args['text_byseller'] = $this->language->get('text_byseller');
				}
			$args['customer2vendor'] = $this->config->get('vendor_customer2vendor');
		
			$template_buffer = $this->getTemplateBuffer($route,$output);
			$find='<li class="list-inline-item"><a href="{{ contact }}"><i class="fa-solid fa-phone"></i></a> <span class="d-none d-md-inline">{{ telephone }}</span></li>';
			
			$replace='
      {% if customer2vendor==1 %}
      <li class="list-inline-item tmd-menubox"><a href="{{ allseller }}"><i class="fas fa-users fa-fw"></i> <span class="d-none d-md-inline"> {{ text_allseller }}</span></a></li>
      {% endif %}
      {% if vendorlogged %}
      <li class="list-inline-item dropdown tmdseller"><a href="#" title="{{ text_selleraccount }}" class="dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-users"></i> <span class="d-none d-md-inline">{{ text_selleraccount }}</span> <span class="caret"></span></a>
      <ul class="dropdown-menu dropdown-menu-right ">
        <li><a href="{{ vendor_profile }}"><i class="fa fa-user fa-fw"></i> {{ text_profile }}</a></li>
        <li><a href="{{ dashboard }}"><i class="fas fa-home fa-fw"></i> {{ text_dashboard }}</a></li>
        <li><a href="{{ products }}"><i class="fa fa-list fa-fw"></i> {{ text_products }}</a></li>
        <li><a href="{{ review }}"><i class="fa fa-star fa-fw"></i> {{ text_review }}</a></li>
        <li><a href="{{ managestore }}"><i class="fa fa-cog fa-fw"></i> {{ text_managestore }}</a></li>
        <li><a href="{{ manageprofile }}"><i class="fa fa-user fa-fw"></i> {{ text_manageprofile }}</a></li>
        <li><a href="{{ vdownload }}"><i class="fas fa-download"></i> {{ text_sellerdownload }}</a></li>
        <li><a href="{{ manufacture }}"><i class="fas fa-thumbtack fa-fw"></i> {{ text_manufacture }}</a></li>
        <li><a href="{{ logouts }}"><i class="fas fa-sign-out-alt"></i> {{ text_sellerlogout }}</a></li>
      </ul>
      </li>
      {% else %}
        <li class="list-inline-item tmd-menubox"><a href="{{ sellerlogin }}"><i class="fas fa-sign-in-alt"></i><span class="d-none d-md-inline"> {{ text_loginseller }}</span></a></li>
      {% endif %}
     <li class="list-inline-item"><a href="{{ contact }}"><i class="fas fa-phone"></i></a> <span class="d-none d-md-inline">{{ telephone }}</span></li>';
			$output = str_replace( $find, $replace, $template_buffer );
			
			$args['lang_code'] = $this->config->get('config_language');
	
			$find='</head>';
			$replace='<link href="extension/tmdmultivendor/catalog/view/stylesheet/vendor/vendor.css" rel="stylesheet">{% if lang_code=='.'ar-ar'.' %}
			   <link href="extension/tmdmultivendor/catalog/view/stylesheet/vendor/bootstrap-rtl.css" rel="stylesheet">
			   <link href="extension/tmdmultivendor/catalog/view/stylesheet/vendor/bootstrap-rtl.min.css" rel="stylesheet">
			   <link href="extension/tmdmultivendor/catalog/view/stylesheet/vendor/rtl.css" rel="stylesheet">
		  {% endif %}</head>';
			$output = str_replace( $find, $replace, $output );
		}
	}
	
	public function index() {
		$this->load->language('extension/tmdmultivendor/module/tmd_vendor');

		$data['heading_title'] = $this->language->get('heading_title');

		/// seller Product Start ////
			$data['text_sellerinformation'] = $this->language->get('text_sellerinformation');
			$data['text_contactseller'] = $this->language->get('text_contactseller');
			$data['text_seller'] = $this->language->get('text_seller');
			$data['text_from'] = $this->language->get('text_from');
			$data['text_totalproducts'] = $this->language->get('text_totalproducts');
			$vendor_hidevnames =  $this->config->get('vendor_hidevendorname');
			if(isset($vendor_hidevnames)){
				$data['vendor_hidevname'] = $vendor_hidevnames;
			} else {
				$data['vendor_hidevname'] = '';
			}
			$data['headingbg'] = $this->config->get('module_tmdvendor_bgcolor');

			$data['textcolor'] = $this->config->get('module_tmdvendor_textcolor');
			$imagetype = $this->config->get('module_tmdvendor_imagetype');
			if($imagetype=='round'){
			$data['imgeborder'] = 'roundborder';
			} elseif($imagetype=='rect'){
				
			$data['imgeborder'] = 'rectborder';
			}
			
			
			$vendor_status = $this->config->get('module_tmdvendor_status');
			
			$imagewidths = $this->config->get('module_tmdvendor_imgwidth');
			$imageheights = $this->config->get('module_tmdvendor_imgheight');
			
			if(!empty($imagewidths)){
				$imagewidth = $imagewidths;
			} else {
				$imagewidth = 100;
				
			}

			if(!empty($imageheights)){
				$imageheight = $imageheights;
			} else {
				$imageheight = 100;
				
			}	
			
			$this->load->model('extension/tmdmultivendor/vendor/vendor');
			$this->load->model('tool/image');
			if(isset($this->request->get['product_id'])){
			$sellerproduct_info = $this->model_extension_tmdmultivendor_vendor_vendor->getSellerProduct($this->request->get['product_id']);
				if(isset($sellerproduct_info['vendor_id'])) {
					$seller_info = $this->model_extension_tmdmultivendor_vendor_vendor->getSellerInfo($sellerproduct_info['vendor_id']);
				}
			}
			
			if(isset($seller_info['display_name'])){
				$dname = $seller_info['display_name'];
			} else {
				$dname='';
			}
			
			if(isset($seller_info['countryname'])){
				$data['countryname'] = $seller_info['countryname'];
			} else {
				$data['countryname']='';
			}
			
			if(isset($sellerproduct_info['vendor_id'])){
			$seller_vendor_id = $sellerproduct_info['vendor_id'];
			} else {				
			$seller_vendor_id='';	
			}
			$totalcount = $this->model_extension_tmdmultivendor_vendor_vendor->getTotalCollections($seller_vendor_id);
			
			
			if(isset($totalcount)){
				$data['totalproducts'] = $totalcount;
			} else {
				$data['totalproducts']='';
			}
			
			if(isset($seller_info['vendor_id'])){
				$vendor_ids = $seller_info['vendor_id'];
			} else {
				$vendor_ids='';
			}
			
			if(!empty($seller_info['image'])){
				$sellerimage = $this->model_tool_image->resize($seller_info['image'],$imagewidth,$imageheight);
			} else {
				$sellerimage = $this->model_tool_image->resize('placeholder.png',$imagewidth,$imageheight);
			}
			/* new code 07 10 2021 */
			$data['reviewvalue'] = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorSumValue($vendor_ids);
			$data['sellertotal'] = $this->model_extension_tmdmultivendor_vendor_vendor->getTotalSellerReview($vendor_ids);
			$vendor_hidevsocialicons =  $this->config->get('vendor_hidevsocialicon');
			if(isset($vendor_hidevsocialicons)){
			$data['vendor_hidevsocialicon'] = $vendor_hidevsocialicons;
			} else {
				$data['vendor_hidevsocialicon'] = '';
			}
			
			if(!empty($seller_info['facebook_url'])){
			$facebookurl = $seller_info['facebook_url'];
			} else {
				$facebookurl = '';
			}

			if(!empty($seller_info['google_url'])){
				$googleurl = $seller_info['google_url'];
			} else {
				$googleurl = '';
			}
			/* Social icon */
		
		if(!empty($seller_info['whatsapp_url'])){
			$whatsapp_url = $seller_info['whatsapp_url'];
		} else {
			$whatsapp_url = '';
		}
		
		if(!empty($seller_info['instagram_url'])){
			$instagram_url = $seller_info['instagram_url'];
		} else {
			$instagram_url = '';
		}
		
		if(!empty($seller_info['twitter_url'])){
			$twitter_url = $seller_info['twitter_url'];
		} else {
			$twitter_url = '';
		}
		
		if(!empty($seller_info['snapchat_url'])){
			$snapchat_url = $seller_info['snapchat_url'];
		} else {
			$snapchat_url = '';
		}
		
		if(!empty($seller_info['pinterest_url'])){
			$pinterest_url = $seller_info['pinterest_url'];
		} else {
			$pinterest_url = '';
		}
		
		if(!empty($seller_info['youtube_url'])){
			$youtube_url = $seller_info['youtube_url'];
		} else {
			$youtube_url = '';
		}
		
		if(!empty($seller_info['linkidin_url'])){
			$linkidin_url = $seller_info['linkidin_url'];
		} else {
			$linkidin_url = '';
		}
		
		if(!empty($seller_info['tiktok_url'])){
			$tiktok_url = $seller_info['tiktok_url'];
		} else {
			$tiktok_url = '';
		}
		
		if(isset($seller_info['map_url']))	{
		$mapurls =  strip_tags(html_entity_decode($seller_info['map_url'], ENT_QUOTES, 'UTF-8'));
		}
		if(!empty($mapurls)){
			$mapurl = $mapurls;
			$vendorfindme = $this->url->link('extension/tmdmultivendor/vendor/findme','&vendor_id=' .$seller_info['vendor_id']);
		} else {
			$mapurl ='';
			$vendorfindme ='';
		} 
		
		if(!empty($seller_info['tiktok_url'])){
			$tiktok_url = $seller_info['tiktok_url'];
		} else {
			$tiktok_url = '';
		}
		
	

		$data['whatsapp_url'] = $whatsapp_url;
		$data['instagram_url'] = $instagram_url;
		$data['twitter_url'] = $twitter_url;
		$data['snapchat_url'] = $snapchat_url;
		$data['pinterest_url'] = $pinterest_url;
		$data['youtube_url'] = $youtube_url;
		$data['linkidin_url'] = $linkidin_url;
		$data['tiktok_url'] = $tiktok_url;
		$data['mapurl'] = $mapurl;
		$data['vendorfindme'] = $vendorfindme;
		
	
		
		/* Social icon */
		
			$data['facebookurl'] = $facebookurl;
			$data['googleurl']   = $googleurl;
			
			/* new code 07 10 2021 */
			$data['sellerimage'] = $sellerimage;
			$data['dname'] = $dname;
			$data['href']  = $this->url->link('extension/tmdmultivendor/vendor/vendor_profile&vendor_id='.$vendor_ids, '', true);
			$data['vendor_ids']   = $vendor_ids;
			
		/// seller Product End ////	
		/* tmd vendor2 seler condtion start */
		$customer2vendor = $this->config->get('vendor_customer2vendor');

		if($customer2vendor==1){
			if(!empty($vendor_ids) || !empty($vendor_statu)){
			return $this->load->view('extension/tmdmultivendor/module/tmd_vendor', $data);
			}
		}
		/* tmd vendor2 seler condtion end */	
	}
	
	protected function getTemplateBuffer( $route, $event_template_buffer ) {
		// if there already is a modified template from view/*/before events use that one
		if ($event_template_buffer) {
			return $event_template_buffer;
		}

		// load the template file (possibly modified by ocmod and vqmod) into a string buffer
		
			if ($this->config->get('config_theme') == 'default') {
				$theme = $this->config->get('theme_default_directory');
			} else {
				$theme = $this->config->get('config_theme');
			}
			  $dir_template = DIR_TEMPLATE ;
			
		
	 $template_file = $dir_template . $route . '.twig';
		if (file_exists( $template_file ) && is_file( $template_file )) {
			
			return file_get_contents( $template_file );
		}
		if ($this->isAdmin()) {
			trigger_error("Cannot find template file for route '$route'");
			exit;
		}
		$dir_template = DIR_TEMPLATE . 'default/template/';
		$template_file = $dir_template . $route . '.twig';
		if (file_exists( $template_file ) && is_file( $template_file )) {
			
			return file_get_contents( $template_file );
		}
		trigger_error("Cannot find template file for route '$route'");
		exit;
	}
}