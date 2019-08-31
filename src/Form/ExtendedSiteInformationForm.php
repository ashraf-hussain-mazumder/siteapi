<?php

namespace Drupal\siteapi\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;

class ExtendedSiteInformationForm extends SiteInformationForm {
 
  /**
  * Add the Site API Key text field in Site Information form.
  */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $site_config = $this->config('system.site');
    $form =  parent::buildForm($form, $form_state);
    $form['site_information']['siteapikey'] = [
      '#type' => 'textfield',
      '#title' => t('Site API Key'),
      '#default_value' => $site_config->get('siteapikey') ?: 'No API Key yet',
      '#description' => t("Text field to set the Site API Key"),
    ];
	
	if (!empty($site_config->get('siteapikey'))) {
      $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => t('Update configuration'),
        '#button_type' => 'primary',
      ];      
	} 
		
    return $form;
  }
  
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
     if ($values['siteapikey'] == 'No API Key yet') {
      $form_state->setErrorByName('siteapikey', $this->t('Please enter Site API Key'));
    }
    parent::validateForm($form, $form_state);
  }
	
  /**
  * Saving the Site Api Key text field in Database.
  */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('system.site')
      ->set('siteapikey', $form_state->getValue('siteapikey'))
      ->save();
    drupal_set_message($this->t('The Site API Key has been saved with @siteapikey.', [
            '@siteapikey' => $form_state->getValue('siteapikey'),
        ]));
    parent::submitForm($form, $form_state);
  }
}