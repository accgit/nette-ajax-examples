<?php

declare(strict_types = 1);

namespace Module\Web\Components;

use Drago\Http\ExtraSession;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Tracy\Debugger;


class Step02 extends Control
{
	/** @var ExtraSession */
	private $sessions;


	public function __construct(ExtraSession $sessions)
	{
		$this->sessions = $sessions;
	}


	public function render(): void
	{
		$template = $this->template;
		$template->setFile(__DIR__ . '/../templates/Control/step02.latte');
		$template->render();
	}


	public function createComponentStep02(): Form
	{
		$form = new Form;
		$form->addText('email', 'Email')
			->addRule(Form::EMAIL, '%label must be valid e-mail.')
			->setRequired();

		$form->addSubmit('send', 'Save');
		$form->onSuccess[] = [$this, 'process'];
		return $form;
	}

	public function process(Form $form): void
	{
		$values = $form->values;
		$sessions = $this->sessions->getSessionSection();
		$sessions->email = $values->email;

		Debugger::barDump($sessions->realname);
		Debugger::barDump($sessions->email);

		unset($sessions->realname, $sessions->email, $sessions->step);

		if ($this->presenter->isAjax()) {
			$this->presenter->redrawControl('step');
			$this->presenter->redrawControl('info');
		}
	}
}
