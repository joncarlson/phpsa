<?php

namespace Tests\PHPSA\Compiler\Expression\BinaryOp;

use PhpParser\Node;
use PHPSA\CompiledExpression;
use PHPSA\Compiler\Expression;
use Tests\PHPSA\Compiler\Expression\AbstractBinaryOp;

class SpaceShipTest extends AbstractBinaryOp
{
    /**
     * @return array
     */
    public function getDataProvider()
    {
        return [
            [1, 1, 0],
            [1, 2, -1],
            [2, 1, 1],
            [true, false, 1],
            [true, 0, 1],
            [[], [], 0],
            [true, [], 1],
            ["a", "b", -1],
            ["a", 2, -1],
        ];
    }

    /**
     * Tests {expr} <=> {expr} = {expr}
     *
     * @dataProvider getDataProvider
     */
    public function testSimpleSuccessCompile($a, $b, $c)
    {
        $baseExpression = new Node\Expr\BinaryOp\Spaceship(
            $this->newScalarExpr($a),
            $this->newScalarExpr($b)
        );
        $compiledExpression = $this->compileExpression($baseExpression);

        self::assertInstanceOfCompiledExpression($compiledExpression);
        self::assertSame(CompiledExpression::INTEGER, $compiledExpression->getType());
        self::assertSame($c, $compiledExpression->getValue());
    }

    /**
     * @param $a
     * @param $b
     * @return bool
     */
    protected function process($a, $b)
    {
        return 0; //currently no spaceship support so we just return 0
    }

    /**
     * @return array
     */
    protected function getSupportedTypes()
    {
        return [
            CompiledExpression::INTEGER,
        ];
    }

    /**
     * @param Node\Scalar $a
     * @param Node\Scalar $b
     * @return Node\Expr\BinaryOp\Spaceship
     */
    protected function buildExpression($a, $b)
    {
        return new Node\Expr\BinaryOp\Spaceship($a, $b);
    }
}
