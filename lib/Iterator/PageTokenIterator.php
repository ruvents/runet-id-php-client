<?php

namespace RunetId\ApiClient\Iterator;

use RunetId\ApiClient\RunetIdClient;

class PageTokenIterator implements \Iterator, \Countable
{
    /**
     * @var RunetIdClient
     */
    private $client;

    /**
     * @var array
     */
    private $context;

    /**
     * @var callable
     */
    private $dataExtractor;

    /**
     * @var int
     */
    private $index = 0;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var null|string
     */
    private $nextPageToken;

    /**
     * @var null|int
     */
    private $nextMaxResults;

    /**
     * @var bool
     */
    private $loaded = false;

    public function __construct(RunetIdClient $client, array $context, callable $dataExtractor)
    {
        $this->client = $client;
        $this->context = $context;
        $this->dataExtractor = $dataExtractor;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->data[$this->index];
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        if (!isset($this->data[$this->index])) {
            $this->loadData();
        }

        return isset($this->data[$this->index]);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->loaded ? $this->data : iterator_to_array($this);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->loaded ? count($this->data) : iterator_count($this);
    }

    protected function loadData()
    {
        if ($this->loaded) {
            return;
        }

        // copy and modify context
        $context = array_replace_recursive($this->context, [
            'query' => [
                'MaxResults' => $this->nextMaxResults,
                'PageToken' => $this->nextPageToken,
            ],
        ]);

        // request raw data
        $raw = $this->client->request($context);

        // extract data
        $data = call_user_func($this->dataExtractor, $raw, $context);
        $countData = count($data);

        $this->data = array_merge($this->data, array_values($data));

        if (null !== $this->nextMaxResults) {
            $this->nextMaxResults -= $countData;
        }

        if (0 === $countData || 0 === $this->nextMaxResults || !isset($raw['NextPageToken'])) {
            $this->loaded = true;
        } else {
            $this->nextPageToken = $raw['NextPageToken'];
        }
    }
}
