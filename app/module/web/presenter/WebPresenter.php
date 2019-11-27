<?php

declare(strict_types = 1);

namespace Module\Web;

use Module\Web\Components\Message;
use Module\Web\Components\Step01;
use Module\Web\Components\Step02;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Tracy\Debugger;


final class WebPresenter extends Presenter
{
	/** @var int */
	private $step = 1;

	/**
	 * @var Step01
	 * @inject
	 */
	public $step01;

	/**
	 * @var Step02
	 * @inject
	 */
	public $step02;

	/**
	 * @var Message
	 * @inject
	 */
	public $message;


	/* typeahead ---------------------------------------------------------------------------------------------------- */

	private function data(): array
	{
		return [
			'Prague',
			'Zagreb',
			'Paris',
		];
	}


	/**
	 * @throws \Nette\Application\AbortException
	 */
	public function handleJson(): void
	{
		$this->sendJson($this->data());
	}


	public function renderTypeahead(): void
	{
		// If he does not want to use this command, we must wrap the snippet with the entire form.
		$this->template->getLatte()->addProvider('formsStack', [$this['form']]);
	}


	protected function createComponentForm(): Form
	{
		$form = new Form;
		$form->addText('input', 'Typeahead')
			->setHtmlAttribute('autocomplete', 'nope')
			->setHtmlAttribute('data-provide', 'typeahead')
			->setRequired();

		$form->addSubmit('send', 'Send');
		$form->onSuccess[] = [$this, 'process'];
		return $form;
	}


	public function process(Form $form): void
	{
		Debugger::barDump($form->values);

		$form->reset();
		if ($this->isAjax()) {
			$this->payload->data = $this->data();
			$this->redrawControl('typeahead');
		}
	}


	/* forms steps -------------------------------------------------------------------------------------------------- */

	protected function createComponentStep01(): Step01
	{
		return $this->step01;
	}


	protected function createComponentStep02(): Step02
	{
		return $this->step02;
	}


	/**
	 * @param string $step
	 */
	public function handleSteps($step): void
	{
		$step = (int) $step;
		$session = $this->session->getSection('steps');
		if ($step === 1 && $session->realname) {

			$session->step = $step;
			$form = $this['step01']['step01'];
			$form['send']->caption = 'Update and continue';
			$form['realname']->setValue($session->realname);

			if ($this->isAjax()) {
				$this->redrawControl('step');
				$this->redrawControl('info');
			}
		}
	}


	public function renderSteps(): void
	{
		$session = $this->session->getSection('steps');
		$this->template->step = $session->step ?? $this->step;
	}


	/* modal -------------------------------------------------------------------------------------------------------- */

	protected function createComponentModalForm(): Form
	{
		$form = new Form;
		$form->addText('name', 'Name')
			->setRequired();

		$form->addTextArea('message', 'Message')
			->setRequired();

		$form->addSubmit('send', 'Send');
		$form->onSuccess[] = [$this, 'modalProcess'];
		return $form;
	}


	public function modalProcess(Form $form): void
	{
		$values = $form->values;
		Debugger::barDump($values);

		if ($this->isAjax()) {
			$this->payload->modal = 'close';
			$this->redrawControl('modal');
		}
	}


	public function handleModal(): void
	{
		if ($this->isAjax()) {
			$this->payload->modal = 'run';
			$this->redrawControl('modal');
		}
	}

	/* flash messages ----------------------------------------------------------------------------------------------- */

	public function handleMessageFromPresenter(): void
	{
		$message = 'Hello, World!';
		$this->presenter->flashMessage($message);

		if ($this->isAjax()) {
			$this->redrawControl('message');
		}
	}


	protected function createComponentMessage(): Message
	{
		return $this->message;
	}
}
