<?php
/**
 * @file
 * @author Ashraf Hussain Mazumder
 * Contains \Drupal\siteapi\Controller\SiteApiController.
 * Please place this file under your siteapi(module_root_folder)/src/Controller/
 */
namespace Drupal\siteapi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Provides route responses for the SiteAPI module.
 */
class SiteApiController extends ControllerBase {
  /**
   * Returns a page in json format.
   *
   * @return array
   *   A json array.
   */
  public function siteApi($sitekey, $nid) {
    $json_array = array(
      'data' => array()
    );
	$config = \Drupal::config('system.site');
    $site_api_key = $config->get('siteapikey');
	$values = \Drupal::entityQuery('node')->condition('nid', $nid)->execute();
    $node_exists = !empty($values);
	if ($node_exists){
   	  $node = Node::load($nid);
	  $node_type = $node->get('type')->target_id;
	}
	if ($sitekey === $site_api_key && $node_type === "page"){
      $json_array['data'][] = array(
	    'type' => $node_type,
        'id' => $node->get('nid')->value,
        'attributes' => array(
          'title' =>  $node->get('title')->value,
          'content' => $node->get('body')->value,
        ),
      );
	  
	  return new JsonResponse($json_array);
	} else {
        $element = array(
          '#markup' => $this->t('<h1>Access Denied</h1>'),
        );
        return $element;
    }	  
  }
}
?>