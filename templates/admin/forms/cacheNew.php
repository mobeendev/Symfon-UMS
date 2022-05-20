<?php

interface lPushSupport
{
    public function lpush(string $key, string $value);
}

// interface setRedisKey
// {
//     public function set(string $key, string $value,string $ttl = null);
// }

// interface setMemCacheKey
// {
//     public function set(string $key, string $value,string $ttl=null, string $is_compressed=null);
// }

abstract class Cache
{   
    private string $host;
    private string $port;
    private $cache;


    public function get(string $key){
        return $this->cache->get($key);
    }

    abstract public function set(string $key, string $value,string $ttl=null, string $is_compressed=null);
    
    public function connect(){
        if (!$this->$host || $this->$port) {
            throw new Exception('Please provide connection information.');
        }
        $this->cache->connect($this->$host , $this->$port); 
    }   

    public function setHost(string $host)
    {
        $this->host = $host;
    }

    public function setPort(string $port)
    {
        $this->port = $port;
    }

    abstract public function setCache();
};



class MemcacheCache extends Cache 
{
    public function setCache()
    {
        $this->cache = new \Memcache();
    }
    public function set(string $key, string $value, string $is_compressed=null, string $ttl=null){
        $this->cache->set($key,$value,$is_compressed,$ttl);
    }    
}
class RedisCache extends Cache implements lPushSupport
{
    
    public function setCache()
    {
        $this->cache = new \Redis();
    }

    public function set(string $key, string $value,string $ttl = null){
        $this->cache->set($key,$value,$ttl);
    }

    public function lpush(string $key, string $value){
            $this->cache->lPush($key,$value);
    }

}


// This is extra code to show how it can be used in a class
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


  function setValueWithTtl( ...$args ){ 
    $this->catch->set(...$args);
} 

    function store( $key ){ 

        try{ 
            global $redisObj; 
          // setting the value in redis
            $redisObj->setex( $key, $ttl, $value );
        }catch( Exception $e ){ 
            echo $e->getMessage(); 
        } 
    } 


}



$redisCache=new RedisCache();
$redisCache->setHost('localhost');
$redisCache->setPort('6379');
$redisCache->set('one','1');
$redisCache->lpush('two','1');
$redisCache->lpush('two','2');
echo $redisCache->get('one');





$memcache=new MemcacheCache();
$memcache->setHost('127.0.0.1');
$memcache->setPort('11211');

$memcache->setCache('memcache');
$memcache->connect('somehost','121');
$memcache->set('one','1');


/*
*This method will not be available on MemcacheCache as it does not implement lPushSupport interface
*/
//$memcache->lpush('two','2'); 


echo $memcache->get('one');





https://medium.com/successivetech/s-o-l-i-d-the-first-5-principles-of-object-oriented-design-with-php-b6d2742c90d7




<!DOCTYPE html>
<html>
<body>

<?php
$txt = "PHP";
echo "I love $txt!";


 function set(...$args){
 			
            
            $vars = func_get_args();

				print_r($vars);

            list($key, $value, $is_compressed) = $args;
			
            me($vars);
            you($key, $value, $is_compressed);
 }
 
  function me(...$args){
  echo "<br>";
  	print_r($args);
  }


  function you(...$args){
  echo "<br>";
  	print_r($args);
  }

 set(1,2,3,4,5);
 
?>

</body>
</html>
