<?php
declare(strict_types=1);

namespace Tests\Presentation\Value;

use CompositeGraphQL\Presentation\Value\ArgumentsSet;
use CompositeGraphQL\Presentation\Value\Collections\Arguments;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Tests\TestName;

final class ArgumentsSetTest extends MockeryTestCase
{
    public function testBeAbleToGetTheName(): void
    {
        $name = new TestName('ingredients');
        $set = new ArgumentsSet($name, new Arguments([]));
        $this->assertSame($name, $set->getName());
    }

    public function testGetDescription(): void
    {
        $set = new ArgumentsSet(new TestName('ingredients'), new Arguments([]));
        $set = $set->withDescription('A list of ingredients');
        $this->assertEquals('A list of ingredients', $set->getDescription());
    }

    public function testGetArguments(): void
    {
        $arguments = new Arguments([]);
        $set = new ArgumentsSet(new TestName('ingredients'), $arguments);
        $this->assertSame($arguments, $set->getArguments());
    }
}
