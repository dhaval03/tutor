<?php
namespace Opencart\Catalog\Controller\extension\Tmdmultivendor\Module;
use \Opencart\System\Helper AS Helper;
class vendorfeatured extends \Opencart\System\Engine\Controller {
	public function index(array $setting): string {
		$this->load->language('extension/tmdmultivendor/module/vendorfeatured');
		
		if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			$data['heading_title'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
		} else {
			$data['heading_title'] = $this->language->get('heading_title');
		}
		
		$data['text_tax'] = $this->language->get('text_tax');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		
		$data['customer2vendor'] = $this->config->get('vendor_customer2vendor');
		
		$vendor_hidevnames =  $this->config->get('vendor_hidevendorname');
	
		if(isset($vendor_hidevnames)){
			$data['vendor_hidevname'] = $vendor_hidevnames;
		} else {
			$data['vendor_hidevname'] = '';
		}

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = [];

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}
            
        $this->load->model('extension/tmdmultivendor/vendor/allseller');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
		$this->load->model('localisation/country');
		$this->load->model('localisation/zone');
		if (!empty($setting['product'])) {
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);

			foreach ($products as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);
				
				if ($product_info) {
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$price = false;
					}

					if ((float)$product_info['special']) {
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $product_info['rating'];
					} else {
						$rating = false;
					}

					$vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendorProductFeature($product_info['product_id']);
					if(!empty($vendor_info)) {
					$ven_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($vendor_info['vendor_id']);
					if(!empty($ven_info)) {
						if(isset($ven_info['firstname'])){
							$sellername = $ven_info['firstname'];
						} else {
							$sellername = '';
						}

						if(isset($ven_info['city'])){
							$sellercity = $ven_info['city'];
						} else {
							$sellercity = '';
						}

						if ($ven_info['image']) {
							$sellerimage = $this->model_tool_image->resize($ven_info['image'], 50, 50);
						} else {
							$sellerimage = $this->model_tool_image->resize('placeholder.png', 50, 50);
						}

						$store_info = $this->model_extension_tmdmultivendor_vendor_allseller->getVendordescription($ven_info['vendor_id']);
						if(isset($store_info['name'])){
							$storename = $store_info['name'];
						} else {
							$storename = '';
						}

						$country_info = $this->model_localisation_country->getCountry($ven_info['country_id']);
						if(isset($country_info['name'])){
							$countryname = $country_info['name'];
						} else {
							$countryname = '';
						}

						$zone_info = $this->model_localisation_zone->getZone($ven_info['zone_id']);
						if(isset($zone_info['name'])){
							$zonename = $zone_info['name'];
						} else {
							$zonename = '';
						}

						$product_data= [
							'product_id'  => $product_info['product_id'],
							'thumb'       => $image,
							'name'        => $product_info['name'],
							'description' => Helper\Utf8\substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 146) . '..',
							'minimum'     => $product_info['minimum'] > 0 ? $product_info['minimum'] : 1,
							'price'       => $price,
							'special'     => $special,
							'tax'         => $tax,
							'rating'      => $rating,
							'sellername'  => $sellername,
							'sellerimage' => $sellerimage,
							'storename'   => $storename,
							'countryname' => $countryname,
							'zonename	' => $zonename,
							'sellercity'  => $sellercity,
							'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
							'profile'     => $this->url->link('extension/tmdmultivendor/vendor/vendor_profile', 'vendor_id=' . $ven_info['vendor_id'])
						];				
						$data['products'][] = $this->load->controller('extension/tmdmultivendor/vendor/vendorthumb', $product_data);					
					}
					}
				}
			}
		

		
			return $this->load->view('extension/tmdmultivendor/module/vendorfeatured', $data);
		}
	}
}