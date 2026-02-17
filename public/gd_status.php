<?php echo extension_loaded('gd') ? 'GD_ENABLED' : 'GD_DISABLED (ExtDir: ' . ini_get('extension_dir') . ', INI: ' . php_ini_loaded_file() . ')'; ?>
