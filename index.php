<!-- "Варіант 5. БД для зберігання інформації про товари в інтернет-магазині " -->
<DOCTYPE! html>
    <html>

    <head>
        <title>Keyboard Store</title>
    </head>

    <script>
        var ajax = new XMLHttpRequest();
        //TEXT
        function getVendorItems() {
            var vendorName = document.getElementById("vendorName").value;
            ajax.open("GET", "vendor_items.php?vendorName=" + vendorName, true);
            ajax.send();
            ajax.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("result1").innerHTML = this.responseText;
                }
            }
        }
        //XML
        function getCategoryItems() {
            var category = document.getElementById("category").value;
            ajax.open("GET", "category_items.php?category=" + category, true);
            ajax.send();
            ajax.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var xmlDoc = this.responseXML;
                    var table = "<table border='1'>";
                    table += "<tr><th>Назва</th><th>Ціна</th><th>Кількість</th><th>Категорія</th></tr>";
                    var items = xmlDoc.getElementsByTagName("item");
                    for (var i = 0; i < items.length; i++) {
                        table += "<tr>";
                        table += "<td>" + items[i].getElementsByTagName("name")[0].childNodes[0].nodeValue + "</td>";
                        table += "<td>" + items[i].getElementsByTagName("price")[0].childNodes[0].nodeValue + "</td>";
                        table += "<td>" + items[i].getElementsByTagName("quantity")[0].childNodes[0].nodeValue + "</td>";
                        table += "<td>" + items[i].getElementsByTagName("category")[0].childNodes[0].nodeValue + "</td>";
                        table += "</tr>";
                    }
                    table += "</table>";
                    document.getElementById("result2").innerHTML = table;
                }
            }
        }
        //JSON
        function getPriceRangeItems(type) {
            var minPrice = document.getElementById("minPrice").value;
            var maxPrice = document.getElementById("maxPrice").value;
            ajax.open("GET", "price_range_items.php?minPrice=" + minPrice + "&maxPrice=" + maxPrice, true);
            ajax.send();
            ajax.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var result = this.response;
                    var items = JSON.parse(result);
                    var table = "<table border='1'>";
                    table += "<tr><th>Назва</th><th>Ціна</th><th>Кількість</th><th>Категорія</th></tr>";
                    for (var i = 0; i < items.length; i++) {
                        table += "<tr>";
                        table += "<td>" + items[i].name + "</td>";
                        table += "<td>" + items[i].price + "</td>";
                        table += "<td>" + items[i].quantity + "</td>";
                        table += "<td>" + items[i].c_name + "</td>";
                        table += "</tr>";
                    }
                    document.getElementById("result3").innerHTML = table;
                }
            }
        }

    </script>

    <body>

        <hr>
        <h2>Клавіатури обраного виробника</h2>
        <select name="vendorName" id="vendorName">
            <?php
            include("connect.php");
            try {
                $sqlSelect = "SELECT * FROM vendors";
                $stmt = $dbh->prepare($sqlSelect);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    echo "<option value='" . $row['v_name'] . "'>" . $row['v_name'] . "</option>";
                }
                echo "";
            } catch (PDOException $ex) {
                echo $ex->GetMessage();
            }
            ?>
        </select>
        <button onclick="getVendorItems()">Отримати</button>

        <div id="result1"></div>

        <hr>
        <h2>Клавіатури в обраній категорі</h2>

        <select name="category" id="category">
            <?php
            include("connect.php");
            try {
                $sqlSelect = "SELECT * FROM category";
                $stmt = $dbh->prepare($sqlSelect);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    echo "<option value='" . $row['c_name'] . "'>" . $row['c_name'] . "</option>";
                }
            } catch (PDOException $ex) {
                echo $ex->GetMessage();
            }
            ?>
        </select>
        <button onclick="getCategoryItems()">Отримати XML</button>
        <div id="result2"></div>

        <hr>
        <h2>Клавіатури в обраному ціновому діапазоні</h2>

        <?php
        include("connect.php");
        try {
            echo "<input type='number' id='minPrice' name='minPrice' step='1' value='1000'>";
            echo "<input type='number' id='maxPrice' name='maxPrice' step='1' value='80000'>";

        } catch (PDOException $ex) {
            echo $ex->GetMessage();
        }
        ?>

        <button onclick="getPriceRangeItems()">Отримати JSON</button>
        <div id="result3"></div>
        <hr>
    </body>

    </html>