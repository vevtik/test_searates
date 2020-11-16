<?php

namespace app\entity;

class Port extends BaseEntity
{
    /**
     * @var string
     */
    protected string $locode;

    /**
     * @var string
     */
    protected string $country;

    /**
     * @var string
     */
    protected string $portCode;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @return string
     */
    public function getLocode(): string
    {
        return $this->locode;
    }

    /**
     * @param string $locode
     *
     * @return self
     */
    public function setLocode(string $locode): self
    {
        $this->locode = $locode;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     *
     * @return self
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getPortCode(): string
    {
        return $this->portCode;
    }

    /**
     * @param string $portCode
     *
     * @return self
     */
    public function setPortCode(string $portCode): self
    {
        $this->portCode = $portCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

}
