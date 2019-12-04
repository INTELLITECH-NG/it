<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 *	@author : CodesLab
 *  @support: support@codeslab.net
 *	date	: 05 June, 2015
 *	http://www.codeslab.net
 *  version: 1.0
 */

class Localization
{

    public function currencyFormat($currency)
    {
        $currency_format = get_option('currency_format');

        if(!empty($currency_format)){

            if($currency_format == 1){
                return number_format($currency, 2, '.', '');
            }
            elseif($currency_format == 2)
            {
                return number_format($currency, 2, '.', ',');
            }
            elseif($currency_format == 3)
            {
                return number_format($currency, 2, ',', '');
            }
            elseif($currency_format == 4)
            {
                return number_format($currency, 2, ',', '.');
            }else{
                return number_format($currency);
            }

        }else{
            return number_format($currency, 2, '.', ',');
        }

    }


    public function dateFormat($date=null)
    {
        return date(get_option('date_format'), strtotime($date));
    }





}