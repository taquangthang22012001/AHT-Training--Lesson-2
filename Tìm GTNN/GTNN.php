<?php
// Cài đặt phương thức
function minIndex($array) {
    $min = $array[0];
    $index = 0;


for($i = 1;$i < count($array); $i++) {
    if ($array[$i] < $min) {
        $min = $array[$i];
        $index = $i;
    }
}
return $index;
 }

// Tạo chương trình
$array = [10,9,8,7,6,5,4,3,2,1];
$MinI = minIndex($array);

echo "Vị trí của phần tử có giá trị nhỏ nhất là:" . $MinI; 
echo "<br>";
echo"Giá trị nhỏ nhất là:" . $array[$MinI];
