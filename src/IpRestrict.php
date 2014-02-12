<?php
namespace Alsar\Stack;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IpRestrict implements HttpKernelInterface
{
    /**
     * @var HttpKernelInterface
     */
    private $app;

    /**
     * @var array
     */
    private $allowedIps;

    /**
     * @param HttpKernelInterface $app
     * @param array               $allowedIps
     */
    public function __construct(HttpKernelInterface $app, array $allowedIps)
    {
        $this->app = $app;
        $this->allowedIps = $allowedIps;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        $ip = $request->getClientIp();

        if (!in_array($ip, $this->allowedIps)) {
            return new Response(sprintf('IP %s is not allowed.', $ip), 403);
        }

        return $this->app->handle($request, $type, $catch);
    }
}
