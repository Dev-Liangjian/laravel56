<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;      //require guzzlehttp/guzzle包

//使用 php artisan make:command 编写命令
class ESInit extends Command
{
    /**
     * The name and signature of the console command.
     * 控制台命令 signature 的名称
     * @var string
     */
    protected $signature = 'es:init';

    /**
     * The console command description.
     * 控制台命令说明。
     * @var string
     */
    protected $description = 'init Laravel Scout for search';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * 执行控制台命令。
     * 该命令执行初始化elasticsearch搜索引擎的template和index
     * @return mixed
     */
    public function handle()
    {
        $esclient = new Client();
        $this->createTemplate($esclient);
        $this->createIndex($esclient);
    }

    /**
     * 创建elasticsearch的index
     * @param  Client $client [description]
     */
    protected function createIndex(Client $client)
    {
        $url = config('scout.elasticsearch.hosts')[0] . '/' . config('scout.elasticsearch.index');
        $client->put($url, [
            'json' => [
                'settings' => [
                    'refresh_interval' => '5s',
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                ],
                'mappings' => [
                    '_default_' => [
                        '_all' => [
                            'enabled' => false
                        ]
                    ]
                ],
            ]
        ]);
        $this->info("create elasticsearch's index successfully");
    }

    /**
     * 创建elasticsearch的template
     * @param  Client $client [description]
     */
    protected function createTemplate(Client $client)
    {
        $url = config('scout.elasticsearch.hosts')[0] . '/_template/rtf';

        $client->put($url, [
            'json' => [
                'template' => '*',
                'settings' => [
                    'number_of_shards' => 1
                ],
                'mappings' => [
                    '_default_' => [
                        '_all' => [
                            'enabled' => true
                        ],
                        'dynamic_templates' => [
                            [
                                'strings' => [
                                    'match_mapping_type' => 'string',
                                    'mapping' => [
                                        'type' => 'text',
                                        'analyzer' => 'ik_smart',
                                        'ignore_above' => 256,
                                        'fields' => [
                                            'keyword' => [
                                                'type' => 'keyword'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
        $this->info("create elasticsearch's template successfully");
    }
}