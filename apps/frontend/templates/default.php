<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $sf_user->getCulture() ?>" lang="<?php echo $sf_user->getCulture() ?>">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />

        <?php echo include_http_metas() ?>
        <?php include_metas() ?>

        <meta name="language" content="<?php echo $sf_user->getCulture() ?>" />

        <?php include_title() ?>

        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
    </head>
    <body>
        <div>
          <?php echo $sf_content ?>
        </div>

        <?php include_slot("body_end") ?>
    </body>
</html>