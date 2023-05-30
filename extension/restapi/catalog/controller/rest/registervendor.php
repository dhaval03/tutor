<?php
/**
 * register.php
 *
 * Registration management
 *
 * @author     Opencart-api.com
 * @copyright  2017
 * @license    License.txt
 * @version    2.0
 * @link       https://opencart-api.com/product/shopping-cart-rest-api/
 * @documentations https://opencart-api.com/opencart-rest-api-documentations/
 */

namespace Opencart\Catalog\Controller\Extension\RestApi\Rest;
require_once(DIR_SYSTEM . 'engine/restcontroller.php');

class Registervendor extends \RestController
{
    public function registervendor()
    {
		$this->checkPlugin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //add customer
            $post = $this->getPost();
            $this->addRegistervendor($post);
        } else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("POST");
        }

        return $this->sendResponse();
    }

	public function addRegistervendor($data)
    {
			$this->load->model('extension/tmdmultivendor/vendor/vendor');

        $vendor = $this->model_extension_tmdmultivendor_vendor_vendor->addVendor($data);
        $data['vendor'] = array_values($data);

        if (!empty($data['vendor'])) {

            $this->json["data"] = $data;
        }

        if($this->includeMeta) {

            $data = $this->json['data'];

            if(isset($this->json['data']['vendor'])) {
                $intercomsData = $this->json['data']['vendor'];
            } else {
                $intercomsData = array();
            }
            $this->response->addHeader('X-Total-Count: ' . count($intercomsData));
            $this->response->addHeader('X-Pagination-Limit: '.count($intercomsData));
            $this->response->addHeader('X-Pagination-Page: 1');
//            $this->json['data'] = array(
//                'totalrowcount' => count($addressData),
//                'pagenumber'    => 1,
//                'pagesize'      => count($addressData),
//                'custom_fields' => $data['custom_fields'],
//                'items'         => $addressData
//            );
        }

    }
}