<?php


namespace crazywhalecc\TimeUtil;


class TimeUtil
{
    /**
     * 【时间戳】获取今日的零时：00:00:00
     * @param null $stamp
     * @return int|null
     */
    public static function getTodayZero($stamp = null) {
        $current = $stamp === null ? time() : $stamp;
        $artifect = $current + 28800;
        $add = $artifect % 86400;
        return $current - $add;
    }

    /**
     * 【时间戳】获取本周零时：周一的00:00:00
     * @param null $stamp
     * @return int|null
     */
    public static function getWeekZero($stamp = null) {
        $current = $stamp ?? time();
        $week = date("N", $current) - 1;
        $current = $current - ($week * 86400);
        return self::getTodayZero($current);
    }

    /**
     * 【时间戳】根据时间戳获取年份
     * @param $timestamp
     * @return false|string
     */
    public static function getYear($timestamp = null) {
        return date("Y", $timestamp ?? time());
    }

    /**
     * 【时间戳】根据时间戳获取月份
     * @param $timestamp
     * @return false|string
     */
    public static function getMonth($timestamp = null) {
        return date("n", $timestamp ?? time());
    }

    /**
     * 【时间戳】根据时间戳获取本月的第几天
     * @param $timestamp
     * @return false|string
     */
    public static function getDay($timestamp = null) {
        return date("j", $timestamp ?? time());
    }

    /**
     * 【时间戳】返回日期的Unix时间戳
     * @param $year
     * @param $month
     * @param $day
     * @param $hour
     * @param $min
     * @param $sec
     * @return false|int
     */
    public static function getTimeByDate($year, $month, $day, $hour, $min, $sec) {
        return strtotime($year . "-" . $month . "-" . $day . " " . $hour . ":" . $min . ":" . $sec);
    }

    /**
     * 获取年份的天数
     * @param $year
     * @return int
     */
    public static function getDaysOfYear($year) {
        return ($year % 4 == 0 ? ($year % 100 == 0 ? ($year % 400 == 0 ? 366 : 365) : 366) : 365);
    }

    /**
     * 获取月的天数
     * @param $month
     * @param $year
     * @return int
     */
    public static function getDaysOfMonth($month, $year) {
        switch ($month) {
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                return 31;
            case 4:
            case 6:
            case 9:
            case 11:
                return 30;
            case 2:
                return self::getDaysOfYear($year) == 365 ? 28 : 29;
            default:
                return 0;
        }
    }

    /**
     * 【时间戳】返回指定时间后的时间戳
     * @param $time
     * @param int $year
     * @param int $month
     * @param int $week
     * @param int $day
     * @param int $hour
     * @param int $min
     * @param int $sec
     * @return float|int
     */
    public static function getTimeAfter($time, $year = 0, $month = 0, $week = 0, $day = 0, $hour = 0, $min = 0, $sec = 0) {
        if ($year != 0) {
            for ($i = 0; $i < $year; $i++) {
                $time += (self::getDaysOfYear(self::getYear($time)) * 86400);
            }
        }
        if ($month != 0) {
            for ($i = 1; $i <= $month; $i++) {
                $monthss = date("n", $time);
                $yearss = date("Y", $time);
                $time += (self::getDaysOfMonth($monthss, $yearss) * 86400);
            }
        }
        if ($week != 0) {
            $days = $week * 7;
            $time += ($days * 86400);
        }
        if ($day != 0) {
            $time += ($day * 86400);
        }
        if ($hour != 0) {
            $time += ($hour * 3600);
        }
        if ($min != 0) {
            $time += ($min * 60);
        }
        if ($sec != 0) {
            $time += $sec;
        }
        return $time;
    }

    /**
     * 【时间戳】获取今日的时间戳，通过时分秒
     * @param $hour
     * @param $min
     * @param $sec
     * @return float|int
     */
    public static function getTodayTimeByHourMinSec($hour, $min, $sec) {
        return self::getTimeAfter(self::getTodayZero(), 0, 0, 0, 0, $hour, $min, $sec);
    }
}
