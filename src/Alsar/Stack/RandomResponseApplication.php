<?php
namespace Alsar\Stack;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RandomResponseApplication implements HttpKernelInterface
{
    /**
     * @var integer
     */
    private $min;

    /**
     * @var integer
     */
    private $max;

    public function __construct($min = 0, $max = 1000000)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        return new Response(rand($this->min, $this->max));
    }
}