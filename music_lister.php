<?php
  /**
   * Created by PhpStorm.
   * User: msmith
   * Date: 2/8/14
   * Time: 10:48 PM
   */

  function startsWith($haystack, $needle)
  {
    return $needle === "" || strpos($haystack, $needle) === 0;
  }
  function endsWith($haystack, $needle)
  {
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
  }

  function generateAudioTag($file) {
    return '<audio controls="controls">'.
        '<source src="'.$file.'" type="audio/mpeg">'.
        'Audio is not supported by your browser?'.
      '</audio>';
  }

  function getEndOfPath($file) {
    $path = explode('/',$file);
    return $path[sizeof($path)-1];
  }

  function generateLink($file) {
    return '<a href="' . $file . '">'.getEndOfPath($file).'</a>';
  }

  function list_contents($file) {
    if ($handle = opendir($file)) {
      $files = scandir($file,SCANDIR_SORT_ASCENDING);
      foreach($files as $new_file) {
        if ($new_file !== '.' && $new_file !== '..') {
          $new_file = $file . DIRECTORY_SEPARATOR . $new_file;
          if (is_dir($new_file)) {
            echo "<li>",getEndOfPath($new_file),"</li>";
            echo '<ul>';
            list_contents($new_file);
            echo '</ul>';
          } elseif (is_file($new_file)) {
//            if (endsWith($new_file, '.mp3')) {
//              $new_file = generateAudioTag($new_file);
//            } else {
              $new_file = generateLink($new_file);
//            }
            echo '<li>',$new_file,'</li>';
          } else {
            echo "<li>? $new_file</li>";
          }
        }
      }

      closedir($handle);
    }
  }

  $dir = 'Music';
  echo "<ul>";
  list_contents($dir);
  echo "</ul>";