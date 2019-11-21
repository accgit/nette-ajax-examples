<?php
declare(strict_types=1);

namespace Module\Web;

use Nette\Application\Routers\RouteList;
use Nette\Routing\Router;
use Nette\StaticClass;


final class RouterFactory
{
	use StaticClass;

	public static function create(): Router
	{
		$router = new RouteList;
		$router->withModule('Web')
			->addRoute('<presenter>/<action>', 'Web:default');

		return $router;
	}
}
