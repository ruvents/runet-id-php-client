<?php

namespace RunetId\ApiClient\Iterator;

use Ruvents\AbstractApiClient\ApiClientInterface;

abstract class AbstractIterator implements \Iterator, \Countable
{
    /**
     * @var ApiClientInterface
     */
    private $apiClient;

    /**
     * @var array
     */
    private $context;

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

    public function __construct(ApiClientInterface $apiClient, array $context)
    {
        $this->apiClient = $apiClient;
        $this->context = $context;

        $mrpn = $this->getMaxResultsParameterName();
        $this->nextMaxResults = isset($this->context['query'][$mrpn]) ? $this->context['query'][$mrpn] : null;
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

    protected function loadData()
    {
        if ($this->loaded) {
            return;
        }

        $maxResultsParName = $this->getMaxResultsParameterName();
        $pageTokenParName = $this->getPageTokenParameterName();
        $nextPageTokenParName = $this->getNextPageTokenParameterName();

        $context = $this->context;
        $context['query'][$pageTokenParName] = $this->nextPageToken;
        $context['query'][$maxResultsParName] = $this->nextMaxResults;
        $context['use_iterators'] = false;

        $rawData = $this->apiClient->request($context);

        /** @var \Symfony\Component\Serializer\Normalizer\DenormalizerInterface $denormalizer */
        $data = $this->extractData($rawData);
        $class = $this->getDenormalizationClass();
        $denormalizer = isset($context['denormalizer']) ? $context['denormalizer'] : null;

        if (null !== $denormalizer && null !== $class
            && isset($context['denormalize']) && true === $context['denormalize']
            && $denormalizer->supportsDenormalization($data, $class)
        ) {
            $data = $denormalizer->denormalize($data, $class);
        }

        $countData = count($data);

        $this->data = array_merge($this->data, $data);

        if (null !== $this->nextMaxResults) {
            $this->nextMaxResults -= $countData;
        }

        if (0 === $countData || 0 === $this->nextMaxResults || !isset($rawData[$nextPageTokenParName])) {
            $this->loaded = true;
        } else {
            $this->nextPageToken = $rawData[$nextPageTokenParName];
        }
    }

    /**
     * @param array $rawData
     *
     * @return array
     */
    abstract protected function extractData(array $rawData);

    /**
     * @return null|string
     */
    protected function getDenormalizationClass()
    {
        return null;
    }

    /**
     * @return string
     */
    protected function getMaxResultsParameterName()
    {
        return 'MaxResults';
    }

    /**
     * @return string
     */
    protected function getPageTokenParameterName()
    {
        return 'PageToken';
    }

    /**
     * @return string
     */
    protected function getNextPageTokenParameterName()
    {
        return 'NextPageToken';
    }
}
