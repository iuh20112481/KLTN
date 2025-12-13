<?php
// CAPTCHA Diagnostic Tool
// Upload this file to your hosting server and access it via browser
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CAPTCHA Diagnostic Check</title>
    <style>
        body { font-family: Arial; padding: 20px; max-width: 800px; margin: 0 auto; }
        .ok { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .warning { color: orange; font-weight: bold; }
        .section { background: #f5f5f5; padding: 15px; margin: 10px 0; border-radius: 5px; }
        h2 { border-bottom: 2px solid #333; padding-bottom: 5px; }
        pre { background: #fff; padding: 10px; border: 1px solid #ccc; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>🔍 CAPTCHA Diagnostic Check</h1>
    <p>This tool checks if your server can generate CAPTCHA images correctly.</p>

    <div class="section">
        <h2>1. PHP Version</h2>
        <?php
        echo "PHP Version: <strong>" . phpversion() . "</strong><br>";
        echo "Server: <strong>" . $_SERVER['HTTP_HOST'] . "</strong><br>";
        ?>
    </div>

    <div class="section">
        <h2>2. GD Library Check</h2>
        <?php
        if (extension_loaded('gd')) {
            echo "<span class='ok'>✓ GD Library is ENABLED</span><br><br>";

            $gdInfo = gd_info();
            echo "<strong>GD Library Details:</strong><br>";
            echo "<pre>";
            print_r($gdInfo);
            echo "</pre>";

            // Check for required functions
            $requiredFunctions = [
                'imagecreatetruecolor',
                'imagecolorallocate',
                'imagefill',
                'imagettftext',
                'imagepng',
                'imagedestroy'
            ];

            echo "<strong>Required Functions:</strong><br>";
            foreach ($requiredFunctions as $func) {
                if (function_exists($func)) {
                    echo "<span class='ok'>✓ $func()</span><br>";
                } else {
                    echo "<span class='error'>✗ $func() NOT AVAILABLE</span><br>";
                }
            }
        } else {
            echo "<span class='error'>✗ GD Library is NOT ENABLED</span><br>";
            echo "<p class='error'>⚠️ CAPTCHA will not work without GD library!</p>";
            echo "<p>Contact your hosting provider to enable the GD extension.</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>3. Font File Check</h2>
        <?php
        $fontPath = '../font/SamsungOne-400.ttf';
        $absolutePath = realpath($fontPath);

        echo "Font Path (relative): <code>$fontPath</code><br>";

        if (file_exists($fontPath)) {
            echo "<span class='ok'>✓ Font file EXISTS</span><br>";
            echo "Absolute path: <code>$absolutePath</code><br>";
            echo "File size: " . filesize($fontPath) . " bytes<br>";

            if (is_readable($fontPath)) {
                echo "<span class='ok'>✓ Font file is READABLE</span><br>";
            } else {
                echo "<span class='error'>✗ Font file is NOT READABLE</span><br>";
                echo "<p class='error'>Check file permissions!</p>";
            }
        } else {
            echo "<span class='error'>✗ Font file NOT FOUND</span><br>";
            echo "<p class='error'>Expected location: $fontPath</p>";

            // Check alternative paths
            $alternatives = [
                '../font/samsungOne-400.ttf',
                __DIR__ . '/../font/SamsungOne-400.ttf',
                __DIR__ . '/../font/samsungOne-400.ttf'
            ];

            echo "<br><strong>Checking alternative paths:</strong><br>";
            foreach ($alternatives as $alt) {
                if (file_exists($alt)) {
                    echo "<span class='ok'>✓ Found: $alt</span><br>";
                } else {
                    echo "<span class='error'>✗ Not found: $alt</span><br>";
                }
            }
        }
        ?>
    </div>

    <div class="section">
        <h2>4. Session Check</h2>
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (session_status() == PHP_SESSION_ACTIVE) {
            echo "<span class='ok'>✓ Session is ACTIVE</span><br>";
            echo "Session ID: " . session_id() . "<br>";
        } else {
            echo "<span class='error'>✗ Session is NOT ACTIVE</span><br>";
        }
        ?>
    </div>

    <div class="section">
        <h2>5. Test CAPTCHA Generation</h2>
        <?php
        if (extension_loaded('gd') && file_exists($fontPath) && is_readable($fontPath)) {
            echo "<p>Attempting to generate a test CAPTCHA image...</p>";

            try {
                // Generate test captcha
                $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $randomString = substr(str_shuffle($characters), 0, 5);

                $width = 100;
                $height = 60;
                $image = imagecreatetruecolor($width, $height);

                $bgColor = imagecolorallocate($image, 255, 255, 255);
                imagefill($image, 0, 0, $bgColor);

                $textColor = imagecolorallocate($image, 0, 0, 0);

                // Try to add text with font
                $result = imagettftext($image, 20, 0, 10, 30, $textColor, $fontPath, $randomString);

                if ($result !== false) {
                    echo "<span class='ok'>✓ CAPTCHA generation SUCCESSFUL!</span><br>";
                    echo "Generated text: <strong>$randomString</strong><br>";

                    // Save temporary image
                    ob_start();
                    imagepng($image);
                    $imageData = ob_get_clean();
                    $base64 = base64_encode($imageData);

                    echo "<br><strong>Test CAPTCHA Image:</strong><br>";
                    echo "<img src='data:image/png;base64,$base64' style='border: 2px solid #333; margin: 10px 0;'><br>";
                } else {
                    echo "<span class='error'>✗ imagettftext() FAILED</span><br>";
                    echo "<p class='error'>There may be an issue with the font file.</p>";
                }

                imagedestroy($image);

            } catch (Exception $e) {
                echo "<span class='error'>✗ Error: " . $e->getMessage() . "</span><br>";
            }
        } else {
            echo "<span class='warning'>⚠️ Cannot test - GD library or font file issues detected above</span><br>";
        }
        ?>
    </div>

    <div class="section">
        <h2>6. Directory Permissions</h2>
        <?php
        $fontDir = '../font';
        echo "Font directory: <code>$fontDir</code><br>";

        if (is_dir($fontDir)) {
            echo "<span class='ok'>✓ Font directory exists</span><br>";

            if (is_readable($fontDir)) {
                echo "<span class='ok'>✓ Font directory is readable</span><br>";

                // List font files
                $fontFiles = glob($fontDir . '/*.ttf');
                echo "<br><strong>Font files found:</strong><br>";
                if (!empty($fontFiles)) {
                    echo "<ul>";
                    foreach ($fontFiles as $file) {
                        echo "<li>" . basename($file) . " (" . filesize($file) . " bytes)</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<span class='error'>No .ttf files found in font directory</span><br>";
                }
            } else {
                echo "<span class='error'>✗ Font directory is NOT readable</span><br>";
            }
        } else {
            echo "<span class='error'>✗ Font directory does NOT exist</span><br>";
        }
        ?>
    </div>

    <div class="section">
        <h2>7. Current CAPTCHA Page Test</h2>
        <p>Click below to test the actual CAPTCHA image:</p>
        <img src="captcha.php" alt="CAPTCHA Test" style="border: 2px solid #333; margin: 10px 0;" id="captchaTest">
        <br>
        <button onclick="document.getElementById('captchaTest').src='captcha.php?rand='+Math.random();">Refresh CAPTCHA</button>
        <br><br>
        <p><strong>If you see an image above, your CAPTCHA is working!</strong></p>
        <p>If you see a broken image icon, check the errors above.</p>
    </div>

    <hr>
    <div style="background: #ffe6e6; padding: 15px; border-radius: 5px; margin: 20px 0;">
        <h3 style="color: red; margin-top: 0;">⚠️ SECURITY WARNING</h3>
        <p><strong>DELETE THIS FILE (captcha_check.php) AFTER TESTING!</strong></p>
        <p>This diagnostic file reveals server information and should not be left on a production server.</p>
    </div>

    <div class="section">
        <h2>Summary & Recommendations</h2>
        <?php
        echo "<ul>";

        if (!extension_loaded('gd')) {
            echo "<li class='error'>❌ Enable GD Library on your hosting server</li>";
        } else {
            echo "<li class='ok'>✅ GD Library is enabled</li>";
        }

        if (!file_exists($fontPath)) {
            echo "<li class='error'>❌ Upload font file to: $fontPath</li>";
        } elseif (!is_readable($fontPath)) {
            echo "<li class='error'>❌ Fix font file permissions (should be readable)</li>";
        } else {
            echo "<li class='ok'>✅ Font file is accessible</li>";
        }

        echo "</ul>";
        ?>
    </div>

</body>
</html>
