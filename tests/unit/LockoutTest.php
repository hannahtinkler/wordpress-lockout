<?php

namespace Tests\Unit;

use Codeception\Stub;
use Prophecy\Argument;
use WordpressLockout\Lib\Filters;
use WordpressLockout\Lib\Lockout;
use WordpressLockout\Lib\Settings;
use WordpressLockout\Lib\Response;

class LockoutTest extends TestCase
{
    public function testItLocksOutLockedOutUserWhenCmsLocked()
    {
        $user = $this->mock('WP_User');
        $user->ID = 5;

        $settings = $this->mock(Settings::class);
        $settings->getLockedStatus()->willReturn(true);
        $settings->getLockedUsers()->willReturn([5]);

        $response = $this->mock(Response::class);
        $response->template(
            Argument::type('string'),
            ['message' => "You're currently locked out from this CMS"]
        )->willReturn("This is the locked out template");

        $filters = $this->mock(Filters::class);
        $filters->filter(
            'wordpress_lockout:locked_out_message',
            "You're currently locked out from this CMS"
        )->willReturn("You're currently locked out from this CMS");

        $lockout = Stub::make(Lockout::class, [
            'settings' => $settings->reveal(),
            'response' => $response->reveal(),
            'filters' => $filters->reveal()
        ]);

        $actual = $lockout->lockoutIfRequired('test', $user->reveal());

        $this->assertTrue($actual);
    }

    public function testItDoesNotLockOutNormalUserWhenCmsLocked()
    {
        $user = $this->mock('WP_User');
        $user->ID = 5;

        $settings = $this->mock(Settings::class);
        $settings->getLockedStatus()->willReturn(true);
        $settings->getLockedUsers()->willReturn([6]);

        $response = $this->mock(Response::class);
        $response->template(
            Argument::type('string'),
            ['message' => "You're currently locked out from this CMS"]
        )->willReturn("This is the locked out template");

        $filters = $this->mock(Filters::class);
        $filters->filter(
            'wordpress_lockout:locked_out_message',
            "You're currently locked out from this CMS"
        )->willReturn("You're currently locked out from this CMS");

        $lockout = Stub::make(Lockout::class, [
            'settings' => $settings->reveal(),
            'response' => $response->reveal(),
            'filters' => $filters->reveal()
        ]);

        $actual = $lockout->lockoutIfRequired('test', $user->reveal());

        $this->assertFalse($actual);
    }

    public function testItDoesNotLockOutNormalUserWhenCmsNotLocked()
    {
        $user = $this->mock('WP_User');
        $user->ID = 5;

        $settings = $this->mock(Settings::class);
        $settings->getLockedStatus()->willReturn(false);
        $settings->getLockedUsers()->willReturn([6]);

        $response = $this->mock(Response::class);
        $response->template(
            Argument::type('string'),
            ['message' => "You're currently locked out from this CMS"]
        )->willReturn("This is the locked out template");

        $filters = $this->mock(Filters::class);
        $filters->filter(
            'wordpress_lockout:locked_out_message',
            "You're currently locked out from this CMS"
        )->willReturn("You're currently locked out from this CMS");

        $lockout = Stub::make(Lockout::class, [
            'settings' => $settings->reveal(),
            'response' => $response->reveal(),
            'filters' => $filters->reveal()
        ]);

        $actual = $lockout->lockoutIfRequired('test', $user->reveal());

        $this->assertFalse($actual);
    }

    public function testItDoesNotLockOutLockedOutUserWhenCmsNotLocked()
    {
        $user = $this->mock('WP_User');
        $user->ID = 5;

        $settings = $this->mock(Settings::class);
        $settings->getLockedStatus()->willReturn(false);
        $settings->getLockedUsers()->willReturn([5]);

        $response = $this->mock(Response::class);
        $response->template(
            Argument::type('string'),
            ['message' => "You're currently locked out from this CMS"]
        )->willReturn("This is the locked out template");

        $filters = $this->mock(Filters::class);
        $filters->filter(
            'wordpress_lockout:locked_out_message',
            "You're currently locked out from this CMS"
        )->willReturn("You're currently locked out from this CMS");

        $lockout = Stub::make(Lockout::class, [
            'settings' => $settings->reveal(),
            'response' => $response->reveal(),
            'filters' => $filters->reveal()
        ]);

        $actual = $lockout->lockoutIfRequired('test', $user->reveal());

        $this->assertFalse($actual);
    }
}
