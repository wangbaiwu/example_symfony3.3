<?php

namespace Tools\EsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elasticsearch\ClientBuilder;

class DefaultController extends Controller
{

    private $logger;

    private $connectTimes=1;

    private $client;

    public function indexAction()
    {
        $this->logger=$this->container->get("monolog.logger.es");
        /*

        $this->logger->info("ccc");
        echo 111;die;
        return $this->render('ToolsEsBundle:Default:index.html.twig');
        */
        $this->client=$this->connect();
        $createParam=array(
            'body' => [
                'settings' => [
                    'number_of_shards' => 3,
                    'number_of_replicas' => 1
                ],

            ]
        );
        //$r=$this->createIndex("demo",$createParam);
        //$r=$this->deleteIndex("demo");
        $indexParam=array(
            'index' => 'demo',
            'type' => 'foo',
            'body' => array(
                'name'=>"kate",
                'age'=>17
            )
        );
        //$r=$this->index($indexParam);
        $getParam=array(
            'index' => 'demo',
            'type' => 'foo',
            'id' => 'Z6VKr2YBxMaD1ruoIk5I'
        );
        //$r=$this->get($getParam);
        $deleteParam=array(
            'index' => 'demo',
            'type' => 'foo',
            'id' => 'aKVLr2YBxMaD1ruohU7d'
        );
        //$r=$this->delete($deleteParam);
        $updateParam1=array(
            'index' => 'demo',
            'type' => 'foo',
            'id' => 'Z6VKr2YBxMaD1ruoIk5I',
            'body' => [
                'doc' => [
                    'address' => 'abc'
                ]
            ]
        );
        $updateParam2=array(
            'index' => 'demo',
            'type' => 'foo',
            'id' => 'Z6VKr2YBxMaD1ruoIk5I',
            'body' => [
                'doc' => [
                    'age' => 19
                ]
            ]
        );
        $updateParam3 = [
            'index' => 'demo',
            'type' => 'foo',
            'id' => 'Z6VKr2YBxMaD1ruoIk5I',
            'body' => [
                'script' => [
                    'source' => 'ctx._source.age += params.count',
                    'params' => [
                        'count' => 4
                    ]
                ],
            ]
        ];
        $updateParam4 = [
            'index' => 'demo',
            'type' => 'foo',
            'id' => 'A6VKr2YBxMaD1ruoIk5I',
            'body' => [
                'script' => [
                    'source' => 'ctx._source.counter += params.count',
                    'params' => [
                        'count' => 4
                    ],
                ],
                'upsert' => [
                    'counter' => 1
                ],
            ]
        ];
        //$r=$this->update($updateParam4);
        $searchParams1 = [
            'index' => 'demo',
            'type' => 'foo',
            'body' => [
                'query' => [
                    'match' => [
                        'name' => 'david'
                    ]
                ]
            ]
        ];
        $searchParams2 = [
            'index' => 'demo',
            'type' => 'foo',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [ 'match' => [ 'name' => 'kate' ] ],
                            [ 'match' => [ 'age' => 17 ] ],
                        ]
                    ]
                ]
            ]
        ];
        $searchParams3 = [
            'index' => 'demo',
            'type' => 'foo',
            'body' => [
                'query' => [
                    'bool' => [
                        'filter' => [
                            'term' => [ 'age' => 19 ]
                        ],
                        'should' => [
                            'match' => [ 'name' => 'jim' ]
                        ]
                    ]
                ]
            ]
        ];

        $r=$this->search($searchParams3);
        var_dump($r);
        die;

    }

    /**
     * @param array $param
     * @return bool
     */
    public function search($param=array()){
        try{
            $result=$this->client->search($param);
        }catch(\Exception $e){
            $this->logger->error(sprintf(
                "search [%s] fail, error msg:[%s].",
                json_encode($param),
                $e->getMessage()
            ));
            return false;
        }
        return $result;
    }

    /**
     * @param array $param
     * $params = [
     *     'index' => 'my_index',
     *     'type' => 'my_type',
     *     'id' => 'my_id',
     *     'body' => [
     *         'doc' => [
     *             'new_field' => 'abc'
     *         ]
     *     ]
     * ];
     *
     * @return bool
     */
    public function update($param=array()){
        try{
            $this->client->update($param);
        }catch(\Exception $e){
            $this->logger->error(sprintf(
                "update [%s] fail, error msg:[%s].",
                json_encode($param),
                $e->getMessage()
            ));
            return false;
        }
        return true;
    }

    /**
     * @param array $param
     * $params = [
     *     'index' => 'my_index',
     *     'type' => 'my_type',
     *     'id' => 'my_id'
     * ];
     * @return bool
     */
    public function delete($param=array()){
        try{
            $this->client->delete($param);
        }catch(\Exception $e){
            $this->logger->error(sprintf(
                "delete [%s] fail, error msg:[%s].",
                json_encode($param),
                $e->getMessage()
            ));
            return false;
        }
        return true;
    }

    /**
     * @param array $param
     * $params = [
     *     'index' => 'my_index',
     *     'type' => 'my_type',
     *     'id' => 'my_id'
     * ];
     * @return bool
     */
    public function get($param=array()){
        try{
            $result=$this->client->get($param);
        }catch(\Exception $e){
            $this->logger->error(sprintf(
                "get [%s] fail, error msg:[%s].",
                json_encode($param),
                $e->getMessage()
            ));
            return false;
        }
        return $result;
    }

    /**
     * @param array $param
     * $params = [
     *     'index' => 'my_index',
     *     'type' => 'my_type',
     *     'body' => [ 'testField' => 'abc']
     * ];
     * @return bool
     */
    public function index($param=array()){
        try{
            $this->client->index($param);
        }catch(\Exception $e){
            $this->logger->error(sprintf(
                "index [%s] fail, error msg:[%s].",
                json_encode($param),
                $e->getMessage()
            ));
            return false;
        }
        return true;
    }

    /**
     * @param string $index
     * @param array $createParams array Associative array of parameters
     * $createParams=array(
     *    'body' => [
     *        'settings' => [
     *            'number_of_shards' => 3,
     *            'number_of_replicas' => 2
     *        ],
     *        'mappings' => [
     *            'my_type' => [
     *                '_source' => [
     *                    'enabled' => true
     *                ],
     *                'properties' => [
     *                    'first_name' => [
     *                        'type' => 'keyword',
     *                        'analyzer' => 'standard'
     *                    ],
     *                    'age' => [
     *                        'type' => 'integer'
     *                    ]
     *                ]
     *            ]
     *        ]
     *    ]
     * );
     * @return bool
     */
    public function createIndex($index="", $createParams=array())
    {
        $ifExists = $this->client->indices()->exists(array('index' => $index));
        if (true === $ifExists) {
            $this->logger->warning(sprintf(
                '[%s] indices has exists.',
                $index
            ));
        } else {
            try{
                $this->client->indices()->create(array_merge($createParams,array(
                    'index'=>$index
                )));
            }catch(\Exception $e){
                $this->logger->error(sprintf(
                    "Create index [%s] fail, error msg:[%s].",
                    $index,
                    $e->getMessage()
                ));
                return false;
            }
        }
        return true;
    }

    /**
     * @param string $index
     * $index   = (list) A comma-separated list of indices to delete; use `_all` or empty string to delete all indices
     * @return bool
     */
    public function deleteIndex($index=""){
        try{
            $this->client->indices()->delete(array("index"=>"$index"));
        }catch(\Exception $e){
            $this->logger->error(sprintf(
                'Delete index [%s] fail, error msg:[%s].',
                $index,
                $e->getMessage()
            ));
            return false;
        }
        return true;
    }

    /**
     * @return \Elasticsearch\Client
     */
    public function connect()
    {
        $esHosts = $this->container->getParameter('es_hosts');
        try {
            $clientBuilder = ClientBuilder::create();
            $clientBuilder->setConnectionPool('\Elasticsearch\ConnectionPool\StaticNoPingConnectionPool', $esHosts);
            //$clientBuilder->setHosts($esHosts);
            $clientBuilder->setRetries(50);
            $clientBuilder->setLogger($this->logger);
            $esClient = $clientBuilder->build();
            $esClient->ping();
        } catch (\Exception $e) {
            ++$this->connectTimes;
            $this->logger->error(sprintf(
                'Es connect error,error times:[%s],reason for this error:[%s].',
                $this->connectTimes,
                $e->getMessage()
            ));
            sleep($this->connectTimes * 5);
            return $this->connect();
        }
        return $esClient;
    }


}
