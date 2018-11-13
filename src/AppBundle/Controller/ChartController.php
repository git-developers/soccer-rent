<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChartController extends Controller {

    public function pieChartAction()
    {

        return $this->render(
            'AppBundle:Chart:pie_chart.html.twig',
            [
                'entitiesJson' => null,
            ]
        );
    }

    public function columnChartAction()
    {

        return $this->render(
            'AppBundle:Chart:column_chart.html.twig',
            [
                'entitiesJson' => null,
            ]
        );
    }

}
