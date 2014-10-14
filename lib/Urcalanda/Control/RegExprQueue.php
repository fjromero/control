<?php
namespace Urcalanda\Control;

    class RegExprQueue extends \SplPriorityQueue
    {
        protected $serial = \PHP_INT_MAX;

        public function addByPriority(\Urcalanda\Control\RegExpr $regExpr)
        {
            $this->insertByPriority($regExpr, $regExpr->getPriority());
        }

        protected function insertByPriority($value, $priority)
        {
            parent::insert($value, array($priority,$this->serial--));
        }

        public function getCommandsBySubjectOrderByPriorityDesc($subject)
        {
            $thisCopy = clone $this;

            if ($thisCopy->isEmpty()) {
                return array();
            }

            $commands = array();
            $thisCopy->top();
            while ($thisCopy->valid()) {
                $aRegExpr = $thisCopy->current();
                if (preg_match($aRegExpr->getRegExpr(), $subject)) {
                    $commands[] = $aRegExpr->getCommand();
                }
                $thisCopy->next();
            }

            return $commands;
        }

    }
