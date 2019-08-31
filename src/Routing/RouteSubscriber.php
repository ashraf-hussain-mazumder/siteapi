<?php 
namespace Drupal\siteapi\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * Use the RouteSubscriber class to implement the new field in ExtendedSiteInformationForm.
   */
  protected function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('system.site_information_settings')) 
      $route->setDefault('_form', '\Drupal\siteapi\Form\ExtendedSiteInformationForm');
  }

}