<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class File_type {

    public function get_file_type($extension, $file=null)
    {

        $image = array("bmp", "gif", "jpeg", "jpg", "jpe", "png", "tiff", "svg");
        if (in_array($extension, $image)) {
            return '<span class="mailbox-attachment-icon has-img"><img src="'.site_url(ATTACHMENT.'/'.$file).'" alt="Attachment"></span>';
        }

        $doc = array("doc", "docx", "word");
        if (in_array($extension, $doc)) {
            return '<span class="mailbox-attachment-icon"><i class="fa fa-file-word-o" aria-hidden="true"></i></span>';
        }

        $xl = array("xlsx","xl","xls");
        if (in_array($extension, $xl)) {
            return '<span class="mailbox-attachment-icon"><i class="fa fa-file-excel-o" aria-hidden="true"></i></span>';
        }

        $ppt = array("pptx","ppt");
        if (in_array($extension, $ppt)) {
            return '<span class="mailbox-attachment-icon"><i class="fa fa-file-powerpoint-o" aria-hidden="true"></i></span>';
        }

        $pdf = array("pdf");
        if (in_array($extension, $pdf)) {
            return '<span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span>';
        }

        $audio = array("mp3","wav","wma");
        if (in_array($extension, $audio)) {
            return '<span class="mailbox-attachment-icon"><i class="fa fa-file-audio-o" aria-hidden="true"></i></span>';
        }

        $video = array("mov","avi","mp4","3gp","flv","wmv");
        if (in_array($extension, $video)) {
            return '<span class="mailbox-attachment-icon"><i class="fa fa-file-video-o" aria-hidden="true"></i></span>';
        }

        $zip = array("zip", "rar", "gzip","7zip");
        if (in_array($extension, $zip)) {
            return '<span class="mailbox-attachment-icon"><i class="fa fa-file-archive-o" aria-hidden="true"></i></span>';
        }else{
            return '<span class="mailbox-attachment-icon"><i class="fa fa-file-o" aria-hidden="true"></i></span>';
        }
    }

    function formatSizeUnits($bytes)
    {

        if ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' MB';
        }
        elseif ($bytes < 1024)
        {
            $bytes = $bytes . ' kB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }


    function sanitize_file_name($filename)
    {
        $special_chars = array(
            "?",
            "[",
            "]",
            "/",
            "\\",
            "=",
            "<",
            ">",
            ":",
            ";",
            ",",
            "'",
            "\"",
            "&",
            "$",
            "#",
            "*",
            "|",
            "~",
            "`",
            "!",
            "{",
            "}",
            "%",
            "+",
            "_",
            chr(0)
        );
        $filename      = str_replace($special_chars, '-', $filename);
        $filename      = str_replace(array(
            '%20',
            '+'
        ), '-', $filename);
        $filename      = preg_replace('/[\r\n\t -]+/', '-', $filename);
        $filename      = trim($filename, '.-_');
        // Split the filename into a base and extension[s]
        $parts         = explode('.', $filename);
        // Return if only one extension
        if (count($parts) <= 2) {
            return $filename;
        }
        // Process multiple extensions
        $filename  = array_shift($parts);
        $extension = array_pop($parts);
        /*
         * Loop over any intermediate extensions. Postfix them with a trailing underscore
         * if they are a 2 - 5 character long alpha string not in the extension whitelist.
         */
        foreach ((array) $parts as $part) {
            $filename .= '.' . $part;
            if (preg_match("/^[a-zA-Z]{2,5}\d?$/", $part)) {
                $allowed  = false;
                $ext_preg = '!^(' . $ext_preg . ')$!i';
                if (preg_match($ext_preg, $part)) {
                    $allowed = true;
                    break;
                }
            }
            if (!$allowed)
                $filename .= '_';
        }
        $filename .= '.' . $extension;
        return $filename;
    }

}