<?php

declare(strict_types = 1);

namespace Module\Web\Components;

use Nette\Application\UI\Control;


class Message extends Control
{
	public function render(): void
	{
		$template = $this->template;
		$template->setFile(__DIR__ . '/../templates/Control/message/message.latte');
		$template->render();
	}


	public function renderButtons(): void
	{
		$template = $this->template;
		$template->setFile(__DIR__ . '/../templates/Control/message/message.buttons.latte');
		$template->render();
	}


	public function renderJs(): void
	{
		$template = $this->template;
		$template->setFile(__DIR__ . '/../templates/Control/message/message.js.latte');
		$template->render();
	}


	public function handleMessageFromControl(): void
	{
		$message = 'Hello, World!';
		$this->presenter->flashMessage($message, 'success');

		if ($this->presenter->isAjax()) {
			$this->presenter->redrawControl('message');
		}
	}


	public function handleMessageInControl(): void
	{
		$message = 'Hello, World!';
		$this->flashMessage($message, 'danger');

		if ($this->presenter->isAjax()) {
			$this->redrawControl('message');
		}
	}
}
