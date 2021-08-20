<?php

$folder="mydir";
$txt="images.txt";
function getContentImg($content){
    $preg =  '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';
    preg_match_all($preg, $content, $match);
    $count = count($match[1]);
    $filepaths = '';
    if ($count > 0) {
        for ($i = 0; $i < $count; $i++) {
            if ($i != $count - 1) {
                $filepaths .= $match[1][$i] . ',';
            } else {
                $filepaths .= $match[1][$i];
            }
        }
    }
    return str_replace('"','',str_replace('>','',strip_tags($filepaths)));
}
$dir=scandir($folder);
foreach($dir as $v){
   if($v!="."&&$v!=".."){
      $arr=json_decode(file_get_contents($folder."/".$v), true);
      foreach ($arr['products'] as $key => $value) {
         $arr2=explode(',',getContentImg($value['body_html']));
         foreach ($arr2 as $c => $b) {
            if($b!=''){
              if(substr($b , 0 , 2)=="//"){
                $b="https:".$b;
              }
              echo $b.PHP_EOL;
              file_put_contents($txt,$b.PHP_EOL,FILE_APPEND);
            }
         }
         foreach ($value['images'] as $m => $n) {
           echo $n['src'].PHP_EOL;
           file_put_contents($txt,$n['src'].PHP_EOL,FILE_APPEND);
         }
      }
   }
}

 ?>
