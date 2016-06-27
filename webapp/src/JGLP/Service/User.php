<?php

namespace JGLP\Service;

use JGLP\ConfigurableTrait;

class User implements ServiceInterface
{
    use ConfigurableTrait, ServiceTrait;

    /**
     * @var int|null
     */
    protected $id;

    /**
     * This object's id property points to the `user` session variable.
     */
    public function __construct()
    {
        $this->id = & $_SESSION["user"];
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     *
     * @throws \Exception If invalid $id parameter given
     */
    public function setId($id)
    {
        if (!is_int($id)) {
            throw new \Exception("\$id must be an integer");
        }

        $this->id = $id;
        return $this;
    }

    /**
     * Set the user id back to null.
     *
     * @return $this
     */
    public function reset()
    {
        $this->id = null;
        return $this;
    }
}