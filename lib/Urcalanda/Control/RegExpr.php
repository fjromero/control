<?php

namespace Urcalanda\Control;

class RegExpr
{
    const PRIORITY_BY_DEFAULT = 5;

    protected $regExpr = '';
    protected $priority = self::PRIORITY_BY_DEFAULT;
    protected $command = null;

    public function getRegExpr()
    {
        return $this->regExpr;
    }

    public function setRegExpr($regExpr)
    {
        $this->regExpr = $regExpr;

        return $this;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function setCommand(\Urcalanda\Control\Command $command)
    {
        $this->command = $command;

        return $this;
    }

}
