<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\Mocks;

use Predis\Client;

/**
 * @method null dump($key)
 * @method int exists($key)
 * @method int expire($key, $seconds)
 * @method int expireat($key, $timestamp)
 * @method array keys($pattern)
 * @method int move($key, $db)
 * @method mixed object($subcommand, $key)
 * @method int persist($key)
 * @method int pexpire($key, $milliseconds)
 * @method int pexpireat($key, $timestamp)
 * @method int pttl($key)
 * @method null randomkey()
 * @method mixed rename($key, $target)
 * @method int renamenx($key, $target)
 * @method array scan($cursor, array $options = null)
 * @method array sort($key, array $options = null)
 * @method int ttl($key)
 * @method mixed type($key)
 * @method int append($key, $value)
 * @method int bitcount($key, $start = null, $end = null)
 * @method int bitop($operation, $destkey, $key)
 * @method null bitfield($key, $subcommand, ...$subcommandArg)
 * @method int bitpos($key, $bit, $start = null, $end = null)
 * @method int decr($key)
 * @method int decrby($key, $decrement)
 * @method int getbit($key, $offset)
 * @method string getrange($key, $start, $end)
 * @method null getset($key, $value)
 * @method int incr($key)
 * @method int incrby($key, $increment)
 * @method string incrbyfloat($key, $increment)
 * @method array mget(array $keys)
 * @method mixed mset(array $dictionary)
 * @method int msetnx(array $dictionary)
 * @method mixed psetex($key, $milliseconds, $value)
 * @method int setbit($key, $offset, $value)
 * @method int setex($key, $seconds, $value)
 * @method int setnx($key, $value)
 * @method int setrange($key, $offset, $value)
 * @method int strlen($key)
 * @method int hdel($key, array $fields)
 * @method int hexists($key, $field)
 * @method null hget($key, $field)
 * @method int hincrby($key, $field, $increment)
 * @method string hincrbyfloat($key, $field, $increment)
 * @method array hkeys($key)
 * @method int hlen($key)
 * @method array hmget($key, array $fields)
 * @method array hscan($key, $cursor, array $options = null)
 * @method int hset($key, $field, $value)
 * @method int hsetnx($key, $field, $value)
 * @method array hvals($key)
 * @method int hstrlen($key, $field)
 * @method null blpop(array|string $keys, $timeout)
 * @method null brpop(array|string $keys, $timeout)
 * @method null brpoplpush($source, $destination, $timeout)
 * @method null lindex($key, $index)
 * @method int linsert($key, $whence, $pivot, $value)
 * @method int llen($key)
 * @method null lpop($key)
 * @method int lpush($key, array $values)
 * @method int lpushx($key, array $values)
 * @method array lrange($key, $start, $stop)
 * @method int lrem($key, $count, $value)
 * @method mixed lset($key, $index, $value)
 * @method mixed ltrim($key, $start, $stop)
 * @method null rpop($key)
 * @method null rpoplpush($source, $destination)
 * @method int rpush($key, array $values)
 * @method int rpushx($key, array $values)
 * @method int sadd($key, array $members)
 * @method int scard($key)
 * @method array sdiff(array|string $keys)
 * @method int sdiffstore($destination, array|string $keys)
 * @method array sinter(array|string $keys)
 * @method int sinterstore($destination, array|string $keys)
 * @method int sismember($key, $member)
 * @method array smembers($key)
 * @method int smove($source, $destination, $member)
 * @method null spop($key, $count = null)
 * @method null srandmember($key, $count = null)
 * @method int srem($key, $member)
 * @method array sscan($key, $cursor, array $options = null)
 * @method array sunion(array|string $keys)
 * @method int sunionstore($destination, array|string $keys)
 * @method int zadd($key, array $membersAndScoresDictionary)
 * @method int zcard($key)
 * @method string zcount($key, $min, $max)
 * @method string zincrby($key, $increment, $member)
 * @method int zinterstore($destination, array|string $keys, array $options = null)
 * @method array zrange($key, $start, $stop, array $options = null)
 * @method array zrangebyscore($key, $min, $max, array $options = null)
 * @method null zrank($key, $member)
 * @method int zrem($key, $member)
 * @method int zremrangebyrank($key, $start, $stop)
 * @method int zremrangebyscore($key, $min, $max)
 * @method array zrevrange($key, $start, $stop, array $options = null)
 * @method array zrevrangebyscore($key, $max, $min, array $options = null)
 * @method null zrevrank($key, $member)
 * @method int zunionstore($destination, array|string $keys, array $options = null)
 * @method null zscore($key, $member)
 * @method array zscan($key, $cursor, array $options = null)
 * @method array zrangebylex($key, $start, $stop, array $options = null)
 * @method array zrevrangebylex($key, $start, $stop, array $options = null)
 * @method int zremrangebylex($key, $min, $max)
 * @method int zlexcount($key, $min, $max)
 * @method int pfadd($key, array $elements)
 * @method mixed pfmerge($destinationKey, array|string $sourceKeys)
 * @method int pfcount(array|string $keys)
 * @method mixed pubsub($subcommand, $argument)
 * @method int publish($channel, $message)
 * @method mixed discard()
 * @method null exec()
 * @method mixed multi()
 * @method mixed unwatch()
 * @method mixed watch($key)
 * @method mixed eval($script, $numkeys, $keyOrArg1 = null, $keyOrArgN = null)
 * @method mixed evalsha($script, $numkeys, $keyOrArg1 = null, $keyOrArgN = null)
 * @method mixed script($subcommand, $argument = null)
 * @method mixed auth($password)
 * @method string echo ($message)
 * @method mixed ping($message = null)
 * @method mixed select($database)
 * @method mixed bgrewriteaof()
 * @method mixed bgsave()
 * @method mixed client($subcommand, $argument = null)
 * @method mixed config($subcommand, $argument = null)
 * @method int dbsize()
 * @method mixed flushall()
 * @method mixed flushdb()
 * @method array info($section = null)
 * @method int lastsave()
 * @method mixed save()
 * @method mixed slaveof($host, $port)
 * @method mixed slowlog($subcommand, $argument = null)
 * @method array time()
 * @method array command()
 * @method int geoadd($key, $longitude, $latitude, $member)
 * @method array geohash($key, array $members)
 * @method array geopos($key, array $members)
 * @method null geodist($key, $member1, $member2, $unit = null)
 * @method array georadius($key, $longitude, $latitude, $radius, $unit, array $options = null)
 * @method array georadiusbymember($key, $member, $radius, $unit, array $options = null)
 */
class RedisClientMock extends Client
{
    protected array $storage = [];

    public function get($key): mixed
    {
        if (array_key_exists($key, $this->storage)) {
            return $this->storage[$key];
        }
        return null;
    }

    public function set($key, $value, $expireResolution = null, $expireTTL = null, $flag = null): bool
    {
        $this->storage[$key] = $value;
        return true;
    }

    public function del(array|string $keys): int
    {
        if (is_string($keys)) {
            $keys = [$keys];
        }

        $counter = 0;
        foreach ($keys as $key) {
            unset($this->storage[$key]);
            $counter++;
        }
        return $counter;
    }

    public function hgetall($key): array
    {
        return (array)$this->get($key);
    }

    public function hmset($key, array $dictionary): bool
    {
        return $this->set($key, $dictionary);
    }

    public function __call($commandID, $arguments)
    {
    }
}