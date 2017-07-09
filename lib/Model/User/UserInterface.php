<?php

namespace RunetId\ApiClient\Model\User;

use RunetId\ApiClient\Model\Event\RoleInterface;

interface UserInterface extends RunetIdInterface
{
    const MALE = 'male';
    const FEMALE = 'female';

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @return string
     */
    public function getFatherName();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getPhone();

    /**
     * @return RoleInterface|null
     */
    public function getEventRole();

    /**
     * @return bool
     */
    public function isVisible();

    /**
     * @return bool
     */
    public function isVerified();

    /**
     * @return string
     */
    public function getGender();

    /**
     * @return WorkInterface|null
     */
    public function getWork();

    /**
     * @return PhotoInterface|null
     */
    public function getPhoto();

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt();

    /**
     * @return array
     */
    public function getAttributes();
}
