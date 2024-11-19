<?php
function findMaxElement($matrix) {
    if (empty($matrix) || empty($matrix[0])) {
        return [
            'value' => null,
            'row' => null,
            'col' => null,
        ];
    }

    $maxValue = $matrix[0][0];
    $maxRow = 0;
    $maxCol = 0;

    foreach ($matrix as $rowIndex => $row) {
        foreach ($row as $colIndex => $value) {
            if ($value > $maxValue) {
                $maxValue = $value;
                $maxRow = $rowIndex;
                $maxCol = $colIndex;
            }
        }
    }

    return [
        'value' => $maxValue,
        'row' => $maxRow,
        'col' => $maxCol,
    ];
}

echo "Nhập kích thước ma trận (số hàng và số cột):\n";
$rows = intval(readline("Số hàng: "));
$cols = intval(readline("Số cột: "));


$userMatrix = [];
for ($i = 0; $i < $rows; $i++) {
    $userMatrix[$i] = [];
    for ($j = 0; $j < $cols; $j++) {
        $userMatrix[$i][$j] = floatval(readline("Nhập phần tử tại hàng $i, cột $j: "));
    }
}

echo "\nMa trận do người dùng nhập:\n";
foreach ($userMatrix as $row) {
    echo implode("\t", $row) . "\n";
}

$result = findMaxElement($userMatrix);
if ($result['value'] === null) {
    echo "Ma trận không hợp lệ hoặc rỗng.\n";
} else {
    echo "Phần tử lớn nhất trong ma trận do người dùng nhập: " . $result['value'] . 
         " tại tọa độ (" . $result['row'] . ", " . $result['col'] . ")\n";
}
?>
