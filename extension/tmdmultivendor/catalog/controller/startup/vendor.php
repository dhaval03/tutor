<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Startup;
class Vendor extends \Opencart\System\Engine\Controller {
    public function index(): void {
		
		// vendor start here
		require_once(DIR_EXTENSION.'/tmdmultivendor/system/library/cart/vendor.php');
		$this->registry->set('vendor', new \Opencart\System\Library\Cart\Vendor($this->registry));
		// vendor start here
		
		$this->event->register('view/*/before', new \Opencart\System\Engine\Action('extension/tmdmultivendor/startup/vendor|event'));   
		if (!$this->isAdmin()) {
	
		$apipath = DIR_APPLICATION . 'controller/api/sale/cart.php'; 
		
		$apifind='$json'."['products'][] = ["."\n";
		
		$apireplace='$this'."->load->model('extension/tmdmultivendor/vendor/vendor');"."\n".'$seller_infos'."=".'$this'."->model_extension_tmdmultivendor_vendor_vendor->getVendorid(".'$product'."['product_id']);"."\n"."if(isset(".'$seller_infos'."['vendor_id'])){"."\n".
					'$seller_info'."=".'$this'."->model_extension_tmdmultivendor_vendor_vendor->getVendor(".'$seller_infos'."['vendor_id']);"."\n".
				"}"."\n".
			
				"if(isset(".'$seller_info'."['display_name'])){"."\n".
					'$sellername'." = ".'$seller_info'."['display_name'];"."\n".
				"} else {"."\n".
					'$sellername'." ='';"."\n".
				"}"."\n".
				"if(isset(".'$seller_info'."['vendor_id'])){"."\n".
					'$ids'." = ".'$seller_info'."['vendor_id'];"."\n".
				"} else {"."\n".
					'$ids'." ='';"."\n".
				"}"."\n".'$json'."['products'][] = ['sellername'   	   => ".'$sellername'.","."\n"."'vendor_id'   "."=> ".'$ids'.",";
		$str1 = file_get_contents($apipath);
		
		$tmdvendor_status = $this->config->get('module_tmdvendor_status');		
		if($tmdvendor_status=1){	
			$chagecode1 = str_replace($apifind, $apireplace, $str1);
			file_put_contents($apipath, $chagecode1);
		}else{
			$chagecode1 = str_replace($apireplace,$apifind, $str1);
			file_put_contents($apipath, $chagecode1);
		}
		}
		
    }

    public function event(string &$route, array &$args, mixed &$output): void {
        $override = [
			
        ];

        if (in_array($route, $override)) {
			$route = 'extension/tmdmultivendor/' . $route;
        }
		
	}
	
	protected function isAdmin() {
		return defined( 'DIR_CATALOG' ) ? true : false;
	}
	
	public function checkoutcart(string &$route, array &$args): array {
		
		$this->load->model('tool/image');
		$this->load->model('tool/upload');

		// Products
		$product_data = [];

		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			if ($product['image']) {
				$image = $this->model_tool_image->resize(html_entity_decode($product['image'], ENT_QUOTES, 'UTF-8'), $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
			} else {
				$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
			}

			$option_data = [];

			foreach ($product['option'] as $option) {
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

				$option_data[] = [
					'name'  => $option['name'],
					'value' => (strlen($value) > 20 ? substr($value, 0, 20) . '..' : $value),
					'type'  => $option['type']
				];
			}

			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$minimum = false;
			} else {
				$minimum = true;
			}

			$option_data = [];

			foreach ($product['option'] as $option) {
				$option_data[] = [
					'product_option_id'       => $option['product_option_id'],
					'product_option_value_id' => $option['product_option_value_id'],
					'option_id'               => $option['option_id'],
					'option_value_id'         => $option['option_value_id'],
					'name'                    => $option['name'],
					'value'                   => $option['value'],
					'type'                    => $option['type']
				];
			}
			
			// vendor start here
			
			$seller_query = $this->db->query("SELECT v.display_name,v.vendor_id FROM " . DB_PREFIX . "vendor_to_product v2p LEFT JOIN " . DB_PREFIX . "vendor v ON (v2p.vendor_id = v.vendor_id) WHERE v2p.product_id = '".(int)$product['product_id'] . "' ");



			if(isset($seller_query->row['display_name'])){
			$sellerdisplay = $seller_query->row['display_name'];
			} else{
			$sellerdisplay ='';
			}

			if(isset($seller_query->row['vendor_id'])){
			$vendor_ids = $seller_query->row['vendor_id'];
			} else{
			$vendor_ids ='';
			}
			// vendor end here

			$product_data[] = [
				'cart_id'      => $product['cart_id'],
				// vendor start here
				'sellerdisplay'   => $sellerdisplay,
				'vendor_ids'      => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile', 'vendor_id=' .$vendor_ids),
				'thumb'        => $image,
				// vendor end here
				'product_id'   => $product['product_id'],
				'master_id'    => $product['master_id'],
				'image'        => $image,
				'name'         => $product['name'],
				'model'        => $product['model'],
				'option'       => $product['option'],
				'subscription' => $product['subscription'],
				'download'     => $product['download'],
				'quantity'     => $product['quantity'],
				'stock'        => $product['stock'],
				'minimum'      => $minimum,
				'shipping'     => $product['shipping'],
				'subtract'     => $product['subtract'],
				'reward'       => $product['reward'],
				'tax_class_id' => $product['tax_class_id'],
				'price'        => $product['price'],
				'total'        => $product['price'] * $product['quantity']
			];
		}

