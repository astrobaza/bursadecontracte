<?php
class Sabai_Addon_PaidListings_Controller_Admin_AddPlan extends Sabai_Addon_Form_MultiStepController
{    
    protected function _getSteps(Sabai_Context $context, array &$formStorage)
    {
        return array('select_plan_type', 'add_plan');
    }
    
    protected function _getFormForStepSelectPlanType(Sabai_Context $context, array &$formStorage)
    {
        $plan_types = $this->PaidListings_PlanTypes(false, true);
        return array(
            'plan_type' => array(
                '#title' => __('Plan type', 'sabai-paidlistings'),
                '#type' => 'radios',
                '#options' => $plan_types[0],
                '#options_description' => $plan_types[1],
                '#required' => true,
                '#default_value' => $context->getRequest()->asStr('type', 'base'),
                '#default_value_auto' => true,
            ),
        );
    }
    
    protected function _getFormForStepAddPlan(Sabai_Context $context, array &$formStorage)
    {
        $this->_submitButtons['submit'] = array(
            '#value' => __('Add Plan', 'sabai-paidlistings'),
            '#btn_type' => 'primary',
        );
        $form = array(
            'basic' => array(
                '#title' => __('Plan Settings', 'sabai-paidlistings'),
                '#tree' => false,
                '#weight' => 1,
                'name' => array(
                    '#type' => 'textfield',
                    '#title' => __('Plan name', 'sabai-paidlistings'),
                    '#required' => true,
                ),
                'description' => array(
                    '#type' => 'textarea',
                    '#title' => __('Description', 'sabai-paidlistings'),
                    '#rows' => 3,
                ),
                'active' => array(
                    '#type' => 'select',
                    '#title' => __('Status', 'sabai-paidlistings'),
                    '#options' => array(1 => __('Active', 'sabai-paidlistings'), 0 => __('Inactive', 'sabai-paidlistings')),
                    '#default_value' => 1,
                    '#required' => true,
                ),
                'weight' => array(
                    '#type' => 'number',
                    '#title' => __('Display order', 'sabai-paidlistings'),
                    '#integer' => true,
                    '#size' => 5,
                    '#default_value' => 0,
                    '#min_value' => 0,
                    '#max_value' => 999,
                ),
                'currency' => array(
                    '#title' => __('Currency', 'sabai-paidlistings'),
                    '#type' => 'select',
                    '#options' => $this->PaidListings_Currencies(null, true),
                    '#default_value' => 'USD', 
                ),
                'featured' => array(
                    '#type' => 'checkbox',
                    '#title' => __('Make this plan featured', 'sabai-paidlistings'),
                    '#default_value' => false,
                ),
            ),
            'features' => array('#tree' => true, '#weight' => 5),
        );
        $form['onetime'] = array(
            '#tree' => true,
            '#title' => __('One-time Payment', 'sabai-paidlistings'),
            '#weight' => 2,
            'enable' => array(
                '#title' => __('Enable', 'sabai-paidlistings'),
                '#type' => 'checkbox',
                '#default_value' => true,
            ),
            'price' => array(
                '#title' => __('Price', 'sabai-paidlistings'),
                '#required' => array(array($this, 'isPriceFieldRequired'), array(array('onetime'))),
                '#type' => 'number',
                '#numeric' => true,
                '#size' => 10,
                '#default_value' => '0.00',
                '#step' => 0.1,
                '#states' => array(
                    'visible' => array('input[name="onetime[enable][]"]' => array('type' => 'checked', 'value' => true)),
                ),
                '#min_value' => 0,
            ),
        );
        if ($formStorage['values']['select_plan_type']['plan_type'] === 'base') {
            $form['recurring'] = array(
                '#tree' => true,
                '#title' => __('Recurring Payment', 'sabai-paidlistings'),
                '#weight' => 3,
            );
            foreach ($this->PaidListings_RecurringPaymentLabels() as $recurring_name => $recurring_label) {
                $form['recurring'][$recurring_name] = array(
                    '#class' => 'sabai-form-group',
                    '#title' => $recurring_label,
                    '#collapsible' => false,
                    '#element_validate' => array(array($this, 'validateRecurringPayment')),
                    'enable' => array(
                        '#title' => __('Enable', 'sabai-paidlistings'),
                        '#type' => 'checkbox',
                    ),
                    'price' => array(
                        '#field_prefix' => __('Price:', 'sabai-paidlistings'),
                        '#required' => array(array($this, 'isPriceFieldRequired'), array(array('recurring', $recurring_name))),
                        '#type' => 'number',
                        '#numeric' => true,
                        '#size' => 10,
                        '#default_value' => '0.00',
                        '#step' => 0.1,
                        '#states' => array(
                            'visible' => array(sprintf('input[name="recurring[%s][enable][]"]', $recurring_name) => array('type' => 'checked', 'value' => true)),
                        ),
                        '#min_value' => 0,
                    ),
                    'trial_period' => array(
                        '#field_prefix' => __('Number of trial period days (0 = no trial period):', 'sabai-paidlistings'),
                        '#type' => 'number',
                        '#integer' => true,
                        '#default_value' => 0,
                        '#size' => 3,
                        '#states' => array(
                            'visible' => array(sprintf('input[name="recurring[%s][enable][]"]', $recurring_name) => array('type' => 'checked', 'value' => true)),
                        ),
                        '#min_value' => 0,
                    ),
                );
            }
        }
        $features = $this->PaidListings_FeaturesByBundle(array($context->bundle->type, ''), $formStorage['values']['select_plan_type']['plan_type']);
        $i = 0;
        foreach ((array)$features as $feature_name) {
            if (!$ifeature = $this->PaidListings_FeatureImpl($feature_name)) {
                continue;
            }
            $feature_info = $ifeature->paidListingsFeatureGetInfo();
            $form['features'][$feature_name] = $ifeature->paidListingsFeatureGetSettingsForm(
                $context->bundle->name,
                $feature_info['default_settings'],
                array('features', $feature_name)
            ) + array('#title' => @$feature_info['label']);
            foreach (array_keys($form['features'][$feature_name]) as $key) {
                if (false !== strpos($key, '#')) continue;
                    
                if (!isset($form['features'][$feature_name][$key]['#states']['visible'])) {
                    $form['features'][$feature_name][$key]['#states']['visible'] = array();
                }
                if ($key !== 'enable' && empty($feature_info['is_default'])) {
                    $form['features'][$feature_name][$key]['#states']['visible'][sprintf('input[name="features[%s][enable][]"]', $feature_name)] = array('type' => 'checked', 'value' => true);
                }
                if (isset($feature_info['onetime_only']) && in_array($key, $feature_info['onetime_only'])) {
                    $form['features'][$feature_name][$key]['#states']['visible']['input[name="onetime[enable][]"]'] = array('type' => 'checked', 'value' => true);
                    $form['features'][$feature_name][$key]['#element_validate'] = array(array($this, 'validateOnetimeOnly'));
                }
            }
            if (!empty($feature_info['is_default'])) {
                $form['features'][$feature_name]['#weight'] = 0;
                $form['features'][$feature_name]['enable'] = array(
                    '#type' => 'hidden',
                    '#value' => 1,
                );
            } else {
                $form['features'][$feature_name]['#weight'] = ++$i;
                $form['features'][$feature_name]['enable'] = (array)@$form['features'][$feature_name]['enable'] + array(
                    '#weight' => -1,
                    '#type' => 'checkbox',
                    '#default_value' => false,
                    '#title' => __('Enable this feature', 'sabai-paidlistings'),
                );
            }       
        }
        
        return $form;
    }
    
