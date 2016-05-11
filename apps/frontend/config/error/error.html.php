<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php $path = preg_replace('#/[^/]+\.php5?$#', '', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : (isset($_SERVER['ORIG_SCRIPT_NAME']) ? $_SERVER['ORIG_SCRIPT_NAME'] : '')) ?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo sfConfig::get('sf_charset', 'utf-8') ?>" />
        <meta name="title" content="Rondo" />
        <meta name="robots" content="index, follow" />
        <meta name="language" content="pl" />

        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/css/normalize.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/js/bootstrap-3.3.6-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/js/bootstrap-3.3.6-dist/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $path ?>/css/frontend/default.css" />
        
        <script type="text/javascript" src="<?php echo $path ?>/js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $path ?>/js/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>

        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="icon" href="favicon.ico" />
    </head>
    <body class="error">
      <div class="wrap">
        <div class="vspace_15px"></div>
        <?php echo image_tag("frontend/main/main_logo.png", array("class" => "img-responsive", "style" => "margin: auto; width: 300px;")) ?>
        <div class="vspace_15px"></div>
        <div class="title">Błąd <?php echo $code ?> <?php echo $text ?></div>
        <div class="vspace_15px"></div>
        <div class="text_small">Prosimy o kontakt mailowy <a href="mailto:kontakt@tworzymystrony.com?subject=Problem ze stroną <?php echo $_SERVER['HTTP_HOST'] ?>">kontakt@tworzymystrony.com</a> z opisem w jakiej sytuacji przytrafił się błąd.</div>
        <div class="text_small">Postaramy się naprawić usterkę najszybciej jak to jest możliwe.</div>
        <div class="text_small">Przepraszamy za problemy.</div>
        <div class="vspace_15px"></div>
        <div class="redirect_small">powrót na: <a href="javascript:history.go(-1)">poprzednią stronę</a> | <a href="/">stronę główną</a></div>
      </div>
    </body>
</html>
