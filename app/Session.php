<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'assignment_id', 'session_date', 'session_duration', 'session_notes'
    ];

    public function assignments() {
        return $this->belongsTo('App\Assignment', 'assignment_id');
    }

    public static function getDuration($session_duration)
    {
        $splitted = explode('.', $session_duration);
        $hours = "";
        switch((integer)$splitted[0])
        {
            case 0:
                $hours = "";
            break;
            case 1:
                $hours = (string)$splitted[0] . ' Hour';
            break;
            default:
                $hours = (string)$splitted[0] . ' Hours';
        break;
        }

        $minutes = "";
        if (isset($splitted[1]))
        {
            if ((integer)$splitted[1] == 0) $minutes = "";
            else{
                if ($splitted[1] < 10) $splitted[1] *= 10;

                if ($hours == "") $minutes = (string)($splitted[1] * 0.6) . ' Minutes';
                else $minutes = ' + ' . (string)($splitted[1] * 0.6) . ' Minutes';
            }
        }

        return $hours . $minutes;
    }

    public static function getAllDurations(){
		return Array(
            "0.50"=>"30 Minutes",
            "0.75"=>"45 Minutes", 
            "1.00"=>"1 Hour", 
            "1.25"=>"1 Hour + 15 Minutes", 
            "1.50"=>"1 Hour + 30 Minutes", 
            "1.75"=>"1 Hour + 45 Minutes", 
            "2.00"=>"2 Hours", 
            "2.25"=>"2 Hours + 15 Minutes", 
            "2.50"=>"2 Hours + 30 Minutes", 
            "2.75"=>"2 Hours + 45 Minutes", 
            "3.00"=>"3 Hours", 
            "3.25"=>"3 Hours + 15 Minutes", 
            "3.50"=>"3 Hours + 30 Minutes", 
            "3.75"=>"3 Hours + 45 Minutes", 
            "4.00"=>"4 Hours", 
            "4.25"=>"4 Hours + 15 Minutes", 
            "4.50"=>"4 Hours + 30 Minutes", 
            "4.75"=>"4 Hours + 45 Minutes", 
            "5.00"=>"5 Hours");
	}
}
