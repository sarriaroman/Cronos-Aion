<?php

/**
 * Description of Ammount
 *
 * @author sarriaroman
 */
class Ammount {
    private $opcode;
    public $optid;

    private $ammount;

    public $emmiter;
    public $receiver;

    function  __construct( $code, $ammount ) {
        $this->opcode = $code;
        $this->ammount = $ammount;

        $this->emmiter = $this->ammount;
        $this->receiver = $this->ammount;
    }

    function calculate() {
        $con = new Connection();

        $operation = mysql_fetch_object( $con->make_request("select id from OpTypes where code = '{$this->opcode}'") );

        $this->optid = $operation->id;

        $revenues = $con->make_request("select * from operation_conditions where optid = '{$operation->id}'");

        while( ( $revenue = mysql_fetch_object( $revenues ) ) ) {
            if( $revenue->cond == "" ) {
                if( $revenue->revenueA != "-1" ) {
                    $revA = new Table("revenues", $revenue->revenueA );

                    $revammount = 0;
                    if( $revA->percentage ) {
                        $revammount = doubleval( $this->ammount ) * doubleval( ( $revA->revenue / 100 ) );
                    } else {
                        $revammount = doubleval( $revA->revenue );
                    }

                    $this->emmiter += $revammount * doubleval( ( $revenue->emitterpercentage / 100 ) );
                    $this->receiver += $revammount * doubleval( ( $revenue->receiverpercentage / 100 ) );
                } else {
                    continue;
                }
            } else {
                $revammount = 0;
                $tempRevA = 0;
                $tempRevB = 0;

                if( $revenue->revenueA != "-1" ) {
                    $revA = new Table("revenues", $revenue->revenueA );

                    if( $revA->percentage ) {
                        $tempRevA = doubleval( $this->ammount ) * doubleval( ( $revA->revenue / 100 ) );
                    } else {
                        $tempRevA = doubleval( $revA->revenue );
                    }
                } else {
                    continue;
                }
                if( $revenue->revenueB != "-1" ) {
                    $revB = new Table("revenues", $revenue->revenueB );

                    if( $revB->percentage ) {
                        $tempRevB = doubleval( $this->ammount ) * doubleval( ( $revB->revenue / 100 ) );
                    } else {
                        $tempRevB = doubleval( $revB->revenue );
                    }
                } else {
                    continue;
                }
                switch( $revenue->cond ) {
                    case ">":
                        $revammount = ( $tempRevA > $tempRevB ) ? $tempRevA : $tempRevB;

                        break;
                    case "<":
                        $revammount = ( $tempRevA < $tempRevB ) ? $tempRevA : $tempRevB;

                        break;
                    case ">=":
                        $revammount = ( $tempRevA >= $tempRevB ) ? $tempRevA : $tempRevB;

                        break;
                    case "<=":
                        $revammount = ( $tempRevA <= $tempRevB ) ? $tempRevA : $tempRevB;

                        break;
                    case "=":
                        $revammount = ( $tempRevA == $tempRevB ) ? $tempRevA : $tempRevB;

                        break;
                }

                $this->emmiter += $revammount * doubleval( ( $revenue->emitterpercentage / 100 ) );
                $this->receiver += $revammount * doubleval( ( $revenue->receiverpercentage / 100 ) );
            }
        }
    }
}
?>
