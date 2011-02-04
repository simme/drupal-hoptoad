<?php
/**
 * Custom Drupal adapted subclass of Hoptoad
 *
 * Basically the only thing we do is override the errorHandler method
 * to allow calling of Drupals built in error handler as well.
 */
include(libraries_get_path('php-hoptoad-notifier'));

class DrupalHoptoad extends Services_Hoptoad
{
  /**
   * First notify, then call Drupals error handler.
   *
   * @param string $code 
   * @param string $message 
   * @param string $file 
   * @param string $line 
   * @return void
   */
  public function errorHandler($code, $message, $file, $line, $context) {
    parent::errorHandler($code, $message, $file, $line);
    drupal_error_handler($code, $message, $file, $line, $context);
  }
}