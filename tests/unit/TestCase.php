<?php

namespace Tests\Unit;

use Prophecy\Prophet;

class TestCase extends \Codeception\Test\Unit
{
    /**
     * @var object Prophet
     */
    protected $prophet;

    /**
     * @param  string $class
     * @return object Prophet
     */
    protected function mock(string $class)
    {
        if (!$this->prophet) {
            $this->prophet = new Prophet;
        }

        return $this->prophet->prophesize($class);
    }

    /**
     * @throws Exception\Prediction\AggregateException
     * @return void
     */
    protected function assertMethodsCalled()
    {
        $this->prophet->checkPredictions();
    }
}
