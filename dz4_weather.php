<?php
header('Content-Type: text/html;charset=UTF-8');

$city = "Irkutsk"; 
$api="142ac7bb252dc72944369f873e76ca7d";
$mode = "json"; 
$units = "metric"; 
$lang = "ru"; 
$countDay = 2; 

if($_GET["mode"] == "test") {
  $data = file_get_contents("$city.$mode");
} else
{
  $url = "http://api.openweathermap.org/data/2.5/forecast/daily?q=$city&mode=$mode&units=$units&cnt=$countDay&lang=$lang&appid=$api";
  $data = file_get_contents($url);
  file_put_contents("$city.$mode", $data);
  if (!$data) {
    echo "Не могу получить данные с сервера";
    $data = file_get_contents("$city.$mode");
    if (!$data) {
      echo "Не могу прочитать данные из файла";
    }
  }
} 

$weather = json_decode($data, true);
$weather = $weather["list"];
print_r("Получен массив с данными:<pre>");
print_r($weather);
echo("</pre>");

foreach ($weather as $key => $val) {
  print_r("<b>Дата: ".date("d D M Y",$val["dt"])."</b></br>");
  foreach($val as $sub_key => $sub_val) {
    switch ($sub_key) {
      case 'temp':
        print_r("Температура: ");
        foreach ($sub_val as $type_temp => $temp) {
          switch ($type_temp) {
            case 'day':
              print_r("дневная: ".$temp."; ");
              break;
            case 'min':
              print_r("минимальная: ".$temp."; ");
              break;                   
            case 'max':
              print_r("максимальная: ".$temp."; ");
              break;        
            case 'night':
              print_r("ночная: ".$temp."; ");
              break;                   
            case 'eve':
              print_r("вечерняя: ".$temp."; ");
              break;                   
            case 'morn':
              print_r("утренняя: ".$temp."; ");
              break;                   
           }
        }
        print_r("</br>");
        break;
      case 'pressure':
        print_r("Давление: ".$sub_val."</br>");
        break;
      case 'humidity':
        print_r("Влажность: ".$sub_val."</br>");
        break;
      case 'speed':
        print_r("Скорость ветра: ".$sub_val."</br>");
        break;
    }
  }
}
?>