		return $product_data;
	
	
}

public function success(string &$route, array &$args): void {
	$this->load->model('extension/tmdmultivendor/vendor/vendor');
	$this->load->model('checkout/order');
	$order_id=$this->session->data['order_id'];
	$orderdata = $this->model_checkout_order->getOrder($this->session->data['order_id']);
	
	$this->db->query("DELETE FROM `" . DB_PREFIX . "vendor_order_product` WHERE order_id = '" . (int)$order_id . "'");
			$this->db->query("DELETE FROM `" . DB_PREFIX . "order_vendorhistory` WHERE order_id = '" . (int)$order_id . "'");
			
			
	$order_products = $this->model_checkout_order->getProducts($this->session->data['order_id']);
	
	foreach ($order_products as $product) {
		
		$order_product_id=$product['order_product_id'];
		// vendor start here
				$commisioninfo=$this->model_extension_tmdmultivendor_vendor_vendor->getOrderCommission($product['product_id'],$product['total']+($product['tax']*$product['quantity']),$product['quantity']);
				if(isset($commisioninfo)){

			
				$seller_info = $this->db->query("SELECT vendor_id FROM " . DB_PREFIX . "vendor_to_product WHERE product_id = '" . (int)$product['product_id'] . "'");

				if(isset($seller_info->row['vendor_id'])) {
					$vendor_ids = $seller_info->row['vendor_id'];
				} else {
					$vendor_ids =0;
				}

				if(!empty($commisioninfo['vendor_id'])){
				$vendor_idss = $commisioninfo['vendor_id'];
				} else {
				$vendor_idss =$vendor_ids;
				}
				
				$shippingcost=0;
					if($orderdata['shipping_code']=='shippingcost.shippingcost'){
						if(!empty($this->session->data['tmdshippingcost'][$product['product_id']]))
						{
							 $shippingcost=$this->session->data['tmdshippingcost'][$product['product_id']];
						}
					}
			
			
				$this->db->query("INSERT INTO " . DB_PREFIX . "vendor_order_product SET order_product_id='".(int)$order_product_id."',order_id = '" . (int)$order_id . "',product_id = '" . (int)$product['product_id'] . "',name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', tax = '" . (float)$product['tax'] . "', reward = '" . (int)$product['reward'] . "',commissionper='".$commisioninfo['commissionper']."',vendor_id='".$vendor_idss."',commissionfix='".$commisioninfo['commissionfix']."',totalcommission='".$commisioninfo['totalcommission']."',  tmdshippingcost='".$shippingcost."',  date_added = NOW()");
				
				}
				
				// vendor end here
				
	}
	
	
}


public function deleteOrder(string &$route, array &$args): array {
	
	$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_order_product WHERE order_id = '" . (int)$args[0] . "'");				
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_vendorhistory WHERE order_id = '" . (int)$args[0] . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "vendor_order_product WHERE order_id = '" . (int)$args[0] . "'");
		
}
	
	
}