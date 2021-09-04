<?php
    namespace App\listItem\view;

    use App\item\view as vw;

    class ListItemComponent{
        public static function render($items){
            $nbItems = count($items);
            $ret = <<<HTML
                <div class="col-9">
                    <div class="row list-container">
HTML;
            for($i = 0; $i < $nbItems; $i++){
                $ret = $ret . vw\ItemComponent::render($items[$i]);
            }
            $ret = $ret . '</div></div>';
            return $ret;
        }
    }
?>