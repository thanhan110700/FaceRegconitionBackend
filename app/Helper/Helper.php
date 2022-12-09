<?php

use Carbon\Carbon;

if (!function_exists('convertDateToStr')) {
    function convertDateToStr($date)
    {
        try {
            return Carbon::parse($date)->format(config('define.date_format'));
        } catch (\Throwable $th) {
            return '';
        }
    }
}

if (!function_exists('convertSecondToTime')) {
    function convertSecondToTime($second)
    {
        try {
            $hours = floor($second / 3600);
            $minutes = floor(($second / 60) % 60);
            $seconds = $second % 60;

            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        } catch (\Throwable $th) {
            return '';
        }
    }
}

if (!function_exists('addTimeToTime')) {
    /*
        $time1 = '01:00:36';
        $time2 = '00:01:36';
        result = 01:02:12
     */
    function addTimeToTime($oldTime, $newTime)
    {
        try {
            $time1 = explode(':', $oldTime);
            $time2 = explode(':', $newTime);

            $seconds = $time1[2] + $time2[2];
            $minutes = $time1[1] + $time2[1];
            $hours = $time1[0] + $time2[0];

            if ($seconds >= 60) {
                $seconds -= 60;
                $minutes++;
            }

            if ($minutes >= 60) {
                $minutes -= 60;
                $hours++;
            }

            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        } catch (\Throwable $th) {
            return '';
        }
    }
}

if (!function_exists('getTimeBetweenTwoDate')) {
    function getTimeBetweenTwoDate($startDate, $endDate, $type = 'second')
    {
        try {
            return Carbon::parse($startDate)->toTimeString($type) . ' - ' .
                Carbon::parse($endDate)->toTimeString($type);
        } catch (\Throwable $th) {
            return '';
        }
    }
}

if (!function_exists('convertViToEn')) {
    function convertViToEn($str)
    {
        try {
            $unicode = array(
                'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
                'd' => 'đ',
                'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
                'i' => 'í|ì|ỉ|ĩ|ị',
                'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
                'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
                'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
                'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ằ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
                'D' => 'Đ',
                'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
                'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
                'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
                'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
                'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            );
            foreach ($unicode as $nonUnicode => $uni) {
                $str = preg_replace("/($uni)/", $nonUnicode, $str);
            }
            return $str;
        } catch (\Throwable $th) {
            return '';
        }
    }
}

if (!function_exists('convertDateTimeToStr')) {
    function convertDateTimeToStr($date)
    {
        try {
            return Carbon::parse($date)->format(config('define.date_time_format'));
        } catch (\Throwable $th) {
            return '';
        }
    }
}
