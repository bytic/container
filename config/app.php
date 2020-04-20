<?php

use Nip\AutoLoader\AutoLoaderServiceProvider;
use Nip\Database\DatabaseServiceProvider;
use Nip\Dispatcher\DispatcherServiceProvider;
use Nip\Filesystem\FilesystemServiceProvider;
use Nip\FlashData\FlashServiceProvider;
use Nip\I18n\TranslatorServiceProvider;
use Nip\Inflector\InflectorServiceProvider;
use Nip\Locale\LocaleServiceProvider;
use Nip\Logger\LoggerServiceProvider;
use Nip\Mail\MailServiceProvider;
use Nip\Mvc\MvcServiceProvider;
use Nip\Router\RouterServiceProvider;
use Nip\Router\RoutesServiceProvider;
use Nip\Staging\StagingServiceProvider;
use Nip\Cache\CacheServiceProvider;

return [
    'providers' => [
        AutoLoaderServiceProvider::class,
        LoggerServiceProvider::class,
        InflectorServiceProvider::class,
        LocaleServiceProvider::class,
        MailServiceProvider::class,
        MvcServiceProvider::class,
        DispatcherServiceProvider::class,
        StagingServiceProvider::class,
        RouterServiceProvider::class,
        RoutesServiceProvider::class,
        DatabaseServiceProvider::class,
        TranslatorServiceProvider::class,
        FlashServiceProvider::class,
        FilesystemServiceProvider::class,
        CacheServiceProvider::class
    ]
];
