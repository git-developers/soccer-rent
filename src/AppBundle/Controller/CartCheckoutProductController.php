<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CategoryHasProduct;


class CartCheckoutProductController extends BaseController
{

    public function indexAction($categoryId)
    {
        $entity = $this->em()->getRepository(CategoryHasProduct::class)->findProductsByCategory($categoryId);
        $categoryHasProduct = $this->getSerializeDecode($entity, 'category_has_product');

        return $this->render(
            'AppBundle:CartCheckoutProduct:index.html.twig',
            [
                'categoryHasProduct' => $categoryHasProduct,
            ]
        );
    }


}
