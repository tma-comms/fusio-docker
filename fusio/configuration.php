<?php

return array(

    // Whether the implicit flow is allowed. This is mostly needed for 
    // javascript apps
    'fusio_grant_implicit'    => true,

    // Expire times of the different tokens which can be issued
    'fusio_expire_implicit'   => 'PT1H',
    'fusio_expire_app'        => 'P2D',
    'fusio_expire_backend'    => 'PT1H',
    'fusio_expire_consumer'   => 'PT1H',

    // The secret key of a project. It is recommended to change this to another
    // random value. This is used i.e. to encrypt the connection credentials in 
    // the database. NOTE IF YOU CHANGE THE KEY FUSIO CAN NO LONGER READ ANY 
    // DATA WHICH WAS ENCRYPTED BEFORE. BECAUSE OF THAT IT IS RECOMMENDED TO 
    // CHANGE THE KEY ONLY BEFORE THE INSTALLATION
    'fusio_project_key'       => getenv('FUSIO_PROJECT_KEY'),

    // The url to the psx public folder (i.e. http://127.0.0.1/psx/public or 
    // http://localhost.com)
    'psx_url'                 => getenv('FUSIO_URL'),

    // The input path 'index.php/' or '' if you use mod_rewrite
    'psx_dispatch'            => '',

    // The default timezone
    'psx_timezone'            => 'UTC',

    // Whether PSX runs in debug mode or not. If not error reporting is set to 0
    // Also several caches are used if the debug mode is false
    'psx_debug'               => false,

    // Database parameters which are used for the doctrine DBAL connection
    // http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html
    'psx_connection'          => [
        'dbname'              => getenv('FUSIO_DB_NAME'),
        'user'                => getenv('FUSIO_DB_USER'),
        'password'            => getenv('FUSIO_DB_PW'),
        'host'                => getenv('FUSIO_DB_HOST'),
        'driver'              => 'pdo_mysql',
    ],

    // Folder locations
    'psx_path_cache'          => __DIR__ . '/cache',
    'psx_path_library'        => __DIR__ . '/src',

    // Supported writers
    'psx_supported_writer'    => [
        \PSX\Data\Writer\Json::class,
        \PSX\Data\Writer\Jsonp::class,
        \PSX\Data\Writer\Jsonx::class,
    ],

    // Global middleware which are applied before and after every request. Must
    // bei either a classname, closure or PSX\Dispatch\FilterInterface instance
    //'psx_filter_pre'          => [],
    //'psx_filter_post'         => [],

    // A closure which returns a doctrine cache implementation. If null the
    // filesystem cache is used
    'psx_cache_factory'       => function($config, $namespace){
        $memcached = new \Memcached();
        $memcached->addServer('127.0.0.1', 11211);

        $memcache = new \Doctrine\Common\Cache\MemcachedCache();
        $memcache->setMemcached($memcached);
        $memcache->setNamespace($namespace);

        return $memcache;
    },

    // A closure which returns a monolog handler implementation. If null the
    // system handler is used
    //'psx_logger_factory'      => null,

    // Class name of the error controller
    //'psx_error_controller'    => null,

    // If you only want to change the appearance of the error page you can 
    // specify a custom template
    //'psx_error_template'      => null,

);