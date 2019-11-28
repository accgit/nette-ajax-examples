<?php

declare(strict_types = 1);

namespace Module\Web\Components;

use Nette\Application\UI\Control;


class Toast extends Control
{
	public function render(?string $title, ?string $body): void
	{
		$template = $this->template;
		$template->setFile(__DIR__ . '/../templates/Control/toast/toast.latte');
		$template->toastTitle = $title;
		$template->toastBody = $body;
		$template->render();
	}


	public function renderJs(): void
	{
		$template = $this->template;
		$template->setFile(__DIR__ . '/../templates/Control/toast/toast.js.latte');
		$template->render();
	}
}
