<?php
if (file_exists('vendor/autoload.php')) {
    $loader = include 'vendor/autoload.php';
}

$zf2Path = false;

if (is_dir('vendor/ZF2/library')) {
    $zf2Path = 'vendor/ZF2/library';
} elseif (getenv('ZF2_PATH')) {      // Support for ZF2_PATH environment variable or git submodule
    $zf2Path = getenv('ZF2_PATH');
} elseif (get_cfg_var('zf2_path')) { // Support for zf2_path directive value
    $zf2Path = get_cfg_var('zf2_path');
}

if ($zf2Path) {
        $configuration = include 'config/application.config.php';
      //  echo '<pre>'; var_dump($configuration['autoloader']['namespaces']); die;

    if (isset($loader)) {
        $loader->add('Zend', $zf2Path);
          foreach ($configuration['autoloader']['namespaces'] as $name => $path) {
           // echo $name,$path;die;
            $loader->add($name, dirname($path));
        }

        $loader->register();
    } else {
        include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
       Zend\Loader\AutoloaderFactory::factory(
            array(
                'Zend\Loader\StandardAutoloader' => $configuration['autoloader'],
            )
        );
    }
}

if (!class_exists('Zend\Loader\AutoloaderFactory')) {
    throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
}
