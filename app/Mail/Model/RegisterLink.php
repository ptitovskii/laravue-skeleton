<?php

namespace App\Mail\Model;

class RegisterLink
{
    /** @var string */
    protected $link;

    public function __construct()
    {
        $this->link = '';
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return self
     */
    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
