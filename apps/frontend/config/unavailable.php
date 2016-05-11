<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php $path = preg_replace('#/[^/]+\.php5?$#', '', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : (isset($_SERVER['ORIG_SCRIPT_NAME']) ? $_SERVER['ORIG_SCRIPT_NAME'] : '')) ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo sfConfig::get('sf_charset', 'utf-8') ?>" />

        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />

        <meta name="title" content="Rondo" />
        <meta name="robots" content="noindex, nofollow" />
        <meta name="language" content="pl" />

        <link rel="shortcut icon" href="/favicon.ico" />
    </head>
    <body class="error">
      <div class="wrap">
        <div class="vspace_15px"></div>
        <div class="vspace_25px"></div>
        <div class="title acenter">Strona tymczasowo niedostępna</div>
        <div class="text acenter">Prosimy o odwiedziny za kilka minut</div>
      </div>
    </body>
</html>