    public function validateOnetimeOnly($form, &$value, $element)
    {
        if (empty($form->values['onetime']['enable'])) {
            $value = null;
        }
    }
    
    public function isPriceFieldRequired(Sabai_Addon_Form_Form $form, array $parents, $field = 'enable')
    {
        $value = $form->getValue($parents);
        return !empty($value['enable']);
    }
    
    public function validateRecurringPayment(Sabai_Addon_Form_Form $form, &$value, $element)
    {
        if (empty($value['enable'])) return;
        
        if ($value['price'] < 0.01) {
            $form->setError(__('The recurring price must be equal or greater than 0.01.', 'sabai-paidlistings'), $element['#name'] . '[price]');
        }
    }
    
    protected function _submitFormForStepAddPlan(Sabai_Context $context, Sabai_Addon_Form_Form $form)
    {
        $recurring = array();
        $price = '0.00';
        $onetime = false;
        if (!empty($form->values['onetime']['enable'])) {
            $price = $form->values['onetime']['price'];
            $onetime = true;
        }
        if ($form->storage['values']['select_plan_type']['plan_type'] === 'base') {
            if (!empty($form->values['recurring'])) {
                foreach (array('w', 'm', '3m', '6m', 'y') as $recurring_name) {
                    if (empty($form->values['recurring'][$recurring_name]['enable'])) continue;
                
                    $recurring[$recurring_name] = array(
                        'price' => $form->values['recurring'][$recurring_name]['price'],
                        'initial_fee' => 0,
                        'trial_period' => (int)$form->values['recurring'][$recurring_name]['trial_period'],
                    );
                }
            }
        }
        
        if (!$onetime && empty($recurring)) {
            $form->setError(__('At least one payment type needs to be enabled.', 'sabai-paidlistings'));
            return;
        }
        
        $plan = $this->getModel(null, 'PaidListings')->create('Plan')->markNew();
        $plan->name = $form->values['name'];
        $plan->description = $form->values['description'];
        $plan->active = (bool)$form->values['active'];
        $plan->weight = (int)$form->values['weight'];
        $plan->currency = $form->values['currency'];
        $plan->featured = !empty($form->values['featured']);
        $plan->price = $price;
        $plan->type = $form->storage['values']['select_plan_type']['plan_type'];
        $plan->features = $form->values['features'];
        $plan->entity_bundle_name = $context->bundle->name;
        $plan->onetime = $onetime;
        $plan->recurring = $recurring;
        $plan->commit();
    }
  
    protected function _complete(Sabai_Context $context, array $formStorage)
    {
        $context->setSuccess($this->_getPlansUrl($context));
    }
    
    protected function _getPlansUrl(Sabai_Context $context, array $params = array())
    {
        return $this->Url(dirname($context->getRoute()), $params);
    }
}