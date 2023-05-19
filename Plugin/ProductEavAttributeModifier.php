<?php

declare(strict_types=1);

namespace Pointeger\AttributeFinder\Plugin;

use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Eav;

/**
 * Class ProductEavAttributeModifier
 * @package Pointeger\ProductAttribute\Plugin
 */
class ProductEavAttributeModifier
{
    /**
     * @param Eav $subject
     * @param callable $proceed
     * @param ProductAttributeInterface $attribute
     * @param $groupCode
     * @param $sortOrder
     * @return mixed
     */
    public function aroundSetupAttributeMeta(
        Eav $subject,
        callable $proceed,
        ProductAttributeInterface $attribute,
        $groupCode,
        $sortOrder
    ) {
        $returnValue = $proceed($attribute, $groupCode, $sortOrder);
        try {
            if ($attribute->getData(
                    'enable_option_search'
                ) && $returnValue['arguments']["data"]["config"]['formElement'] == 'select') {
                $returnValue['arguments']["data"]["config"]['component'] = 'Pointeger_AttributeFinder/js/form/element/ui-select';
                $returnValue['arguments']["data"]["config"]['filterOptions'] = true;
                $returnValue['arguments']["data"]["config"]['multiple'] = false;
                $returnValue['arguments']["data"]["config"]['disableLabel'] = true;
                $returnValue['arguments']["data"]["config"]['elementTmpl'] = 'ui/grid/filters/elements/ui-select';
            }
        } catch (\Exception $exception) {
        }
        return $returnValue;
    }
}
