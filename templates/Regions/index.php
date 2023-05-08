<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<h1>Regions</h1>

<select id="select-region">
    <?php foreach ($regions as $region): ?>
        <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
    <?php endforeach; ?>
</select>

<div id="users"></div>





<script>
    $(document).ready(function() {
        $("#select-region").change(function() {
            var regionId = $(this).val();
            $.ajax({
                url: "http://localhost/projects/app_data/regions/getUsersByRegion",
                data: {region_id: regionId},
                dataType:"Json",
                success: function(data) {
                    var table = "<table> <tr> <th>Name</th><th>Age</th></tr>";
                    for(var i = 0; i<data.length;i++){
                        table += "<tr><td>" + data[i].name + "</td><td>" + data[i].age + "</td></tr>";
                    }
                    table += "</table>";
                    $("#users").html(table);
                }
            });
        });
    });
</script>
