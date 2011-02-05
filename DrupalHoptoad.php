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
    // Report error directly instead of putting it in a queue, useful for
    // staging and development environments or when cron is not available.
    if (variable_get('hoptoad_report_directly', FALSE)) {
      parent::errorHandler($code, $message, $file, $line);
    }
    else {
      // Remove $context, it sometimes contains resources
      // json_encode can't handle resources
      $args   = func_get_args();
      array_pop($args);
      $args[] = debug_backtrace();

      // Add the error report to the queue
      // So, for now I'm supressing errors from json_encode. It seems to be
      // a bug in PHP which makes json_encode throw warnings about recursion
      // when serializing an object with hidden properties or classes
      // implementing the Iterator interface.
      //
      // So, either we iterate through all in $args and convert 'em to arrays.
      // Or we suppress json_encode's error warning. I actually don't know
      // what is slower.
      db_query(
        "INSERT INTO {hoptoad_queue} VALUES(NULL, '%s')",
        @json_encode($args)
      );
    }

    // Call Drupals built in error handler to allow dblogging 'n stuff
    drupal_error_handler($code, $message, $file, $line, $context);
  }
}