<?php

class sfSQLite3Cache extends sfCache
{
  protected
    $dbh      = null,
    $database = '';

  /**
   * Initializes this sfCache instance.
   *
   * Available options:
   *
   * * database: File where to put the cache database (or :memory: to store cache in memory)
   *
   * * see sfCache for options available for all drivers
   *
   * @see sfCache
   */
  public function initialize($options = array())
  {
    if (!extension_loaded('SQLite3') && !extension_loaded('pdo_SQLite')) //SQLite3
    {
      throw new sfConfigurationException('sfSQLite3Cache class needs "sqlite3" or "pdo_sqlite" extension to be loaded.');
    }

    parent::initialize($options);

    if (!$this->getOption('database'))
    {
      throw new sfInitializationException('You must pass a "database" option to initialize a sfSQLiteCache object.');
    }

    $this->setDatabase($this->getOption('database'));
  }

  /**
   * @see sfCache
   */
  public function getBackend()
  {
    return $this->dbh;
  }

  /**
   * @see sfCache
   */
  public function get($key, $default = null)
  {
    $data = $this->dbh->querySingle(sprintf("SELECT data FROM cache WHERE key = '%s' AND timeout > %d", SQLite3::escapeString($key), time()));

    return null === $data ? $default : $data;
  }

  /**
   * @see sfCache
   */
  public function has($key)
  {
    return (boolean) $this->dbh->query(sprintf("SELECT key FROM cache WHERE key = '%s' AND timeout > %d", SQLite3::escapeString($key), time()))->fetchArray(SQLITE3_NUM);
  }

  /**
   * @see sfCache
   */
  public function set($key, $data, $lifetime = null)
  {
    if ($this->getOption('automatic_cleaning_factor') > 0 && rand(1, $this->getOption('automatic_cleaning_factor')) == 1)
    {
      $this->clean(sfCache::OLD);
    }

    return (boolean) $this->dbh->query(sprintf("INSERT OR REPLACE INTO cache (key, data, timeout, last_modified) VALUES ('%s', '%s', %d, %d)", SQLite3::escapeString($key), SQLite3::escapeString($data), time() + $this->getLifetime($lifetime), time()));
  }

  /**
   * @see sfCache
   */
  public function remove($key)
  {
    return (boolean) $this->dbh->query(sprintf("DELETE FROM cache WHERE key = '%s'", SQLite3::escapeString($key)));
  }

  /**
   * @see sfCache
   */
  public function removePattern($pattern)
  {
    return (boolean) $this->dbh->query(sprintf("DELETE FROM cache WHERE REGEXP('%s', key)", SQLite3::escapeString(self::patternToRegexp($pattern))));
  }

  /**
   * @see sfCache
   */
  public function clean($mode = sfCache::ALL)
  {
    try {
        return (boolean) $this->dbh->query("DELETE FROM cache".(sfCache::OLD == $mode ? sprintf(" WHERE timeout < '%s'", time()) : ''))->fetchArray(SQLITE3_NUM);
    } catch(Exception $error) {
        
    }
  }

  /**
   * @see sfCache
   */
  public function getTimeout($key)
  {
    $rs = $this->dbh->query(sprintf("SELECT timeout FROM cache WHERE key = '%s' AND timeout > %d", SQLite3::escapeString($key), time()));

    return $rs->numRows() ? intval($rs->fetchSingle()) : 0;
  }

  /**
   * @see sfCache
   */
  public function getLastModified($key)
  {
    $rs = $this->dbh->query(sprintf("SELECT last_modified FROM cache WHERE key = '%s' AND timeout > %d", SQLite3::escapeString($key), time()));

    $result = $rs->fetchArray(SQLITE3_NUM);
    if($result) {
        //$result = intval($rs->fetchArray(SQLITE3_NUM));
        $result = intval(array_pop($result));
    } else {
        $result = 0;
    }
    return $result;
  }

  /**
   * Sets the database name.
   *
   * @param string $database The database name where to store the cache
   */
  protected function setDatabase($database)
  {
    $this->database = $database;

    $new = false;
    if (':memory:' == $database)
    {
      $new = true;
    }
    else if (!is_file($database))
    {
      $new = true;

      // create cache dir if needed
      $dir = dirname($database);
      $current_umask = umask(0000);
      if (!is_dir($dir))
      {
        @mkdir($dir, 0777, true);
      }

      touch($database);
      umask($current_umask);
    }

    if (!$this->dbh = new SQLite3($this->database, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE))
    {
      throw new sfCacheException('Unable to connect to SQLite3 database.');
    }

    $this->dbh->createFunction('regexp', array($this, 'removePatternRegexpCallback'), 2);

    if ($new)
    {
      $this->createSchema();
    }
  }

  /**
   * Callback used when deleting keys from cache.
   */
  public function removePatternRegexpCallback($regexp, $key)
  {
    return preg_match($regexp, $key);
  }

  /**
   * @see sfCache
   */
  public function getMany($keys)
  {
    $rows = $this->dbh->arrayQuery(sprintf("SELECT key, data FROM cache WHERE key IN ('%s') AND timeout > %d", implode('\', \'', array_map('SQLite3::escapeString', $keys)), time()));

    $data = array();
    foreach ($rows as $row)
    {
      $data[$row['key']] = $row['data'];
    }

    return $data;
  }

  /**
   * Creates the database schema.
   *
   * @throws sfCacheException
   */
  protected function createSchema()
  {
    $statements = array(
      'CREATE TABLE [cache] (
        [key] VARCHAR(255),
        [data] LONGVARCHAR,
        [timeout] TIMESTAMP,
        [last_modified] TIMESTAMP
      )',
      'CREATE UNIQUE INDEX [cache_unique] ON [cache] ([key])',
    );

    foreach ($statements as $statement)
    {
        $this->dbh->query($statement);
        //var_dump($this->dbh->query($statement));
//      if (!$this->dbh->query($statement))
//      {
//        throw new sfCacheException(SQLite3::lastErrorMsg());
//      }
    }
  }
}