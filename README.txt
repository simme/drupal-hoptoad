Hoptoad for Drupal
-----------------------------------------------------------------------------
Hoptoad for Drupal enables you to send you sites error messages and exceptions
to hoptoadapp.org


Installation:
-----------------------------------------------------------------------------
  1. Add the libraries module if you don't already have it.

  2. Download/clone this github repo into your sites/default|domain/libraries
     https://github.com/rich/php-hoptoad-notifier
     The folder needs to be named php-hoptoad-notifier and Hoptoad.php must be
     placed within the Services folder in php-hoptoad-notifier.

     Also you need to apply these two patches unless it's already been
     included in a new release:
      https://github.com/rich/php-hoptoad-notifier/issues#issue/3
      https://github.com/rich/php-hoptoad-notifier/issues#issue/2

  3. Add $conf['hoptoad_api_key'] = 'your_api_key_here'; to your settings.php
     Optionally add any more settings, options below.

  4. Install and enable this module


Settings:
-----------------------------------------------------------------------------
Hoptoad for Drupal currently lacks any UI and relies on you to put settings
into your settings.php file. The only one you need to set is hoptoad_api_key.

* hoptoad_api_key (required)
  Your projects Hoptoad API key.

* hoptoad_path (optional)
  The absolute path (from your drupal root) to the php-hoptoad-notifier
  directory. If this is set Hoptoad will be loaded in hook_boot() and will
  be able to cover more errors.

  If this is not set Library API will be used in hook_init() to find the
  class instead.

* hoptoad_environment (optional)
  The environment the error will be reported under on your Hoptoad account.
  Preferably should be set to 'stagin', 'development' or something.

  Defaults to 'production'.

* hoptoad_client (optional)
  The method used when talking to hoptoadapp.com. Can be 'curl', 'pear' or
  'zend'.

  Defaults to 'curl'.

* hoptoad_report_directly (optional)
  If this is set to TRUE all error reports will be sent to Hoptoad the moment
  an error is encountered. If left out (or set to FALSE) all error reports
  will be put into a queue and sent to Hoptoad on cron.

  This is to avoid slow loading for regular users when an error has to be sent
  to Hoptoad.

* hoptoad_cron_limit (optional)
  The number of reports to sent to Hoptoad on each cron. Hoptoad client has a
  timeout of two seonds. So maximum execution time will be limit times two.

  Defaults to 30.

So in your settings.php file you need to enter:
  $conf['hoptoad_api_key'] = 'your_api_key_here';