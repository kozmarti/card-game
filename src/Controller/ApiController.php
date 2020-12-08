<?php

namespace App\Controller;

use App\Model\AbstractManager;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;
use DateTime;

class ApiController extends AbstractController
{
    public function nasaAPI($date)
    {

        $client = HttpClient::create([
        'headers' => [
            'Authorization' => '6i6JpxJ67Dye6UFbIbODQrsrJ8v2K2VOhcfbsa',
        ],
        ]);
        $response = $client->request(
            'GET',
            'https://api.nasa.gov/planetary/apod?api_key=6i6JpxJ67Dye6UFbIbODQrsrJ8v2K2VOhcfbsa3s&date=' . $date
        );

        $cardData = $response->toArray();
        return $cardData['url'];
    }

    public function cards()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cardsNumber = $_POST['number'];
            if ($cardsNumber % 2 !== 0) {
                $cardsNumber += 1;
            }
        }
        $cardImages = [];
        $allCards = [];

        for ($i = 1; $i <= ($cardsNumber / 2); $i++) {
            $date = rand(2018, 2019) . '-' . rand(10, 12) . '-' . rand(10, 28);
            $cardImages[$i] = $this->nasaAPI($date);
        }

        for ($i = 1; $i <= ($cardsNumber); $i++) {
            $allCards[] .= $i;
        }
        $finalCards=[];

        for ($i = 1; $i <= ($cardsNumber / 2); $i++) {
            $allImages = array_merge($cardImages, $cardImages);
            $w = array_rand(array_flip($cardImages), 1);
            $key = array_search($w, $cardImages);
            unset($cardImages[$key]);

            $card1 = array_rand(array_flip($allCards), 1);
            $key = array_search($card1, $allCards);
            unset($allCards[$key]);

            $card2 = array_rand(array_flip($allCards), 1);
            $key = array_search($card2, $allCards);
            unset($allCards[$key]);

            $finalCards[$card1] = $w;
            $finalCards[$card2] = $w;
        }
        ksort($finalCards);


        return $this->twig->render('Home/game.html.twig', ['cards' => $finalCards, 'card_number' => $cardsNumber]);
    }
}
