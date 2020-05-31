<?php

namespace TexasHoldem\Engine;

use TexasHoldem\Entity\Card;
use TexasHoldem\Entity\Hand;
use TexasHoldem\Engine\Ranking;

class HandsRulesEngine
{
  protected $ranking;
  protected $hands = array();

  /**
   *
   * @return void
   */
  public function __construct(Ranking $ranking)
  {
    $this->ranking = $ranking;
  }

  /**
   *
   * @return array
   */
  public function getHands() : array
  {
    return $this->hands;
  }

  /**
   *
   * @return void
   */
  public function setHands(array $hands)
  {
    foreach($hands as $index => $hand)
    {
      $entityHand = new Hand($index);

      // i.e. 10♥ 10♦ 10♠ 9♣ 9♦
      $cards = explode(" ", $hand);
      foreach($cards as $card)
      {
        $entityCard = new Card($card);
        $entityHand->addCard($entityCard);
      }

      array_push($this->hands, $entityHand);
    }
  }

  /**
   *
   * @return array
   */
  public function getSortedHands() : array
  {
    return $this->evaluate();
  }

  /**
   * @param string $method
   * @param array  $args
   *
   * @return array
   */
  protected function evaluate() : array
  {
    $sorted = array();

    foreach($this->hands as $hand)
    {
      $this->ranking->setHand($hand);


      // @TODO IL PROBLEMA E' CHE SOVRASCRIVO I VALORI NEGLI STESSI INDICI


      if($this->ranking->isRoyalFlush() > 0)
      {
        $sorted[$hand->getScore()][] = $hand;
      }
      else if($this->ranking->isStraightFlush() > 0)
      {
        $sorted[$hand->getScore()][] = $hand;
      }
      else if($this->ranking->isFourOfAKind() > 0)
      {
        $sorted[$hand->getScore()][] = $hand;
      }
      else if($this->ranking->isFullHouse() > 0)
      {
        $sorted[$hand->getScore()][] = $hand;
      }
      else if($this->ranking->isFlush() > 0)
      {
        $sorted[$hand->getScore()][] = $hand;
      }
      else if($this->ranking->isStraight() > 0)
      {
        $sorted[$hand->getScore()][] = $hand;
      }
      else if($this->ranking->isThreeOfAKind() > 0)
      {
        $sorted[$hand->getScore()][] = $hand;
      }
      else if($this->ranking->isTwoPair() > 0)
      {
        $sorted[$hand->getScore()][] = $hand;
      }
      else if($this->ranking->isPair() > 0)
      {
        $sorted[$hand->getScore()][] = $hand;
      }
      else if($this->ranking->isHighCard() > 0)
      {
        $sorted[$hand->getScore()][] = $hand;
      }
      else {
        $sorted[0] = $hand;
      }
    }

    ksort($sorted);

    return array_reverse($sorted, true);
  }
}