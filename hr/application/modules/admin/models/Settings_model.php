<?php
class Settings_model  extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }


    function translation_stats() {

        $languages = $this->db->get('language')->result();

        $stats = array();
        $fstats = array();
        foreach ($languages as $lang) {

            $lang = $lang->name;
            $translated = 0;
            $total = 0;
            //foreach ($files as $file => $altpath) {


                $diff = 0;
                $shortfile = str_replace("_lang.php", "", $lang);

                $en_menu = $this->lang->load('english_menu', 'english', TRUE, TRUE);
                $en_body = $this->lang->load('english_body', 'english', TRUE, TRUE);
                $en_msg = $this->lang->load('english_msg', 'english', TRUE, TRUE);
                $en_title = $this->lang->load('english_title', 'english', TRUE, TRUE);

                $en = array_merge($en_menu, $en_body, $en_msg,$en_title );



                if ($lang != 'english') {

                    $menu    =  $this->lang->load($shortfile.'_menu', $lang, TRUE, TRUE);
                    $body    =  $this->lang->load($shortfile.'_body', $lang, TRUE, TRUE);
                    $msg     =  $this->lang->load($shortfile.'_msg',   $lang, TRUE, TRUE);
                    $title   =  $this->lang->load($shortfile.'_title', $lang, TRUE, TRUE);

                    $tr = array_merge($menu, $body, $msg,$title );
                    //$tr = $this->lang->load($shortfile, $lang, TRUE, TRUE);

                    if (!empty($tr)):
                        foreach ($en as $key => $value) {
                            $translation = isset($tr[$key]) ? $tr[$key] : $value;
                            if (!empty($translation) && $translation != $value) {
                                $diff++;
                            }
                        }endif;

                    $fstats[$shortfile] = array(
                        "total" => count($en),
                        "translated" => $diff,
                    );
                } else {
                    $diff = count($en);

                    $fstats[$shortfile] = array(
                        "total" => count($en),
                        "translated" => $diff,
                    );
                }
                $total += count($en);
                $translated += $diff;
            //}
            $stats[$lang]['total'] = $total;
            $stats[$lang]['translated'] = $translated;
            $stats[$lang]['files'] = $fstats;
        };

        return $stats;
    }

    function available_translations() {

        $result = $this->db->get('language')->result();

        foreach ($result as $v_result) {
            $existing[] = $v_result->name;
        }
        $availabe_language = $this->db->group_by('language')->get('locales')->result();

        foreach ($availabe_language as $v_language) {
            if (!in_array($v_language->language, $existing)) {
                $available[] = $v_language;
            }
        }
        return $available;
    }


    function add_language($language, $files) {

        $this->load->helper('file');
        $lang       = $this->db->get_where('locales', array('language' => $language))->result();
        $l          = $lang[0];
        $slug       = strtolower($language);
        $dirpath    = './application/language/' . $slug;

        $icon = explode("_", $l->locale);

        if (isset($icon[1])) {
            $icon = strtolower($icon[1]);
        } else {
            $icon = strtolower($icon[0]);
        }

        if (!is_dir($dirpath)) {
            mkdir($dirpath, 0755);
        }

        foreach ($files as $file => $path) {

            $source         = './application/language/' . 'english/' . $file;
            $destination    = './application/language/' . $language . '/' .str_replace('english',$language, $file);

            $data           = read_file($source);
            $data           = str_replace('/english/', '/' . $language . '/', $data);
            write_file($destination, $data);
        }

        $insert = array(
            'code' => $l->code,
            'name' => $slug,
            'icon' => $icon,
            'active' => '0'
        );

        return $this->db->insert('language', $insert);
    }

    function save_translation($language) {


        $data = '';
        $this->load->helper('file');

        $type = array(
            'menu'  => 'menu',
            'body'  => 'body',
            'title' => 'title',
            'msg'   => 'msg',

        );

        foreach($type as $transType) {

            $data = '';
            $fullpath = "./application/language/" . $language . "/" . $language .'_'.$transType."_lang.php";

            $eng = $this->lang->load('english_'.$transType, 'english', TRUE, TRUE);

            if ($language == 'english') {
                $trn = $eng;
            } else {
                $trn = $this->lang->load($language.'_'.$transType, $language, TRUE, TRUE);
            }

            foreach ($eng as $key => $value) {

                $input_lang = $this->input->post($transType.'['.$key.']', true);

                if (isset($input_lang)) {
                    $newvalue = $input_lang;
                } elseif (isset($trn[$key])) {
                    $newvalue = $trn[$key];
                } else {
                    $newvalue = $value;
                }
                $nvalue = str_replace("'", "\'", $newvalue);
                $data .= '$lang[\'' . $key . '\'] = \'' . $nvalue . '\';' . "\r\n";
            }
            $data .= "\r\n" . "\r\n";

            $data .= "/* End of file " . $language .'_'.$transType."_lang.php */" . "\r\n";
            $data .= "/* Location: ./application/language/" . $language . "/" .  $language .'_'.$transType."_lang.php  */" . "\r\n";

            $data = '<?php' . "\r\n" . $data;
            write_file($fullpath, $data);
        }

        return true;
    }


    function timezones() {
        $timezoneIdentifiers = DateTimeZone::listIdentifiers();
        $utcTime = new DateTime('now', new DateTimeZone('UTC'));

        $tempTimezones = array();
        foreach ($timezoneIdentifiers as $timezoneIdentifier) {
            $currentTimezone = new DateTimeZone($timezoneIdentifier);

            $tempTimezones[] = array(
                'offset' => (int) $currentTimezone->getOffset($utcTime),
                'identifier' => $timezoneIdentifier
            );
        }

        // Sort the array by offset,identifier ascending
        usort($tempTimezones, function($a, $b) {
            return ($a['offset'] == $b['offset']) ? strcmp($a['identifier'], $b['identifier']) : $a['offset'] - $b['offset'];
        });

        $timezoneList = array();
        foreach ($tempTimezones as $tz) {
            $sign = ($tz['offset'] > 0) ? '+' : '-';
            $offset = gmdate('H:i', abs($tz['offset']));
            $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset . ') ' .
                $tz['identifier'];
        }

        return $timezoneList;
    }


    public function get_all_holiday_by_date($start_date, $end_date)
    {
        $this->db->select('holidays.*', false);
        $this->db->from('holidays');
        $this->db->where('start_date >=', $start_date);
        $this->db->where('end_date <=', $end_date);
        $this->db->order_by("start_date", "asc");
        $query_result = $this->db->get();
        $result = $query_result->result();


        return $result;
    }



}