<?php
/**
 * Created by PhpStorm.
 * User: liker
 * Date: 21/03/2019
 * Time: 10:48
 */

namespace App\Helpers;

use Carbon\Carbon;

/**
 * Class Logs - Singleton for writing logs
 *
 * @package App\Helpers
 */
class Logs
{
    private $filename = null;
    private static $instance = null;
    private static $folder = null;


    /**
     * Set new directory for writing logs
     * @param $folder
     */
    public static function setPath($folder)
    {
        self::$folder = $folder;
    }

    /**
     * @return Logs|null
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Logs();
        }

        return self::$instance;
    }

    /**
     * Logs constructor.
     */
    private function __construct()
    {
        try {
            if (self::$folder == NULL) {
                self::$folder = "../logs";
            }

            // check if exists directory for logs
            if (!file_exists(self::$folder)) {
                mkdir(self::$folder, 0777, true);
            }

            $dateNow = Carbon::now();
            $this->filename = fopen(
                self::$folder . "/" . $dateNow->day . "-" . $dateNow->month . "-" . $dateNow->year . "_"
                . $dateNow->hour . "-" . $dateNow->minute . "-" . $dateNow->second . ".log", "w");

        } catch (\Exception $e) {
            echo "Something wrong with open stream. Please check path or filename";
        }
    }


    /**
     * Write messages to log file
     *
     * @param $message
     */
    public function writeToLog($message)
    {
        if ($this->filename != null) {
            $message = "[" . Carbon::now() . "] ------" . $message . "------\r\n";
            fwrite($this->filename, $message);
        }
    }

    /**
     * Close connection stream for logs
     */
    public function closeLog()
    {
        if ($this->filename != null) {
            try {
                fclose($this->filename);
            } catch (\Exception $e) {
                echo "Something wrong with close stream. Please check path or filename";
            }
        }
    }
}