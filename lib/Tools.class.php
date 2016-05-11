<?php

// lib/Tools.class.php
class Tools {

  static public function slugify($text) {
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

    // trim
    $text = trim($text, '-');

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // lowercase
    $text = strtolower($text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    if (strlen($text) > 255) { //ucinam do 250 znakow
      $text = substr($text, 0, 255);
    }

    if (empty($text)) {
      return 'brak-opisu';
    }

    return $text;
  }

  /*
  static public function slugify($text) {
      // replace all non letters or digits by -
      $text = preg_replace('/[^A-Za-z0-9-]+/', '-', self::_no_pl($text));//preg_replace('/\W+/', '-', $text);

      // trim and lowercase
      $text = strtolower(trim($text, '-'));

      if (empty($text)) {
          return 'brak-opisu';
      }

      if (strlen($text) > 120) { //ucinam do 60 znakow
          $text = substr($text, 0, 120);
      }

      return $text;
  }*/

  static public function clear_pl_chars($text) {
    return self::_no_pl($text);
  }

  static protected function _no_pl($text) {
    $convert_table = Array(
      //WIN
      "\xb9" => "a", "\xa5" => "A", "\xe6" => "c", "\xc6" => "C",
      "\xea" => "e", "\xca" => "E", "\xb3" => "l", "\xa3" => "L",
      "\xf3" => "o", "\xd3" => "O", "\x9c" => "s", "\x8c" => "S",
      "\x9f" => "z", "\xaf" => "Z", "\xbf" => "z", "\xac" => "Z",
      "\xf1" => "n", "\xd1" => "N",
      //UTF
      "\xc4\x85" => "a", "\xc4\x84" => "A", "\xc4\x87" => "c", "\xc4\x86" => "C",
      "\xc4\x99" => "e", "\xc4\x98" => "E", "\xc5\x82" => "l", "\xc5\x81" => "L",
      "\xc3\xb3" => "o", "\xc3\x93" => "O", "\xc5\x9b" => "s", "\xc5\x9a" => "S",
      "\xc5\xbc" => "z", "\xc5\xbb" => "Z", "\xc5\xba" => "z", "\xc5\xb9" => "Z",
      "\xc5\x84" => "n", "\xc5\x83" => "N",
      //ISO
      "\xb1" => "a", "\xa1" => "A", "\xe6" => "c", "\xc6" => "C",
      "\xea" => "e", "\xca" => "E", "\xb3" => "l", "\xa3" => "L",
      "\xf3" => "o", "\xd3" => "O", "\xb6" => "s", "\xa6" => "S",
      "\xbc" => "z", "\xac" => "Z", "\xbf" => "z", "\xaf" => "Z",
      "\xf1" => "n", "\xd1" => "N");

    return strtr($text, $convert_table);
  }

  static public function clearSpacesBetweenTags($string) {
    return preg_replace('/\s{2,}/', '', $string); //usuwam spacje tak aby string byl w jednej linii
  }

  /*@PARAMS : $permissions = 'drwxr-xr-x';
   */
  static public function getChmodValue($permissions) {
    $mode = 0;

    if ($permissions[1] == 'r') $mode += 0400;
    if ($permissions[2] == 'w') $mode += 0200;
    if ($permissions[3] == 'x') $mode += 0100;
    else if ($permissions[3] == 's') $mode += 04100;
    else if ($permissions[3] == 'S') $mode += 04000;

    if ($permissions[4] == 'r') $mode += 040;
    if ($permissions[5] == 'w') $mode += 020;
    if ($permissions[6] == 'x') $mode += 010;
    else if ($permissions[6] == 's') $mode += 02010;
    else if ($permissions[6] == 'S') $mode += 02000;

    if ($permissions[7] == 'r') $mode += 04;
    if ($permissions[8] == 'w') $mode += 02;
    if ($permissions[9] == 'x') $mode += 01;
    else if ($permissions[9] == 't') $mode += 01001;
    else if ($permissions[9] == 'T') $mode += 01000;

    return $mode;
  }

  static public function gallery_path($gallery = '') {
    $uploadDir = sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_path_gallery");
    $webDir = sfConfig::get("sf_web_dir");
    $upload_gallery_path = substr($uploadDir, strlen($webDir), strlen($uploadDir) - strlen($webDir));
    $upload_gallery_path = str_replace('\\', '/', $upload_gallery_path);
    return $upload_gallery_path;
  }

  static public function rmdir($dir) {
    if (is_dir($dir)) {
      $objects = scandir($dir);
      foreach ($objects as $object) {
        if ($object != "." && $object != "..") {
          if (filetype($dir . "/" . $object) == "dir") {
            self::rmdir($dir . "/" . $object);
          } else {
            unlink($dir . "/" . $object);
          }
        }
      }
      reset($objects);
      rmdir($dir);
    }
  }

  /**
   * Przenosi wskazany widget ($wgtNameToMove) w formularzu przed podany widget ($wgtNameToInsertBefore)
   * @param sfWidgetFormSchema $widget
   * @param type $wgtNameToMove
   * @param type $wgtNameToInsertBefore
   * @return type
   */
  static public function changeWidgetPosition(sfWidgetFormSchema $widget, $wgtNameToMove, $wgtNameToInsertBefore) {
    $arr_positions = $widget->getPositions();
    $key_of_element_after = array_search($wgtNameToInsertBefore, $arr_positions);
    array_splice($arr_positions, $key_of_element_after, 0, $wgtNameToMove);
    $key_of_old_position = array_keys($arr_positions, $wgtNameToMove);//$key_of_old_position = array_search($wgtNameToMove, $arr_positions);
    //wyszukuje klucz indeksu ktorego nie chcemy usuwac (dopiero co wstawionego)
    unset($key_of_old_position[(array_search($key_of_element_after, $key_of_old_position))]);
    $key_of_old_position = array_pop($key_of_old_position);
    //usuwam przeniesiony wczesniej klucz
    unset($arr_positions[$key_of_old_position]);
    $arr_positions = array_merge($arr_positions);
    $widget->setPositions($arr_positions);
    return $arr_positions;
  }

  static public function rmfile_with_prefix($file, $dir) {
    if ($file !== '') {
      $dir_handle = opendir($dir);

      while (false !== ($entry = readdir($dir_handle))) {
        if (strpos($entry, $file) !== false) {
          try {
            @unlink($dir . $entry);
          } catch (Exception $e) {
          }
        }
      }
      closedir($dir_handle);
    }
  }

  /**
   * @desc Dzieli ciag znakow po spacji - pierwszy wyraz jest bez dodatkowego formatowania,
   * @desc pozostala czesc zostaje pogrubiona <b>
   *
   * @param string $string
   * @return string
   */
  static public function firstWordNormalRestBold($string) {
    //zmiana teraz wszystko ma byc bez boldu w drugim członie
    return $string;
    /*
    $arr_string = explode(" ", $string);
    $string = array_shift($arr_string)." <b>".implode(" ", $arr_string)."</b>";
    return $string;
    */
  }

  /**
   * Metoda statyczna generujaca skrot tekstu, wycinajac tagi
   *
   * @param string $text Okresla tekst z ktorego ma byc wygenerowany skrot
   * @param int $lenght Okresla ilosc znakow jaka ma byc pobrana z analizowanego tekstu
   * @return String
   */
  static public function cutText($text, $lenght = 40) {
    $text = str_replace(PHP_EOL, ' ', $text); //usuwam konce linii
    $text = strip_tags($text);
    $text = trim($text);
    $text = str_replace(array("&nbsp;", "&nbsp"), array(' ', ' '), $text);
    $text = preg_replace('/[ ]+/', ' ', $text); //preg_replace('/\W+/', '-', $text);
    //koniec czyszczenia tekstu

    if (mb_strlen($text, 'UTF-8') <= $lenght) { //jezeli dlugosc wejsciowa jest mniejsza/rowna wartosci zadanej zwracamy bez meczenia procesora
      return $text;
    }

    //tekst jest dluzszy niz wartosc zadana przygotowywujemy miejsce na trzy kropki
    $lenght = intval($lenght) - 3; //aby sie zmieściły kropki trzy

    $text_array = explode(" ", $text);
    if (count($text_array) == 1) { //jesli tekst jest jednym ciagiem znakow to ucinamy bez patrzenia gdzie
      return substr($text_array[0], 0, $lenght) . "...";
    } else { //tekst jest podzielony spacjami
      $state_prev = '';
      $state_curr = '';
      foreach ($text_array as $key => $part) {
        if ($key == 0) {
          $state_curr .= $part;
        } else {
          $state_curr .= " " . $part;
        }

        if (mb_strlen($state_curr, 'UTF-8') <= $lenght) {
          $state_prev = $state_curr;
        } else {
          break;
        }

      }
      $state_prev = preg_replace('/[.,]$/', '', $state_prev); //preg_replace('/\W+/', '-', $text);
      $state_prev .= '...';
      return $state_prev;
    }
  }

  static public function cutHttpPrefix($value) {
    $httpPrefix = array("https://", "http://");
    return str_replace($httpPrefix, "", $value);
  }

  static public function cutFacebookUrlPrefix($value) {
    $facebokUrlPrefix = array("www.facebook.com", "facebook.com");
    return str_replace($facebokUrlPrefix, "", $value);
  }

  /**
   * @param string $value
   * @return string
   */
  static public function addLeadingSlash($value) {
    return "/".ltrim($value, '/');
  }

  /**
   *
   * @param string $value
   * @return string
   */
  static public function addTrailingSlash($value) {
    return rtrim($value, '/')."/";
  }

  static public function startsWithTrailingSlash($value) {
    return (stripos($value, '/') === 0) ? true : false;
  }

  static public function getFileExt($value) {
    $arrValue = explode(".", $value);
    return array_pop($arrValue);
  }
  
  static public function prepareRedirectURL($url) {
    if(strpos($url, 'http://') === null || strpos($url, 'https://') === null) {
        $routing_options = sfContext::getInstance()->getRouting()->getOptions();
        $prefix = $routing_options['context']['prefix'];
        if (strpos($url, $prefix) === false) {
            $url = ltrim($url, '/');
            $url = $prefix . '/' . $url;
        }
    }
    return $url;
  }
}

?>