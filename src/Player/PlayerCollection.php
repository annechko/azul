<?php
declare(strict_types=1);

namespace Azul\Player;

use Webmozart\Assert\Assert;

/**
 * @method Player current()
 */
class PlayerCollection extends \SplStack
{
    public function __construct(array $players)
    {
        Assert::allIsInstanceOf($players, Player::class);
        foreach ($players as $player) {
            $this->push($player);
        }
    }
}