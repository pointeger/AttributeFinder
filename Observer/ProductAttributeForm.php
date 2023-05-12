<?php

declare(strict_types=1);

namespace Pointeger\AttributeFinder\Observer;

use Magento\Config\Model\Config\Source\Yesno;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class ProductAttributeForm
 * @package Pointeger\ProductAttribute\Observer
 */
class ProductAttributeForm implements ObserverInterface
{
    /**
     * @var Yesno
     */
    protected $yesNo;

    /**
     * ProductAttributeForm constructor.
     * @param Yesno $yesno
     */
    public function __construct(Yesno $yesno)
    {
        $this->yesNo = $yesno;
    }

    /**
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        $yesno = $this->yesNo->toOptionArray();

        $form = $observer->getData('form');
        $advancedFieldset = $form->getElements()->searchById('advanced_fieldset');

        $advancedFieldset->addField(
            'enable_option_search',
            'select',
            [
                'name' => 'enable_option_search',
                'label' => __('Searchable on Product Edit Page'),
                'note' => __(
                    'Select "Yes" to make this attribute options searchable on product edit page (only if this attribute is of "Select" type).'
                ),
                'values' => $yesno,
                'sortOrder' => 200
            ]
        );
        return $this;
    }
}
