<?php

/**
 * Helper class to work with string
 */

// check whether a string starts with the target substring
function starts_with($haystack, $needle)
{
	return substr($haystack, 0, strlen($needle))===$needle;
}

// check whether a string ends with the target substring
function ends_with($haystack, $needle)
{
	return substr($haystack, -strlen($needle))===$needle;
}

function dateFormat($date=null)
{
    echo date(get_option('date_format'), strtotime($date));
}

function currency($currency)
{
    $currency_format = get_option('currency_format');

    if(!empty($currency_format)){

        if($currency_format == 1){
            echo number_format($currency, 2, '.', '');
        }
        elseif($currency_format == 2)
        {
            echo number_format($currency, 2, '.', ',');
        }
        elseif($currency_format == 3)
        {
            echo number_format($currency, 2, ',', '');
        }
        elseif($currency_format == 4)
        {
            echo number_format($currency, 2, ',', '.');
        }else{
            echo number_format($currency);
        }

    }else{
        echo number_format($currency, 2, '.', ',');
    }

}