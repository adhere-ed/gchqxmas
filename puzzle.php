<?php 

class Puzzle{

    
    public $colChunks = array(
        array(7,2,1,1,7),
        array(1,1,2,2,1,1),
        array(1,3,1,3,1,3,1,3,1),
        array(1,3,1,1,5,1,3,1),
        array(1,3,1,1,4,1,3,1),
        array(1,1,1,2,2,1,1),
        array(7,1,1,1,1,1,7),
        array(1,1,3),
        array(2,1,2,1,8,2,1),
        array(2,2,1,2,1,1,1,2),
        array(1,7,3,2,1),
        array(1,2,3,1,1,1,1,1),
        array(4,1,1,2,6),
        array(3,3,1,1,1,3,1),
        array(1,2,5,2,2),
        array(2,2,1,1,1,1,1,2,1),
        array(1,3,3,2,1,8,1),
        array(6,2,1),
        array(7,1,4,1,1,3),
        array(1,1,1,1,4),
        array(1,3,1,3,7,1),
        array(1,3,1,1,1,2,1,1,4),
        array(1,3,1,4,3,3),
        array(1,1,2,2,2,6,1),
        array(7,1,3,2,1,1),
    );
    
    public $rowChunks = array(
        array(7,3,1,1,7),
        array(1,1,2,2,1,1),
        array(1,3,1,3,1,1,3,1),
        array(1,3,1,1,6,1,3,1),
        array(1,3,1,5,2,1,3,1),
        array(1,1,2,1,1),
        array(7,1,1,1,1,1,7),
        array(3,3),
        array(1,2,3,1,1,3,1,1,2),
        array(1,1,3,2,1,1),
        array(4,1,4,2,1,2),
        array(1,1,1,1,1,4,1,3),
        array(2,1,1,1,2,5),
        array(3,2,2,6,3,1),
        array(1,9,1,1,2,1),
        array(2,1,2,2,3,1),
        array(3,1,1,1,1,5,1),
        array(1,2,2,5),
        array(7,1,2,1,1,1,3),
        array(1,1,2,1,2,2,1),
        array(1,3,1,4,5,1),
        array(1,3,1,3,10,2),
        array(1,3,1,1,6,6),
        array(1,1,2,1,1,2),
        array(7,2,1,2,5),
    );
    
    public $squares = array();
    
    public $blackSquares = array(
        4 => array(4,5,13,14,22),
        9 => array(7,8,11,15,16,19),
        17 => array(7,12,17,21),
        22 => array(4,5,10,11,16,21,22),
    );
    
    
    public $gridHtml;
    
    
    public function initialise()
    {
        $this->colCount = count($this->colChunks);
        $this->rowCount = count($this->rowChunks);
        
        for($c=1;$c<=$this->colCount;$c++){
            for($r=1;$r<=$this->rowCount;$r++){
                $this->squares[$r][$c] = FALSE;
            }
        }
        
        $this->setBlackSquares();
    }
    
    public function setBlackSquares()
    {
        foreach($this->blackSquares as $rowNumber=>$columnsArray){
            foreach($columnsArray as $columnNumber){
                $this->squares[$rowNumber][$columnNumber] = TRUE;
            }
        }
    }
    
    
    public function returnGrid()
    {
        $this->openTable();
        
        $this->insertTopRowOfTable();
        
        $this->insertOtherRowsOfTable();
        
        $this->solvePuzzle();
        
        $this->closeTable();
        
        
        return $this->gridHtml;
        
    }
    
    
    public function solvePuzzle()
    {
        /*
            Functions needed - each on a per-set basis (row or column)
            totalBlacksInSet()
            currentBlacksInSet()
            remainingBlacksInSet()
            biggestFreeSlotSize()
            biggestFreeSlotStartPosition()
        */
    }
    
    
    
    
    public function openTable()
    {
        $this->addToGridHtml('<table><tbody>');
    }
    
    public function insertTopRowOfTable()
    {
        $this->startRow();
        $this->addEmptyTd();
        
        
        
        $colsToDraw = $this->colCount + 1;
        foreach($this->colChunks as $colKey=>$colChunk){
            $this->addOpeningTag('td');
            
            $this->addColHeader($colChunk);
            
            $this->addClosingTag('td');
        }
        
        
        $this->endRow();
    }
    
    public function insertOtherRowsOfTable()
    {
    
        foreach($this->rowChunks as $rowKey => $rowChunk)
        {
            $this->startRow();
            $this->addFirstColumn($rowChunk);
            $this->addOtherColumns($rowKey);
            $this->endRow();
        }
        
    }
    
    
    public function startRow()
    {
        $this->addOpeningTag('tr');
    }
    
    public function endRow()
    {
        $this->addClosingTag('tr');
    }
    
    public function addEmptyTd()
    {
        $this->addOpeningTag('td');
        $this->addClosingTag('td');   
    }
    
    public function addBlackTd()
    {
        $this->addToGridHtml('<td class="filled">');
        $this->addClosingTag('td');
    }
    
    public function addColHeader($colChunk)
    {
        $content = implode('<br>', $colChunk);
        $this->addToGridHtml($content);
    }
    
    
    public function addRowHeader($rowChunk)
    {
        $content = implode('&nbsp;', $rowChunk);
        $this->addToGridHtml($content);
    }
    
    public function addOtherColumns($rowKey)
    {
        for($i=1; $i<=$this->colCount; $i++){
            
            if($this->squares[$rowKey+1][$i]){
                $this->addBlackTd();
            } else {
                $this->addEmptyTd();    
            }
            
        }
    }
    
    public function addFirstColumn($rowChunk)
    {
        $this->addOpeningTag('td');
        
        $this->addRowHeader($rowChunk);
        
        $this->addClosingTag('td');
    }
    
    public function addOpeningTag($tag)
    {
        $this->addToGridHtml("<$tag>");
    }
    
    public function addClosingTag($tag)
    {
        $this->addToGridHtml("</$tag>");
    }
    
    public function closeTable()
    {
        $this->addToGridHtml('</tbody></table>');
    }
    
    public function addToGridHtml($content)
    {
        $this->gridHtml .= $content;
    }
    

    public function mapBlackSquares()
    {
            
    }    
    
}



$puzzle = new Puzzle;

$puzzle->initialise();

$gridHtml = $puzzle->returnGrid();


?>


<!doctype html>
<html>
    <head>
    
        <style>
            
            table{
                border-collapse: collapse;
            }
        
            td{
                vertical-align: bottom;
                text-align: right;
                padding: 4px;
                min-width: 24px;
                min-height: 24px;
                border: 1px solid black;
            }
            
            td.filled{
                background-color: black;
            }
        </style>
    </head>
    <body>
        <?php echo $gridHtml;?>
    </body>
</html>
