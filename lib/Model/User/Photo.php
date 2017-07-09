<?php

namespace RunetId\ApiClient\Model\User;

class Photo implements PhotoInterface
{
    /**
     * @var string[]
     */
    protected $urls = [];

    public function __construct($data)
    {
        $this->urls[PhotoInterface::SMALL] = isset($data['Small']) ? $data['Small'] : null;
        $this->urls[PhotoInterface::MEDIUM] = isset($data['Medium']) ? $data['Medium'] : null;
        $this->urls[PhotoInterface::LARGE] = isset($data['Large']) ? $data['Large'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl($type = self::LARGE)
    {
        return $this->urls[$type];
    }
}
