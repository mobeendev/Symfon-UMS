<?php

interface lPushSupport
{
    public function lpush(string $key, string $value);
}

abstract class Cache
{   
    private string $host;
    private string $port;
    private $cache;

    public function setHost(string $host)
    {
        $this->host = $host;
    }

    public function setPort(string $port)
    {
        $this->port = $port;
    }

    public function connect(){
        if (!$this->$host || $this->$port) {
            throw new Exception('Please provide connection information.');
        }
        $this->cache->connect($this->$host , $this->$port); 
    }  

    public function get(string $key){
        return $this->cache->get($key);
    }

    abstract public function set(...$args);
    
    abstract public function setCache();
};



class MemcacheCache extends Cache 
{
    public function setCache()
    {
        $this->cache = new \Memcache();
    }
    
    public function set(...$args){
        list($key,$value,$ttl,$is_compressed) = $args;
        $this->cache->set($key,$value,$is_compressed,$ttl);
    }    
}
class RedisCache extends Cache implements lPushSupport
{
    
    public function setCache()
    {
        $this->cache = new \Redis();
    }

    public function set(...$args){
        list($key,$value,$ttl) = $args;
        $this->cache->set($key,$value,$ttl);
    }    

    public function lpush(string $key, string $value){
            $this->cache->lPush($key,$value);
    }

}


// This is code to show how it can be used in a class
class CacheManager {

    private Cache $cache;

    public function __construct(Cache $cache) {
      $this->cache = $cache;
    }
    /**
   * Retrieve cached data by its key
   */
  public function retrieve($key) {
    return $this->catch->get($key);
  }
    /**
   * Store cached data
   */
  function store(...$args){ 
        $params = func_get_args();
        $this->catch->set($params);
  } 
}



$redisCache=new RedisCache();
$redisCache->setHost('localhost');
$redisCache->setPort('6379');
$redisCache->connect();
$redisCache->set('one','1');
$redisCache->lpush('two','1');
$redisCache->lpush('two','2');
echo $redisCache->get('one');





$memcache=new MemcacheCache();
$memcache->setHost('127.0.0.1');
$memcache->setPort('11211');
$redisCache->connect();
$memcache->set('one','1');
echo $cm->get('one');

/*
*This method will not be available on MemcacheCache as it does not implement lPushSupport interface
*/
//$memcache->lpush('two','2'); 

//using CacheManager

$rcm=new CacheManager($redisCache);
$rcm->store('one','1');
$rcm->retrieve('one');

$mcm=new CacheManager($memcache);
$mcm->store('one','1');
$mcm->retrieve('one');
