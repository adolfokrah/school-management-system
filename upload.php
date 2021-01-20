<?php

if (! empty($_FILES)) {
    // Validating SQL file type by extensions
    if (! in_array(strtolower(pathinfo($_FILES["backup_file"]["name"], PATHINFO_EXTENSION)), array(
        "sql"
    ))) {
        $response = array(
            "type" => "error",
            "message" => "Invalid File Type"
        );
    } else {
            if(move_uploaded_file($_FILES["backup_file"]["tmp_name"], $_FILES["backup_file"]["name"])){
                //$response = restoreMysqlDB($_FILES["backup_file"]["name"], $conn);
                $response = array(
                    "type" => "success",
                    "message" => "Database Restore Completed Successfully."
                );
            }
            
    }
}
?>
<html>
<head>
<title>Select file to upload to online server</title>
<style>
body {
	max-width: 550px;
	font-family: "Segoe UI", Optima, Helvetica, Arial, sans-serif;
}

#frm-restore {
	background: #aee5ef;
	padding: 20px;
	border-radius: 2px;
	border: #a3d7e0 1px solid;
}

.form-row {
	margin-bottom: 20px;
}

.input-file {
	background: #FFF;
	padding: 10px;
	margin-top: 5px;
	border-radius: 2px;
}

.btn-action {
	background: #333;
	border: 0;
	padding: 10px 40px;
	color: #FFF;
	border-radius: 2px;
}

.response {
	padding: 10px;
	margin-bottom: 20px;
    border-radius: 2px;
}

.error {
    background: #fbd3d3;
    border: #efc7c7 1px solid;
}

.success {
    background: #cdf3e6;
    border: #bee2d6 1px solid;
}
</style>
</head>
<body>
    <h2>Select database to upload</h2>
<?php
if (! empty($response)) {
    ?>
<div class="response <?php echo $response["type"]; ?>">
<?php echo nl2br($response["message"]); ?>
</div>
<?php
}
?>
    <form method="post" action="" enctype="multipart/form-data"
        id="frm-restore">
        <div class="form-row">
            <div>Choose Backup File</div>
            <div>
                <input type="file" name="backup_file" class="input-file" />
            </div>
        </div>
        <div>
            <input type="submit" name="restore" value="Upload"
                class="btn-action" />
        </div>
    </form>
</body>
</html>