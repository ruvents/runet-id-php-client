<?php

namespace RunetId\ApiClient\Model;

use RunetId\ApiClient\Model\Section\Hall;
use RunetId\ApiClient\Model\Section\Report;

/**
 * Class Section
 */
class Section
{
    /**
     * @var int
     */
    public $Id;

    /**
     * @var string
     */
    public $Title;

    /**
     * @var string
     */
    public $Info;

    /**
     * @var \DateTime
     */
    public $Start;

    /**
     * @var \DateTime
     */
    public $End;

    /**
     * @var \DateTime
     */
    public $UpdateTime;

    /**
     * @var bool
     */
    public $Deleted;

    /**
     * @var string
     */
    public $TypeCode;

    /**
     * @var Hall[]
     */
    public $Halls = [];

    /**
     * @var Report[]
     */
    public $Reports = [];

    /**
     * @var string[]
     */
    public $Attributes = [];

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->Title;
    }

    /**
     * If $map is null, reports will be grouped by role ids.
     * Otherwise for the map
     * ['groupName1' => [<roleId1>, <roleId2>], 'groupName2' => [<roleId3>, <roleId4>]],
     * method will return
     * ['groupName1' => Report[], 'groupName2' => Report[]].
     * @param null|array $map
     * @return array
     */
    public function getGroupedReports(array $map = null)
    {
        if (!$this->Reports) {
            return [];
        }

        $reports = [];

        foreach ($this->Reports as $report) {
            $reports[$report->SectionRoleId][] = $report;
        }

        if (!isset($map)) {
            return $reports;
        }

        $mappedReports = [];

        foreach ($map as $name => $roleIds) {
            if (!isset($mappedReports[$name])) {
                $mappedReports[$name] = [];
            }

            foreach ($roleIds as $roleId) {
                if (empty($reports[$roleId])) {
                    continue;
                }

                $mappedReports[$name] = array_merge($mappedReports[$name], $reports[$roleId]);
            }
        }

        return $mappedReports;
    }
}
