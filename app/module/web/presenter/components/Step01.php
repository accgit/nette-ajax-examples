<?php

declare(strict_types = 1);

namespace Module\Web\Components;

use Drago\Http\Sessions;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;


class Step01 extends Control
{
	/** @var Sessions */
	private $sessions;


	public function __construct(Sessions $sessions)
	{
		$this->sessions = $sessions;
	}


	public function render(): void
	{
		$template = $this->template;
		$template->setFile(__DIR__ . '/../templates/Control.step01.latte');
		$template->render();
	}


	public function createComponentStep01(): Form
	{
		$form = new Form;
		$form->addText('realname', 'Realmane')
			->setRequired();

		$form->addSubmit('send', 'Next');
		$form->onSuccess[] = [$this, 'process'];
		return $form;
	}


	public function process(Form $form): void
	{
		$values = $form->values;
		$sessions = $this->sessions->getSessionSection();
		$sessions->realname = $values->realname;
		$sessions->step = 2;

		if ($this->presenter->isAjax()) {
			$this->presenter->redrawControl('step');
			$this->presenter->redrawControl('info');
		}
	}
}
