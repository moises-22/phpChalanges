<?php

namespace Codespace\PhpChallenges;

// Ignore this class, too advanced and it would be an overkill 
class MemoryCache
{
    private $maxEntries;
    private $ttl;
    private $entries = [];
    private $timestamps = [];
    private $keyOrder = [];

    public function __construct(int $maxEntries, int $ttl)
    {
        $this->maxEntries = $maxEntries;
        $this->ttl = $ttl;
    }

    public function set($key, $value): void
    {
        $this->entries[$key] = $value;
        $this->timestamps[$key] = time();
        $this->updateKeyOrder($key);
        $this->evictExpiredEntries();
        $this->evictLRUEntries();
    }

    public function get($key)
    {
        if (!$this->has($key)) {
            return null;
        }

        $this->updateKeyOrder($key);
        return $this->entries[$key];
    }

    public function has($key): bool
    {
        return isset($this->entries[$key]) && !$this->isExpired($key);
    }

    public function delete($key): void
    {
        unset($this->entries[$key]);
        unset($this->timestamps[$key]);
        unset($this->keyOrder[array_search($key, $this->keyOrder)]);
    }

    public function clear(): void
    {
        $this->entries = [];
        $this->timestamps = [];
        $this->keyOrder = [];
    }

    private function updateKeyOrder($key): void
    {
        unset($this->keyOrder[array_search($key, $this->keyOrder)]);
        array_unshift($this->keyOrder, $key);
    }

    private function evictExpiredEntries(): void
    {
        if ($this->ttl <= 0) {
            return;
        }

        $expiredKeys = array_filter($this->keyOrder, [$this, 'isExpired']);
        foreach ($expiredKeys as $key) {
            $this->delete($key);
        }
    }

    private function evictLRUEntries(): void
    {
        while (count($this->keyOrder) > $this->maxEntries) {
            $key = array_pop($this->keyOrder);
            $this->delete($key);
        }
    }

    private function isExpired($key): bool
    {
        return time() - $this->timestamps[$key] > $this->ttl;
    }
}
