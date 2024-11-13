<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lí sản phẩm</title>
</head>
<body>
    <h1>Quản lí sản phẩm</h1>

    
    <form method="POST">
        <label>Tên sản phẩm: </label>
        <input type="text" name="name" required> <br>
        <label>Giá sản phẩm:</label>
        <input type="number" name="price" required> <br>
        <label>Số lượng:</label>
        <input type="number" name="quantity" required> <br>
        <button type="submit" name="add">Thêm sản phẩm</button>
    </form>

    
    <form method="post">
        <label >Tìm kiếm sản phẩm: </label>
        <input type="text" name="keyword">
        <button type="submit" name="search">Tìm kiếm</button>
    </form>

    
    <form method="post">
        <button type="submit" name="sort">Sắp xếp theo tên</button>
    </form>
</body>
</html>

<?php
    $products = []; 

    session_start();
    if(isset($_SESSION ['products'])) {
        $products = $_SESSION['products'];
    }

    function addProduct(&$products, $name, $price, $quantity) {
        $product = [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity
        ];
        $products[] = $product;
    }

    
    function displayProducts($products) {
        if (empty($products)) {
            echo "Không có sản phẩm nào trong danh sách.";
        } else {
            echo "<table border='1'><tr><th>Tên</th><th>Giá</th><th>Số lượng</th></tr>";
            foreach ($products as $product) {
                printf(
                    "<tr><td>%s</td><td>%d</td><td>%d</td></tr>",
                    htmlspecialchars($product['name']),
                    $product['price'],
                    $product['quantity']
                );
            }
            echo "</table>";
        }
    }

    
    function searchProduct($products, $keyword) {
        $result = [];
        foreach ($products as $product) {
            if (strpos(strtolower($product['name']), strtolower($keyword)) !== false) {
                $result[] = $product;
            }
        }
        return $result;
    }

    
    function sortProductsByName(&$products) {
        usort($products, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
    }

    
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        if (!empty($name) && is_numeric($price) && is_numeric($quantity)) {
            addProduct($products, $name, (int)$price, (int)$quantity);
            $_SESSION['products'] = $products; 
            echo "<p>Sản phẩm đã được thêm!</p>";
        } else {
            echo "<p>Thông tin sản phẩm không đúng!</p>";
        }
    }

    
    if (isset($_POST['search'])) {
        $keyword = $_POST['keyword'];
        $searchResults = searchProduct($products, $keyword);
        echo "<h2>Kết quả tìm kiếm:</h2>";
        displayProducts($searchResults);
    }

    
    if (isset($_POST['sort'])) {
        sortProductsByName($products);
        $_SESSION['products'] = $products; 
        echo "<p>Danh sách sản phẩm đã được sắp xếp theo tên!</p>";
    }


    echo "<h2>Danh sách Sản phẩm:</h2>";
    displayProducts($products);
    ?>