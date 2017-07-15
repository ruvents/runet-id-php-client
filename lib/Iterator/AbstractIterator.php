<?php

namespace RunetId\ApiClient\Iterator;

use RunetId\ApiClient\Denormalizer\MockDenormalizer;
use Ruvents\AbstractApiClient\ApiClientInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class AbstractIterator implements \Iterator, \Countable
{
    /**
     * @var null|DenormalizerInterface
     */
    protected $denormalizer;

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

    public function __construct(
        ApiClientInterface $apiClient,
        array $context,
        DenormalizerInterface $denormalizer = null
    ) {
        $this->apiClient = $apiClient;
        $this->context = $context;
        $this->denormalizer = $denormalizer ?: new MockDenormalizer();

        $maxResultsParName = $this->getMaxResultsParameterName();
        $this->nextMaxResults = isset($this->context['query'][$maxResultsParName])
            ? $this->context['query'][$maxResultsParName] : null;
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

        $extractedData = $this->denormalize($rawData);
        $countExtractedData = count($extractedData);

        $this->data = array_merge($this->data, $extractedData);

        if (null !== $this->nextMaxResults) {
            $this->nextMaxResults -= $countExtractedData;
        }

        if (0 === $countExtractedData || 0 === $this->nextMaxResults || !isset($rawData[$nextPageTokenParName])) {
            $this->loaded = true;
        } else {
            $this->nextPageToken = $rawData[$nextPageTokenParName];
        }
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

    /**
     * @param array $rawData
     *
     * @return array
     */
    abstract protected function denormalize(array $rawData);
}
