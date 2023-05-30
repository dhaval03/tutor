<?php

/**
 * tutor.php
 *
 * tutor management
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

class Course extends \RestController
{

    private $error = array();

    public function course()
    {
		$this->checkPlugin();
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			if (isset($this->request->get['id']) && ctype_digit($this->request->get['id'])) {
			    $this->getCourse($this->request->get['id']);
			} else {
				$this->listcourse();
			}
        }else {
            $this->statusCode = 405;
            $this->allowedHeaders = array("GET");
        }

        return $this->sendResponse();
    }
	
	
	public function getCourse($product_id)
	{
		$json = array('success' => true);

		$this->load->model('extension/tmdmultivendor/vendor/product');
			
        $course = $this->model_extension_tmdmultivendor_vendor_product->getProduct($product_id,$this->vendor->getId());
        if(!empty($course)) {
            $this->json["data"] = $course;
        } else {
            $this->json['success'] = false;
        }

        $this->sendResponse($json);
	}
	
    public function listcourse()
    {
		 $this->load->model('extension/tmdmultivendor/vendor/product');

        $course = $this->model_extension_tmdmultivendor_vendor_product->getProducts();
        $data['course'] = array_values($course);

        if (!empty($data['course'])) {

            $this->json["data"] = $data;
        }

        if($this->includeMeta) {

            $data = $this->json['data'];

            if(isset($this->json['data']['course'])) {
                $intercomsData = $this->json['data']['course'];
            } else {
                $intercomsData = array();
            }
            $this->response->addHeader('X-Total-Count: ' . count($intercomsData));
            $this->response->addHeader('X-Pagination-Limit: '.count($intercomsData));
            $this->response->addHeader('X-Pagination-Page: 1');        
        }
	}
}