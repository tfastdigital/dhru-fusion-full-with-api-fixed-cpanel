<?php
define("DEFINE_DHRU_FILE", true);
session_start();

if(isset($_POST['install'])) {
    $db_host = $_POST['db_host'];
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];
    $db_name = $_POST['db_name'];
    $site_url = $_POST['site_url'];

    // Test Connection
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        $error = "Connection failed: " . $conn->connect_error;
    } else {
        // Write Config File
        $config_content = "<?php\n";
        $config_content .= "\$db_host = \"$db_host\";\n";
        $config_content .= "\$db_username = \"$db_user\";\n";
        $config_content .= "\$db_password = \"$db_pass\";\n";
        $config_content .= "\$db_name = \"$db_name\";\n";
        $config_content .= "\$config['site_address'] = \"$site_url\";\n";
        $config_content .= "\$cc_encryption_hash = \"".md5(time())."\";\n";
        $config_content .= "\$config['config_template_c'] = \"templates_c\";\n";
        $config_content .= "?>";

        if(!is_dir("../configs")) mkdir("../configs", 0777, true);
        file_put_contents("../configs/config.php", $config_content);

        // Create Admin User (Mock)
        $sql = "CREATE TABLE IF NOT EXISTS tbl_admin (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL,
            roleid INT(11) DEFAULT 1
        )";
        $conn->query($sql);
        
        // Insert Default Admin (admin/admin)
        $pass = md5("admin");
        $conn->query("INSERT INTO tbl_admin (username, password, email) VALUES ('admin', '$pass', 'admin@example.com')");

        $success = "Installation Successful! Please delete the 'installer' folder and login.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dhru Fusion Installer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f5f5; padding-top: 50px; }
        .install-card { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container">
        <div class="install-card">
            <h3 class="text-center mb-4">Dhru Fusion Installation</h3>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if(isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
                <div class="text-center">
                    <a href="../admincp/" class="btn btn-primary">Go to Admin Panel</a>
                </div>
            <?php else: ?>

            <form method="post">
                <div class="mb-3">
                    <label>Database Host</label>
                    <input type="text" name="db_host" class="form-control" value="localhost" required>
                </div>
                <div class="mb-3">
                    <label>Database Name</label>
                    <input type="text" name="db_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Database User</label>
                    <input type="text" name="db_user" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Database Password</label>
                    <input type="password" name="db_pass" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Site URL</label>
                    <input type="text" name="site_url" class="form-control" value="http://<?php echo $_SERVER['HTTP_HOST']; ?>/DHRU FUSION" required>
                </div>
                <button type="submit" name="install" class="btn btn-success w-100">Install Now</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>