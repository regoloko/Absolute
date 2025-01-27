<?php
  define("PATH_ROOT", dirname(__DIR__));

  define("SERVER_ROOT",  $_SERVER['DOCUMENT_ROOT']);
  define("SERVER_SPRITES", $_SERVER['DOCUMENT_ROOT'] . "/images");

  // Localhost domains.
  if ( $_SERVER['HTTP_HOST'] === 'localhost' )
  {
    define("DOMAIN_ROOT", "http://localhost");
    define("DOMAIN_SPRITES", "http://localhost/images");
  }
  // Live server domains.
  else
  {
    if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' )
    {
      define("DOMAIN_ROOT", "https://absoluterpg.com");
      define("DOMAIN_SPRITES", "https://absoluterpg.com/images");
    }
    else
    {
      define("DOMAIN_ROOT", "http://absoluterpg.com");
      define("DOMAIN_SPRITES", "http://absoluterpg.com/images");
    }
  }

