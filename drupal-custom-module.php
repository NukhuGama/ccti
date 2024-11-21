<?php
// custom_hello/custom_hello.info.yml
name: Custom Hello
description: A simple custom Drupal module
package: Custom
type: module
core_version_requirement: ^8 || ^9

// custom_hello/custom_hello.routing.yml
custom_hello.content:
  path: '/custom-hello'
  defaults:
    _controller: '\Drupal\custom_hello\Controller\CustomHelloController::content'
    _title: 'Custom Hello Page'
  requirements:
    _permission: 'access content'

// custom_hello/src/Controller/CustomHelloController.php
<?php
namespace Drupal\custom_hello\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

class CustomHelloController extends ControllerBase {
  public function content() {
    // Get the current user
    $current_user = \Drupal::currentUser();
    
    // Render a simple page
    return [
      '#markup' => $this->t('Hello, @name! Welcome to our custom Drupal module.', [
        '@name' => $current_user->getDisplayName()
      ])
    ];
  }
}

// custom_hello/custom_hello.module
<?php
/**
 * Implements hook_theme()
 */
function custom_hello_theme($existing, $type, $theme, $path) {
  return [
    'custom_hello_template' => [
      'variables' => [
        'title' => NULL,
        'content' => NULL,
      ],
      'template' => 'custom-hello-template',
    ],
  ];
}
