<?php

namespace Deployer;

use Dotenv\Dotenv;

require __DIR__.'/vendor/autoload.php'; // This line is needed because deployer installed as phar package via deployer/dist
require 'recipe/common.php';

// Global
set('application', 'Base project');
set('default_timeout', 0.0);

define('PROJECT_ROOT', __DIR__);
$variables = Dotenv::createImmutable(__DIR__)->safeLoad();

set(
    'env',
    array_merge(
        $variables,
        [
            'PROJECT_ROOT' => PROJECT_ROOT,
        ]
    )
);
// Laravel shared dirs
set('shared_dirs', [
    'storage',
]);


set('laravel_version', function () {
    $result = run('cd {{release_path}} && {{bin/php}} artisan --version');

    preg_match_all('/(\d+\.?)+/', $result, $matches);

    return $matches[0][0] ?? 5.5;
});

if (file_exists(PROJECT_ROOT.'/.dep/hosts.yml')) {
    $data = file_get_contents(PROJECT_ROOT.'/.dep/hosts.yml');
    foreach ($variables as $key => $variable) {
        $data = str_replace("{{".strtoupper($key)."}}", $variable, $data);
    }

    file_put_contents(PROJECT_ROOT.'/.dep/hosts.tmp.yml', $data);
    inventory(PROJECT_ROOT.'/.dep/hosts.tmp.yml');
}

task(
    'gitlab:symlink',
    function () {
        writeln('Create link from {{source_path}}/* to {{dist_path}}');

        run('{{bin/symlink}} {{source_path}}/* {{dist_path}}');
        run('{{bin/symlink}} {{source_path}}/.htaccess {{dist_path}}/.htaccess');
        run('{{bin/symlink}} {{source_path}}/.env {{dist_path}}/.env');
    }
)->desc('Creating symlink to project')
    ->setPrivate();

task(
    'gitlab:version',
    function () {
        writeln('Create version.txt file');

        run("{{bin/git}} log --pretty=format:'%H' --abbrev-commit --date=short -1 > {{release_path}}/version.txt");
    }
)->desc('Create version file')
    ->setPrivate();

task(
    'gitlab:cron',
    function () {
        writeln('Setup Cron tasks');

        cd('{{release_path}}');

        run('cat ./.cron > /var/spool/cron/crontabs/www-data');
        run('echo >> /var/spool/cron/crontabs/www-data');
        run('chown www-data:crontab /var/spool/cron/crontabs/www-data');
        run('chmod 600 /var/spool/cron/crontabs/www-data');
        run('cron');
    }
)->desc('Create cron task')
    ->setPrivate();

task(
    'gitlab:success',
    function () {
        writeln(sprintf('<info>{{application}} is UP! Domain: %s</info>', getenv('BUILD_URL')));
    }
)->desc('Success task')
    ->local()
    ->setPrivate()
    ->shallow();

task(
    'gitlab:final',
    function () {
        run('chown -R www-data:www-data {{source_path}}/*');
        run('chown -R www-data:www-data {{dist_path}}/*');
        invoke('common:unlink');
    }
)->desc('Final ownership fix')
    ->setPrivate()
    ->shallow();

task(
    'common:unlink',
    function () {
        $hostsFile = PROJECT_ROOT.'/.dep/hosts.tml.yml';
        if (!file_exists($hostsFile)) {
            return;
        }
        unlink($hostsFile);
    }
)->setPrivate();

task(
    'gitlab:deploy',
    function () {
        writeln('Start project deploy');

        set('release_path', PROJECT_ROOT);
        set('deploy_path', PROJECT_ROOT);
        set('source_path', PROJECT_ROOT);
        set('dist_path', '/var/www/html');

        writeln('Move files');

        invoke('gitlab:symlink');
        invoke('gitlab:version');
        invoke('laravel:build');
        invoke('create:user');
        invoke('gitlab:cron');
        invoke('common:unlink');

    }
)->desc('Deploy project on Gitlab CI/CD');

task('laravel:build', function () {
    set('deploy_path', PROJECT_ROOT);
    writeln(run('{{bin/php}} {{deploy_path}}/artisan env'));
    invoke('deploy:info');
    invoke('deploy:prepare');
    invoke('deploy:writable');
    invoke('artisan:migrate');
    if (getenv('TELESCOPE_ENABLED') == 'true'){
        writeln(run('{{bin/php}} {{deploy_path}}/artisan telescope:install'));
    }

    invoke('deploy:npm_install');
})->local()
    ->desc('Gitlab CI tasks bundle');

task('create:user', function () {
    set('deploy_path', PROJECT_ROOT);
    writeln(run('{{bin/php}} {{deploy_path}}/artisan user:create admin@nosend.net Password11'));
})->local()
    ->desc('Create user');


task('deploy:npm_install', function () {
        run('npm i');
        run('npm run prod');

})->desc('Install node modules');

task(
    'deploy:version',
    function () {
        writeln('Create version.txt file');
        cd('{{release_path}}');
        run(
            "{{bin/git}} log --pretty=format:'%h %an(%ae) - %B' --abbrev-commit --date=short -1 > {{release_path}}/public/version.txt"
        );
    }
)->desc('Create version file')
    ->setPrivate();

after('gitlab:deploy', 'gitlab:final');
after('gitlab:final', 'gitlab:success');

task('artisan:migrate', function () {
    writeln(run('{{bin/php}} {{deploy_path}}/artisan migrate --force --seed'));
})->desc('Run migrations');


$testPaths = [
    PROJECT_ROOT.'/app',
];

task(
    'tests:php_md',
    function () use ($testPaths) {
        $params = [
            implode(',', $testPaths),
            'xml '.PROJECT_ROOT.'/dev/etc/phpmd/rules/rules.xml',
            '--suffixes php',
        ];
        run('php '.PROJECT_ROOT.'/vendor/bin/phpmd '.implode(' ', $params));
    }
)->desc('PHP MD static tests');

task(
    'tests:php_cpd',
    function () use ($testPaths) {
        $params = [
            implode(' ', $testPaths),
            '--min-lines 50',
            '--exclude tests',
        ];
        run('php '.PROJECT_ROOT.'/vendor/bin/phpcpd '.implode(' ', $params));
    }
)->desc('PHP CPD static tests');

task(
    'tests:php_cs',
    function () use ($testPaths) {
        $params = [
            '--standard='.PROJECT_ROOT.'/dev/etc/phpcs/standard/ruleset.xml',
            '--extensions=php',
            '-qn',
            implode(' ', $testPaths),
        ];
        run('php '.PROJECT_ROOT.'/vendor/bin/phpcs '.implode(' ', $params));
    }
)->desc('PHP CS static tests');

task(
    'tests',
    function () {
        invoke('tests:php_md');
        invoke('tests:php_cpd');
        invoke('tests:php_cs');
    }
);
