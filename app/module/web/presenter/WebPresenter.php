<?php

declare(strict_types = 1);

namespace Module\Web;

use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;


final class WebPresenter extends Presenter
{
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


	public function renderDefault()
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
		$form->onSubmit[] = [$this, 'process'];
		return $form;
	}


	public function process(Form $form): void
	{
		$form->reset();
		$this->payload->data = $this->data();
		$this->redrawControl('typeahead');
	}
}
