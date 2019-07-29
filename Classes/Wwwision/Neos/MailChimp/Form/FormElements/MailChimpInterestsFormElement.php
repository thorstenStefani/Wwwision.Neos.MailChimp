<?php

namespace Wwwision\Neos\MailChimp\Form\FormElements;

use Neos\Flow\Exception;
use Neos\Form\FormElements\GenericFormElement;
use Wwwision\Neos\MailChimp\Domain\Service\MailChimpService;
use Neos\Flow\Annotations as Flow;

class MailChimpInterestsFormElement extends GenericFormElement {

    /**
     * @Flow\Inject
     * @var MailChimpService
     */
    protected $mailChimpService;

    /**
     * @param \Neos\Form\Core\Runtime\FormRuntime $formRuntime
     *
     * @throws \Neos\Flow\Exception
     */
    public function beforeRendering(\Neos\Form\Core\Runtime\FormRuntime $formRuntime)
    {
        $properties = $this->getProperties();

        if (!isset($properties['listId'])) {
            throw new Exception('Property "listId" missing', 1486627024);
        }
        if (!isset($properties['categoryId'])) {
            throw new Exception('Property "categoryId" missing', 1486631201);
        }
        $listId = $properties['listId'];
        $categoryId = $properties['categoryId'];

        $categoryResult = $this->mailChimpService->getCategoryByListIdAndInterestCategoryId($listId, $categoryId);

        if (!$this->getLabel()) {
            $this->setLabel($categoryResult['title']);
        }

        $this->setProperty('type', $categoryResult['type']);
        $this->setProperty('options', $this->mailChimpService->getInterestsFormOptionsByListIdAndInterestCategoryId($listId, $categoryId));
    }
}