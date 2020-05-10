<?php

namespace Azul\Board;

use Azul\Tile\TileCollection;
use Webmozart\Assert\Assert;

class Board
{
    public const ROW_1 = 1;
    public const ROW_2 = 2;
    public const ROW_3 = 3;
    public const ROW_4 = 4;
    public const ROW_5 = 5;

    private BoardRow $row1;
    private BoardRow $row2;
    private BoardRow $row3;
    private BoardRow $row4;
    private BoardRow $row5;
    private TileCollection $floorLine;

    public function __construct()
    {
        $this->row1 = new BoardRow(1);
        $this->row2 = new BoardRow(2);
        $this->row3 = new BoardRow(3);
        $this->row4 = new BoardRow(4);
        $this->row5 = new BoardRow(5);
        $this->floorLine = new TileCollection();
    }

    public function placeTiles(TileCollection $tiles, $rowOrNumber): void
    {
        $row = $rowOrNumber instanceof BoardRow ? $rowOrNumber : $this->getRow($rowOrNumber);
        if ($tiles->bottom()->isFirstPlayerMarker()) {
            $this->floorLine->push($tiles->pop());
        }
        $extraCount = $tiles->count() - $row->getEmptySlotsCount();
        for ($j = 0; $j < $extraCount; $j++) {
            $this->floorLine->push($tiles->pop());
        }
        $row->placeTiles($tiles);
    }

    private function getRow(string $rowNumber): BoardRow
    {
        Assert::range($rowNumber, 1, 5);
        return $this->{'row' . $rowNumber};
    }

    public function getFloorTilesCount(): int
    {
        return $this->floorLine->count();
    }

    public function getRowTilesCount(int $rowNumber): int
    {
        $row = $this->getRow($rowNumber);
        return $row->getTilesCount();
    }

    /**
     * @return BoardRow[]
     */
    public function getRows(): array
    {
        return [
            $this->row1,
            $this->row2,
            $this->row3,
            $this->row4,
            $this->row5,
        ];
    }
}