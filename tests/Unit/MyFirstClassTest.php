<?php

namespace Tests\Unit;

use App\MyFirstClass;
use PHPUnit\Framework\TestCase;

class MyFirstClassTest extends TestCase
{
    /** @test */
    public function it_will_add_two_integer(): void
    {
        $class = new MyFirstClass;

        $result = $class->add(1, 2);

        $this->assertEquals(3, $result);
    }
}
