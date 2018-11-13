<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\Crud\Builder\CrudMapper;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Entity\Bet;

class BetController extends BaseController {

    const CLASS_PATH = User::class;
    const GROUP_NAME = 'user';
    const VIEW = 'User';
    const FORM_TYPE = UserType::class;
    const LIMIT_USER = 20;
    const GROUPS_VALIDATOR = 'registration_admin';


    public function indexAction(Request $request)
    {

        if($request->isMethod('POST')){

            $matches = $this->matches();
            $all = $request->request->all();

            //valida si los campos estan vacios
            foreach ($all as $key => $value){

                $scoreHome = isset($value[0]) && $value[0] >= 0 ? true  : false;
                $scoreAway = isset($value[1]) && $value[1] >= 0 ? true  : false;

                if(!$scoreHome || !$scoreAway){
                    $this->flashError('Por favor, llena todos los campos (payaso)');
                    return $this->redirectUrl('app_bet_index');
                }
            }

            //parsea los resultados y los guarda en database
            foreach ($all as $key => $value){

                $scoreHome = isset($value[0]) ? $value[0] : null;
                $scoreAway = isset($value[1]) ? $value[1] : null;

                $bet = new Bet();
                $bet->setMatchKey($key);

                $data = $matches[$key];
                $teamHomeName = $data['home']['name'];
                $teamAwayName = $data['away']['name'];

                $bet->setTeamHome($teamHomeName);
                $bet->setTeamAway($teamAwayName);

                $bet->setTeamHomeScore($scoreHome);
                $bet->setTeamAwayScore($scoreAway);

                $this->persist($bet);
            }

            $this->flashSuccess('Tu apuesta se ingreso con exito!!. Posibilidades de ganar: 0.' . rand(1, 1000000) . '%');
        }


        return $this->render(
            'AppBundle:Bet:index.html.twig',
            [
                'matches' => $this->matches(),
            ]
        );

    }

    public function betListAction(Request $request)
    {

        $entities = $this->em()->getRepository(Bet::class)->findAll();


        return $this->render(
            'AppBundle:Bet:list.html.twig',
            [
                'entities' => $entities,
            ]
        );

    }

    public function matches()
    {
        return [
            'match_1' => [
                'home' => [
                    'input' => 'peru',
                    'name' => 'Perú',
                    'flag' => 'https://image.flaticon.com/icons/svg/580/580979.svg',
                ],
                'away' => [
                    'input' => 'colombia',
                    'name' => 'Colombia',
                    'flag' => 'https://image.flaticon.com/icons/svg/580/580854.svg',
                ],
            ],
            'match_2' => [
                'home' => [
                    'input' => 'brasil',
                    'name' => 'Brasil',
                    'flag' => 'https://image.flaticon.com/icons/svg/580/580836.svg',
                ],
                'away' => [
                    'input' => 'chile',
                    'name' => 'Chile',
                    'flag' => 'https://image.flaticon.com/icons/svg/580/580851.svg',
                ],
            ],
            'match_3' => [
                'home' => [
                    'input' => 'ecuador',
                    'name' => 'Ecuador',
                    'flag' => 'https://image.flaticon.com/icons/svg/580/580871.svg',
                ],
                'away' => [
                    'input' => 'argentina',
                    'name' => 'Argentina',
                    'flag' => 'https://image.flaticon.com/icons/svg/580/580815.svg',
                ],
            ],
            'match_4' => [
                'home' => [
                    'input' => 'paraguay',
                    'name' => 'Paraguay',
                    'flag' => 'https://image.flaticon.com/icons/svg/580/580991.svg',
                ],
                'away' => [
                    'input' => 'venezuela',
                    'name' => 'Venezuela',
                    'flag' => 'https://image.flaticon.com/icons/svg/581/581044.svg',
                ],
            ],
            'match_5' => [
                'home' => [
                    'input' => 'uruguay',
                    'name' => 'Uruguay',
                    'flag' => 'https://image.flaticon.com/icons/svg/581/581040.svg',
                ],
                'away' => [
                    'input' => 'bolivia',
                    'name' => 'Bolivia',
                    'flag' => 'https://image.flaticon.com/icons/svg/580/580834.svg',
                ],
            ],
        ];
    }


}
